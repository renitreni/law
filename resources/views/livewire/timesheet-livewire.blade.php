<div>
    <div wire:ignore id='calendar' style="height: 150px"></div>
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

            calendar.on('dateClick', function(e) {
                console.log(e);
            });

            function resetCalendar()
            {
                calendar.removeAllEvents();
            }
    </script>
@endpush
