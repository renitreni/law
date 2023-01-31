<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Matter;
use Livewire\Component;

class OptionsLivewire extends Component
{
    public mixed $client = [];
    public mixed $matter = [];

    public function render()
    {
        $this->client = Client::all();
        $this->matter = Matter::all();

        return view('livewire.options-livewire');
    }
}
