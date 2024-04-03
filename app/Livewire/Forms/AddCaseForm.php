<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AddCaseForm extends Form
{

    public string $case_title = "";
    public string $case_category = "";
    public string $case_status = "";
    public string $case_description = "";
    public string $case_attorney = "";
    public  $case_date;

    public string $client_name = "";
    public string $client_contact = "";

    public int $client_age = 0;
    public $client_birthday;
    public string $client_company = "";
    public string $client_role = "";
    public string $client_attorney = "";

    public string $opponent_name = "";
    public string $opponent_contact = "";

    public int $opponent_age = 0;
    public $opponent_birthday;
    public string $opponent_company = "";
    public string $opponent_role = "";
    public string $opponent_attorney = "";

    public string $court_name = "";
    public string $court_address = "";
    public  $court_date;


    public function getCase() :array
    {
        return [
            'case_title' => $this->case_title,
            'case_description'=> $this->case_description,
            'case_category'=> $this->case_category,
            'case_status'=> $this->case_status,
            'case_attorney'=> $this->case_attorney,
            'case_date'=> $this->case_date
        ];
    }

    public function getClient(int $case_id) : array
    {
        return [
            'law_cases_id'=> $case_id,
            'name'=>$this->client_name,
            'contact'=>$this->client_contact,
            'age'=>$this->client_age,
            'birthday'=>$this->client_birthday,
            'company'=>$this->client_company,
            'role'=>$this->client_role,
            'attorney'=>$this->client_attorney
        ];
    }

    public function getOpponent(int $case_id) : array
    {
        return [
            'law_cases_id'=> $case_id,
            'name'=>$this->opponent_name,
            'contact'=>$this->opponent_contact,
            'age'=>$this->opponent_age,
            'birthday'=>$this->opponent_birthday,
            'company'=>$this->opponent_company,
            'role'=>$this->opponent_role,
            'attorney'=>$this->opponent_attorney
        ];
    }

    public function getCourt(int $case_id) : array
    {
        return [
            'law_cases_id'=> $case_id,
            'court_name'=>$this->court_name,
            'court_date'=>$this->court_date,
            'court_address'=>$this->court_address,
        ];
    }

    protected array $rules = [
        'case_title' => 'required',
        'case_category' => 'required',
        'case_status' => 'required',
        'case_description' => 'required',
        'case_attorney' => 'required',
        'client_name' => 'required',
        'client_contact' => 'required',
        'client_age' => 'required|integer',
        'client_birthday' => 'required',
        'client_company' => 'required',
        'client_role' => 'required',
        'client_attorney' => 'required',
        'opponent_name' => 'required',
        'opponent_contact' => 'required',
        'opponent_age' => 'required|integer',
        'opponent_birthday' => 'required',
        'opponent_company' => 'required',
        'opponent_role' => 'required',
        'opponent_attorney' => 'required',
        'court_name' => 'required',
        'court_address' => 'required',
        'court_date' => 'required',
    ];

    public function messages()
{
    return [
        'case_title.required' => 'Please enter a title for the case.',
        'case_category.required' => 'Please select a category for the case.',
        'case_status.required' => 'Please select a status for the case.',
        'case_description.required' => 'Please provide a description for the case.',
        'case_attorney.required' => 'Please select an attorney for the case.',
        'client_name.required' => 'Please enter the client\'s name.',
        'client_contact.required' => 'Please enter the client\'s contact information.',
        'client_age.required' => 'Please enter the client\'s age.',
        'client_age.integer' => 'The client\'s age must be a number.',
        'client_birthday.required' => 'Please enter the client\'s birthday.',
        'client_company.required' => 'Please enter the client\'s company.',
        'client_role.required' => 'Please enter the client\'s role in the company.',
        'client_attorney.required' => 'Please select an attorney for the client.',
        'opponent_name.required' => 'Please enter the opponent\'s name.',
        'opponent_contact.required' => 'Please enter the opponent\'s contact information.',
        'opponent_age.required' => 'Please enter the opponent\'s age.',
        'opponent_age.integer' => 'The opponent\'s age must be a number.',
        'opponent_birthday.required' => 'Please enter the opponent\'s birthday.',
        'opponent_company.required' => 'Please enter the opponent\'s company.',
        'opponent_role.required' => 'Please enter the opponent\'s role in the company.',
        'opponent_attorney.required' => 'Please select an attorney for the opponent.',
        'court_name.required' => 'Please enter the court\'s name.',
        'court_address.required' => 'Please enter the court\'s address.',
        'court_date.required' => 'Please enter the court date.',
    ];
}

}
