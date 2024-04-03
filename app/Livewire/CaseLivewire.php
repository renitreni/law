<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Case')]
class CaseLivewire extends Component
{
    public function render()
    {
        return view('livewire.case-livewire');
    }
}
