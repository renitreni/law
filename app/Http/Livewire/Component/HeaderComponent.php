<?php

namespace App\Http\Livewire\Component;

use Carbon\Carbon;
use Livewire\Component;

class HeaderComponent extends Component
{
    public string $state = 'month';

    public array $monthList = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ];

    public array $yearList = [];

    public array $monthRange = [];

    public array $dayList = [];

    public $month;

    public $year;

    public $day;

    public $range;

    public function mount()
    {
        $this->month = (int) now()->format('m');
        $cnt = $this->year = (int) now()->format('Y');
        $minYear = 2000;

        do {
            $this->yearList[] = $cnt;
            $cnt--;
        } while ($cnt > $minYear);

        $maxDay = Carbon::parse("{$this->year}-{$this->month}-1");

        $this->range = $maxDay->format('Y-m-d').'#'.$maxDay->addDays(6)->format('Y-m-d');

        $this->getDayList($maxDay->endOfMonth()->format('d'));

        $this->day = now()->format('d');
    }

    public function render()
    {
        $this->getMonthWeeks();

        return view('livewire.component.header-component');
    }

    public function getMonthWeeks()
    {
        $this->monthRange = [];
        $startDate = Carbon::parse("{$this->year}-{$this->month}-1");
        $list = [];

        do {
            $list[] = [
                'start' => $this->setStartDate($startDate)->format('Y-m-d'),
                'end' => $this->setEndDate($startDate)->format('Y-m-d')
            ];
            $startDate->addDays(1);
        } while ($startDate->format('m') == $this->month);

        $this->monthRange = $list;
    }

    public function setEndDate(&$startDate)
    {
        if(!$startDate->isSaturday()) {
            do {
                $startDate->addDay();
            } while(!$startDate->isSaturday());
        }

        return $startDate;
    }

    public function setStartDate(&$startDate)
    {
        if(!$startDate->isSunday()) {
            do {
                $startDate->subDay();
            } while(!$startDate->isSunday());
        }

        return $startDate;
    }

    public function getDayList($maxDay)
    {
        $this->dayList = [];
        do {
            $this->dayList[] = $maxDay;
            $maxDay--;
        } while ($maxDay > 0);
    }

    public function updatedMonth()
    {
        $startDate = Carbon::parse("{$this->year}-{$this->month}-1");

        $this->range = [
            'start' => $startDate->format('Y-m-d'),
            'end' => $startDate->endOfMonth()->format('Y-m-d')
        ];
    }

    public function updated()
    {
        $this->emit('timeSheetFilter', [
            'state' => $this->state,
            'single_date' => Carbon::parse("{$this->year}-{$this->month}-{$this->day}"),
            'month' => $this->month,
            'year' => $this->year,
            'day' => $this->day,
            'range' => $this->range,
        ]);
    }
}
