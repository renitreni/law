<?php

namespace Tests\Unit\Models;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_inquiry_can_be_created()
    {
        $inquiry = Inquiry::factory()->create();

        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'firstname' => $inquiry->firstname,
            'lastname' => $inquiry->lastname,
            'email' => $inquiry->email,
            'phonenumber' => $inquiry->phonenumber,
            'legalIssue' => $inquiry->legalIssue,
            'message' => $inquiry->message,
        ]);
    }

    public function test_inquiry_fillable_attributes()
    {
        $inquiry = Inquiry::factory()->make([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phonenumber' => '1234567890',
            'legalIssue' => 'Civil',
            'message' => 'Test message',
        ]);

        $this->assertEquals('John', $inquiry->firstname);
        $this->assertEquals('Doe', $inquiry->lastname);
        $this->assertEquals('john.doe@example.com', $inquiry->email);
        $this->assertEquals('1234567890', $inquiry->phonenumber);
        $this->assertEquals('Civil', $inquiry->legalIssue);
        $this->assertEquals('Test message', $inquiry->message);
    }
}
