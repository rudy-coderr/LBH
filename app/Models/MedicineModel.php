<?php
namespace App\Models;
use CodeIgniter\Model;

class MedicineModel extends Model
{
    protected $table = 'medicines';
    protected $primaryKey = 'medicine_id';
    protected $allowedFields = ['medicine_name','category','quantity','expiry_date','price'];
}
