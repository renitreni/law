<?php

namespace Tests\Unit\Models;

use App\Models\CaseClient;
use App\Models\CaseCourt;
use App\Models\CaseFiles;
use App\Models\LawCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LawCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_law_case_can_be_created()
    {
        $lawCase = LawCase::factory()->create();

        $this->assertDatabaseHas('law_cases', [
            'id' => $lawCase->id,
            'case_plaintiff' => $lawCase->case_plaintiff,
            'case_defendant' => $lawCase->case_defendant,
            'case_category' => $lawCase->case_category,
            'case_status' => $lawCase->case_status,
            'case_attorney' => $lawCase->case_attorney,
        ]);
    }

    public function test_law_case_uses_soft_deletes()
    {
        $lawCase = LawCase::factory()->create();
        $lawCase->delete();

        $this->assertSoftDeleted('law_cases', ['id' => $lawCase->id]);
    }

    public function test_law_case_has_client_relationship()
    {
        $lawCase = LawCase::factory()->create();
        $caseClient = CaseClient::factory()->create(['law_cases_id' => $lawCase->id]);

        $this->assertInstanceOf(CaseClient::class, $lawCase->client);
        $this->assertEquals($caseClient->id, $lawCase->client->id);
    }

    public function test_law_case_has_files_relationship()
    {
        $lawCase = LawCase::factory()->create();
        CaseFiles::factory()->count(3)->create(['law_cases_id' => $lawCase->id]);

        $this->assertCount(3, $lawCase->files);
    }

    public function test_law_case_has_court_relationship()
    {
        $lawCase = LawCase::factory()->create();
        CaseCourt::factory()->count(2)->create(['law_cases_id' => $lawCase->id]);

        $this->assertCount(2, $lawCase->court);
    }
}
