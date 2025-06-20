<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StaffModel;
use App\Models\AdminModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $session = session();
        $userModel = new UserModel();
        $staffModel = new StaffModel();
        $adminModel = new AdminModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role = strtolower($this->request->getPost('role')); // Normalize role to lowercase

        // Find user by username and role
        $user = $userModel->where('username', $username)->where('role', ucfirst($role))->first();

        if ($user) {
            // Use password_verify to compare entered password with hashed password
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'role' => strtolower($user['role']),
                    'logged_in' => true,
                ];

                if ($user['role'] === 'Staff') {
                    $staff = $staffModel->where('user_id', $user['user_id'])->first();
                    if ($staff) {
                        $sessionData['staff_id'] = $staff['staff_id'];
                        $sessionData['first_name'] = $staff['first_name'];
                        $sessionData['last_name'] = $staff['last_name'];
                    }
                }

                if ($user['role'] === 'Admin') {
                    $admin = $adminModel->where('user_id', $user['user_id'])->first();
                    if ($admin) {
                        $sessionData['admin_id'] = $admin['admin_id'];
                        $sessionData['first_name'] = $admin['first_name'];
                        $sessionData['last_name'] = $admin['last_name'];
                    }
                }

                // Store session data
                $session->set($sessionData);

                // Redirect based on role
                if ($sessionData['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } elseif ($sessionData['role'] === 'staff') {
                    return redirect()->to('/staff/dashboard');
                } else {
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('error', 'Invalid password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'User not found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
