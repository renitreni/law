<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Case')]
class CaseLivewire extends Component
{
    public function render()
    {
        return view('livewire.case-livewire');
    }
}
