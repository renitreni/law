<?php

namespace App\Livewire\CaseFeature;

use Carbon\Carbon;
use App\Models\LawCase;
use Livewire\Component;
use App\Models\CaseCourt;
use App\Models\CaseClient;
use App\Models\ClientOpponent;
use App\Livewire\Forms\AddCaseForm;

class EditCaseLivewire extends Component
{
    public AddCaseForm $addForm;
    public array $courts = [];
    public int $id;

    public function mount(int|string $id) : void
    {
        $case = LawCase::with('client', 'opponent', 'court')->findOrFail($id);
        $this->id = $case->id;
        $this->insertData($case);
    }

    public function back()
    {
        return $this->redirect(route('case'),navigate:true);
    }

    protected function insertData(LawCase $case):void
    {
        $this->addForm->case_title = $case->case_title;
        $this->addForm->case_category = $case->case_category;
        $this->addForm->case_status = $case->case_status;
        $this->addForm->case_description = $case->case_description;
        $this->addForm->case_attorney = $case->case_attorney;
        $this->addForm->case_date = $case->case_date;
        $this->addForm->client_name = $case->client->name;
        $this->addForm->client_contact = $case->client->contact;
        $this->addForm->client_age = $case->client->age;
        $this->addForm->client_birthday = $case->client->birthday;
        $this->addForm->client_company = $case->client->company;
        $this->addForm->client_role = $case->client->role;
        $this->addForm->client_attorney = $case->client->attorney;
        $this->addForm->opponent_name = $case->opponent->name;
        $this->addForm->opponent_contact = $case->opponent->contact;
        $this->addForm->opponent_age = $case->opponent->age;
        $this->addForm->opponent_birthday = $case->opponent->birthday;
        $this->addForm->opponent_company = $case->opponent->company;
        $this->addForm->opponent_role = $case->opponent->role;
        $this->addForm->opponent_attorney = $case->opponent->attorney;

        foreach($case->court as $court){
            $this->courts[] = [
                'id'=>$court->id,
                'court_name' => $court->court_name,
                'court_address' => $court->court_address,
                'court_date' => $court->court_date
            ];
        }
    }

    public function saveChanges(int $id){
        LawCase::findOrFail($id)->update($this->addForm->getCase());
        CaseClient::where('law_cases_id',$id)->update($this->addForm->getClient($id));
        ClientOpponent::where('law_cases_id',$id)->update($this->addForm->getClient($id));

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
}
