<?php

namespace Tests\Feature\Livewire;

use App\Livewire\MatterLivewire;
use App\Models\Matter;
use App\Models\SubMatter;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatterLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_matter_creates_matter()
    {
        Livewire::test(MatterLivewire::class)
            ->set('matterDetails.name', 'Test Matter')
            ->set('matterDetails.code', 'TM001')
            ->call('storeMatter')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('matters', [
            'name' => 'Test Matter',
            'code' => 'tm001',
        ]);
    }

    public function test_store_matter_validates_required_fields()
    {
        Livewire::test(MatterLivewire::class)
            ->set('matterDetails.name', '')
            ->set('matterDetails.code', '')
            ->call('storeMatter')
            ->assertHasErrors(['matterDetails.name', 'matterDetails.code']);
    }

    public function test_destroy_matter_deletes_matter()
    {
        $matter = Matter::factory()->create();

        Livewire::test(MatterLivewire::class)
            ->call('destroyMatter', $matter->id);

        $this->assertSoftDeleted('matters', ['id' => $matter->id]);
    }

    public function test_add_sub_matter_sets_sub_matter_details()
    {
        $matter = Matter::factory()->create();

        Livewire::test(MatterLivewire::class)
            ->call('addSubMatter', $matter->id)
            ->assertSet('subMatterDetails.matter_id', $matter->id);
    }

    public function test_store_sub_matter_creates_sub_matter()
    {
        $matter = Matter::factory()->create();

        Livewire::test(MatterLivewire::class)
            ->set('subMatterDetails.matter_id', $matter->id)
            ->set('subMatterDetails.name', 'Test Sub Matter')
            ->set('subMatterDetails.code', 'TSM001')
            ->call('storeSubMatter')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('sub_matters', [
            'matter_id' => $matter->id,
            'name' => 'Test Sub Matter',
            'code' => 'tsm001',
        ]);
    }

    public function test_store_sub_matter_validates_required_fields()
    {
        $matter = Matter::factory()->create();

        Livewire::test(MatterLivewire::class)
            ->set('subMatterDetails.matter_id', $matter->id)
            ->set('subMatterDetails.name', '')
            ->set('subMatterDetails.code', '')
            ->call('storeSubMatter')
            ->assertHasErrors(['subMatterDetails.name', 'subMatterDetails.code']);
    }

    public function test_destroy_sub_matter_deletes_sub_matter()
    {
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);

        Livewire::test(MatterLivewire::class)
            ->call('destroySubMatter', $subMatter->id);

        $this->assertSoftDeleted('sub_matters', ['id' => $subMatter->id]);
    }

    public function test_render_returns_paginated_matters()
    {
        Matter::factory()->count(5)->create();

        Livewire::test(MatterLivewire::class)
            ->call('render')
            ->assertViewIs('livewire.matter-livewire');
    }
}