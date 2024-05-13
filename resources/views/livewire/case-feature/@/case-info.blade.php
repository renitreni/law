<div>
    <h3>Case Information</h3>
    <div class="row mt-4">
        <div class="mb-3 col-md-4">
            <label for="case_plaintiff" class="form-label">Plaintiff</label>
            <input wire:model='addForm.case_plaintiff' type="text" class="form-control" id="case_plaintiff" required>
            @error('addForm.case_plaintiff') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="case_defendant" class="form-label">Defendant</label>
            <input wire:model='addForm.case_defendant' type="text" class="form-control" id="defendant" required>
            @error('addForm.case_defendant') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="case_category" class="form-label">Category/ الفئة</label>
            <input wire:model='addForm.case_category' list="issues" type="text" class="form-control" id="case_category" required>
            @error('addForm.case_category') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

            <datalist id="issues">
                <option value="Litigation and pleading">الدعاوى والتقادم</option>
                <option value="General Legal Consultation">الاستشارة القانونية العامة</option>
                <option value="Legal consultations in the financial and business sector">الاستشارات القانونية في القطاع المالي والأعمال</option>
                <option value="Contract Services">خدمات العقود</option>
                <option value="Liquidation of Companies">تصفية الشركات</option>
                <option value="Liquidation of estates">تصفية الأملاك</option>
                <option value="Legal mediation and arbitration">الوساطة القانونية والتحكيم</option>
                <option value="Intellectual Property">الملكية الفكرية</option>
                <option value="Establishing Companies">تأسيس الشركات</option>
                <option value="Creating legal department and divisions">إنشاء الإدارة القانونية والأقسام</option>
                <option value="Dept Collection">تحصيل الديون</option>
                <option value="Governance Service">خدمات الحوكمة</option>
                <option value="Other">أخرى</option>
            </datalist>
        </div>

        <div class="mb-3 col-md-4">
            <label for="case_status" class="form-label">Status/الحالة</label>
            <input wire:model='addForm.case_status' list="status" type="text" class="form-control" id="case_status" required>
            @error('addForm.case_status') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

            <datalist id="status">
                <option value="Ongoing"></option>
                <option value="Hold"></option>
                <option value="Closed"></option>
                <option value="Cancel"></option>
            </datalist>
        </div>



        <div class="mb-3 col-md-4">
            <label for="case_attorney" class="form-label">Attorney/محامي</label>
            <input wire:model='addForm.case_attorney' list="attorneys" type="text" class="form-control" id="case_attorney" required>
            @error('addForm.case_attorney') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
            <datalist id="attorneys">
                <option value="Maha Aljubaire"></option>
                <option value="Majed Alghunaim"></option>
                <option value="Meshari Alhumadi"></option>
            </datalist>
        </div>


        <div class="mb-3 col-md-2">
            <label for="case_date" class="form-label">Date/تاريخ</label>
            <input type="date" wire:model='addForm.case_date' class="form-control" id="case_date" required>
            @error('addForm.case_date') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>
        @if (Route::is('add_case'))
        <div class="mb-3 col-md-2">
            <label for="case_documents" class="form-label">Documents</label>
            <input multiple type="file" wire:model='addForm.case_documents'  class="form-control" id="case_documents" required>
            @error('addForm.case_documents') <small class="text-danger"><em>{{ $message }}</em></small> @enderror
        </div>

        @endif

        <div class="mb-3 col-md-6">
            <label for="case_description" class="form-label">Description/الوصف</label>
            <textarea wire:model='addForm.case_description' class="form-control" id="case_description" rows="3"></textarea>
            @error('addForm.case_description') <small class="text-danger"><em>{{ $message }}</em></small> @enderror

        </div>
    </div>
</div>
