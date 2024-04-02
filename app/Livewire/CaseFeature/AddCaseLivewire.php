<?php

namespace App\Livewire\CaseFeature;

use App\Livewire\Forms\AddCaseForm;
use App\Models\CaseClient;
use App\Models\CaseCourt;
use App\Models\ClientOpponent;
use App\Models\LawCase;
use Carbon\Carbon;
use Livewire\Component;

class AddCaseLivewire extends Component
{

    public AddCaseForm $addForm;
    public string $successMessage;
    public function mount(){
        $this->addForm->case_date = Carbon::now();
        $this->addForm->court_date = Carbon::now();
    }

    public function save(){
        $this->addForm->validate();
        $case = LawCase::create($this->addForm->getCase());
        CaseClient::create($this->addForm->getClient($case->id));
        ClientOpponent::create($this->addForm->getClient($case->id));
        CaseCourt::create($this->addForm->getCourt($case->id));
        $this->addForm->reset();
        $this->dispatch('caseAdded','New case successfully added.');
        return $this->redirect(route('add_case'));
    }

    public function goBack()
    {
        $this->addForm->reset();
        return redirect()->route('case');
    }
    public function render()
    {
        return view('livewire.case-feature.add-case-livewire');
    }
}
