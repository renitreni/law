<?php

namespace App\Livewire\Component;

use App\Models\Entry;
use Livewire\Component;
use Illuminate\Support\Str;

use function Laravel\Prompts\alert;

class AutocompleteComponent extends Component
{
    public string $keywording;

    public string $selected;

    public $data;

    public array $listing = [];

    public string $keywordCallback;

    public string $bindCallback = '';

    public function render()
    {
        return view('livewire.component.autocomplete-component');
    }

    public function updatedKeywording($value)
    {
        $this->listing = [];
        foreach ($this->data as $item) {
            $haystack = Str::lower($item['text']);
            $needle = Str::lower($value);
            if (Str::contains($haystack, $needle)) {
                $this->listing[] = $item;
            } else {
                $this->listing[] = $item;
            }
        }
    }

    public function setValue($value, $text)
    {
        $this->selected = $text;
        $this->keywording = '';

    //    $this->dispatch($this->keywordCallback, $value);
    }
}
