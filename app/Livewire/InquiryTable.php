<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class InquiryTable extends PowerGridComponent
{
    use WithExport;

    public int $perPage = 5;
    public array $perPageValues = [0,5,10,20,50];

    public function setUp(): array
    {
        return [
            /*Exportable::make('export')
                ->striped()
                ->csvSeparator('|')
                ->csvDelimiter("'")
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),*/
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showPerPage($this->perPage,$this->perPageValues)
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Inquiry::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('firstname')
            ->add('lastname')
            ->add('email');
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('First Name')
                ->field('firstname')
                ->searchable(),
            Column::add()
                ->title('Last Name')
                ->field('lastname')
                ->searchable(),
            Column::add()
                ->title('Email')
                ->field('email')
                ->searchable(),
            Column::action('')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId) : void
    {
        Inquiry::where('id',$rowId)->delete();
    }

    public function actions(Inquiry $row): array
    {
        return [
            Button::add('view')
                ->slot('View')
                ->class('btn btn-sm btn-dark')
                ->dispatch('view',['rowId'=> $row->id]),
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-sm btn-danger')
                ->dispatch('delete',['rowId'=> $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
