<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Livewire\Component;

class SendInquiryLivewire extends Component
{
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $legalIssue;
    public string $phonenumber;
    public string $message;

    public function send() {
        $this->validate([
            'firstname'=> "required|min:3",
            'lastname'=> "required|min:3",
            'email'=> "required|email",
            'phonenumber'=>'required',
            'legalIssue'=> "required",
            'message'=> "required|min:3",
        ]);

        $inquiry = new Inquiry;
        $inquiry->fill($this->all());
        $inquiry->save();
        $this->reset();
        return session()->flash('success','Inquiry Successfully Sent.');

    }
    public function render()
    {
        return view('livewire.send-inquiry-livewire');
    }
}
