<div>
    <div class="row">
        {{-- Matter --}}
        <div class="col-6 d-flex flex-column">
            <h4>Matter</h4>
            <div class="input-group mb-3">
                <input type="text" class="form-control" wire:model="matterDetails.code" placeholder="Code"
                    aria-label="Code" aria-describedby="button-addon2">
                <input type="text" class="form-control" wire:model="matterDetails.name" placeholder="Name"
                    aria-label="name" aria-describedby="button-addon2">
                <button class="btn btn-success" type="button" id="button-addon2" wire:click='storeMatter'>
                    <i class='bx bx-plus-medical'></i>
                </button>
            </div>
            @error('matterDetails.name')
                <label class="text-danger">{{ $message }}</label>
            @enderror
            @error('matterDetails.code')
                <label class="text-danger">{{ $message }}</label>
            @enderror
            <ul class="list-group">
                @foreach ($matter as $item)
                    <li class="list-group-item d-flex flex-row justify-content-between bg-dark text-white">
                        <div>{{ strtoupper($item->code) }} - {{ $item->name }}</div>
                        <div class="d-flex flex-row">
                            <button type="button" class="btn btn-sm btn-info mx-1"
                                wire:click='addSubMatter({{ $item->id }})'>
                                <i class='bx bx-edit'></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger mx-1"
                                wire:click='destroyMatter({{ $item->id }})'>
                                <i class='bx bx-window-close'></i>
                            </button>
                        </div>
                    </li>
                    @if (isset($subMatterDetails['matter_id']) && $subMatterDetails['matter_id'] == $item->id)
                        <li class="list-group-item d-flex flex-row justify-content-between">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model="subMatterDetails.code"
                                    placeholder="Code" aria-label="Code"/>
                                <input type="text" class="form-control" wire:model="subMatterDetails.name"
                                    placeholder="Name" aria-label="name"/>
                                <button class="btn btn-success" type="button"
                                    wire:click='storeSubMatter'>
                                    <i class='bx bx-plus-medical'></i>
                                </button>
                            </div>
                            @error('subMatterDetails.name')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            @error('subMatterDetails.code')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </li>
                    @endif
                    @foreach ($item->subMatters as $matter)
                        <li class="list-group-item d-flex flex-row justify-content-between">
                            <div>{{ strtoupper($matter->code) }} - {{ $matter->name }}</div>
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click='destroySubMatter({{ $matter->id }})'>
                                <i class='bx bx-window-close'></i>
                            </button>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
        {{-- Client --}}
        <div class="col-6 d-flex flex-column">
            <h4>Client</h4>
            <div class="input-group mb-3">
                <input type="text" class="form-control" wire:model="clientDetails.code" placeholder="Code"
                    aria-label="Code" aria-describedby="button-addon1">
                <input type="text" class="form-control" wire:model="clientDetails.name" placeholder="Name"
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
