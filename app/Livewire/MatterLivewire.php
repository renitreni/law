<?php

namespace App\Livewire;

use App\Models\Matter;
use Livewire\Component;
use App\Models\SubMatter;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Matters')]
class MatterLivewire extends Component
{
    use WithPagination;

    public $matterDetails = [];

    public $subMatterDetails = [];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $matter = Matter::paginate(3);

        return view('livewire.matter-livewire', compact('matter'));
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

    public function addSubMatter($id)
    {
        $this->subMatterDetails = [
            'matter_id' => $id,
            'name' => '',
            'code' => '',
        ];
    }

    public function destroyMatter($id)
    {
        Matter::destroy($id);
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
