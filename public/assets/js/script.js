// Login Script
// Tab switching functionalit
 document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.login-tab');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Hide all forms
            document.querySelectorAll('.login-form-container').forEach(form => {
                form.classList.remove('active');
            });
            
            // Show the corresponding form
            const tabType = this.getAttribute('data-tab');
            document.getElementById(tabType + '-form').classList.add('active');
        });
    });
});
// End Login Script

// Dashboard Script / Navbar
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('toggle-sidebar');
    const sidebarIcon = document.getElementById('sidebar-icon');

    toggleButton.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');

        if (sidebar.classList.contains('collapsed')) {
            sidebarIcon.classList.remove('fa-chevron-left');
            sidebarIcon.classList.add('fa-chevron-right');
        } else {
            sidebarIcon.classList.remove('fa-chevron-right');
            sidebarIcon.classList.add('fa-chevron-left');
        }
    });
});

// update medicine
function opennUpdateModal(medicine) {
    document.getElementById('update_medicine_id').value = medicine.medicine_id;
    document.getElementById('update_medicine_name').value = medicine.medicine_name;
    document.getElementById('update_category').value = medicine.category;
    document.getElementById('update_quantity').value = medicine.quantity;
    document.getElementById('update_expiry_date').value = medicine.expiry_date;
    document.getElementById('update_price').value = medicine.price;

    var updateModal = new bootstrap.Modal(document.getElementById('updateMedicineModal'));
    updateModal.show();
}

// update staff
function openUpdateModal(staff) {
    document.getElementById('update_staff_id').value = staff.staff_id;
    document.getElementById('update_first_name').value = staff.first_name;
    document.getElementById('update_last_name').value = staff.last_name;
    document.getElementById('update_contact_number').value = staff.contact_number;
    document.getElementById('update_email').value = staff.email;
    document.getElementById('update_address').value = staff.address;
    document.getElementById('update_date_hired').value = staff.date_hired;
    document.getElementById('update_username').value = staff.username;

    // Set selected value for position
    const positionSelect = document.getElementById('update_position');
    for (let option of positionSelect.options) {
        if (option.value === staff.position) {
            option.selected = true;
        }
    }

    // Set selected value for role
    const roleSelect = document.getElementById('update_role');
    for (let option of roleSelect.options) {
        if (option.value === staff.role) {
            option.selected = true;
        }
    }

    const updateModal = new bootstrap.Modal(document.getElementById('updateStaffModal'));
    updateModal.show();
}

// update patient
function openUpdatePatient(patients) {
    document.getElementById('update_patient_id').value = patients.patient_id;
    document.getElementById('update_full_name').value = patients.full_name;
    document.getElementById('update_age').value = patients.age;
    document.getElementById('update_contact_number').value = patients.contact_number;
    document.getElementById('update_address').value = patients.address
    const updateModal = new bootstrap.Modal(document.getElementById('updatePatientModal'));
    updateModal.show();
}
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".add-appointment-btn").forEach(button => {
        button.addEventListener("click", function () {
            let patientName = this.getAttribute("data-name"); // Get patient's name
            document.getElementById("patientName").value = patientName; // Set it in the input field
        });
    });
});




    document.querySelectorAll('.add-consultation-btn').forEach(button => {
        button.addEventListener('click', function () {
            const patientId = this.getAttribute('data-id');
            const patientName = this.getAttribute('data-name');
            const appointmentId = this.getAttribute('data-appointment');
            const appointmentType = this.getAttribute('data-type');

            // Fill the modal fields
            const modals = {
                "Prenatal Checkup": "#addPrenatalConsultationModal",
                "In Labor": "#addDeliveryConsultationModal",
                "Postnatal Checkup": "#addPostnatalConsultationModal"
            };

            const modalId = modals[appointmentType];

            if (!modalId) {
                alert("Unknown appointment type: " + appointmentType);
                return;
            }

            // Set values in the appropriate modal
            const modal = document.querySelector(modalId);
            if (modal) {
                modal.querySelector('input[name="patient_name"]').value = patientName;
                modal.querySelector('input[name="patient_id"]').value = patientId;
                modal.querySelector('input[name="appointment_id"]').value = appointmentId;

                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
        });
    });




// Appointments calendar
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

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
        events: '/staff/appointments',
         

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



// End Dashboard Script / Navbar



