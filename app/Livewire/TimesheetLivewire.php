<?php

namespace App\Livewire;

use App\Http\Resources\CalendarSummaryResource;
use App\Models\Client;
use App\Models\Entry;
use App\Models\Matter;
use App\Models\Office;
use App\Models\SubMatter;
use App\Services\EntryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Timesheet')]
class TimesheetLivewire extends Component
{
    use LivewireAlert;

    public $viewFilter = [];

    public array $details = [];

    public array $entry = [];

    public array $timeEntry = ['client' => ''];

    public $clients = [];

    public $defaultClient = [];

    public $matter = [];

    public $defaultMatter = [];

    public $subMatter = [];

    public $defaultSubMatter = [];

    public $office = [];

    public $defaultOffice = [];

    public $templates = [];

    public $defaultTemplate = [];

    public function mount()
    {
        $this->resetInputs();

        $maxDay = Carbon::parse(now()->format('Y').'-'.now()->format('m').'-1');

        $this->viewFilter = [
            'state' => 'month',
            'month' => now()->format('m'),
            'year' => now()->format('Y'),
            'day' => now()->format('d'),
            'range' => $maxDay->format('Y-m-d').'#'.$maxDay->addDays(6)->format('Y-m-d'),
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
                'entry_date',
            ])
            ->when($this->viewFilter['state'] == 'month', function ($query) {
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
        $this->details = (new EntryService)->getEntryByDate($param);
    }

    public function createTimeEntry()
    {
        $this->dispatch('livewire-select-refresh');
        $this->resetInputs();

        $timeEntry = Carbon::parse($this->details ? $this->details[0]['entry_date'] : null) ?? now();

        $this->timeEntry['entry_date'] = $timeEntry->format('Y-m-d');
    }

    public function editTimeEntry($id)
    {
        $this->timeEntry = Entry::find($id)->w->toArray();
    }

    public function resetInputs()
    {
        $this->timeEntry = [
            'client' => '',
            'is_template' => 0,
            'template_name' => '',
            'is_billable' => false,
        ];
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

        (new EntryService)->create($this->timeEntry, $isDraft);

        $this->alert('success', 'Process successful!');
        $this->showDetails($this->timeEntry['entry_date']);
        $this->resetInputs();
        $this->dispatch('livewire-select-refresh');
    }

    #[On('keywordClient')]
    public function keywordClient($value, $selected = null)
    {
        if ($selected) {
            $this->timeEntry['client_id'] = $selected;
        }
        $this->clients = Client::query()
            ->where('name', 'LIKE', "{$value}%")
            ->when($value == '', function ($q) {
                $q->limit(5);
            })
            ->get()
            ->map(function ($value) {
                return [
                    'value' => $value->id,
                    'text' => Str::upper($value->code).' - '.$value->name,
                ];
            });
    }

    #[On('keywordSubMatter')]
    public function keywordSubMatter($value, $selected = null)
    {
        if ($selected) {
            $this->timeEntry['sub_matter_id'] = $selected;
        }
        if (isset($this->timeEntry['matter_id'])) {
            $this->subMatter = SubMatter::query()
                ->where('matter_id', $this->timeEntry['matter_id'])
                ->where('name', 'LIKE', "{$value}%")
                ->when($value == '', function ($q) {
                    $q->limit(5);
                })
                ->get()
                ->map(function ($value) {
                    return [
                        'value' => $value->id,
                        'text' => Str::upper($value->code).' - '.$value->name,
                    ];
                });
        }
    }

    #[On('keywordMatter')]
    public function keywordMatter($value, $selected = null)
    {
        if ($selected) {
            $this->timeEntry['matter_id'] = $selected;
        }

        $this->dispatch('livewire-select-refresh', 'keywordSubMatter');

        $this->matter = Matter::query()
            ->where('name', 'LIKE', "{$value}%")
            ->when($value == '', function ($q) {
                $q->limit(5);
            })
            ->get()
            ->map(function ($value) {
                return [
                    'value' => $value->id,
                    'text' => Str::upper($value->code).' - '.$value->name,
                ];
            });
    }

    #[On('keywordOffice')]
    public function keywordOffice($value, $selected = null)
    {
        if ($selected) {
            $this->timeEntry['office_id'] = $selected;
        }

        $this->office = Office::query()
            ->where('name', 'LIKE', "{$value}%")
            ->when($value == '', function ($q) {
                $q->limit(5);
            })
            ->get()
            ->map(function ($value) {
                return [
                    'value' => $value->id,
                    'text' => Str::upper($value->code).' - '.$value->name,
                ];
            });
    }

    #[On('keywordTemplate')]
    public function keywordTemplate($keyword, $selected = null)
    {
        if ($selected) {
            $this->timeEntry['template_name'] = $selected;
        }

        $this->templates = Entry::query()
            ->select(['id', 'is_template', 'template_name'])
            ->where('is_template', true)
            ->where('template_name', 'LIKE', "{$keyword}%")
            ->when($keyword == '', function ($q) {
                $q->limit(5);
            })
            ->get()
            ->map(function ($value) {
                return [
                    'value' => $value->template_name,
                    'text' => $value->template_name,
                ];
            });
    }
}
