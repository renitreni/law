<?php

namespace Tests\Unit\Models;

use App\Models\Invoice;
use App\Models\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_service_can_be_created()
    {
        $invoice = Invoice::factory()->create();
        $service = InvoiceService::factory()->create(['invoice_id' => $invoice->id]);

        $this->assertDatabaseHas('invoice_services', [
            'id' => $service->id,
            'invoice_id' => $invoice->id,
            'service' => $service->service,
            'amount' => $service->amount,
        ]);
    }

    public function test_invoice_service_uses_soft_deletes()
    {
        $invoice = Invoice::factory()->create();
        $service = InvoiceService::factory()->create(['invoice_id' => $invoice->id]);
        $service->delete();

        $this->assertSoftDeleted('invoice_services', ['id' => $service->id]);
    }

    public function test_invoice_service_belongs_to_invoice()
    {
        $invoice = Invoice::factory()->create();
        $service = InvoiceService::factory()->create(['invoice_id' => $invoice->id]);

        $this->assertInstanceOf(Invoice::class, $service->invoice);
        $this->assertEquals($invoice->id, $service->invoice->id);
    }
}
