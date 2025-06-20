<?php

namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    protected $allowedFields = ['user_id', 'first_name', 'last_name', 'position', 'contact_number', 'email', 'address'];

    public function getAdminWithUsers()
    {
        return $this->select('admin.*, users.username, users.role')
                    ->join('users', 'users.user_id = admin.user_id')
                    ->findAll();
    }
}
