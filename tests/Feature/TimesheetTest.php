<?php

namespace Tests\Feature;

use App\Livewire\TimesheetLivewire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TimesheetTest extends TestCase
{
    use RefreshDatabase;

    public function test_timesheet_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/timesheet');

        $response->assertStatus(200);
        $response->assertSeeLivewire(TimesheetLivewire::class);
    }

    public function test_timesheet_livewire_component_mounts()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(TimesheetLivewire::class)
            ->assertStatus(200);
    }

    public function test_all_admin_blade_routes_render_without_500()
    {
        $user = User::factory()->create();

        $routes = [
            '/timesheet',
            '/options',
            '/matters',
            '/case',
            '/case/add',
            '/inquiry',
            '/invoice',
            '/photos',
            '/user',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($user)->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_guest_routes_render_without_500()
    {
        $guestRoutes = [
            '/',
            '/login',
            '/about',
            '/contact',
            '/services',
            '/attorneys',
            '/gallery',
        ];

        foreach ($guestRoutes as $route) {
            $response = $this->get($route);
            $this->assertNotEquals(500, $response->getStatusCode(), "Route {$route} returned 500");
        }
    }
}
