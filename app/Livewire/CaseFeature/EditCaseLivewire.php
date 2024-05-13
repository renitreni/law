<?php

namespace App\Livewire\CaseFeature;

use Carbon\Carbon;
use App\Models\LawCase;
use Livewire\Component;
use App\Models\CaseCourt;
use App\Models\CaseClient;
use App\Livewire\Forms\AddCaseForm;
use App\Models\CaseFiles;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EditCaseLivewire extends Component
{
    use WithFileUploads;
    public AddCaseForm $addForm;
    public array $courts = [];
    public array $files = [];
    public int $id;
    public bool $isEdit = false;
    public $newFiles;

    public function mount(int|string $id) : void
    {
        $case = LawCase::with('client', 'files', 'court')->findOrFail($id);
        $this->id = $case->id;
        $this->isEdit = true;
        $this->insertData($case);
    }

    public function back()
    {
        return $this->redirect(route('case'),navigate:true);
    }

    protected function insertData(LawCase $case):void
    {
        $this->addForm->case_plaintiff = $case->case_plaintiff;
        $this->addForm->case_defendant = $case->case_defendant;
        $this->addForm->case_category = $case->case_category;
        $this->addForm->case_status = $case->case_status;
        $this->addForm->case_description = $case->case_description;
        $this->addForm->case_attorney = $case->case_attorney;
        $this->addForm->case_date = $case->case_date;
        $this->addForm->client_name = $case->client->client_name;
        $this->addForm->client_contact = $case->client->client_contact;
        $this->addForm->client_email = $case->client->client_email;
        $this->addForm->client_company = $case->client->client_company;

        foreach($case->court as $court){
            $this->courts[] = [
                'id'=>$court->id,
                'court_name' => $court->court_name,
                'court_address' => $court->court_address,
                'court_date' => $court->court_date
            ];
        }

        foreach($case->files as $file){
            $this->files[] = [
                'id' => $file->id,
                'filename' => $file->filename,
                'uploaded_by' => $file->uploaded_by
            ];
        }
    }

    public function saveChanges(int $id){
        LawCase::findOrFail($id)->update($this->addForm->getCase());
        CaseClient::where('law_cases_id',$id)->update($this->addForm->getClient($id));

        foreach($this->courts as $court){
            if($court['id'] === "" || empty($court['id']) ){
                CaseCourt::create(array_merge(
                    $court,
                    ['law_cases_id'=>$id]
                ));
            }
            CaseCourt::where('id',$court['id'])->update($court);
        }
        $this->dispatch('updatedCase','Case updated.');
        return redirect()->back();
    }

    public function deleteFile(CaseFiles $file)
    {
        Storage::disk('public')->delete('case/' . $file->filename);
        $file->delete();
        $this->dispatch('deleteCase','Successfully deleted a file.');
        return redirect()->route('edit_case',['id'=>$this->id]);
    }


    public function delete(LawCase $id)
    {
        $id->delete();
        $this->dispatch('deleteCase','Successfully deleted a case.');
        return $this->redirect(route('case'),navigate:true);
    }

    public function add():void
    {
        $this->courts[] = [
            'id'=> "",
            'court_name' => "",
            'court_address' => "",
            'court_date' => Carbon::now()
        ];
    }

    public function uploadNewFile()
    {
        if(!empty($this->newFiles)){
            foreach($this->newFiles as $file){
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/case',$filename);
                CaseFiles::create([
                    'law_cases_id' => $this->id,
                    'filename' => $filename,
                    'uploaded_by' => auth()->user()->name
                ]);
            }

            $this->dispatch('updatedCase','Successfully added a file.');
            return redirect()->route('edit_case',['id'=>$this->id]);
        }
    }
}
