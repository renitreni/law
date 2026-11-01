<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatterStoreRequest;
use App\Http\Requests\SubMatterStoreRequest;
use App\Models\Matter;
use App\Models\SubMatter;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MatterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $matters = Matter::with('subMatters')->latest()->paginate(15);

        return Inertia::render('Matter/Index', [
            'matters' => $matters,
        ]);
    }

    /**
     * Store a newly created matter in storage.
     */
    public function store(MatterStoreRequest $request): RedirectResponse
    {
        Matter::create($request->validated());

        return redirect()->route('matters.index')
            ->with('success', 'Matter created successfully.');
    }

    /**
     * Remove the specified matter from storage.
     */
    public function destroy(Matter $matter): RedirectResponse
    {
        $matter->delete();

        return redirect()->route('matters.index')
            ->with('success', 'Matter deleted successfully.');
    }

    /**
     * Store a newly created sub matter in storage.
     */
    public function storeSubMatter(SubMatterStoreRequest $request, Matter $matter): RedirectResponse
    {
        $matter->subMatters()->create($request->validated());

        return redirect()->route('matters.index')
            ->with('success', 'Sub matter created successfully.');
    }

    /**
     * Remove the specified sub matter from storage.
     */
    public function destroySubMatter(Matter $matter, SubMatter $subMatter): RedirectResponse
    {
        $subMatter->delete();

        return redirect()->route('matters.index')
            ->with('success', 'Sub matter deleted successfully.');
    }
}