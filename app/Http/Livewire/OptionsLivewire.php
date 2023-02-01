<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Matter;
use App\Models\SubMatter;
use Livewire\Component;
use Illuminate\Support\Str;

class OptionsLivewire extends Component
{
    public mixed $client = [];

    public mixed $matter = [];

    public $clientDetails = [];

    public $matterDetails = [];

    public $subMatterDetails = [];

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

    public function addSubMatter($id)
    {
        $this->subMatterDetails = [
            'matter_id' => $id,
            'name' => '',
            'code' => '',
        ];
    }

    public function storeSubMatter()
    {
        $this->validate([
            'subMatterDetails.name' => 'required',
            'subMatterDetails.code' => 'required|unique:matters,code',
        ]);
        SubMatter::create([
            'matter_id' => $this->subMatterDetails['matter_id'],
            'name' => $this->subMatterDetails['name'],
            'code' => Str::lower($this->subMatterDetails['code']),
        ]);
        $this->subMatterDetails = [];
    }

    public function destroySubMatter($id)
    {
        SubMatter::destroy($id);
    }
}
