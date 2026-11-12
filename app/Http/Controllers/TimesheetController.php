<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarSummaryResource;
use App\Models\Client;
use App\Models\Matter;
use App\Models\Office;
use App\Services\EntryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class TimesheetController extends Controller
{
    private const MAX_CALENDAR_RANGE_DAYS = 42;

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

    /**
     * Display daily time-entry totals for the requested calendar range.
     *
     * @throws ValidationException
     */
    public function calendar(Request $request): JsonResponse
    {
        $data = $request->validate([
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => ['required', 'date_format:Y-m-d', 'after_or_equal:start'],
        ]);

        $start = Carbon::createFromFormat('Y-m-d', $data['start'])->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $data['end'])->endOfDay();

        if ($start->diffInDays($end) > self::MAX_CALENDAR_RANGE_DAYS) {
            throw ValidationException::withMessages([
                'end' => ['The calendar range must not exceed 42 days.'],
            ]);
        }

        $entries = (new EntryService)->getCalendarSummary(
            $start->toDateString(),
            $end->toDateString()
        );

        return CalendarSummaryResource::collection($entries)->response($request);
    }

    /**
     * Display time entries for one day.
     */
    public function entries(Request $request): JsonResponse
    {
        $data = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        return response()->json([
            'data' => (new EntryService)->getEntryByDate($data['date']),
        ]);
    }
}
