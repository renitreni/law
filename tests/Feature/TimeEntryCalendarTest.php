<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Entry;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeEntryCalendarTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Client $client;

    protected Matter $matter;

    protected SubMatter $subMatter;

    protected Office $office;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->client = Client::factory()->create();
        $this->matter = Matter::factory()->create();
        $this->subMatter = SubMatter::factory()->create(['matter_id' => $this->matter->id]);
        $this->office = Office::factory()->create();
    }

    protected function createTimeEntry(array $overrides = []): Entry
    {
        return Entry::factory()->create(array_merge([
            'client_id' => $this->client->id,
            'matter_id' => $this->matter->id,
            'sub_matter_id' => $this->subMatter->id,
            'office_id' => $this->office->id,
            'is_template' => false,
        ], $overrides));
    }

    public function test_calendar_endpoints_require_authentication(): void
    {
        $routes = [
            'timesheet.calendar' => ['start' => '2024-01-01', 'end' => '2024-01-31'],
            'timesheet.entries' => ['date' => '2024-01-15'],
        ];

        foreach ($routes as $route => $params) {
            $this->get(route($route, $params))->assertRedirect(route('login'));
        }
    }

    public function test_calendar_summary_returns_daily_duration_totals(): void
    {
        $this->createTimeEntry([
            'entry_date' => '2024-01-10',
            'duration' => 2.5,
            'is_draft' => false,
            'is_billable' => true,
        ]);
        $this->createTimeEntry([
            'entry_date' => '2024-01-10',
            'duration' => 1.5,
            'is_draft' => true,
            'is_billable' => false,
        ]);
        $this->createTimeEntry([
            'entry_date' => '2024-02-10',
            'duration' => 4,
            'is_draft' => false,
            'is_billable' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('timesheet.calendar', [
            'start' => '2024-01-01',
            'end' => '2024-01-31',
        ]));

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.date', '2024-01-10')
            ->assertJsonPath('data.0.posted', 2.5)
            ->assertJsonPath('data.0.draft', 1.5)
            ->assertJsonPath('data.0.billable', 2.5)
            ->assertJsonPath('data.0.non_billable', 1.5);
    }

    public function test_calendar_summary_excludes_templates_and_soft_deleted_entries(): void
    {
        $this->createTimeEntry([
            'entry_date' => '2024-01-10',
            'duration' => 2,
            'is_template' => true,
        ]);

        $deletedEntry = $this->createTimeEntry([
            'entry_date' => '2024-01-10',
            'duration' => 3,
        ]);
        $deletedEntry->delete();

        $response = $this->actingAs($this->user)->get(route('timesheet.calendar', [
            'start' => '2024-01-01',
            'end' => '2024-01-31',
        ]));

        $response->assertOk()->assertJsonCount(0, 'data');
    }

    public function test_calendar_summary_filters_the_requested_cross_year_range(): void
    {
        $this->createTimeEntry(['entry_date' => '2023-12-31', 'duration' => 2]);
        $this->createTimeEntry(['entry_date' => '2024-01-01', 'duration' => 3]);

        $response = $this->actingAs($this->user)->get(route('timesheet.calendar', [
            'start' => '2024-01-01',
            'end' => '2024-01-31',
        ]));

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.date', '2024-01-01')
            ->assertJsonPath('data.0.posted', 3);
    }

    public function test_calendar_summary_rejects_ranges_longer_than_42_days(): void
    {
        $response = $this->actingAs($this->user)->get(route('timesheet.calendar', [
            'start' => '2024-01-01',
            'end' => '2024-02-13',
        ]));

        $response->assertSessionHasErrors(['end']);
    }

    public function test_entries_returns_details_for_the_selected_day(): void
    {
        $this->createTimeEntry([
            'entry_date' => '2024-01-10',
            'narrative' => 'Draft client consultation',
            'is_draft' => true,
            'is_billable' => false,
        ]);
        $this->createTimeEntry(['entry_date' => '2024-01-11']);

        $response = $this->actingAs($this->user)->get(route('timesheet.entries', [
            'date' => '2024-01-10',
        ]));

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.entry_date', '2024-01-10')
            ->assertJsonPath('data.0.narrative', 'Draft client consultation')
            ->assertJsonPath('data.0.clients.name', $this->client->name)
            ->assertJsonPath('data.0.submatters.code', $this->subMatter->code)
            ->assertJsonPath('data.0.offices.name', $this->office->name);
    }

    public function test_entries_excludes_templates_and_rejects_invalid_dates(): void
    {
        $this->createTimeEntry([
            'entry_date' => '2024-01-10',
            'is_template' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('timesheet.entries', [
            'date' => '2024-01-10',
        ]));

        $response->assertOk()->assertJsonCount(0, 'data');

        $this->actingAs($this->user)
            ->get(route('timesheet.entries', ['date' => '01/10/2024']))
            ->assertSessionHasErrors(['date']);
    }

    public function test_entry_write_endpoints_require_authentication(): void
    {
        $this->post(route('timesheet.entries.store'), [])->assertRedirect(route('login'));

        $entry = $this->createTimeEntry();

        $this->put(route('timesheet.entries.update', $entry), [])->assertRedirect(route('login'));
    }

    public function test_store_creates_a_posted_time_entry(): void
    {
        $response = $this->actingAs($this->user)->post(route('timesheet.entries.store'), [
            'client_id' => $this->client->id,
            'sub_matter_id' => $this->subMatter->id,
            'office_id' => $this->office->id,
            'entry_date' => '2024-01-10',
            'duration' => 2.5,
            'narrative' => 'Client consultation',
            'is_billable' => 1,
            'is_draft' => 0,
            'is_template' => 0,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.entry_date', '2024-01-10')
            ->assertJsonPath('data.duration', 2.5)
            ->assertJsonPath('data.is_draft', false)
            ->assertJsonPath('data.clients.id', $this->client->id)
            ->assertJsonPath('data.submatters.id', $this->subMatter->id)
            ->assertJsonPath('data.offices.id', $this->office->id);

        $this->assertDatabaseHas('entries', [
            'client_id' => $this->client->id,
            'matter_id' => $this->matter->id,
            'sub_matter_id' => $this->subMatter->id,
            'office_id' => $this->office->id,
            'entry_date' => '2024-01-10',
            'duration' => 2.5,
            'is_draft' => false,
            'is_billable' => true,
        ]);
    }

    public function test_store_creates_a_draft_time_entry(): void
    {
        $response = $this->actingAs($this->user)->post(route('timesheet.entries.store'), [
            'client_id' => $this->client->id,
            'sub_matter_id' => $this->subMatter->id,
            'office_id' => $this->office->id,
            'entry_date' => '2024-01-10',
            'duration' => 1,
            'is_billable' => 0,
            'is_draft' => 1,
            'is_template' => 0,
        ]);

        $response->assertCreated()->assertJsonPath('data.is_draft', true);

        $this->assertDatabaseHas('entries', ['is_draft' => true, 'is_billable' => false]);
    }

    public function test_store_requires_template_name_when_saving_as_template(): void
    {
        $this->actingAs($this->user)->post(route('timesheet.entries.store'), [
            'client_id' => $this->client->id,
            'sub_matter_id' => $this->subMatter->id,
            'office_id' => $this->office->id,
            'entry_date' => '2024-01-10',
            'duration' => 1,
            'is_billable' => 1,
            'is_draft' => 0,
            'is_template' => 1,
        ])->assertSessionHasErrors(['template_name']);

        $this->actingAs($this->user)->post(route('timesheet.entries.store'), [
            'client_id' => $this->client->id,
            'sub_matter_id' => $this->subMatter->id,
            'office_id' => $this->office->id,
            'entry_date' => '2024-01-10',
            'duration' => 1,
            'is_billable' => 1,
            'is_draft' => 0,
            'is_template' => 1,
            'template_name' => 'Consultation',
        ])->assertCreated()->assertJsonPath('data.is_template', true);

        $this->assertDatabaseHas('entries', ['template_name' => 'Consultation', 'is_template' => true]);
    }

    public function test_store_rejects_invalid_payloads(): void
    {
        $this->actingAs($this->user)->post(route('timesheet.entries.store'), [
            'client_id' => 999999,
            'sub_matter_id' => 999999,
            'office_id' => 999999,
            'entry_date' => 'not-a-date',
            'duration' => 0,
            'is_billable' => 1,
            'is_draft' => 0,
            'is_template' => 0,
        ])->assertSessionHasErrors([
            'client_id',
            'sub_matter_id',
            'office_id',
            'entry_date',
            'duration',
        ]);
    }

    public function test_update_changes_fields_and_post_status(): void
    {
        $entry = $this->createTimeEntry([
            'entry_date' => '2024-01-10',
            'duration' => 1,
            'is_draft' => true,
            'narrative' => 'Old narrative',
        ]);

        $newClient = Client::factory()->create();
        $newMatter = Matter::factory()->create();
        $newSubMatter = SubMatter::factory()->create(['matter_id' => $newMatter->id]);
        $newOffice = Office::factory()->create();

        $response = $this->actingAs($this->user)->put(route('timesheet.entries.update', $entry), [
            'client_id' => $newClient->id,
            'sub_matter_id' => $newSubMatter->id,
            'office_id' => $newOffice->id,
            'entry_date' => '2024-01-12',
            'duration' => 3.5,
            'narrative' => 'Updated narrative',
            'is_billable' => 0,
            'is_draft' => 0,
            'is_template' => 0,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.id', $entry->id)
            ->assertJsonPath('data.entry_date', '2024-01-12')
            ->assertJsonPath('data.duration', 3.5)
            ->assertJsonPath('data.is_draft', false)
            ->assertJsonPath('data.clients.id', $newClient->id)
            ->assertJsonPath('data.submatters.id', $newSubMatter->id);

        $this->assertDatabaseHas('entries', [
            'id' => $entry->id,
            'client_id' => $newClient->id,
            'matter_id' => $newMatter->id,
            'sub_matter_id' => $newSubMatter->id,
            'office_id' => $newOffice->id,
            'entry_date' => '2024-01-12',
            'duration' => 3.5,
            'narrative' => 'Updated narrative',
            'is_draft' => false,
            'is_billable' => false,
        ]);
    }

    public function test_index_passes_unique_templates_to_the_page(): void
    {
        $this->createTimeEntry([
            'is_template' => true,
            'template_name' => 'Consultation',
            'duration' => 1.5,
        ]);
        $this->createTimeEntry([
            'is_template' => true,
            'template_name' => 'Consultation',
            'duration' => 2,
        ]);
        $this->createTimeEntry([
            'is_template' => true,
            'template_name' => 'Hearing',
            'duration' => 4,
        ]);

        $response = $this->actingAs($this->user)->get(route('timesheet'));

        $response->assertInertia(fn ($page) => $page
            ->component('Timesheet/Index')
            ->has('templates', 2)
            ->where('templates.0.template_name', 'Hearing')
        );
    }
}
