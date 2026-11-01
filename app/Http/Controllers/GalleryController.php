<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $photos = Gallery::latest()->paginate(12);

        return Inertia::render('Gallery/Index', [
            'photos' => $photos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photos.*' => 'required|image|max:5120', // 5MB max per image
        ]);

        foreach ($request->file('photos') as $photo) {
            $filename = uniqid().'_'.date('Ymd').'.'.$photo->getClientOriginalExtension();
            $photo->storeAs('public/gallery', $filename);
            Gallery::create([
                'photo_name' => $filename,
            ]);
        }

        return redirect()->route('gallery.index')
            ->with('success', 'Photos uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $photo): RedirectResponse
    {
        if ($photo->photo_name && Storage::disk('public')->exists('gallery/'.$photo->photo_name)) {
            Storage::disk('public')->delete('gallery/'.$photo->photo_name);
        }

        $photo->delete();

        return redirect()->route('gallery.index')
            ->with('success', 'Photo deleted successfully.');
    }
}
