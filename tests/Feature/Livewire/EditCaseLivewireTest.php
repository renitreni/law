<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CaseFeature\EditCaseLivewire;
use App\Models\LawCase;
use App\Models\CaseClient;
use App\Models\CaseCourt;
use App\Models\CaseFiles;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EditCaseLivewireTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_mount_loads_case_data()
    {
        $lawCase = LawCase::factory()->create();
        CaseClient::factory()->create(['law_cases_id' => $lawCase->id]);
        CaseCourt::factory()->create(['law_cases_id' => $lawCase->id]);
        CaseFiles::factory()->create(['law_cases_id' => $lawCase->id]);

        Livewire::test(EditCaseLivewire::class, ['id' => $lawCase->id])
            ->assertSet('id', $lawCase->id)
            ->assertSet('isEdit', true)
            ->assertSet('addForm.case_plaintiff', $lawCase->case_plaintiff);
    }

    public function test_save_changes_updates_case()
    {
        $lawCase = LawCase::factory()->create();

        Livewire::test(EditCaseLivewire::class, ['id' => $lawCase->id])
            ->set('addForm.case_plaintiff', 'Updated Plaintiff')
            ->set('addForm.case_defendant', 'Updated Defendant')
            ->set('addForm.case_category', 'Criminal')
            ->set('addForm.case_status', 'Closed')
            ->set('addForm.case_description', 'Updated description')
            ->set('addForm.case_attorney', 'New Attorney')
            ->set('addForm.case_date', '2024-03-01')
            ->set('addForm.client_name', 'New Client')
            ->set('addForm.client_contact', '0987654321')
            ->set('addForm.client_email', 'new@example.com')
            ->set('addForm.client_company', 'New Company')
            ->set('courts', [
                ['id' => '', 'court_name' => 'New Court', 'court_address' => '456 Court Ave', 'court_date' => '2024-04-01'],
            ])
            ->call('saveChanges', $lawCase->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('law_cases', [
            'id' => $lawCase->id,
            'case_plaintiff' => 'Updated Plaintiff',
            'case_status' => 'Closed',
        ]);
    }

    public function test_delete_file_removes_file()
    {
        $lawCase = LawCase::factory()->create();
        $caseFile = CaseFiles::factory()->create(['law_cases_id' => $lawCase->id]);

        Storage::fake('public');
        Storage::disk('public')->put('case/' . $caseFile->filename, 'content');

        Livewire::test(EditCaseLivewire::class, ['id' => $lawCase->id])
            ->call('deleteFile', $caseFile)
            ->assertRedirect(route('edit_case', ['id' => $lawCase->id]));

        $this->assertSoftDeleted('case_files', ['id' => $caseFile->id]);
    }

    public function test_delete_deletes_case()
    {
        $lawCase = LawCase::factory()->create();

        Livewire::test(EditCaseLivewire::class, ['id' => $lawCase->id])
            ->call('delete')
            ->assertRedirect(route('case'));

        $this->assertSoftDeleted('law_cases', ['id' => $lawCase->id]);
    }

    public function test_add_adds_new_court_entry()
    {
        $lawCase = LawCase::factory()->create();

        Livewire::test(EditCaseLivewire::class, ['id' => $lawCase->id])
            ->call('add')
            ->assertSet('courts.0.id', '')
            ->assertSet('courts.0.court_name', '')
            ->assertSet('courts.0.court_address', '');
    }

    public function test_upload_new_file_uploads_file()
    {
        Storage::fake('public');

        $lawCase = LawCase::factory()->create();
        $file = UploadedFile::fake()->create('new-doc.pdf');

        Livewire::test(EditCaseLivewire::class, ['id' => $lawCase->id])
            ->set('newFiles', [$file])
            ->call('uploadNewFile')
            ->assertRedirect(route('edit_case', ['id' => $lawCase->id]));

        $this->assertDatabaseCount('case_files', 1);
    }
}