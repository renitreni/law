<?php

namespace Tests\Unit\Models;

use App\Models\Invoice;
use App\Models\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_can_be_created()
    {
        $invoice = Invoice::factory()->create();

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'name' => $invoice->name,
            'phoneNumber' => $invoice->phoneNumber,
            'address' => $invoice->address,
        ]);
    }

    public function test_invoice_uses_soft_deletes()
    {
        $invoice = Invoice::factory()->create();
        $invoice->delete();

        $this->assertSoftDeleted('invoices', ['id' => $invoice->id]);
    }

    public function test_invoice_has_services_relationship()
    {
        $invoice = Invoice::factory()->create();
        InvoiceService::factory()->count(3)->create(['invoice_id' => $invoice->id]);

        $this->assertCount(3, $invoice->services);
    }
}
