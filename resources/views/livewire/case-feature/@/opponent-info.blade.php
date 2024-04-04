<div>
    <h3>Opponent Information</h3>
    <div class="row mt-4">
        <div class="mb-3 col-md-4">
            <label for="opponent_name" class="form-label">Full Name</label>
            <input wire:model='addForm.opponent_name' type="text" class="form-control" id="opponent_name" required>
            @error('addForm.opponent_name') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>
        <div class="mb-3 col-md-4">
            <label for="opponent_contact" class="form-label">Contact</label>
            <input wire:model='addForm.opponent_contact' type="text" class="form-control" id="opponent_contact" required>
            @error('addForm.opponent_contact') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-2">
            <label for="opponent_age" class="form-label">Age</label>
            <input wire:model='addForm.opponent_age' type="text" class="form-control" id="opponent_age" required>
            @error('addForm.opponent_age') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-2">
            <label for="opponent_birthday" class="form-label">Birthdate</label>
            <input wire:model='addForm.opponent_birthday' type="date" class="form-control" id="opponent_birthday" required>
            @error('addForm.opponent_birthday') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-4">
            <label for="opponent_company" class="form-label">Company</label>
            <input wire:model='addForm.opponent_company' type="text" class="form-control" id="opponent_company" required>
            @error('addForm.opponent_company') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-4">
            <label for="opponent_role" class="form-label">Role</label>
            <input wire:model='addForm.opponent_role' list="role" type="text" class="form-control" id="opponent_role" required>
            @error('addForm.opponent_role') <small class="text-danger"><em>{{ $message }}</em></small> @enderror


            <datalist id="role">
                <option value="Defendant"></option>
            </datalist>
        </div>

        <div class="mb-3 col-md-4">
            <label for="opponent_attorney" class="form-label">Attorney</label>
            <input wire:model='addForm.opponent_attorney' list="attorneys" type="text" class="form-control" id="opponent_attorney" required>
            @error('addForm.opponent_attorney') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

            <datalist id="attorneys">
                <option value="Maha Aljubaire"></option>
                <option value="Majed Alghunaim"></option>
                <option value="Meshari Alhumadi"></option>
            </datalist>
        </div>
    </div>
</div>
