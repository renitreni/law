<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_be_created()
    {
        $client = Client::factory()->create();

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => $client->name,
            'code' => $client->code,
        ]);
    }

    public function test_client_uses_soft_deletes()
    {
        $client = Client::factory()->create();
        $client->delete();

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    public function test_client_fillable_attributes()
    {
        $client = Client::factory()->make([
            'name' => 'Test Client',
            'code' => 'TC001',
        ]);

        $this->assertEquals('Test Client', $client->name);
        $this->assertEquals('TC001', $client->code);
    }
}
