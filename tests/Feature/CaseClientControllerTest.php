<?php

namespace Tests\Feature;

use App\Models\CaseClient;
use App\Models\LawCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseClientControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected LawCase $lawCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->lawCase = LawCase::factory()->create();
    }

    public function test_index_returns_200(): void
    {
        CaseClient::factory()->count(3)->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->get(route('law-cases.clients.index', $this->lawCase));

        $response->assertStatus(200);
    }

    public function test_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('law-cases.clients.create', $this->lawCase));

        $response->assertStatus(200);
    }

    public function test_store_creates_client(): void
    {
        $clientData = [
            'law_cases_id' => $this->lawCase->id,
            'client_name' => 'Test Client',
            'client_contact' => 'John Contact',
            'client_email' => 'client@example.com',
            'client_company' => 'Test Company',
        ];

        $response = $this->actingAs($this->user)->post(route('law-cases.clients.store', $this->lawCase), $clientData);

        $response->assertRedirect(route('law-cases.clients.index', $this->lawCase));
        $this->assertDatabaseHas('case_clients', [
            'law_cases_id' => $this->lawCase->id,
            'client_name' => 'Test Client',
            'client_email' => 'client@example.com',
        ]);
    }

    public function test_show_returns_200(): void
    {
        $client = CaseClient::factory()->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->get(route('law-cases.clients.show', [$this->lawCase, $client]));

        $response->assertStatus(200);
    }

    public function test_edit_returns_200(): void
    {
        $client = CaseClient::factory()->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->get(route('law-cases.clients.edit', [$this->lawCase, $client]));

        $response->assertStatus(200);
    }

    public function test_update_client(): void
    {
        $client = CaseClient::factory()->create([
            'law_cases_id' => $this->lawCase->id,
            'client_name' => 'Original Client',
            'client_email' => 'original@example.com',
        ]);

        $updateData = [
            'client_name' => 'Updated Client',
            'client_contact' => 'Updated Contact',
            'client_email' => 'updated@example.com',
            'client_company' => 'Updated Company',
        ];

        $response = $this->actingAs($this->user)->put(route('law-cases.clients.update', [$this->lawCase, $client]), $updateData);

        $response->assertRedirect(route('law-cases.clients.index', $this->lawCase));
        $this->assertDatabaseHas('case_clients', [
            'id' => $client->id,
            'client_name' => 'Updated Client',
            'client_email' => 'updated@example.com',
        ]);
    }

    public function test_destroy_client_soft_deletes(): void
    {
        $client = CaseClient::factory()->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->delete(route('law-cases.clients.destroy', [$this->lawCase, $client]));

        $response->assertRedirect(route('law-cases.clients.index', $this->lawCase));
        $this->assertSoftDeleted('case_clients', ['id' => $client->id]);
    }

    public function test_validation_rejects_missing_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('law-cases.clients.store', $this->lawCase), []);

        $response->assertSessionHasErrors([
            'law_cases_id',
            'client_name',
        ]);
    }
}
