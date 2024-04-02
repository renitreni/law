<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Case')]
class CaseLivewire extends Component
{

    public function AddPage()
    {
        return redirect()->route('add_case');
    }
    public function render()
    {
        return view('livewire.case-livewire');
    }
}
