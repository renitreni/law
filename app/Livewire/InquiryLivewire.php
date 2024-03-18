<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Livewire\Component;

class InquiryLivewire extends Component
{
    public bool $isView = false;
    public $viewData = null;

    #[\Livewire\Attributes\On('view')]
    public function view($rowId) : void
    {
        $this->viewData = Inquiry::where('id',$rowId)->first();
        $this->isView = true;
    }

    public function close() : void
    {
        $this->viewData = null;
        $this->isView = false;
    }
    public function render()
    {
        return view('livewire.inquiry-livewire');
    }
}
