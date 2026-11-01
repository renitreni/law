<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimesheetControllerTest extends TestCase
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
        $response = $this->actingAs($this->user)->get(route('timesheet'));

        $response->assertStatus(200);
    }

    public function test_index_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('timesheet'));

        $response->assertInertia(fn ($page) => $page
            ->component('Timesheet/Index')
            ->has('clients')
            ->has('matters')
            ->has('offices')
        );
    }
}
