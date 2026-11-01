<?php

namespace App\Http\Controllers;

use App\Http\Requests\LawCaseStoreRequest;
use App\Http\Requests\LawCaseUpdateRequest;
use App\Models\LawCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LawCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $cases = LawCase::latest()->paginate(15);

        return Inertia::render('LawCase/Index', [
            'cases' => $cases,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('LawCase/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LawCaseStoreRequest $request): RedirectResponse
    {
        $case = LawCase::create($request->validated());

        return redirect()->route('law-cases.index')
            ->with('success', 'Law case created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LawCase $lawCase): Response
    {
        $lawCase->load(['client', 'court', 'files']);

        return Inertia::render('LawCase/Show', [
            'case' => $lawCase,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LawCase $lawCase): Response
    {
        return Inertia::render('LawCase/Edit', [
            'case' => $lawCase,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LawCaseUpdateRequest $request, LawCase $lawCase): RedirectResponse
    {
        $lawCase->update($request->validated());

        return redirect()->route('law-cases.index')
            ->with('success', 'Law case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawCase $lawCase): RedirectResponse
    {
        $lawCase->delete();

        return redirect()->route('law-cases.index')
            ->with('success', 'Law case deleted successfully.');
    }
}
