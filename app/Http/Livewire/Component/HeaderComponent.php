<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class HeaderComponent extends Component
{
    public string $state = 'month';
    
    public function render()
    {
        return view('livewire.component.header-component');
    }
}
