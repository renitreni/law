<?php

namespace App\Livewire\Component;

use Livewire\Component;

class SidebarComponent extends Component
{
    public $menu = '';

    public function render()
    {
        $this->menu = request()->route()->getName();

        return view('livewire.component.sidebar-component');
    }
}
