<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';
    protected $allowedFields = ['patient_id', 'staff_id', 'appointment_date', 'status', 'notes','appointment_type'];

    // Existing method to fetch appointment with patient info
    public function getAppointmentsWithPatient()
    {
        return $this->select('appointments.*, patients.full_name AS patient_name')
                    ->join('patients', 'patients.patient_id = appointments.patient_id');
    }

    // ✅ New method: fetch appointment with patient and staff info
    public function getAppointmentsWithPatientAndStaff()
    {
        return $this->select('appointments.*, 
                              patients.full_name AS patient_name, 
                              staff.first_name AS staff_first_name, 
                              staff.last_name AS staff_last_name')
                    ->join('patients', 'patients.patient_id = appointments.patient_id')
                    ->join('staff', 'staff.staff_id = appointments.staff_id', 'left');
                   
    }
}
