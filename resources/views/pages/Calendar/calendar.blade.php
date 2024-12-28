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
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    dateClick: function(info) {
                        // عرض نافذة الإدخال
                        var title = prompt('ادخل عنوان الحدث):');

                        // التحقق من الإدخال
                        if (title === null) {
                            // في حالة الإلغاء (النقر على إلغاء في نافذة prompt)
                            alert('تم إلغاء إضافة الحدث');
                            return;
                        }

                        if (title && title.trim() !== '') {
                            // إضافة الحدث إلى التقويم
                            var date = new Date(info.dateStr + 'T00:00:00');
                            calendar.addEvent({
                                title: title,
                                start: date,
                                allDay: true
                            });

                            // إرسال الحدث إلى الخادم باستخدام AJAX
                            var eventAdd = {
                                title: title,
                                start: date.toISOString()
                            };
                            $.ajax({
                                url: 'dashboard/addevent',
                                type: 'POST',
                                data: eventAdd,
                                headers: {
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function(data) {
                                    alert('تم إضافة الحدث بنجاح');
                                    console.log('Event added:', data);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error adding event:', error);
                                    alert('حدث خطأ أثناء إضافة الحدث');
                                }
                            });
                        } else {
                            alert('من فضلك أدخل عنوان الحدث.');
                        }
                    },
                    editable: true,
                    selectable: true,
                    displayEventTime: false,
                    droppable: true,
                    eventDrop: function(info) {
                        // تحديث الحدث في الخادم
                        var updatedEvent = {
                            id: info.event.id,
                            start: info.event.start.toISOString(),
                        };
                        $.ajax({
                            url: 'dashboard/updateevent',
                            type: 'POST',
                            data: updatedEvent,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                alert('تم تحديث الحدث بنجاح');
                                console.log('Event updated:', data);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error updating event:', error);
                                alert('حدث خطأ أثناء تحديث الحدث');
                            }
                        });
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // جلب الأحداث من الخادم
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

                calendar.render();
            });
        </script>



        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
    @endpush
</div>
