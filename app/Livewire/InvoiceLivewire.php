<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\Attributes\On;

class InvoiceLivewire extends Component
{
    public string $name;
    public string $phoneNumber;
    public string $address;

    public $services = [];
    public bool $isDisplay = false;

    public function addService():array
    {
        return $this->services[] = [
                'service' => "",
                "amount" => 0
        ]   ;
    }

    public function remove(): array
    {
        return array_pop($this->services);
    }

    public function resetAll()
    {
        $this->isDisplay = false;
        $this->reset();
    }

    public function save()
    {
        $invoice = Invoice::create($this->all());
        foreach($this->services as $service){
            $invoice->services()->create($service);
        }
        session()->flash('success', 'Invoice created.');
        $this->reset();
    }

    #[On('show-invoice')]
    public function display($row){
        $this->name = $row['name'];
        $this->phoneNumber = $row['phoneNumber'];
        $this->address = $row['address'];

        foreach($row['services'] as $service){
            $this->services[] = [
                'service' => $service['service'],
                'amount' => $service['amount']
            ];
        }
        $this->isDisplay = true;
        $this->dispatch('display-invoice');
    }
    public function render()
    {
        return view('livewire.invoice-livewire');
    }
}
