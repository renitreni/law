<?php

namespace Tests\Feature;

use App\Models\LawCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseControllerTest extends TestCase
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

        $response = $this->actingAs($this->user)->get(route('case'));

        $response->assertStatus(200);
    }

    public function test_index_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('case'));

        $response->assertInertia(fn ($page) => $page
            ->component('Case/Index')
            ->has('recentCases')
        );
    }

    public function test_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('add_case'));

        $response->assertStatus(200);
    }

    public function test_create_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('add_case'));

        $response->assertInertia(fn ($page) => $page
            ->component('Case/Add')
        );
    }

    public function test_store_creates_case(): void
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

        $response = $this->actingAs($this->user)->post(route('case.store'), $caseData);

        $response->assertRedirect(route('case'));
        $this->assertDatabaseHas('law_cases', [
            'case_plaintiff' => 'John Doe',
            'case_defendant' => 'Jane Smith',
            'case_category' => 'Civil',
            'case_status' => 'Open',
        ]);
    }

    public function test_edit_returns_200(): void
    {
        $lawCase = LawCase::factory()->create();

        $response = $this->actingAs($this->user)->get(route('edit_case', $lawCase));

        $response->assertStatus(200);
    }

    public function test_edit_renders_inertia_page(): void
    {
        $lawCase = LawCase::factory()->create();

        $response = $this->actingAs($this->user)->get(route('edit_case', $lawCase));

        $response->assertInertia(fn ($page) => $page
            ->component('Case/Edit')
            ->has('case')
        );
    }

    public function test_update_case(): void
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

        $response = $this->actingAs($this->user)->put(route('case.update', $lawCase), $updateData);

        $response->assertRedirect(route('case'));
        $this->assertDatabaseHas('law_cases', [
            'id' => $lawCase->id,
            'case_plaintiff' => 'Updated Plaintiff',
            'case_defendant' => 'Updated Defendant',
            'case_category' => 'Civil',
            'case_status' => 'Open',
        ]);
    }

    public function test_destroy_case_soft_deletes(): void
    {
        $lawCase = LawCase::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('case.destroy', $lawCase));

        $response->assertRedirect(route('case'));
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
