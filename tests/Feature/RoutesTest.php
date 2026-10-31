<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_welcome()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('welcome', ['lang' => 'en']));
    }

    public function test_login_route_exists()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_register_route_exists()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_authenticated_routes_redirect_guest_to_login()
    {
        $protectedRoutes = [
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

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }
}