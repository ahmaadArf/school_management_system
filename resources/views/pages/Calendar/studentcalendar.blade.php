<div>
    <div>
        <div id='calendar-container' wire:ignore>
            <div id='calendar'></div>
        </div>
    </div>
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {

                var calendarEl = document.getElementById('calendar');

                // تهيئة تقويم FullCalendar
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',

                    events: function(fetchInfo, successCallback, failureCallback) {
                        // جلب الأحداث من الخادم باستخدام AJAX
                        $.ajax({
                            url: 'dashboard/getevents',
                            type: 'GET',
                            success: function(data) {
                                successCallback(data); // عرض الأحداث
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching events:', error);
                                failureCallback(error);
                            }
                        });
                    }
                });

                // عرض التقويم
                calendar.render();
            });
        </script>




        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
    @endpush
</div>
