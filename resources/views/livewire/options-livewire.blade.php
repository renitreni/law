<div>
    <div class="row">
        {{-- Client --}}
        <div class="col-6 d-flex flex-column">
            <h4>Client</h4>
            <div class="input-group mb-3">
                <input type="text" class="form-control" wire:model.live="clientDetails.code" placeholder="Code"
                    aria-label="Code" aria-describedby="button-addon1">
                <input type="text" class="form-control" wire:model.live="clientDetails.name" placeholder="Name"
                    aria-label="Name" aria-describedby="button-addon1">
                <button class="btn btn-success" type="button" wire:click='storeClient' id="button-addon1">
                    <i class='bx bx-plus-medical'></i>
                </button>
            </div>
            @error('clientDetails.name')
                <label class="text-danger">{{ $message }}</label>
            @enderror
            @error('clientDetails.code')
                <label class="text-danger">{{ $message }}</label>
            @enderror
            <ul class="list-group">
                @foreach ($client as $item)
                    <li class="list-group-item d-flex flex-row justify-content-between">
                        <div>{{ strtoupper($item->code) }} - {{ $item->name }}</div>
                        <button type="button" class="btn btn-sm btn-danger"
                            wire:click='destroyClient({{ $item->id }})'>
                            <i class='bx bx-window-close'></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
