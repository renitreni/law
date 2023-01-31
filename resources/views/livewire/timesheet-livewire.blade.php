<div>
    <div wire:ignore id='calendar' style="height: 150px"></div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar/main.min.css" rel="stylesheet" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            calendar.on('dateClick', function(e) {
                console.log(e);
            });

            window.addEventListener('changeCalendarView', params => {
                let filter = params.detail.params;
                console.log(filter)
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
            });
        });
    </script>
@endpush
