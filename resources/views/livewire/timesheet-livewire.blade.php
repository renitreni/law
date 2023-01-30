<div>
    <div id='calendar' style="height: 150px"></div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar/main.min.css" rel="stylesheet" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    center: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
            });
            calendar.render();

            calendar.on('dateClick', function(e) {
                console.log(e);
            });
        });
    </script>
@endpush
