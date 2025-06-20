<?php

namespace App\Models;

use CodeIgniter\Model;

class PrenatalModel extends Model
{
    protected $table = 'prenatal_records';
    protected $primaryKey = 'record_id';
    protected $allowedFields = ['patient_id', 'staff_id', 'appointment_id', 'visit_date', 'gestational_age', 'blood_pressure', 'weight', 'remarks'];

    // Fetch prenatal records for a specific patient by patient ID
    public function getRecordsByPatientId($patientId)
    {
        $query = $this->select('prenatal_records.*, 
                                patients.full_name AS patient_name, 
                                staff.first_name AS staff_first_name, 
                                staff.last_name AS staff_last_name, 
                                appointments.status AS appointment_status')
                      ->join('patients', 'patients.patient_id = prenatal_records.patient_id')
                      ->join('staff', 'staff.staff_id = prenatal_records.staff_id', 'left')
                      ->join('appointments', 'appointments.appointment_id = prenatal_records.appointment_id', 'left')
                      ->where('prenatal_records.patient_id', $patientId)
                      ->findAll();
    
        // Debugging: Check if data is fetched correctly
        if (empty($query)) {
            log_message('error', 'No prenatal records found for patient ID: ' . $patientId);
        }
    
        return $query;
    }
    
}
