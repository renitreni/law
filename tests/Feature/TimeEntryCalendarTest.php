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
}
