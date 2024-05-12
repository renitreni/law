<section x-data="{show:false}" x-on:display-invoice.window="show = true">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>

    @endif

    <div class="d-flex justify-content-between align-items-center">
        <h3>Invoice</h3>
        <button x-show="!show" x-on:click="show=true" type="button" class="btn btn-sm btn-primary">Create
            Invoice</button>
        <button x-cloak x-show="show" x-on:click="show=false,$wire.resetAll()" type="button"
            class="btn btn-sm btn-primary">Cancel</button>
    </div>

    <div x-show="!show">
        <livewire:invoice-table />
    </div>

    <form wire:submit='save' x-transtion x-cloak x-show="show">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="name" class="form-label">Name</label>
                <input wire:model='name' type="text" class="form-control" id="name" required>
                @error('name') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
            </div>
            <div class="mb-3 col-md-4">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input wire:model='phoneNumber' type="text" class="form-control" id="phoneNumber" required>
                @error('phoneNumber') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
            </div>
            <div class="mb-3 col-md-4">
                <label for="address" class="form-label">Address</label>
                <input wire:model='address' type="text" class="form-control" id="address" required>
                @error('address') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
            </div>
        </div>
        <div class="mt-3">
            <div class="d-flex justify-content-end gap-1">
                @if (!$isDisplay)
                <button wire:click='addService' type="button" class="btn btn-sm btn-primary">Add Service</button>
                <button {{ $services ? "" :"disabled" }} wire:click='remove' type="button"
                    class="btn btn-sm btn-secondary">Remove</button>
                @endif
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Service</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $index => $service )
                    <tr wire:key='{{ $index }}'>
                        <th scope="row">
                            <input wire:model='services.{{ $index }}.service' type="text" class="form-control"
                                id="service" required>
                        </th>
                        <td>
                            <input wire:model='services.{{ $index }}.amount' type="text" class="form-control"
                                id="amount" required>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (!$isDisplay)
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-sm btn-primary">Submit Invoice</button>
        </div>
        @endif

    </form>


</section>
