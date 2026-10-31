<?php

namespace Tests\Feature\Livewire;

use App\Livewire\OptionsLivewire;
use App\Models\Client;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OptionsLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_client_creates_client()
    {
        Livewire::test(OptionsLivewire::class)
            ->set('clientDetails.name', 'Test Client')
            ->set('clientDetails.code', 'TC001')
            ->call('storeClient')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'name' => 'Test Client',
            'code' => 'tc001',
        ]);
    }

    public function test_store_client_validates_required_fields()
    {
        Livewire::test(OptionsLivewire::class)
            ->set('clientDetails.name', '')
            ->set('clientDetails.code', '')
            ->call('storeClient')
            ->assertHasErrors(['clientDetails.name', 'clientDetails.code']);
    }

    public function test_destroy_client_deletes_client()
    {
        $client = Client::factory()->create();

        Livewire::test(OptionsLivewire::class)
            ->call('destroyClient', $client->id);

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    public function test_render_returns_all_clients()
    {
        Client::factory()->count(3)->create();

        Livewire::test(OptionsLivewire::class)
            ->call('render')
            ->assertViewIs('livewire.options-livewire');
    }
}