<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\Entry;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use RefreshDatabase;

    public function test_entry_can_be_created()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        $entry = Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
        ]);

        $this->assertDatabaseHas('entries', [
            'id' => $entry->id,
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
        ]);
    }

    public function test_entry_uses_soft_deletes()
    {
        $entry = Entry::factory()->create();
        $entry->delete();

        $this->assertSoftDeleted('entries', ['id' => $entry->id]);
    }

    public function test_entry_belongs_to_client()
    {
        $client = Client::factory()->create();
        $entry = Entry::factory()->create(['client_id' => $client->id]);

        $this->assertInstanceOf(Client::class, $entry->clients);
        $this->assertEquals($client->id, $entry->clients->id);
    }

    public function test_entry_belongs_to_matter()
    {
        $matter = Matter::factory()->create();
        $entry = Entry::factory()->create(['matter_id' => $matter->id]);

        $this->assertInstanceOf(Matter::class, $entry->matters);
        $this->assertEquals($matter->id, $entry->matters->id);
    }

    public function test_entry_belongs_to_sub_matter()
    {
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $entry = Entry::factory()->create(['sub_matter_id' => $subMatter->id]);

        $this->assertInstanceOf(SubMatter::class, $entry->submatters);
        $this->assertEquals($subMatter->id, $entry->submatters->id);
    }

    public function test_entry_belongs_to_office()
    {
        $office = Office::factory()->create();
        $entry = Entry::factory()->create(['office_id' => $office->id]);

        $this->assertInstanceOf(Office::class, $entry->offices);
        $this->assertEquals($office->id, $entry->offices->id);
    }

    public function test_entry_auto_loads_relationships()
    {
        $client = Client::factory()->create();
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $office = Office::factory()->create();

        $entry = Entry::factory()->create([
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'sub_matter_id' => $subMatter->id,
            'office_id' => $office->id,
        ]);

        $freshEntry = Entry::find($entry->id);
        $this->assertInstanceOf(Client::class, $freshEntry->clients);
        $this->assertInstanceOf(Matter::class, $freshEntry->matters);
        $this->assertInstanceOf(SubMatter::class, $freshEntry->submatters);
        $this->assertInstanceOf(Office::class, $freshEntry->offices);
    }
}
