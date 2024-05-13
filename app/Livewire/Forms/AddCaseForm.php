<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AddCaseForm extends Form
{

    public string $case_plaintiff = "";
    public string $case_defendant = "";
    public string $case_category = "";
    public string $case_status = "";
    public string $case_description = "";
    public string $case_attorney = "";
    public  $case_date;
    public  $case_documents;

    public string $client_name = "";
    public string $client_contact = "";

    public string $client_email = "";
    public string $client_company = "";

    public string $court_name = "";
    public string $court_address = "";
    public  $court_date;


    public function getCase() :array
    {
        return [
            'case_plaintiff' => $this->case_plaintiff,
            'case_defendant' => $this->case_defendant,
            'case_description'=> $this->case_description,
            'case_category'=> $this->case_category,
            'case_status'=> $this->case_status,
            'case_attorney'=> $this->case_attorney,
            'case_date'=> $this->case_date,
            'case_documents'=> $this->case_documents
        ];
    }

    public function getClient(int $case_id) : array
    {
        return [
            'law_cases_id'=> $case_id,
            'client_name'=>$this->client_name,
            'client_contact'=>$this->client_contact,
            'client_email'=>$this->client_email,
            'client_company'=>$this->client_company,
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
        'case_plaintiff' => 'required',
        'case_defendant' => 'required',
        'case_category' => 'required',
        'case_status' => 'required',
        'case_description' => 'required',
        'case_attorney' => 'required',
        'client_name' => 'required',
        'client_company' => 'required',
        'client_contact' => 'required',
        'client_email' => 'required|email',
        'court_name' => 'required',
        'court_address' => 'required',
        'court_date' => 'required',
    ];

    public function messages()
{
    return [
        'case_plaintiff.required' => 'Please enter a name for plaintiff.',
        'case_defendant.required' => 'Please enter a name for defendant.',
        'case_category.required' => 'Please select a category for the case.',
        'case_status.required' => 'Please select a status for the case.',
        'case_description.required' => 'Please provide a description for the case.',
        'case_attorney.required' => 'Please select an attorney for the case.',
        'client_name.required' => 'Please enter the client\'s representative name.',
        'client_contact.required' => 'Please enter the client\'s contact number.',
        'client_email.required' => 'Please enter the client\'s email.',
        'client_company.required' => 'Please enter the client\'s company.',
        'court_name.required' => 'Please enter the court\'s name.',
        'court_address.required' => 'Please enter the court\'s address.',
        'court_date.required' => 'Please enter the court date.',
    ];
}

}
