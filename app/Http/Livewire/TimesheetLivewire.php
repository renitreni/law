<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TimesheetLivewire extends Component
{
    protected $listeners = ['timeSheetFilter' => 'filter'];

    public function render()
    {
        return view('livewire.timesheet-livewire');
    }

    public function filter($params)
    {
        dump($params);
    }
}
