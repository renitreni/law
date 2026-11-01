<?php

namespace Tests\Feature;

use App\Models\CaseCourt;
use App\Models\LawCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseCourtControllerTest extends TestCase
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
        CaseCourt::factory()->count(3)->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->get(route('law-cases.courts.index', $this->lawCase));

        $response->assertStatus(200);
    }

    public function test_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('law-cases.courts.create', $this->lawCase));

        $response->assertStatus(200);
    }

    public function test_store_creates_court(): void
    {
        $courtData = [
            'law_cases_id' => $this->lawCase->id,
            'court_name' => 'Supreme Court',
            'court_date' => '2024-06-15',
            'court_address' => '123 Court St',
        ];

        $response = $this->actingAs($this->user)->post(route('law-cases.courts.store', $this->lawCase), $courtData);

        $response->assertRedirect(route('law-cases.courts.index', $this->lawCase));
        $this->assertDatabaseHas('case_courts', [
            'law_cases_id' => $this->lawCase->id,
            'court_name' => 'Supreme Court',
            'court_date' => '2024-06-15',
        ]);
    }

    public function test_show_returns_200(): void
    {
        $court = CaseCourt::factory()->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->get(route('law-cases.courts.show', [$this->lawCase, $court]));

        $response->assertStatus(200);
    }

    public function test_edit_returns_200(): void
    {
        $court = CaseCourt::factory()->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->get(route('law-cases.courts.edit', [$this->lawCase, $court]));

        $response->assertStatus(200);
    }

    public function test_update_court(): void
    {
        $court = CaseCourt::factory()->create([
            'law_cases_id' => $this->lawCase->id,
            'court_name' => 'Original Court',
            'court_date' => '2024-01-01',
        ]);

        $updateData = [
            'court_name' => 'Updated Court',
            'court_date' => '2024-07-01',
            'court_address' => '456 New Court Ave',
        ];

        $response = $this->actingAs($this->user)->put(route('law-cases.courts.update', [$this->lawCase, $court]), $updateData);

        $response->assertRedirect(route('law-cases.courts.index', $this->lawCase));
        $this->assertDatabaseHas('case_courts', [
            'id' => $court->id,
            'court_name' => 'Updated Court',
            'court_date' => '2024-07-01',
        ]);
    }

    public function test_destroy_court_soft_deletes(): void
    {
        $court = CaseCourt::factory()->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->delete(route('law-cases.courts.destroy', [$this->lawCase, $court]));

        $response->assertRedirect(route('law-cases.courts.index', $this->lawCase));
        $this->assertSoftDeleted('case_courts', ['id' => $court->id]);
    }

    public function test_validation_rejects_missing_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('law-cases.courts.store', $this->lawCase), []);

        $response->assertSessionHasErrors([
            'law_cases_id',
            'court_name',
            'court_date',
        ]);
    }
}
