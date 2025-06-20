<?php

namespace App\Models;
use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'patient_id';
    protected $allowedFields = ['user_id', 'full_name', 'age', 'contact_number', 'address'];

    public function getPatientWithUsers()
    {
        return $this->select('patients.*, users.username, users.role')
                    ->join('users', 'users.user_id = patients.user_id')
                    ->findAll();
    }
}
