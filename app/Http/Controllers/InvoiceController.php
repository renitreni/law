<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $invoices = Invoice::with('services')->latest()->paginate(15);

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:50',
            'address' => 'required|string',
            'services' => 'required|array|min:1',
            'services.*.service' => 'required|string|max:255',
            'services.*.amount' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'name' => $validated['name'],
            'phoneNumber' => $validated['phoneNumber'],
            'address' => $validated['address'],
        ]);

        foreach ($validated['services'] as $service) {
            InvoiceService::create([
                'invoice_id' => $invoice->id,
                'service' => $service['service'],
                'amount' => $service['amount'],
            ]);
        }

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice created successfully.');
    }
}
