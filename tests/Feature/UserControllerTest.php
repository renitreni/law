<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get(route('user'));

        $response->assertStatus(200);
    }

    public function test_index_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('user'));

        $response->assertInertia(fn ($page) => $page
            ->component('User/Index')
            ->has('users')
        );
    }
}