<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseCourtStoreRequest;
use App\Http\Requests\CaseCourtUpdateRequest;
use App\Models\CaseCourt;
use App\Models\LawCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CaseCourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LawCase $lawCase): Response
    {
        $courts = $lawCase->court()->latest()->paginate(15);

        return Inertia::render('LawCase/Court/Index', [
            'lawCase' => $lawCase,
            'courts' => $courts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(LawCase $lawCase): Response
    {
        return Inertia::render('LawCase/Court/Create', [
            'lawCase' => $lawCase,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CaseCourtStoreRequest $request, LawCase $lawCase): RedirectResponse
    {
        $court = $lawCase->court()->create($request->validated());

        return redirect()->route('law-cases.courts.index', $lawCase)
            ->with('success', 'Court appearance added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LawCase $lawCase, CaseCourt $court): Response
    {
        return Inertia::render('LawCase/Court/Show', [
            'lawCase' => $lawCase,
            'court' => $court,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LawCase $lawCase, CaseCourt $court): Response
    {
        return Inertia::render('LawCase/Court/Edit', [
            'lawCase' => $lawCase,
            'court' => $court,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CaseCourtUpdateRequest $request, LawCase $lawCase, CaseCourt $court): RedirectResponse
    {
        $court->update($request->validated());

        return redirect()->route('law-cases.courts.index', $lawCase)
            ->with('success', 'Court appearance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawCase $lawCase, CaseCourt $court): RedirectResponse
    {
        $court->delete();

        return redirect()->route('law-cases.courts.index', $lawCase)
            ->with('success', 'Court appearance deleted successfully.');
    }
}
