<div x-show='currentIndex === 1'>
    <h3>Client Information</h3>
    <div class="row mt-4">
        <div class="mb-3 col-md-4">
            <label for="client_name" class="form-label">Full Name</label>
            <input wire:model='addForm.client_name' type="text" class="form-control" id="client_name" required>
        </div>
        <div class="mb-3 col-md-4">
            <label for="client_contact" class="form-label">Contact</label>
            <input wire:model='addForm.client_contact' type="text" class="form-control" id="client_contact" required>
        </div>

        <div class="mb-3 col-md-2">
            <label for="client_age" class="form-label">Age</label>
            <input wire:model='addForm.client_age' type="text" class="form-control" id="client_age" required>
        </div>

        <div class="mb-3 col-md-2">
            <label for="client_birthday" class="form-label">Birthdate</label>
            <input wire:model='addForm.client_birthday' type="date" class="form-control" id="client_birthday" required>
        </div>

        <div class="mb-3 col-md-4">
            <label for="client_company" class="form-label">Company</label>
            <input wire:model='addForm.client_company' type="text" class="form-control" id="client_company" required>
        </div>

        <div class="mb-3 col-md-4">
            <label for="client_role" class="form-label">Role</label>
            <input wire:model='addForm.client_role' list="role" type="text" class="form-control" id="client_role" required>

            <datalist id="role">
                <option value="Defendant"></option>
            </datalist>
        </div>

        <div class="mb-3 col-md-4">
            <label for="client_attorney" class="form-label">Attorney</label>
            <input wire:model='addForm.client_attorney' list="attorneys" type="text" class="form-control" id="client_attorney" required>
            <datalist id="attorneys">
                <option value="Maha Aljubaire"></option>
                <option value="Majed Alghunaim"></option>
                <option value="Meshari Alhumadi"></option>
            </datalist>
        </div>
    </div>
</div>
