<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OptionsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_200(): void
    {
        Client::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get(route('options.index'));

        $response->assertStatus(200);
    }

    public function test_index_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('options.index'));

        $response->assertInertia(fn ($page) => $page
            ->component('Options/Index')
            ->has('clients')
        );
    }

    public function test_store_creates_client(): void
    {
        $clientData = [
            'name' => 'Test Client',
            'code' => 'tc001',
        ];

        $response = $this->actingAs($this->user)->post(route('options.store'), $clientData);

        $response->assertRedirect(route('options.index'));
        $this->assertDatabaseHas('clients', [
            'name' => 'Test Client',
            'code' => 'tc001',
        ]);
    }

    public function test_destroy_client_soft_deletes(): void
    {
        $client = Client::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('options.destroy', $client));

        $response->assertRedirect(route('options.index'));
        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    public function test_validation_rejects_missing_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('options.store'), []);

        $response->assertSessionHasErrors(['name', 'code']);
    }
}
