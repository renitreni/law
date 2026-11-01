<?php

namespace Tests\Feature;

use App\Models\LawCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LawCaseControllerTest extends TestCase
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
        LawCase::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get(route('law-cases.index'));

        $response->assertStatus(200);
    }

    public function test_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('law-cases.create'));

        $response->assertStatus(200);
    }

    public function test_store_creates_law_case(): void
    {
        $caseData = [
            'case_plaintiff' => 'John Doe',
            'case_defendant' => 'Jane Smith',
            'case_category' => 'Civil',
            'case_status' => 'Open',
            'case_description' => 'Test case description',
            'case_attorney' => 'Attorney Name',
            'case_date' => '2024-01-15',
            'case_opponent' => 'Opponent Name',
        ];

        $response = $this->actingAs($this->user)->post(route('law-cases.store'), $caseData);

        $response->assertRedirect(route('law-cases.index'));
        $this->assertDatabaseHas('law_cases', [
            'case_plaintiff' => 'John Doe',
            'case_defendant' => 'Jane Smith',
            'case_category' => 'Civil',
            'case_status' => 'Open',
        ]);
    }

    public function test_show_returns_200(): void
    {
        $lawCase = LawCase::factory()->create();

        $response = $this->actingAs($this->user)->get(route('law-cases.show', $lawCase));

        $response->assertStatus(200);
    }

    public function test_edit_returns_200(): void
    {
        $lawCase = LawCase::factory()->create();

        $response = $this->actingAs($this->user)->get(route('law-cases.edit', $lawCase));

        $response->assertStatus(200);
    }

    public function test_update_law_case(): void
    {
        $lawCase = LawCase::factory()->create([
            'case_plaintiff' => 'Original Plaintiff',
            'case_defendant' => 'Original Defendant',
            'case_category' => 'Criminal',
            'case_status' => 'Closed',
        ]);

        $updateData = [
            'case_plaintiff' => 'Updated Plaintiff',
            'case_defendant' => 'Updated Defendant',
            'case_category' => 'Civil',
            'case_status' => 'Open',
            'case_description' => 'Updated description',
            'case_attorney' => 'Updated Attorney',
            'case_date' => '2024-06-01',
            'case_opponent' => 'Updated Opponent',
        ];

        $response = $this->actingAs($this->user)->put(route('law-cases.update', $lawCase), $updateData);

        $response->assertRedirect(route('law-cases.index'));
        $this->assertDatabaseHas('law_cases', [
            'id' => $lawCase->id,
            'case_plaintiff' => 'Updated Plaintiff',
            'case_defendant' => 'Updated Defendant',
            'case_category' => 'Civil',
            'case_status' => 'Open',
        ]);
    }

    public function test_destroy_law_case_soft_deletes(): void
    {
        $lawCase = LawCase::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('law-cases.destroy', $lawCase));

        $response->assertRedirect(route('law-cases.index'));
        $this->assertSoftDeleted('law_cases', ['id' => $lawCase->id]);
    }

    public function test_validation_rejects_missing_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('law-cases.store'), []);

        $response->assertSessionHasErrors([
            'case_plaintiff',
            'case_defendant',
            'case_category',
            'case_status',
            'case_date',
        ]);
    }
}
