<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Str;

class AutocompleteComponent extends Component
{
    public $keyword;

    public $data;

    public array $listing = [];

    public string $keywordCallback;

    public function render()
    {
        return view('livewire.component.autocomplete-component');
    }

    public function updatedKeyword($value)
    {
        $this->listing = [];
        foreach($this->data as $item)
        {
            $haystack = Str::lower($item['text']);
            $needle = Str::lower($value);
            if(Str::contains($haystack, $needle)) {
                $this->listing[] = $item;
            }
        }
    }

    public function setValue($value, $text)
    {
        $this->keyword = $text;
        $this->listing = [];
        $this->emit($this->keywordCallback, $value);
    }
}
