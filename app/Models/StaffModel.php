<?php

namespace App\Models;
use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    protected $allowedFields = ['user_id', 'first_name', 'last_name', 'position', 'contact_number', 'email', 'address', 'date_hired'];

    public function getStaffWithUsers()
    {
        return $this->select('staff.*, users.username, users.role')
                    ->join('users', 'users.user_id = staff.user_id')
                    ->findAll();
    }
}
