<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\GetTemplateResource;
use Tests\TestCase;

class GetTemplateResourceTest extends TestCase
{
    public function test_get_template_resource_wraps_results()
    {
        $resource = new GetTemplateResource((object)[
            'id' => 1,
            'template_name' => 'Test Template',
            'is_template' => true,
        ]);

        $array = $resource->toArray($this->createMock(\Illuminate\Http\Request::class));

        $this->assertArrayHasKey('results', $array);
        $this->assertEquals(1, $array['results']['id']);
        $this->assertEquals('Test Template', $array['results']['text']);
    }

    public function test_get_template_resource_returns_correct_structure()
    {
        $resource = new GetTemplateResource((object)[
            'id' => 42,
            'template_name' => 'Another Template',
            'is_template' => true,
        ]);

        $array = $resource->toArray($this->createMock(\Illuminate\Http\Request::class));

        $this->assertArrayHasKey('results', $array);
        $this->assertEquals(42, $array['results']['id']);
        $this->assertEquals('Another Template', $array['results']['text']);
    }
}