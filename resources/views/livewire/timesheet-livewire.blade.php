<div>
    <div id="calendar"></div>
</div>


@push('scripts')
    <script src="{{ asset('fullcalendar/dist/index.global.min.js') }}"></script>
    <link href="" rel="stylesheet" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    start: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                    end: 'prevYear,prev,next,nextYear'
                },
            });
            calendar.render();
        });
    </script>
@endpush
