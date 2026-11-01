<?php

namespace Tests\Unit\Models;

use App\Models\CaseFiles;
use App\Models\LawCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseFilesTest extends TestCase
{
    use RefreshDatabase;

    public function test_case_files_can_be_created()
    {
        $lawCase = LawCase::factory()->create();
        $caseFile = CaseFiles::factory()->create(['law_cases_id' => $lawCase->id]);

        $this->assertDatabaseHas('case_files', [
            'id' => $caseFile->id,
            'law_cases_id' => $lawCase->id,
            'filename' => $caseFile->filename,
            'uploaded_by' => $caseFile->uploaded_by,
        ]);
    }

    public function test_case_files_uses_soft_deletes()
    {
        $lawCase = LawCase::factory()->create();
        $caseFile = CaseFiles::factory()->create(['law_cases_id' => $lawCase->id]);
        $caseFile->delete();

        $this->assertSoftDeleted('case_files', ['id' => $caseFile->id]);
    }

    public function test_case_files_belongs_to_law_case()
    {
        $lawCase = LawCase::factory()->create();
        $caseFile = CaseFiles::factory()->create(['law_cases_id' => $lawCase->id]);

        $this->assertInstanceOf(LawCase::class, $caseFile->case);
        $this->assertEquals($lawCase->id, $caseFile->case->id);
    }
}
