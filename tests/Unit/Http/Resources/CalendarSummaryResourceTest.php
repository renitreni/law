<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CalendarSummaryResource;
use Illuminate\Http\Request;
use Tests\TestCase;

class CalendarSummaryResourceTest extends TestCase
{
    public function test_calendar_summary_resource_transforms_data_correctly()
    {
        $resource = new CalendarSummaryResource((object) [
            'posted' => 5.5,
            'draft' => 2.0,
            'billable' => 4.0,
            'non_billable' => 3.5,
            'entry_date' => '2024-01-15',
        ]);

        $array = $resource->toArray($this->createMock(Request::class));

        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('start', $array);
        $this->assertEquals('2024-01-15', $array['start']);
        $this->assertStringContainsString('<strong>Posted:</strong> 5.5', $array['title']);
        $this->assertStringContainsString('<strong>Draft:</strong> 2', $array['title']);
        $this->assertStringContainsString('<strong>Billable:</strong> 4', $array['title']);
        $this->assertStringContainsString('<strong>Non-billable:</strong> 3.5', $array['title']);
    }
}
