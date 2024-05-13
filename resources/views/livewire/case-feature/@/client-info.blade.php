<div>
    <h3>Client Information</h3>
    <div class="row mt-4">

        <div class="mb-3 col-md-6">
            <label for="client_company" class="form-label">Company/شركة</label>
            <input wire:model='addForm.client_company' type="text" class="form-control" id="client_company" required>
            @error('addForm.client_company') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-6">
            <label for="client_email" class="form-label">Email</label>
            <input wire:model='addForm.client_email' type="email" class="form-control" id="client_email" required>
            @error('addForm.client_email') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>


        <div class="mb-3 col-md-4">
            <label for="client_name" class="form-label">Representative</label>
            <input wire:model='addForm.client_name' type="text" class="form-control" id="client_name" required>
            @error('addForm.client_name') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
            </div>


        <div class="mb-3 col-md-6">
            <label for="client_contact" class="form-label">Mobile Number</label>
            <input wire:model='addForm.client_contact' min="0" type="number" class="form-control" id="client_contact" required>
            @error('addForm.client_contact') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>
    </div>
</div>
