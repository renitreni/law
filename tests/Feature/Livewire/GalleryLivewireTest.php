<?php

namespace Tests\Feature\Livewire;

use App\Livewire\GalleryLivewire;
use App\Models\Gallery;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GalleryLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_uploads_photos_and_creates_gallery_records()
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->image('photo1.jpg');
        $file2 = UploadedFile::fake()->image('photo2.jpg');

        Livewire::test(GalleryLivewire::class)
            ->set('photos', [$file1, $file2])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/photos');

        $this->assertDatabaseCount('galleries', 2);
        Storage::disk('public')->assertExists('gallery/' . basename($file1->hashName()));
    }

    public function test_alert_dispatches_delete_success()
    {
        Livewire::test(GalleryLivewire::class)
            ->call('alert')
            ->assertDispatched('deleteSuccess');
    }

    public function test_render_returns_view()
    {
        Livewire::test(GalleryLivewire::class)
            ->call('render')
            ->assertViewIs('livewire.gallery-livewire');
    }
}