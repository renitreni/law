<?php

namespace Tests\Unit\Models;

use App\Models\CaseCourt;
use App\Models\LawCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseCourtTest extends TestCase
{
    use RefreshDatabase;

    public function test_case_court_can_be_created()
    {
        $lawCase = LawCase::factory()->create();
        $caseCourt = CaseCourt::factory()->create(['law_cases_id' => $lawCase->id]);

        $this->assertDatabaseHas('case_courts', [
            'id' => $caseCourt->id,
            'law_cases_id' => $lawCase->id,
            'court_name' => $caseCourt->court_name,
            'court_date' => $caseCourt->court_date,
            'court_address' => $caseCourt->court_address,
        ]);
    }

    public function test_case_court_uses_soft_deletes()
    {
        $lawCase = LawCase::factory()->create();
        $caseCourt = CaseCourt::factory()->create(['law_cases_id' => $lawCase->id]);
        $caseCourt->delete();

        $this->assertSoftDeleted('case_courts', ['id' => $caseCourt->id]);
    }

    public function test_case_court_belongs_to_law_case()
    {
        $lawCase = LawCase::factory()->create();
        $caseCourt = CaseCourt::factory()->create(['law_cases_id' => $lawCase->id]);

        $this->assertInstanceOf(LawCase::class, $caseCourt->case);
        $this->assertEquals($lawCase->id, $caseCourt->case->id);
    }
}
