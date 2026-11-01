<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_index_returns_200(): void
    {
        Gallery::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get(route('gallery.index'));

        $response->assertStatus(200);
    }

    public function test_index_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('gallery.index'));

        $response->assertInertia(fn ($page) => $page
            ->component('Gallery/Index')
            ->has('photos')
        );
    }

    public function test_store_uploads_photos(): void
    {
        $photo1 = UploadedFile::fake()->image('photo1.jpg', 800, 600);
        $photo2 = UploadedFile::fake()->image('photo2.png', 400, 300);

        $response = $this->actingAs($this->user)->post(route('gallery.store'), [
            'photos' => [$photo1, $photo2],
        ]);

        $response->assertRedirect(route('gallery.index'));
        $this->assertDatabaseCount('galleries', 2);
    }

    public function test_destroy_deletes_photo_and_file(): void
    {
        $photo = Gallery::factory()->create(['photo_name' => 'test.jpg']);
        Storage::disk('public')->put('gallery/test.jpg', 'fake content');

        $response = $this->actingAs($this->user)->delete(route('gallery.destroy', $photo));

        $response->assertRedirect(route('gallery.index'));
        $this->assertSoftDeleted('galleries', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing('gallery/test.jpg');
    }

    public function test_validation_rejects_non_images(): void
    {
        $file = UploadedFile::fake()->create('test.pdf', 100);

        $response = $this->actingAs($this->user)->post(route('gallery.store'), [
            'photos' => [$file],
        ]);

        $response->assertSessionHasErrors('photos.*');
    }
}
