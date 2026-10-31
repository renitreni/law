<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CaseFeature\AddCaseLivewire;
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

class AddCaseLivewireTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_save_creates_case_with_client_and_court()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf');

        Livewire::test(AddCaseLivewire::class)
            ->set('addForm.case_plaintiff', 'John Plaintiff')
            ->set('addForm.case_defendant', 'Jane Defendant')
            ->set('addForm.case_category', 'Civil')
            ->set('addForm.case_status', 'Open')
            ->set('addForm.case_description', 'Test case description')
            ->set('addForm.case_attorney', 'Attorney Name')
            ->set('addForm.case_date', '2024-01-15')
            ->set('addForm.client_name', 'Client Name')
            ->set('addForm.client_contact', '1234567890')
            ->set('addForm.client_email', 'client@example.com')
            ->set('addForm.client_company', 'Client Company')
            ->set('addForm.court_name', 'Supreme Court')
            ->set('addForm.court_address', '123 Court St')
            ->set('addForm.court_date', '2024-02-01')
            ->set('addForm.case_documents', [$file])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('add_case'));

        $this->assertDatabaseCount('law_cases', 1);
        $this->assertDatabaseCount('case_clients', 1);
        $this->assertDatabaseCount('case_courts', 1);
        $this->assertDatabaseCount('case_files', 1);
    }

    public function test_save_validates_required_fields()
    {
        Livewire::test(AddCaseLivewire::class)
            ->set('addForm.case_plaintiff', '')
            ->set('addForm.case_defendant', '')
            ->set('addForm.case_category', '')
            ->set('addForm.case_status', '')
            ->set('addForm.case_description', '')
            ->set('addForm.case_attorney', '')
            ->set('addForm.client_name', '')
            ->set('addForm.client_company', '')
            ->set('addForm.client_contact', '')
            ->set('addForm.client_email', '')
            ->set('addForm.court_name', '')
            ->set('addForm.court_address', '')
            ->set('addForm.court_date', '')
            ->call('save')
            ->assertHasErrors([
                'addForm.case_plaintiff',
                'addForm.case_defendant',
                'addForm.case_category',
                'addForm.case_status',
                'addForm.case_description',
                'addForm.case_attorney',
                'addForm.client_name',
                'addForm.client_company',
                'addForm.client_contact',
                'addForm.client_email',
                'addForm.court_name',
                'addForm.court_address',
                'addForm.court_date',
            ]);
    }

    public function test_go_back_redirects_to_case_route()
    {
        Livewire::test(AddCaseLivewire::class)
            ->call('goBack')
            ->assertRedirect(route('case'));
    }
}