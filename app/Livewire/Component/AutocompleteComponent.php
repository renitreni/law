<?php

namespace App\Livewire\Component;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class AutocompleteComponent extends Component
{
    public string $keywording;

    public string $selected;

    public $defaultVal = [];

    #[Modelable]
    public $data;

    public $widthAutocomplete = 0;

    public array $listing = [];

    public string $keywordCallback;

    public string $bindCallback = '';

    public function mount()
    {
        if ($this->defaultVal) {
            $this->setValue($this->defaultVal[0], $this->defaultVal[1]);
        }
    }

    public function render()
    {
        $this->listing = [];
        if ($this->data) {
            foreach ($this->data as $item) {
                $this->listing[] = $item;
            }
        }

        return view('livewire.component.autocomplete-component');
    }

    public function toggleAction()
    {
        $this->keywording = '';
        $this->dispatch($this->keywordCallback, '');
    }

    public function updatedKeywording($value)
    {
        $this->dispatch($this->keywordCallback, $value);
    }

    public function setValue($value, $text)
    {
        $this->selected = $text;
        $this->keywording = '';

        $this->dispatch($this->keywordCallback, $this->keywording, $value);
    }

    #[On('livewire-select-refresh')]
    public function refresh($specific = null)
    {
        if ($specific == $this->keywordCallback) {
            $this->keywording = '';
            $this->selected = '';
            $this->data = [];
        } else if ($specific == null) {
            $this->keywording = '';
            $this->selected = '';
            $this->data = [];
        }
    }
}
