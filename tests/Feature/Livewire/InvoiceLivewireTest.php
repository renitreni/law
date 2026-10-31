<?php

namespace Tests\Feature\Livewire;

use App\Livewire\InvoiceLivewire;
use App\Models\Invoice;
use App\Models\InvoiceService;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_creates_invoice_with_services()
    {
        Livewire::test(InvoiceLivewire::class)
            ->set('name', 'Test Invoice')
            ->set('phoneNumber', '1234567890')
            ->set('address', '123 Test St')
            ->set('services', [
                ['service' => 'Service 1', 'amount' => 100.00],
                ['service' => 'Service 2', 'amount' => 200.00],
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('invoices', [
            'name' => 'Test Invoice',
            'phoneNumber' => '1234567890',
            'address' => '123 Test St',
        ]);

        $invoice = Invoice::first();
        $this->assertCount(2, $invoice->services);
    }

    public function test_add_service_adds_service_to_array()
    {
        Livewire::test(InvoiceLivewire::class)
            ->call('addService')
            ->assertSet('services.0.service', '')
            ->assertSet('services.0.amount', 0);
    }

    public function test_remove_removes_last_service()
    {
        Livewire::test(InvoiceLivewire::class)
            ->set('services', [
                ['service' => 'Service 1', 'amount' => 100],
                ['service' => 'Service 2', 'amount' => 200],
            ])
            ->call('remove')
            ->assertSet('services.0.service', 'Service 1')
            ->assertSet('services.1', []);
    }

    public function test_reset_all_resets_component()
    {
        Livewire::test(InvoiceLivewire::class)
            ->set('name', 'Test')
            ->set('isDisplay', true)
            ->call('resetAll')
            ->assertSet('name', '')
            ->assertSet('isDisplay', false);
    }
}