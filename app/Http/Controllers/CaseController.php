<?php

namespace App\Http\Controllers;

use App\Http\Requests\LawCaseStoreRequest;
use App\Http\Requests\LawCaseUpdateRequest;
use App\Models\LawCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CaseController extends Controller
{
    /**
     * Display the case dashboard.
     */
    public function index(): Response
    {
        $recentCases = LawCase::latest()->limit(10)->get();

        return Inertia::render('Case/Index', [
            'recentCases' => $recentCases,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Case/Add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LawCaseStoreRequest $request): RedirectResponse
    {
        $case = LawCase::create($request->validated());

        return redirect()->route('case')
            ->with('success', 'Case created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LawCase $lawCase): Response
    {
        $lawCase->load(['client', 'court', 'files']);

        return Inertia::render('Case/Edit', [
            'case' => $lawCase,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LawCaseUpdateRequest $request, LawCase $lawCase): RedirectResponse
    {
        $lawCase->update($request->validated());

        return redirect()->route('case')
            ->with('success', 'Case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawCase $lawCase): RedirectResponse
    {
        $lawCase->delete();

        return redirect()->route('case')
            ->with('success', 'Case deleted successfully.');
    }
}