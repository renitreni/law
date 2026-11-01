<?php

namespace Tests\Unit\Models;

use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfficeTest extends TestCase
{
    use RefreshDatabase;

    public function test_office_can_be_created()
    {
        $office = Office::factory()->create();

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => $office->name,
            'code' => $office->code,
        ]);
    }

    public function test_office_uses_soft_deletes()
    {
        $office = Office::factory()->create();
        $office->delete();

        $this->assertSoftDeleted('offices', ['id' => $office->id]);
    }

    public function test_office_fillable_attributes()
    {
        $office = Office::factory()->make([
            'name' => 'Test Office',
            'code' => 'TO001',
        ]);

        $this->assertEquals('Test Office', $office->name);
        $this->assertEquals('TO001', $office->code);
    }
}
