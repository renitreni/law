<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseFileStoreRequest;
use App\Models\CaseFiles;
use App\Models\LawCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CaseFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LawCase $lawCase): Response
    {
        $files = $lawCase->files()->latest()->paginate(15);

        return Inertia::render('LawCase/File/Index', [
            'lawCase' => $lawCase,
            'files' => $files,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(LawCase $lawCase): Response
    {
        return Inertia::render('LawCase/File/Create', [
            'lawCase' => $lawCase,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CaseFileStoreRequest $request, LawCase $lawCase): RedirectResponse
    {
        $file = $request->file('file');
        $path = $file->store('case-files', 'public');

        $caseFile = $lawCase->files()->create([
            'filename' => $request->filename,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('law-cases.files.index', $lawCase)
            ->with('success', 'File uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LawCase $lawCase, CaseFiles $file): Response
    {
        return Inertia::render('LawCase/File/Show', [
            'lawCase' => $lawCase,
            'file' => $file,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawCase $lawCase, CaseFiles $file): RedirectResponse
    {
        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return redirect()->route('law-cases.files.index', $lawCase)
            ->with('success', 'File deleted successfully.');
    }
}
