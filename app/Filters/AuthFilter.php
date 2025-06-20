<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Check if user is logged in
        if (!$session->has('user_id')) {
            return redirect()->to('/login');
        }

        $userRole = strtolower($session->get('role')); // Convert to lowercase

        if (!empty($arguments)) {
            $requiredRole = strtolower($arguments[0]); // Convert to lowercase

            // If user role does not match the required role, show unauthorized page
            if ($userRole !== $requiredRole) {
                return redirect()->to('/unauthorized');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
