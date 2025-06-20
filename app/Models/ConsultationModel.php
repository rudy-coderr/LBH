<?php

namespace App\Models;
use CodeIgniter\Model;

class ConsultationModel extends Model
{
    protected $table = 'consultation';
    protected $primaryKey = 'consultation_id';
    protected $allowedFields = ['appointment_id', 'patient_id', 'staff_id', 'consultation_date', 'diagnosis', 'prescription', 'address', 'notes','status'];

    public function getConsultationsByPatientId($patient_id)
    {
        return $this->select('consultation.*, staff.first_name as staff_first_name, staff.last_name as staff_last_name, 
                             patients.full_name as patient_full_name')
                    ->join('staff', 'staff.staff_id = consultation.staff_id')
                    ->join('patients', 'patients.patient_id = consultation.patient_id')
                    ->where('consultation.patient_id', $patient_id)
                    ->findAll();
    }
    
}
