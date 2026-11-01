<?php

namespace Tests\Feature;

use App\Models\Matter;
use App\Models\SubMatter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterControllerTest extends TestCase
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
        Matter::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get(route('matters.index'));

        $response->assertStatus(200);
    }

    public function test_index_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('matters.index'));

        $response->assertInertia(fn ($page) => $page
            ->component('Matter/Index')
            ->has('matters')
        );
    }

    public function test_store_creates_matter(): void
    {
        $matterData = [
            'name' => 'Test Matter',
            'code' => 'tm001',
        ];

        $response = $this->actingAs($this->user)->post(route('matters.store'), $matterData);

        $response->assertRedirect(route('matters.index'));
        $this->assertDatabaseHas('matters', [
            'name' => 'Test Matter',
            'code' => 'tm001',
        ]);
    }

    public function test_destroy_matter_soft_deletes(): void
    {
        $matter = Matter::factory()->create();
        $matterId = $matter->id;

        $response = $this->actingAs($this->user)->delete(route('matters.destroy', $matter));

        $response->assertRedirect(route('matters.index'));
        $this->assertSoftDeleted('matters', ['id' => $matterId]);
    }

    public function test_store_sub_matter(): void
    {
        $matter = Matter::factory()->create();

        $subMatterData = [
            'name' => 'Test Sub Matter',
            'code' => 'tsm001',
        ];

        $response = $this->actingAs($this->user)->post(route('matters.storeSubMatter', $matter), $subMatterData);

        $response->assertRedirect(route('matters.index'));
        $this->assertDatabaseHas('sub_matters', [
            'matter_id' => $matter->id,
            'name' => 'Test Sub Matter',
            'code' => 'tsm001',
        ]);
    }

    public function test_destroy_sub_matter_soft_deletes(): void
    {
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);

        $response = $this->actingAs($this->user)->delete(route('matters.destroySubMatter', [$matter, $subMatter]));

        $response->assertRedirect(route('matters.index'));
        $this->assertSoftDeleted('sub_matters', ['id' => $subMatter->id]);
    }

    public function test_validation_rejects_missing_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('matters.store'), []);

        $response->assertSessionHasErrors(['name', 'code']);
    }
}
