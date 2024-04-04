<div>
    <h3>Court Information</h3>
    <div class="row mt-4">

        <div class="mb-3 col-md-4">
            <label for="court_name" class="form-label">Court Name</label>
            <input wire:model='addForm.court_name' type="text" class="form-control" id="court_name" required>
            @error('addForm.court_name') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-4">
            <label for="court_address" class="form-label">Address</label>
            <input wire:model='addForm.court_address' type="text" class="form-control" id="court_address" required>
            @error('addForm.court_address') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-4">
            <label for="court_date" class="form-label">Date</label>
            <input wire:model='addForm.court_date' type="date" class="form-control" id="court_date" required>
            @error('addForm.court_date') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>


    </div>
</div>
