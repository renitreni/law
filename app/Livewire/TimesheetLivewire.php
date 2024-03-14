<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Entry;
use App\Models\Client;
use App\Models\Matter;
use App\Models\Office;
use Livewire\Component;
use App\Models\SubMatter;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Resources\CalendarSummaryResource;

class TimesheetLivewire extends Component
{
    use LivewireAlert;

    public $viewFilter = [];
    public array $details = [];
    public array $entry = [];
    public array $timeEntry = ['client' => ''];
    public $clients;
    public $matter;
    public $office;
    public $templates;

    public function mount()
    {
        $this->resetInputs();
        $this->clients = Client::all()->map(function ($value) {
            return [
                'value' => $value->id,
                'text' => Str::upper($value->code) . ' - ' . $value->name,
            ];
        });
        $this->matter = SubMatter::all()->map(function ($value) {
            return [
                'value' => $value->id,
                'text' => Str::upper($value->code) . ' - ' . $value->name,
            ];
        });
        $this->office = Office::all()->map(function ($value) {
            return [
                'value' => $value->id,
                'text' => Str::upper($value->code) . ' - ' . $value->name,
            ];
        });
        $this->templates = Entry::query()
            ->select(['id', 'is_template', 'template_name'])
            ->where('is_template', true)
            ->get()
            ->map(function ($value) {
                return [
                    'value' => $value->id,
                    'text' => $value->template_name,
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

    #[On('timeSheetFilter')]
    public function filter($params)
    {
        $params['start'] = explode('#', $params['range'])[0];
        $params['end'] = explode('#', $params['range'])[1];
        $this->viewFilter = $params;

        $this->dispatch('changeCalendarView', ['params' => $this->viewFilter]);
    }

    #[On('loadCalendarSummary')]
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

        $this->dispatch(
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
            'is_template' => 0,
            'template_name' => '',
            'is_billable' => false
        ];

        $this->dispatch('bindClient', null);
        $this->dispatch('bindMatter', null);
        $this->dispatch('bindOffice', null);
    }

    public function keywordClient($value)
    {
        $this->timeEntry['client_id'] = $value;
    }

    #[On('keywordClient')]
    public function keywordMatter($value)
    {
        $this->timeEntry['sub_matter_id'] = $value;
    }

    #[On('keywordClient')]
    public function keywordOffice($value)
    {
        $this->timeEntry['office_id'] = $value;
    }

    #[On('keywordClient')]
    public function keywordTemplate($value)
    {
        $entry = Entry::find($value);

        $this->timeEntry['office_id'] = $entry->office_id;
        $this->timeEntry['sub_matter_id'] = $entry->sub_matter_id;
        $this->timeEntry['client_id'] = $entry->client_id;

        $this->dispatch('bindClient', $entry->client_id);
        $this->dispatch('bindMatter', $entry->sub_matter_id);
        $this->dispatch('bindOffice', $entry->office_id);
    }

    public function store($isDraft)
    {
        $this->validate([
            'timeEntry.entry_date' => 'required',
            'timeEntry.duration' => 'required',
        ], [
            'timeEntry.duration.required' => 'Duration is required.',
            'timeEntry.entry_date.required' => 'Entry date is required.',
        ]);

        $entry = new Entry();
        $entry->client_id = $this->timeEntry['client_id'];

        $matter = SubMatter::find($this->timeEntry['sub_matter_id']);
        $this->timeEntry['matter_id'] = $matter->id;

        $entry->matter_id = $this->timeEntry['matter_id'];

        $entry->sub_matter_id = $this->timeEntry['sub_matter_id'];
        $entry->office_id = $this->timeEntry['office_id'];
        $entry->entry_date = $this->timeEntry['entry_date'];
        $entry->duration = $this->timeEntry['duration'];
        $entry->narrative = $this->timeEntry['narrative'];
        $entry->template_name = $this->timeEntry['template_name'];
        $entry->is_template = $this->timeEntry['is_template'] ?? null;
        $entry->is_draft = $isDraft;
        $entry->is_billable = $this->timeEntry['is_billable'];
        $entry->save();

        $this->alert('success', 'Process successful!');
        $this->showDetails($this->timeEntry['entry_date']);
        $this->resetInputs();
    }
}
