<div>
    <h3>Case Information</h3>
    <div class="row mt-4">
        <div class="mb-3 col-md-4">
            <label for="case_title" class="form-label">Title/العنوان</label>
            <input wire:model='addForm.case_title' type="text" class="form-control" id="case_title" required>
            @error('addForm.case_title') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="case_category" class="form-label">Category/ الفئة</label>
            <input wire:model='addForm.case_category' list="issues" type="text" class="form-control" id="case_category" required>
            @error('addForm.case_category') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

            <datalist id="issues">
                <option value="Divorce"></option>
                <option value="Murder"></option>
                <option value="Others"></option>
            </datalist>
        </div>

        <div class="mb-3 col-md-4">
            <label for="case_status" class="form-label">Status/الحالة</label>
            <input wire:model='addForm.case_status' list="status" type="text" class="form-control" id="case_status" required>
            @error('addForm.case_status') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

            <datalist id="status">
                <option value="Closed"></option>
            </datalist>
        </div>

        <div class="mb-3 col">
            <label for="case_description" class="form-label">Description/الوصف</label>
            <textarea wire:model='addForm.case_description' class="form-control" id="case_description" rows="1"></textarea>
            @error('addForm.case_description') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>

        <div class="mb-3 col-md-4">
            <label for="case_attorney" class="form-label">Attorney/محامي</label>
            <input wire:model='addForm.case_attorney' list="attorneys" type="text" class="form-control" id="case_attorney" required>
            @error('addForm.case_attorney') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

                <option value="Maha Aljubaire"></option>
                <option value="Majed Alghunaim"></option>
                <option value="Meshari Alhumadi"></option>
            </datalist>
        </div>


        <div class="mb-3 col-md-2">
            <label for="case_date" class="form-label">Date/تاريخ</label>
            <input type="date" wire:model='addForm.case_date' type="text" class="form-control" id="case_date" required>
            @error('addForm.case_date') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>
    </div>
</div>
