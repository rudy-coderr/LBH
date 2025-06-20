<?php

namespace App\Models;

use CodeIgniter\Model;

class PostnatalModel extends Model
{
    protected $table = 'postnatal_records';
    protected $primaryKey = 'record_id';
    protected $allowedFields = ['patient_id', 'staff_id', 'appointment_id', 'visit_date', 'baby_weight', 'breastfeeding_status', 'mental_health_check', 'remarks'];

    // Fetch prenatal records for a specific patient by patient ID
    public function getPostnatalRecordsByPatientId($patientId)
    {
        $query = $this->select('postnatal_records.*, 
                                patients.full_name AS patient_name, 
                                staff.first_name AS staff_first_name, 
                                staff.last_name AS staff_last_name, 
                                appointments.status AS appointment_status')
                      ->join('patients', 'patients.patient_id = postnatal_records.patient_id')
                      ->join('staff', 'staff.staff_id = postnatal_records.staff_id', 'left')
                      ->join('appointments', 'appointments.appointment_id = postnatal_records.appointment_id', 'left')
                      ->where('postnatal_records.patient_id', $patientId)
                      ->findAll();
    
        // Debugging: Check if data is fetched correctly
        if (empty($query)) {
            log_message('error', 'No postnatal records found for patient ID: ' . $patientId);
        }
    
        return $query;
    }
    
}
