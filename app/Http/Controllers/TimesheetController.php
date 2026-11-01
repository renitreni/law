<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Matter;
use App\Models\Office;
use Inertia\Inertia;
use Inertia\Response;

class TimesheetController extends Controller
{
    /**
     * Display the timesheet page.
     */
    public function index(): Response
    {
        $clients = Client::select('id', 'name', 'code')->orderBy('name')->get();
        $matters = Matter::with('subMatters:id,matter_id,name,code')->select('id', 'name', 'code')->orderBy('name')->get();
        $offices = Office::select('id', 'name', 'code')->orderBy('name')->get();

        return Inertia::render('Timesheet/Index', [
            'clients' => $clients,
            'matters' => $matters,
            'offices' => $offices,
        ]);
    }
}
