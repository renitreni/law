<?php

namespace App\Livewire\CaseFeature;

use Carbon\Carbon;
use App\Models\LawCase;
use Livewire\Component;
use App\Models\CaseCourt;
use App\Models\CaseClient;
use Livewire\WithFileUploads;
use App\Livewire\Forms\AddCaseForm;

class AddCaseLivewire extends Component
{
    use WithFileUploads;


    public AddCaseForm $addForm;
    public function mount(){
        $this->addForm->case_date = Carbon::now()->toDateString();
        $this->addForm->court_date = Carbon::now()->toDateString();
    }

    public function save(){
        $this->addForm->validate();
        $case = LawCase::create($this->addForm->getCase());
        if(!empty($this->addForm->case_documents)){
            foreach($this->addForm->case_documents as $file){
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/case',$filename);
                $case->files()->create([
                    'filename' => $filename,
                    'uploaded_by' => auth()->user()->name
                ]);
            }
        };
        CaseClient::create($this->addForm->getClient($case->id));
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
