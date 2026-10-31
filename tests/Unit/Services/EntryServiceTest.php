<?php

namespace Tests\Unit\Services;

use App\Services\EntryService;
use App\Models\Entry;
use App\Models\Client;
use App\Models\Matter;
use App\Models\SubMatter;
use App\Models\Office;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class EntryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EntryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EntryService();
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

        $entry2 = Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
            'entry_date' => $date,
            'narrative' => 'Second entry',
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
}