<?php

namespace Tests\Unit\Models;

use App\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_can_be_created()
    {
        $gallery = Gallery::factory()->create();

        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'photo_name' => $gallery->photo_name,
        ]);
    }

    public function test_gallery_fillable_attributes()
    {
        $gallery = Gallery::factory()->make([
            'photo_name' => 'test-image.jpg',
        ]);

        $this->assertEquals('test-image.jpg', $gallery->photo_name);
    }
}
