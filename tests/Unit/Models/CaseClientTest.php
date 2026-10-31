<?php

namespace Tests\Unit\Models;

use App\Models\CaseClient;
use App\Models\LawCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaseClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_case_client_can_be_created()
    {
        $lawCase = LawCase::factory()->create();
        $caseClient = CaseClient::factory()->create(['law_cases_id' => $lawCase->id]);

        $this->assertDatabaseHas('case_clients', [
            'id' => $caseClient->id,
            'law_cases_id' => $lawCase->id,
            'client_name' => $caseClient->client_name,
            'client_contact' => $caseClient->client_contact,
            'client_email' => $caseClient->client_email,
            'client_company' => $caseClient->client_company,
        ]);
    }

    public function test_case_client_uses_soft_deletes()
    {
        $lawCase = LawCase::factory()->create();
        $caseClient = CaseClient::factory()->create(['law_cases_id' => $lawCase->id]);
        $caseClient->delete();

        $this->assertSoftDeleted('case_clients', ['id' => $caseClient->id]);
    }

    public function test_case_client_belongs_to_law_case()
    {
        $lawCase = LawCase::factory()->create();
        $caseClient = CaseClient::factory()->create(['law_cases_id' => $lawCase->id]);

        $this->assertInstanceOf(LawCase::class, $caseClient->case);
        $this->assertEquals($lawCase->id, $caseClient->case->id);
    }
}