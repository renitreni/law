<?php

namespace Tests\Unit\Models;

use App\Models\SubMatter;
use App\Models\Matter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubMatterTest extends TestCase
{
    use RefreshDatabase;

    public function test_sub_matter_can_be_created()
    {
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);

        $this->assertDatabaseHas('sub_matters', [
            'id' => $subMatter->id,
            'matter_id' => $matter->id,
            'name' => $subMatter->name,
            'code' => $subMatter->code,
        ]);
    }

    public function test_sub_matter_uses_soft_deletes()
    {
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);
        $subMatter->delete();

        $this->assertSoftDeleted('sub_matters', ['id' => $subMatter->id]);
    }

    public function test_sub_matter_belongs_to_matter()
    {
        $matter = Matter::factory()->create();
        $subMatter = SubMatter::factory()->create(['matter_id' => $matter->id]);

        $this->assertEquals($matter->id, $subMatter->matter_id);
        $this->assertInstanceOf(Matter::class, $subMatter->matter);
    }
}