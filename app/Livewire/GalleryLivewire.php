<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Gallery')]
class GalleryLivewire extends Component
{
    public function render()
    {
        return view('livewire.gallery-livewire');
    }
}
