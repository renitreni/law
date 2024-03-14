<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\Str;

class OptionsLivewire extends Component
{
    public mixed $client = [];

    public $clientDetails = [];

    public function render()
    {
        $this->client = Client::all();

        return view('livewire.options-livewire');
    }

    public function storeClient()
    {
        $this->validate([
            'clientDetails.name' => 'required',
            'clientDetails.code' => 'required|unique:clients,code',
        ]);
        Client::create([
            'name' => $this->clientDetails['name'],
            'code' => Str::lower($this->clientDetails['code']),
        ]);
        $this->clientDetails = [];
    }

    public function destroyClient($id)
    {
        Client::destroy($id);
    }
}
