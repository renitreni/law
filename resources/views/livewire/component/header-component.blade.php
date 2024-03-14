<header class="header" id="header">
    <div class="d-flex flex-row">
        <div class="header_toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="d-flex flex-row ms-5">
            <button type="button" wire:click="$set('state', 'month')"
                class="btn {{ $state == 'month' ? 'btn-info text-white' : 'btn-outline-info' }} mx-1">
                Month
            </button>
            <button type="button" wire:click="$set('state', 'week')"
                class="btn {{ $state == 'week' ? 'btn-info text-white' : 'btn-outline-info' }} mx-1">
                Week
            </button>
            <button type="button" wire:click="$set('state', 'day')"
                class="btn {{ $state == 'day' ? 'btn-info text-white' : 'btn-outline-info' }} mx-1">
                Day
            </button>
            <div class="d-flex flex-row ms-2">
                <select wire:model.live="month" class="form-select">
                    @foreach ($monthList as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>
                <select wire:model.live="year" class="form-select ms-1">
                    @foreach ($yearList as $key => $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
                @if ($state == 'week')
                    <select wire:model.live="selectedRange" class="form-select ms-1">
                        @foreach ($monthRange as $range)
                            <option value="{{ $range['start'].'#'.$range['end'] }}">
                                {{ Carbon\Carbon::parse($range['start'])->format('d').' - '.Carbon\Carbon::parse($range['end'])->format('d') }}
                            </option>
                        @endforeach
                    </select>
                @endif
                @if ($state == 'day')
                    <select wire:model.live="day" class="form-select ms-1">
                        @foreach ($dayList as $day)
                            <option value="{{ $day }}">
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </div>

    <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div>
</header>

@push('scripts')
    <script></script>
@endpush
