<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Gallery')]
class GalleryLivewire extends Component
{
    use WithFileUploads;

    public array $photos = [];

    public function save(): void
    {

        foreach ($this->photos as $photo) {
            $filename = uniqid().'_'.date('Ymd').'.'.$photo->getClientOriginalExtension();
            $photo->storeAs('public/gallery', $filename);
            Gallery::create([
                'photo_name' => $filename,
            ]);
        }

        $this->reset('photos');
        session()->flash('success', 'Upload Successfully.');
        $this->redirect('/photos');
    }

    #[On('deleteSuccess')]
    public function alert(): void
    {
        session()->flash('deleteSuccess', 'Delete Successfully.');
    }

    public function render()
    {
        return view('livewire.gallery-livewire');
    }
}
