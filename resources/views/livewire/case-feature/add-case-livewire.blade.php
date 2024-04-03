<div>
    <div class="mb-3">
        <button class="btn btn-sm btn-primary" wire:click='goBack'> &larr; Back</button>
    </div>

    <form  x-cloak x-data='{currentIndex: 0}'>
        @if ($errors->any())
        <div  class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @if ($successMessage)
        <div class="alert alert-success" role="alert">
           {{ session('success') }}
          </div>
        @endif
        @endif
        @include('livewire.case-feature.@.case-info')
        @include('livewire.case-feature.@.client-info')
        @include('livewire.case-feature.@.opponent-info')
        @include('livewire.case-feature.@.court-info')
        <button class="btn  btn-secondary" type="button" @click="currentIndex = Math.max(currentIndex - 1, 0)" x-show="currentIndex !== 0">&#10094; Previous</button>
        <button
            x-show = "currentIndex !== 3"
            class="btn  btn-primary"
            type="button" x-text="'Next &#10095;'"
            @click="currentIndex = Math.min(currentIndex + 1, 3)"
        >
        </button>
        <button
            x-show = "currentIndex === 3"
            class="btn  btn-primary"
            type="button" x-text="'Submit &#10148;'"
            wire:click="save">
        </button>
    </form>
</div>

@script
<script>
    $wire.on('caseAdded', message => alert(message));
</script>
@endscript
