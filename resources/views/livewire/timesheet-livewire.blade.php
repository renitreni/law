<div>
    <div class="row">
        <div class="col-md-12">
            <div wire:ignore id='calendar' style="height: 150px"></div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="d-flex flex-row">
                <button class="btn btn-success mx-2">
                    <i class="fas fa-plus"></i>
                    New Entry
                </button>
                @isset($details[0])
                    <h3>{{ \Carbon\Carbon::parse($details[0]['entry_date'])->format('F j, Y') }}</h3>
                @endisset
            </div>
            <div class="accordion mt-3" id="accordionPanelsStayOpenExample">
                @foreach ($details as $item)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-heading{{ $item['id'] }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapse{{ $item['id'] }}" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapse{{ $item['id'] }}">
                                <div class="row w-100">
                                    <div class="col-md-4">
                                        {{ strtoupper($item['clients']['code']) }} - {{ $item['clients']['name'] }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ strtoupper($item['submatters']['code']) }} -
                                        {{ $item['submatters']['name'] }}
                                    </div>
                                    <div class="col-md-2">
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
                                    <div class="col-md-2"><strong>{{ $item['duration'] }}</strong></div>
                                </div>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapse{{ $item['id'] }}" class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-heading{{ $item['id'] }}">
                            <div class="accordion-body">
                            </div>
                        </div>
                    </div>
                @endforeach
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
            let filter = params.detail.params;
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
            Livewire.emit('loadCalendarSummary');
        });

        window.addEventListener('load', () => {
            calendar.removeAllEvents();
            Livewire.emit('loadCalendarSummary');
        });

        window.addEventListener('bindCalendarSummary', params => {
            resetCalendar()
            params.detail[0].forEach(function(value, idx) {
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
