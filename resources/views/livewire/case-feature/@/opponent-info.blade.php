<div x-show='currentIndex === 2'>
    <h3>Opponent Information</h3>
    <div class="row mt-4">
        <div class="mb-3 col-md-4">
            <label for="opponent_name" class="form-label">Full Name</label>
            <input wire:model='addForm.opponent_name' type="text" class="form-control" id="opponent_name" required>
        </div>
        <div class="mb-3 col-md-4">
            <label for="opponent_contact" class="form-label">Contact</label>
            <input wire:model='addForm.opponent_contact' type="text" class="form-control" id="opponent_contact" required>
        </div>

        <div class="mb-3 col-md-2">
            <label for="opponent_age" class="form-label">Age</label>
            <input wire:model='addForm.opponent_age' type="text" class="form-control" id="opponent_age" required>
        </div>

        <div class="mb-3 col-md-2">
            <label for="opponent_birthday" class="form-label">Birthdate</label>
            <input wire:model='addForm.opponent_birthday' type="date" class="form-control" id="opponent_birthday" required>
        </div>

        <div class="mb-3 col-md-4">
            <label for="opponent_company" class="form-label">Company</label>
            <input wire:model='addForm.opponent_company' type="text" class="form-control" id="opponent_company" required>
        </div>

        <div class="mb-3 col-md-4">
            <label for="opponent_role" class="form-label">Role</label>
            <input wire:model='addForm.opponent_role' list="role" type="text" class="form-control" id="opponent_role" required>

            <datalist id="role">
                <option value="Defendant"></option>
            </datalist>
        </div>

        <div class="mb-3 col-md-4">
            <label for="opponent_attorney" class="form-label">Attorney</label>
            <input wire:model='addForm.opponent_attorney' list="attorneys" type="text" class="form-control" id="opponent_attorney" required>
            <datalist id="attorneys">
                <option value="Maha Aljubaire"></option>
                <option value="Majed Alghunaim"></option>
                <option value="Meshari Alhumadi"></option>
            </datalist>
        </div>
    </div>
</div>
