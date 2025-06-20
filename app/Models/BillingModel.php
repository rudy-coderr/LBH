<?php

namespace App\Models;
use CodeIgniter\Model;

class BillingModel extends Model
{
    protected $table = 'billing';
    protected $primaryKey = 'billing_id';
    protected $allowedFields = [
        'patient_id',
        'amount',
        'payment_status',
        'payment_date',
        'notes'
    ];

    public function getBillingWithPatients()
    {
        return $this->select('billing.*, patients.full_name')
                    ->join('patients', 'patients.patient_id = billing.patient_id')
                    ->findAll();
    }
    
}
