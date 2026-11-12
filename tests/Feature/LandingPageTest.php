<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_returns_200()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_guest_sees_login_button()
    {
        $response = $this->get('/');

        $response->assertSee('No landing page yet');
        $response->assertSee(route('login'), false);
    }

    public function test_authenticated_user_sees_dashboard_button()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertSee(route('timesheet'), false);
    }
}
