<div>
    <h3>Inquiry</h3>
    <livewire:inquiry-table/>

    {{-- modal --}}
    @if ($isView)
    <div class="modal fade show d-block" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex flex-column">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $viewData->firstname }} {{ $viewData->lastname }} </h5>
                        <small class="modal-title">{{ $viewData->email }}</small>
                    </div>
                    <button wire:click='close' type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>Legal Issue: {{ $viewData->legalIssue }}</span>
                    <p class="mt-2">{{ $viewData->message }}</p>

                    <hr>
                    <small>{{ date('F d, Y',strtotime($viewData->created_at)) }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
@endif
</div>
