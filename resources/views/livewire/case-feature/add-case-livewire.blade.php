<div>
    <div class="mb-3">
        <button class="btn btn-sm btn-primary" wire:click='goBack'> &larr; Back</button>
    </div>

    <form  x-cloak x-data='{currentIndex: 0}'>
        <div>
            <div class="my-3 bg-slate-50 p-3 rounded">
                @include('livewire.case-feature.@.case-info')
            </div>
            <div class="my-3 bg-slate-50 p-3 rounded">
                @include('livewire.case-feature.@.client-info')
            </div>
            <div class="my-3 bg-slate-50 p-3 rounded">
                @include('livewire.case-feature.@.opponent-info')
            </div>
            <div class="my-3 bg-slate-50 p-3 rounded">
                @include('livewire.case-feature.@.court-info')
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button
                class="btn  btn-primary"
                type="button" x-text="'Submit &#10148;'"
                wire:click="save">
            </button>
        </div>
    </form>
</div>

@script
<script>
    $wire.on('caseAdded', message => alert(message));
</script>
@endscript
