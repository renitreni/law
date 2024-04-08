<div>
    <div class="row">
        <div class="col-md-12">
            <livewire:component.calendar-control-component>
        </div>
        <div class="col-md-12 mt-3">
            <div class="d-flex flex-row">
                <button class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#timeEntryModal"
                    wire:click='createTimeEntry'>
                    <i class='bx bx-plus'></i>
                    New Time Entry
                </button>

                @isset($details[0])
                    <h3 class="my-auto">{{ \Carbon\Carbon::parse($details[0]['entry_date'])->format('F j, Y') }}</h3>
                @endisset
            </div>
            <div class="accordion mt-3" id="accordionPanelsStayOpenExample">
                @foreach ($details as $item)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-heading{{ $item['id'] }}">
                            <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapse{{ $item['id'] }}" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapse{{ $item['id'] }}">
                                <div class="row w-100">
                                    <div class="col-md-3 m-auto">
                                        {{ strtoupper($item['clients']['code']) }} - {{ $item['clients']['name'] }}
                                    </div>
                                    <div class="col-md-3 m-auto">
                                        {{ strtoupper($item['submatters']['code']) }} -
                                        {{ $item['submatters']['name'] }}
                                    </div>
                                    <div class="col-md-2 m-auto">
                                        @if ($item['is_draft'])
                                            <span class="badge bg-warning">draft</span>
                                        @else
                                            <span class="badge bg-success">posted</span>
                                        @endif
                                        @if ($item['is_billable'])
                                            <span class="badge bg-primary">billable</span>
                                        @else
                                            <span class="badge bg-danger">non-billable</span>
                                        @endif
                                    </div>
                                    <div class="col-md-2 m-auto">
                                        <strong>{{ $item['duration'] }}</strong>
                                    </div>
                                </div>
                            </span>
                        </h2>
                        <div id="panelsStayOpen-collapse{{ $item['id'] }}" class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-heading{{ $item['id'] }}">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-auto">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#timeEntryModal" wire:click='editTimeEntry({{ $item['id'] }})'>
                                            <i class="fas fa-pencil"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <strong class="me-2">Duration</strong>
                                        <label>{{ $item['duration'] }}</label>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                    </div>
                                    <div class="col-md-4">
                                        <strong class="me-2">Client</strong>
                                        <label>{{ strtoupper($item['clients']['code']) }} -
                                            {{ $item['clients']['name'] }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <strong class="me-2">Matters</strong>
                                        <label>{{ strtoupper($item['clients']['code']) }} -
                                            {{ $item['clients']['name'] }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <strong class="me-2">Office</strong>
                                        <label>{{ strtoupper($item['offices']['code']) }} -
                                            {{ $item['offices']['name'] }}</label>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <strong class="me-2">Narrative</strong><br>
                                        <p>{{ $item['narrative'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div wire:ignore id='calendar' style="height: 150px"></div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="timeEntryModal" aria-labelledby="timeEntryModalLabel"
        aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeEntryModalLabel">Time Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col-md-5 d-flex flex-row mb-3">
                            <div class="me-3">
                                <label>Entry Date</label>
                                <input type="date" class="form-control" wire:model.live='timeEntry.entry_date'>
                                @error('timeEntry.entry_date')
                                    <small class="text-danger text-nowrap">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="me-3">
                                <label>Duration</label>
                                <input type="number" class="form-control" wire:model.live='timeEntry.duration'>
                                @error('timeEntry.duration')
                                    <small class="text-danger text-nowrap">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Apply a Template</label>
                            {{-- :defaultVal="[1, 'aut']" --}}
                            <livewire:component.autocomplete-component wire:model="templates" :keywordCallback="'keywordTemplate'" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Client</label>
                            <livewire:component.autocomplete-component wire:model="clients" :keywordCallback="'keywordClient'" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Matters</label>
                            <livewire:component.autocomplete-component wire:model="matter" :keywordCallback="'keywordMatter'" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Sub Matter</label>
                            <livewire:component.autocomplete-component wire:model="subMatter" :keywordCallback="'keywordSubMatter'" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Office</label>
                            <livewire:component.autocomplete-component wire:model="office" :keywordCallback="'keywordOffice'" />
                        </div>

                        <div class="col-12 mb-3">
                            <label>Narrative</label>
                            <textarea class="form-control" rows="5" wire:model.live='timeEntry.narrative'></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault"
                                    wire:model.live='timeEntry.is_template'>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Save as Template
                                </label>
                            </div>
                        </div>
                        @if ($timeEntry['is_template'] ?? false)
                            <div class="col-md-4">
                                <input type="text" class="form-control" wire:model.live='timeEntry.template_name'
                                    placeholder="Type in Template Name">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" wire:click='store(0)'>Draft</button>
                    <button type="button" class="btn btn-success" wire:click='store(1)'>Post</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar/main.min.css" rel="stylesheet" />

    <script>
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: 750,
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'title',
                center: '',
                right: ''
            },
        });

        calendar.render();

        window.addEventListener('changeCalendarView', params => {
            let filter = params.detail[0].params;

            if (filter.state == 'month') {
                calendar.changeView('dayGridMonth', filter.start);
                calendar.setOption('height', 700);
            }
            if (filter.state == 'week') {
                calendar.changeView('dayGridWeek', filter.start);
                calendar.setOption('height', 300);
            }
            if (filter.state == 'day') {
                calendar.changeView('dayGridDay', filter.single_date);
                calendar.setOption('height', 300);
            }
            resetCalendar()
            $(".fc-event-title").each(function() {
                $(this).html($(this).text());
            });
            Livewire.dispatch('loadCalendarSummary');
        });

        window.addEventListener('load', () => {
            calendar.removeAllEvents();
            Livewire.dispatch('loadCalendarSummary');
        });

        window.addEventListener('bindCalendarSummary', params => {
            resetCalendar()
            params.detail[0][0].forEach(function(value, idx) {
                calendar.addEvent(value);
            });
            $(".fc-event-title").each(function() {
                $(this).html($(this).text());
            });
        });

        calendar.on('eventClick', function(e) {
            @this.showDetails(moment(e.event._instance.range.start).format('L'));
        });

        function resetCalendar() {
            calendar.removeAllEvents();
        }
    </script>
@endpush
