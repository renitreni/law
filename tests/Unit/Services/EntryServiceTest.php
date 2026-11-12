<?php

namespace Tests\Unit\Services;

use App\Models\Client;
use App\Models\Entry;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
use App\Services\EntryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EntryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EntryService;
    }

    protected function createTimeEntry(array $overrides = []): Entry
    {
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);

        return Entry::factory()->create(array_merge([
            'client_id' => Client::factory(),
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => Office::factory(),
        ], $overrides));
    }

    public function test_get_entry_by_date_returns_entries_for_given_date()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        $date = '2024-01-15';

        Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => $date,
        ]);

        Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => '2024-01-16',
        ]);

        $result = $this->service->getEntryByDate($date);

        $this->assertCount(1, $result);
        $this->assertEquals($date, $result[0]['entry_date']);
    }

    public function test_get_entry_by_date_returns_empty_array_when_no_entries()
    {
        $result = $this->service->getEntryByDate('2024-01-15');

        $this->assertEmpty($result);
    }

    public function test_get_entry_by_date_orders_by_created_at_desc()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        $date = '2024-01-15';

        $entry1 = Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => $date,
            'narrative' => 'First entry',
        ]);

        // Ensure the second entry has a later created_at
        $entry2 = Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => $date,
            'narrative' => 'Second entry',
            'created_at' => now()->addSecond(),
        ]);

        $result = $this->service->getEntryByDate($date);

        $this->assertCount(2, $result);
        $this->assertEquals('Second entry', $result[0]['narrative']);
        $this->assertEquals('First entry', $result[1]['narrative']);
    }

    public function test_create_saves_entry_with_all_fields()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        $timeEntry = [
            'client_id' => $client->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => '2024-01-15',
            'duration' => 2.5,
            'narrative' => 'Test narrative',
            'template_name' => 'Test Template',
            'is_template' => true,
            'is_billable' => true,
        ];

        $this->service->create($timeEntry, false);

        $this->assertDatabaseHas('entries', [
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => '2024-01-15',
            'duration' => 2.5,
            'narrative' => 'Test narrative',
            'template_name' => 'Test Template',
            'is_template' => true,
            'is_draft' => false,
            'is_billable' => true,
        ]);
    }

    public function test_create_sets_is_draft_correctly()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        $timeEntry = [
            'client_id' => $client->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => '2024-01-15',
            'duration' => 1.0,
            'narrative' => 'Draft entry',
            'is_billable' => false,
        ];

        $this->service->create($timeEntry, true);

        $this->assertDatabaseHas('entries', [
            'is_draft' => true,
        ]);
    }

    public function test_get_calendar_summary_aggregates_the_requested_range(): void
    {
        $this->createTimeEntry([
            'entry_date' => '2024-01-15',
            'duration' => 2.5,
            'is_draft' => false,
            'is_billable' => true,
        ]);
        $this->createTimeEntry([
            'entry_date' => '2024-01-15',
            'duration' => 1.5,
            'is_draft' => true,
            'is_billable' => false,
        ]);
        $this->createTimeEntry(['entry_date' => '2024-01-16', 'duration' => 4]);

        $result = $this->service->getCalendarSummary('2024-01-01', '2024-01-15');

        $this->assertCount(1, $result);
        $this->assertSame('2024-01-15', $result->first()->entry_date);
        $this->assertSame(2.5, (float) $result->first()->posted);
        $this->assertSame(1.5, (float) $result->first()->draft);
        $this->assertSame(2.5, (float) $result->first()->billable);
        $this->assertSame(1.5, (float) $result->first()->non_billable);
    }

    public function test_get_calendar_summary_excludes_templates_and_soft_deleted_entries(): void
    {
        $this->createTimeEntry([
            'entry_date' => '2024-01-15',
            'duration' => 2,
            'is_template' => true,
        ]);

        $deletedEntry = $this->createTimeEntry([
            'entry_date' => '2024-01-15',
            'duration' => 3,
        ]);
        $deletedEntry->delete();

        $this->assertCount(0, $this->service->getCalendarSummary('2024-01-01', '2024-01-31'));
    }

    public function test_get_entry_by_date_excludes_templates(): void
    {
        $this->createTimeEntry([
            'entry_date' => '2024-01-15',
            'is_template' => true,
        ]);

        $this->assertEmpty($this->service->getEntryByDate('2024-01-15'));
    }
}
