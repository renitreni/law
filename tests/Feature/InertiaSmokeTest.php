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
        );
    }
}
