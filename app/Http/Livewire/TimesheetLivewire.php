<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class TimesheetLivewire extends Component
{
    protected $listeners = ['timeSheetFilter' => 'filter'];

    public $viewFilter = [];

    public function mount()
    {
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
}
