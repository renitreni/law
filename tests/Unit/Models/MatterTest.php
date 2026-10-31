<?php

namespace Tests\Unit\Models;

use App\Models\Matter;
use App\Models\SubMatter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatterTest extends TestCase
{
    use RefreshDatabase;

    public function test_matter_can_be_created()
    {
        $matter = Matter::factory()->create();

        $this->assertDatabaseHas('matters', [
            'id' => $matter->id,
            'name' => $matter->name,
            'code' => $matter->code,
        ]);
    }

    public function test_matter_uses_soft_deletes()
    {
        $matter = Matter::factory()->create();
        $matter->delete();

        $this->assertSoftDeleted('matters', ['id' => $matter->id]);
    }

    public function test_matter_has_submatters_relationship()
    {
        $matter = Matter::factory()->create();
        SubMatter::factory()->count(3)->create(['matter_id' => $matter->id]);

        $this->assertCount(3, $matter->subMatters);
    }

    public function test_matter_auto_loads_submatters()
    {
        $matter = Matter::factory()->create();
        SubMatter::factory()->count(2)->create(['matter_id' => $matter->id]);

        $freshMatter = Matter::find($matter->id);
        $this->assertCount(2, $freshMatter->subMatters);
    }
}