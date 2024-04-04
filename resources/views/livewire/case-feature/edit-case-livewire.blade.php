<div>
    <div class="d-flex gap-2 justify-content-between align-items-center">
        <span class="fs-5">{{ $addForm->case_title }} Case</span>
        <div>
            <button wire:confirm='Are you sure to delete this case record?' wire:click='delete({{ $id }})'
                class="btn gap-1 text-danger btn-sm">
                <i class="fa-regular fa-trash-can"></i>
                <span>Delete</span>
            </button>
            <button wire:click='back' class="btn  gap-1 btn-sm">
                <i class="fa-solid fa-xmark"></i>
                <span>Close</span>
            </button>
        </div>
    </div>

    <form>
        <div class=" bg-slate-50 row rounded p-4 my-3">
            @include('livewire.case-feature.@.case-info')
        </div>

        <div class=" bg-slate-50 row rounded p-4 my-3">
            @include('livewire.case-feature.@.client-info')
        </div>

        <div class=" bg-slate-50 row rounded p-4 my-3">
            @include('livewire.case-feature.@.opponent-info')
        </div>
        <div class=" bg-slate-50 row rounded p-4 my-3">
            <div class="d-inline-flex justify-content-between align-items-center w-100">
                <h3>Court Information</h3>
                <button wire:click='add' type="button" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add Court</span>
                </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Court</th>
                        <th scope="col">Address</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courts as $index => $court )
                    <tr wire:key='{{ $index }}'>
                        <td>
                            <input type="hidden" wire:model='courts{{ $index }}.id'>
                            <input wire:model='courts.{{ $index }}.court_name' type="text" class="form-control"
                                id="court_name" required>
                        </td>
                        <td>
                            <input wire:model='courts.{{ $index }}.court_address' type="text" class="form-control"
                                id="court_address" required>
                        </td>
                        <td>
                            <input wire:model='courts.{{ $index }}.court_date' type="date" class="form-control"
                                id="court_date" required>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <button
                wire:click='saveChanges({{ $id }})'
                class="btn btn-primary"
                type="button"
                x-text="'Save Changes &#10148;'">
            </button>
        </div>
    </form>
</div>


@script
<script>
    $wire.on('deleteCase', message => alert(message));
    $wire.on('updatedCase', message => alert(message));
</script>
@endscript
