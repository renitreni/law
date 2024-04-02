<div x-show='currentIndex === 0'>
    <h3>Case Information</h3>
    <div class="row mt-4">
        <div class="mb-3 col-md-4">
            <label for="case_title" class="form-label">Title</label>
            <input wire:model='addForm.case_title' type="text" class="form-control" id="case_title" required>
        </div>
        <div class="mb-3 col-md-4">
            <label for="case_category" class="form-label">Category</label>
            <input wire:model='addForm.case_category' list="issues" type="text" class="form-control" id="case_category" required>

            <datalist id="issues">
                <option value="Divorce"></option>
                <option value="Murder"></option>
                <option value="Others"></option>
            </datalist>
        </div>

        <div class="mb-3 col-md-4">
            <label for="case_status" class="form-label">Status</label>
            <input wire:model='addForm.case_status' list="status" type="text" class="form-control" id="case_status" required>
            <datalist id="status">
                <option value="Closed"></option>
            </datalist>
        </div>

        <div class="mb-3 col">
            <label for="case_description" class="form-label">Description</label>
            <textarea wire:model='addForm.case_description' class="form-control" id="case_description" rows="1"></textarea>
        </div>

        <div class="mb-3 col-md-4">
            <label for="case_attorney" class="form-label">Attorney</label>
            <input wire:model='addForm.case_attorney' list="attorneys" type="text" class="form-control" id="case_attorney" required>
            <datalist id="attorneys">
                <option value="Maha Aljubaire"></option>
                <option value="Majed Alghunaim"></option>
                <option value="Meshari Alhumadi"></option>
            </datalist>
        </div>


        <div class="mb-3 col-md-2">
            <label for="case_date" class="form-label">Date</label>
            <input type="date" wire:model='addForm.case_date' type="text" class="form-control" id="case_date" required>
        </div>
    </div>
</div>
