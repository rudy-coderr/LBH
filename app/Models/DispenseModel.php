<?php
namespace App\Models;
use CodeIgniter\Model;

class DispenseModel extends Model
{
    protected $table = 'medicine_dispense';
    protected $primaryKey = 'dispense_id';
    protected $allowedFields = [
        'patient_id', 'medicine_id', 'quantity', 'price', 'total', 'dispense_date'
    ];
}
