<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class GetTemplateTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_template_returns_wrapped_results()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/template');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'results' => [
                    '*' => ['id', 'text'],
                ],
            ]);
    }

    public function test_get_template_requires_authentication()
    {
        $response = $this->getJson('/api/template');

        $response->assertStatus(401);
    }
}