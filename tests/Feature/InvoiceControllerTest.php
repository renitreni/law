<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\InvoiceService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_200(): void
    {
        Invoice::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get(route('invoice.index'));

        $response->assertStatus(200);
    }

    public function test_index_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('invoice.index'));

        $response->assertInertia(fn ($page) => $page
            ->component('Invoice/Index')
            ->has('invoices')
        );
    }

    public function test_store_creates_invoice(): void
    {
        $invoiceData = [
            'name' => 'Test Client',
            'phoneNumber' => '1234567890',
            'address' => '123 Test St',
            'services' => [
                ['service' => 'Legal Consultation', 'amount' => 500],
                ['service' => 'Document Review', 'amount' => 300],
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('invoice.store'), $invoiceData);

        $response->assertRedirect(route('invoice.index'));
        $this->assertDatabaseHas('invoices', [
            'name' => 'Test Client',
            'phoneNumber' => '1234567890',
            'address' => '123 Test St',
        ]);
        
        $invoice = Invoice::where('name', 'Test Client')->first();
        $this->assertDatabaseHas('invoice_services', [
            'invoice_id' => $invoice->id,
            'service' => 'Legal Consultation',
            'amount' => 500,
        ]);
    }

    public function test_validation_rejects_missing_required_fields(): void
    {
        $response = $this->actingAs($this->user)->post(route('invoice.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'phoneNumber',
            'address',
            'services',
        ]);
    }
}