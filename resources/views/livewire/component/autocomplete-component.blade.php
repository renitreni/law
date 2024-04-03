<div>
    <div x-data="dropdown()" x-on:focusin.window="!containsProcess($refs.panel.contains($event.target)) && !close()">
        <input id="{{ $keywordCallback }}" class="form-select auto-comp" wire:click='toggleAction'
            x-on:click="toggle('{{ $keywordCallback }}')" wire:model.live='selected'
             readonly>
        <div class="position-relative d-inline">
            <div class="list-group position-absolute mt-1" id="{{ $keywordCallback }}-list" style="z-index: 10;"
                wire:ignore.self x-show="isOpen()"  x-trap="open" x-ref="panel" x-on:click.outside="close()">
                <li class="list-group-item p-0">
                    <input type="text" class="form-control border-0" wire:model.live='keywording'
                        placeholder="Search Keyword..."/>
                </li>

                @if ($selected)
                    <li class="list-group-item p-0 text-center">
                        <a href="#" class="btn btn-link" wire:click='refresh'>Clear Selected</a>
                    </li>
                @endif

                @foreach ($listing as $item)
                    <li class="list-group-item p-0">
                        <button type="button" wire:click='setValue("{{ $item['value'] }}", "{{ $item['text'] }}")'
                            class="btn btn-link no-underline text-black w-100 text-start bg-light" x-on:click="close()">
                            {{ $item['text'] }}
                        </button>
                    </li>
                @endforeach

                @if (!$listing)
                    <li class="list-group-item p-0 text-center py-2">
                        No Results Found
                    </li>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function dropdown() {
            return {
                containsProcess(value, id) {

                    return value;
                },
                show: false,
                toggle(id) {
                    let el = document.getElementById(id);
                    let child = document.getElementById(id + "-list");
                    child.style.width = el.getBoundingClientRect().width + 'px'
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
