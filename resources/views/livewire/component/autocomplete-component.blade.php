<div>
    <span x-data="dropdown()">
        <input type="text" class="form-select" x-on:click="toggle()" wire:model.live='selected' readonly>
        <div class="relative" x-show="isOpen()">
            <div class="list-group position-fixed">
                <li class="list-group-item p-0">
                    <input type="text" class="form-control" wire:model.live='keywording' placeholder="Search Keyword..." />
                </li>
                @foreach ($listing as $item)
                    <li class="list-group-item p-0">
                        <button type="button" wire:click='setValue("{{ $item['value'] }}", "{{ $item['text'] }}")'
                            class="btn btn-link no-underline text-black w-100 text-start" x-on:click="close()">
                            {{ $item['text'] }}
                        </button>
                    </li>
                @endforeach
            </div>
        </div>
    </span>
</div>

@push('scripts')
    <script>
        function dropdown() {
            return {
                show: false,
                toggle() {
                    this.show = !this.show
                },
                open() {
                    this.show = true
                },
                close() {
                    this.show = false
                },
                isOpen() {
                    return this.show === true
                },
            }
        }
    </script>
@endpush
