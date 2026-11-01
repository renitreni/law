<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseClientStoreRequest;
use App\Http\Requests\CaseClientUpdateRequest;
use App\Models\CaseClient;
use App\Models\LawCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CaseClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LawCase $lawCase): Response
    {
        $clients = $lawCase->client()->paginate(15);

        return Inertia::render('LawCase/Client/Index', [
            'lawCase' => $lawCase,
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(LawCase $lawCase): Response
    {
        return Inertia::render('LawCase/Client/Create', [
            'lawCase' => $lawCase,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CaseClientStoreRequest $request, LawCase $lawCase): RedirectResponse
    {
        $client = $lawCase->client()->create($request->validated());

        return redirect()->route('law-cases.clients.index', $lawCase)
            ->with('success', 'Client added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LawCase $lawCase, CaseClient $client): Response
    {
        return Inertia::render('LawCase/Client/Show', [
            'lawCase' => $lawCase,
            'client' => $client,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LawCase $lawCase, CaseClient $client): Response
    {
        return Inertia::render('LawCase/Client/Edit', [
            'lawCase' => $lawCase,
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CaseClientUpdateRequest $request, LawCase $lawCase, CaseClient $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('law-cases.clients.index', $lawCase)
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawCase $lawCase, CaseClient $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('law-cases.clients.index', $lawCase)
            ->with('success', 'Client deleted successfully.');
    }
}
