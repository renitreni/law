<?php

namespace App\Livewire;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class GalleryTable extends PowerGridComponent
{
    public function setUp(): array
    {
        //$this->showCheckBox();

        return [
            //Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Gallery::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('photo_name', function ($img) {
                $path = asset("storage/gallery/{$img->photo_name}");

                return "<img style='width:50px;height:50px;' class='img-thumbnail' src='{$path}' alt='' >";
            })
            ->add('photo_name_lower', fn (Gallery $model) => strtolower(e($model->name)))
            ->add('created_at')
            ->add('created_at_formatted', fn (Gallery $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Photo', 'photo_name'),
            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Uploaded Date', 'created_at_formatted', 'created_at')
                ->searchable(),

            Column::action(''),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(Gallery $row): array
    {
        return [
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('border btn-danger btn btn-sm')
                ->dispatch('delete', ['rowId' => $row->id]),
        ];
    }

    /*
    public function actionRules(Gallery $row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */

    #[On('delete')]
    public function delete($rowId): void
    {
        $photo = Gallery::where('id', $rowId)->first();

        if (Storage::disk('public')->exists("gallery/{$photo->photo_name}")) {
            Storage::disk('public')->delete("gallery/{$photo->photo_name}");
        }
        $photo->delete();
        $this->dispatch('deleteSuccess');
    }
}
