<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Inertia\Inertia;
use Inertia\Response;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $inquiries = Inquiry::latest()->paginate(15);

        return Inertia::render('Inquiry/Index', [
            'inquiries' => $inquiries,
        ]);
    }
}