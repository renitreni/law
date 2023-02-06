<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Entry;
use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CalendarSummaryResource;

class TimesheetLivewire extends Component
{
    protected $listeners = [
        'timeSheetFilter' => 'filter',
        'loadCalendarSummary' => 'calendarSummary',
        'keywordClient'
    ];

    public $viewFilter = [];

    public array $details = [];

    public array $entry = [];

    public array $timeEntry = ['client' => ''];

    public $clients;

    public function mount()
    {
        $this->resetInputs();
        $this->clients = Client::all()->map(function ($value) {
            return [
                'value' => $value->code,
                'text' => Str::upper($value->code) . ' - ' . $value->name,
            ];
        });

        $maxDay = Carbon::parse(now()->format('Y') . "-" . now()->format('m') . "-1");

        $this->viewFilter = [
            "state" => "month",
            "month" => now()->format('m'),
            "year" => now()->format('Y'),
            "day" => now()->format('d'),
            "range" => $maxDay->format('Y-m-d') . '#' . $maxDay->addDays(6)->format('Y-m-d'),
        ];
    }

    public function render()
    {
        return view('livewire.timesheet-livewire');
    }

    public function filter($params)
    {
        $params['start'] = explode('#', $params['range'])[0];
        $params['end'] = explode('#', $params['range'])[1];
        $this->viewFilter = $params;

        $this->dispatchBrowserEvent('changeCalendarView', ['params' => $this->viewFilter]);
    }

    public function calendarSummary()
    {
        $entry = Entry::query()
            ->select([
                DB::raw('SUM(CASE WHEN is_billable THEN duration ELSE 0 END) as billable'),
                DB::raw('SUM(CASE WHEN NOT is_billable THEN duration ELSE 0 END) as non_billable'),
                DB::raw('SUM(CASE WHEN is_draft THEN duration ELSE 0 END) as draft'),
                DB::raw('SUM(CASE WHEN NOT is_draft THEN duration ELSE 0 END) as posted'),
                'entry_date'
            ])
            ->when($this->viewFilter["state"] == 'month', function ($query) {
                $query->where(DB::raw('month(entry_date)'), (int) $this->viewFilter['month']);
            })
            ->groupBy('entry_date');

        $this->dispatchBrowserEvent(
            'bindCalendarSummary',
            [CalendarSummaryResource::collection($entry->get())]
        );
    }

    public function showDetails($param)
    {
        $this->details = Entry::query()
            ->where('entry_date', Carbon::parse($param))
            ->get()
            ->toArray();
    }

    public function createTimeEntry()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->timeEntry = [
            'client' => '',
            'is_template' => 0
        ];
    }

    public function keywordClient($value)
    {
        $this->timeEntry['client_code'] = $value;
        dump($this->timeEntry);
    }
}
