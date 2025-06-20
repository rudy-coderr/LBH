<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryModel extends Model
{
    protected $table = 'delivery_records';
    protected $primaryKey = 'record_id';
    protected $allowedFields = ['patient_id', 'staff_id', 'appointment_id', 'delivery_date', 'delivery_type', 'complications', 'baby_weight', 'baby_sex'];

    // Fetch prenatal records for a specific patient by patient ID
    public function getDeliveryRecordsByPatientId($patientId)
{
    $query = $this->select('delivery_records.*, 
                            patients.full_name AS patient_name, 
                            staff.first_name AS staff_first_name, 
                            staff.last_name AS staff_last_name, 
                            appointments.status AS appointment_status')
                  ->join('patients', 'patients.patient_id = delivery_records.patient_id')
                  ->join('staff', 'staff.staff_id = delivery_records.staff_id', 'left')
                  ->join('appointments', 'appointments.appointment_id = delivery_records.appointment_id', 'left')
                  ->where('delivery_records.patient_id', $patientId)
                  ->findAll();



    
        // Debugging: Check if data is fetched correctly
        if (empty($query)) {
            log_message('error', 'No prenatal records found for patient ID: ' . $patientId);
        }
    
        return $query;
    }
    
}
