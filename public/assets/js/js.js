 
        document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendarr');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',
        contentHeight: 650,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        events: '/admin/appointments',
         

        eventDidMount: function(info) {
            console.log('Event Mounted:', info.event);
            // Custom coloring based on type (optional)
            const eventType = info.event.extendedProps.type;
            if (eventType === 'Prenatal Checkup') {
                info.el.classList.add('fc-event-prenatal');
            } else if (eventType === 'In Labor') {
                info.el.classList.add('fc-event-labor');
            } else if (eventType === 'Postnatal Checkup') {
                info.el.classList.add('fc-event-postpartum');
            } else if (eventType === 'Checkup') {
                info.el.classList.add('fc-event-checkup');
            }
        },

        eventClick: function(info) {
            alert(
                'Patient: ' + info.event.extendedProps.patient +
                '\nType: ' + info.event.extendedProps.type +
                '\nDate & Time: ' + info.event.start.toLocaleString()
            );
        },

        dateClick: function(info) {
            $('#appointmentDate').val(info.dateStr);
            $('#appointmentModal').modal('show');
        }
    });

    calendar.render();

    // Filter functions
    const filterPrenatal = document.getElementById('filterPrenatal');
    const filterLabor = document.getElementById('filterLabor');
    const filterPostpartum = document.getElementById('filterPostpartum');
    const filterCheckup = document.getElementById('filterCheckup');

    if (filterPrenatal && filterLabor && filterPostpartum && filterCheckup) {
        filterPrenatal.addEventListener('change', filterEvents);
        filterLabor.addEventListener('change', filterEvents);
        filterPostpartum.addEventListener('change', filterEvents);
        filterCheckup.addEventListener('change', filterEvents);
    }

    function filterEvents() {
        const showPrenatal = filterPrenatal.checked;
        const showLabor = filterLabor.checked;
        const showPostpartum = filterPostpartum.checked;
        const showCheckup = filterCheckup.checked;

        const allEvents = calendar.getEvents();

        allEvents.forEach(event => {
            const type = event.extendedProps.type;
            const shouldDisplay = (
                (type === 'Prenatal Checkup' && showPrenatal) ||
                (type === 'In Labor' && showLabor) ||
                (type === 'Postnatal Checkup' && showPostpartum) ||
                (type === 'Checkup' && showCheckup)
            );

            event.setProp('display', shouldDisplay ? 'auto' : 'none');
        });
    }

    // New Appointment button
    const newAppointmentBtn = document.getElementById('newAppointmentBtn');
    if (newAppointmentBtn) {
        newAppointmentBtn.addEventListener('click', function() {
            $('#appointmentModal').modal('show');
        });
    }

    // Save Appointment button
    const saveAppointmentBtn = document.getElementById('saveAppointment');
    if (saveAppointmentBtn) {
        saveAppointmentBtn.addEventListener('click', function() {
            const form = document.getElementById('appointmentForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const patient = document.getElementById('patientSelect').value;
            const type = document.getElementById('appointmentType').value;
            const date = document.getElementById('appointmentDate').value;
            const time = document.getElementById('appointmentTime').value;

            const eventTitle = `${patient} - ${document.getElementById('appointmentType').options[
                document.getElementById('appointmentType').selectedIndex
            ].text}`;

            const startDateTime = `${date}T${time}:00`;
            const endHour = parseInt(time.split(':')[0], 10) + 1;
            const endMinute = time.split(':')[1];
            const endDateTime = `${date}T${endHour < 10 ? '0' + endHour : endHour}:${endMinute}:00`;

            calendar.addEvent({
                title: eventTitle,
                start: startDateTime,
                end: endDateTime,
                extendedProps: {
                    type: type,
                    patient: patient
                }
            });

            $('#appointmentModal').modal('hide');
            form.reset();
            alert('Appointment scheduled successfully!');
        });
    }
});

    