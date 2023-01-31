<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Matter;
use Livewire\Component;
use Illuminate\Support\Str;

class OptionsLivewire extends Component
{
    public mixed $client = [];

    public mixed $matter = [];

    public $clientDetails = [];

    public $matterDetails = [];

    public function render()
    {
        $this->client = Client::all();
        $this->matter = Matter::all();

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

    public function storeMatter()
    {
        $this->validate([
            'matterDetails.name' => 'required',
            'matterDetails.code' => 'required|unique:matters,code',
        ]);
        Matter::create([
            'name' => $this->matterDetails['name'],
            'code' => Str::lower($this->matterDetails['code']),
        ]);
        $this->matterDetails = [];
    }

    public function destroyClient($id)
    {
        Client::destroy($id);
    }

    public function destroyMatter($id)
    {
        Matter::destroy($id);
    }
}
