<?php

namespace App\Http\Livewire\Component;

use App\Models\Entry;
use Livewire\Component;
use Illuminate\Support\Str;

class AutocompleteComponent extends Component
{
    public $keyword;

    public $data;

    public array $listing = [];

    public string $keywordCallback;

    public string $bindCallback = '';

    public function render()
    {
        return view('livewire.component.autocomplete-component');
    }

    public function updatedKeyword($value)
    {
        $this->listing = [];
        foreach ($this->data as $item) {
            $haystack = Str::lower($item['text']);
            $needle = Str::lower($value);
            if (Str::contains($haystack, $needle)) {
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

    public function getListeners()
    {
        return [$this->bindCallback => 'bindKeyword'];
    }

    public function bindKeyword($value)
    {
        foreach ($this->data as $item) {
            if ($item['value'] == $value) {
                $this->keyword = $item['text'];
            }
        }
    }
}
