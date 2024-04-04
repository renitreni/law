<?php

namespace App\Livewire;

use App\Models\LawCase;
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
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class CaseTable extends PowerGridComponent
{
    use WithExport;
    public int $perPage = 5;
    public array $perPageValues = [0, 5, 10, 20, 50];
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
        return LawCase::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('case_title')
            ->add('case_category')
            ->add('case_status')
            ->add('case_title_lower', fn (LawCase $model) => strtolower(e($model->name)))
            ->add('created_at')
            ->add('case_date_formatted', fn (LawCase $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Case Title', 'case_title')
                ->searchable()
                ->sortable()
                ->editOnClick(),

            Column::make('Category', 'case_category')
                ->searchable()
                ->editOnClick(),

            Column::make('Status', 'case_status')
                ->searchable()
                ->editOnClick(),

            Column::make('Attorney', 'case_attorney')
                ->searchable()
                ->editOnClick(),

            Column::make('Date Created','case_date_formatted','case_field'),

            Column::action('')
        ];
    }

    public function onUpdatedEditable(int|string $id, string $field, string $value): void
    {
        LawCase::query()->find($id)->update([
            $field => $value
        ]);
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(LawCase $row): array
    {
        return [
            Button::add('edit')
                    ->slot('<i class="fa-regular fa-pen-to-square"></i>')
                    ->target('_self')
                    ->route('edit_case',['id'=> $row->id])
                    ->class('btn btn-sm btn-outline-primary')
                    ->tooltip('Edit Record')
        ];
    }

    /*
    public function actionRules(LawCase $row): array
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
