<?php

namespace App\Livewire;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class InvoiceTable extends PowerGridComponent
{
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Invoice::query()->with('services');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('name')
            ->add('name_lower', fn (Invoice $model) => strtolower(e($model->name)))
            ->add('phoneNumber')
            ->add('address')
            ->add('created_at')
            ->add('created_at_formatted', fn (Invoice $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Phone Number', 'phoneNumber')
                ->searchable(),

            Column::make('Address', 'address')
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($row): void
    {
        $this->dispatch('show-invoice', row: $row);
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        Invoice::find($id)->delete();
        session()->flash('success','Delete successfully');
    }

    public function actions(Invoice $row): array
    {
        return [
            Button::add('edit')
                ->slot('Details')
                ->id()
                ->class('btn btn-sm btn-primary')
                ->dispatch('edit', ['row' => $row]),
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-sm btn-danger')
                ->dispatch('delete', ['id' => $row->id])
        ];
    }
}
