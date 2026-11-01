<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InertiaSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_inertia_test_route_returns_200()
    {
        $response = $this->get('/inertia-test');
        $response->assertStatus(200);
    }

    public function test_inertia_renders_welcome_page()
    {
        $response = $this->get('/inertia-test');
        $response->assertInertia(fn ($page) => $page
            ->component('Welcome')
            ->has('message')
            ->has('flash')
        );
    }

    public function test_inertia_shares_flash_messages()
    {
        $response = $this->withSession(['success' => 'Operation successful'])
            ->get('/inertia-test');

        $response->assertInertia(fn ($page) => $page
            ->component('Welcome')
            ->where('flash.success', 'Operation successful')
            ->where('flash.error', null)
        );
    }
}
