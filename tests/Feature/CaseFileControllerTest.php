<?php

namespace Tests\Feature;

use App\Models\CaseFiles;
use App\Models\LawCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CaseFileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected LawCase $lawCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->lawCase = LawCase::factory()->create();
        Storage::fake('public');
    }

    public function test_index_returns_200(): void
    {
        CaseFiles::factory()->count(3)->create(['law_cases_id' => $this->lawCase->id]);

        $response = $this->actingAs($this->user)->get(route('law-cases.files.index', $this->lawCase));

        $response->assertStatus(200);
    }

    public function test_create_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('law-cases.files.create', $this->lawCase));

        $response->assertStatus(200);
    }

    public function test_store_uploads_file(): void
    {
        $file = UploadedFile::fake()->create('test.pdf', 100);

        $response = $this->actingAs($this->user)->post(route('law-cases.files.store', $this->lawCase), [
            'filename' => 'Test Document',
            'file' => $file,
        ]);

        // Check that file was stored and database was updated
        $this->assertDatabaseHas('case_files', [
            'law_cases_id' => $this->lawCase->id,
            'filename' => 'Test Document',
        ]);

        // Check file was stored
        $storedFile = CaseFiles::where('filename', 'Test Document')->first();
        $this->assertNotNull($storedFile);
        $this->assertNotNull($storedFile->file_path);
        Storage::disk('public')->assertExists($storedFile->file_path);

        // Check for successful response (either redirect or 200)
        $this->assertTrue($response->status() === 302 || $response->status() === 200);
    }

    public function test_destroy_deletes_file_and_record(): void
    {
        $file = CaseFiles::factory()->create([
            'law_cases_id' => $this->lawCase->id,
            'filename' => 'test.pdf',
            'file_path' => 'case-files/test.pdf',
        ]);

        Storage::disk('public')->put('case-files/test.pdf', 'fake content');

        $response = $this->actingAs($this->user)->delete(route('law-cases.files.destroy', [$this->lawCase, $file]));

        $response->assertRedirect(route('law-cases.files.index', $this->lawCase));
        $this->assertSoftDeleted('case_files', ['id' => $file->id]);
        Storage::disk('public')->assertMissing('case-files/test.pdf');
    }

    public function test_validation_rejects_missing_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('law-cases.files.store', $this->lawCase), []);

        $response->assertSessionHasErrors([
            'filename',
            'file',
        ]);
    }
}
