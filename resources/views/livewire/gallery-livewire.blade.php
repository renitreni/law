<div>
    @if (session('deleteSuccess'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="alert alert-success" role="alert">
        {{ session('deleteSuccess') }}
    </div>
    @endif
    <h4>Gallery</h4>
    <div class="mb-3" x-cloak x-data="{open:false}">
        <form enctype="multipart/form-data" wire:submit.prevent='save' class="d-flex flex-row-reverse gap-2">
            <button x-show="!open" type="button" x-on:click="open = !open" class="btn btn-sm border">Upload New
                Photo</button>

            <button x-show="open" type="button" x-on:click="open = !open;"
                class="btn btn-sm bg-dark text-light">Cancel</button>
            <button x-show="open" type="submit" class="btn btn-sm bg-primary text-light">Upload</button>

            <div class="d-flex flex-column">
                <input required="required" accept="image/*" wire:model='photos' x-transition x-show="open" multiple
                    type="file" class="border p-1">
                    <span wire:loading wire:target='photos' x-show="open" class="text-success fs-6">Loading...</span>
                @if (session('success')) <span x-show="open" class="text-success fs-6">{{ session('success')
                    }}</span>@endif
                @error('photos') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </form>
    </div>
    <livewire:gallery-table />
</div>
