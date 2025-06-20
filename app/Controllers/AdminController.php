<?php

namespace App\Controllers;
use App\Models\StaffModel;
use App\Models\UserModel;
use App\Models\MedicineModel;
use App\Models\PatientModel;
use App\Models\AppointmentModel;
use App\Models\PrenatalModel;
use App\Models\PostnatalModel;
use App\Models\DeliveryModel;
use App\Models\AdminModel;
use App\Models\BillingModel;
use Dompdf\Dompdf;



use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
  public function index()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $staffModel = new StaffModel();
    $patientModel = new PatientModel();
    $appointmentModel = new AppointmentModel();

    // Count total staff
    $totalStaff = $staffModel->countAll();

    // Count total patients
    $totalPatient = $patientModel->countAll();

    // Count appointments for the current month
    $currentMonth = date('m');
    $currentYear = date('Y');

    $monthlyAppointments = $appointmentModel
    ->where('MONTH(appointment_date)', $currentMonth)
    ->where('YEAR(appointment_date)', $currentYear)
    ->where('status !=', 'pending') // Exclude pending
    ->countAllResults();

    $data = [
        'first_name'          => session()->get('first_name'),
        'last_name'           => session()->get('last_name'),
        'role'                => session()->get('role'),
        'totalStaff'          => $totalStaff,
        'totalPatient'        => $totalPatient,
        'monthlyAppointments' => $monthlyAppointments,
    ];

    return view('admin/dashboard', $data);
}


    
    
   

    public function appointment()
    {
        $data =[  ];
   
        return view ("admin/Appointment", $data);    

    }
    public function staff()
    {
        $data =[  ];
   
        return view ("admin/Staff", $data);    

    }

    

    public function fetchAllStaff(): string
    {  
        $staffModel = new StaffModel();
        $data['listofstaff'] = $staffModel->getStaffWithUsers(); // Use new method
    
        return view('admin/staff', $data);
    }

    public function insertStaff()
    {
        $staffModel = new StaffModel();
        $userModel = new UserModel();
    
        // Prepare user data
        $userData = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
        ];
    
        // Insert into users table
        if ($userModel->insert($userData)) {
            $userId = $userModel->getInsertID(); // Get the last inserted user_id
    
            // Prepare staff data
            $staffData = [
                'user_id' => $userId,
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'position' => $this->request->getPost('position'),
                'contact_number' => $this->request->getPost('contact_number'),
                'email' => $this->request->getPost('email'),
                'address' => $this->request->getPost('address'),
                'date_hired' => $this->request->getPost('date_hired'),
            ];
    
            // Insert into staff table
            if ($staffModel->insert($staffData)) {
                return redirect()->to('/admin/Staff')->with('success', 'Staff added successfully.');
            } else {
                log_message('error', 'Failed to insert staff: ' . json_encode($staffModel->errors()));
                return redirect()->back()->with('error', 'Failed to add staff to the staff table.');
            }
        } else {
            log_message('error', 'Failed to insert user: ' . json_encode($userModel->errors()));
            return redirect()->back()->with('error', 'Failed to add user to the users table.');
        }
    }

    public function deleteStaff($staff_id)
{
    $staffModel = new StaffModel();
    $userModel = new UserModel();

    // Check if the staff exists
    $staff = $staffModel->find($staff_id);
    if (!$staff) {
        return redirect()->back()->with('error', 'Staff not found.');
    }

    // Delete related user first
    if ($staff['user_id']) {
        $userModel->delete($staff['user_id']);
    }

    // Delete the staff record
    if ($staffModel->delete($staff_id)) {
        return redirect()->to('/admin/Staff')->with('success', 'Staff deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to delete staff.');
    }
}

// Update
public function updateStaff()
{
    $staffModel = new StaffModel();
    $userModel = new UserModel();

    $staffId = $this->request->getPost('staff_id');
    $userId = $staffModel->where('staff_id', $staffId)->first()['user_id'];

    if (!$staffId || !$userId) {
        return redirect()->back()->with('error', 'Invalid Staff ID.');
    }

    // Update staff data
    $staffData = [
        'first_name' => $this->request->getPost('first_name'),
        'last_name' => $this->request->getPost('last_name'),
        'position' => $this->request->getPost('position'),
        'contact_number' => $this->request->getPost('contact_number'),
        'email' => $this->request->getPost('email'),
        'address' => $this->request->getPost('address'),
        'date_hired' => $this->request->getPost('date_hired'),
    ];

    // Update user data
    $userData = [
        'username' => $this->request->getPost('username'),
        'role' => $this->request->getPost('role'),
    ];

    // Update password if provided
    if ($this->request->getPost('password')) {
        $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
    }

    $staffModel->update($staffId, $staffData);
    $userModel->update($userId, $userData);

    return redirect()->to('/admin/Staff')->with('success', 'Staff updated successfully.');
}
// Search
public function searchStaff()
{
    $staffModel = new StaffModel();
    $searchTerm = $this->request->getGet('search');

    if (!empty($searchTerm)) {
        $staffModel->select('staff.*, users.username, users.role');
        $staffModel->join('users', 'users.user_id = staff.user_id');
        $staffModel->groupStart()
            ->like('staff.first_name', $searchTerm)
            ->orLike('staff.last_name', $searchTerm)
            ->orLike('users.username', $searchTerm)
            ->groupEnd();
    }

    $listofstaff = $staffModel->findAll();

    if (empty($listofstaff)) {
        session()->setFlashdata('error', "No staff found for: '$searchTerm'");
    }

    $data = [
        'listofstaff' => $listofstaff,
        'searchTerm' => $searchTerm,
    ];

    return view('admin/staff', $data);
}


//Medicine Management

public function insertMedicine()
{
    $model = new MedicineModel();
    
    $data = [
        'medicine_name' => $this->request->getPost('medicine_name'),
        'category' => $this->request->getPost('category'),
        'quantity' => $this->request->getPost('quantity'),
        'expiry_date' => $this->request->getPost('expiry_date'),
        'price' => $this->request->getPost('price'),
    ];

    $model->insert($data);
    session()->setFlashdata('success', 'Medicine added successfully!');
    return redirect()->to('/admin/Medication');
}

public function fetchAllMedicines(): string{  
    //Fetching All products
   $medicinemodel= new MedicineModel();
   $data['listofmedicines'] = $medicinemodel->findAll();

   return view('admin/Medication', $data);

//    echo '<pre>';
//    print_r($data);
//    echo'</pre>';
//    exit;

}

//For Fetching Product  id
public function fetchMedicineByID($medicine_id) {
    $medicinemodel = new MedicineModel();
    $medicine = $medicinemodel->find($medicine_id);

    if ($medicine) {
        return $this->response->setJSON($medicine);
    } else {
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Medicine not found']);
    }
}


//For Updating
public function updateMedicine()
{
    $medicinemodel = new MedicineModel();
    
    // Validate form data
    $medicine_id = $this->request->getPost('medicine_id');
    if (!$medicine_id) {
        return redirect()->to('/admin/Medication')->with('error', 'Invalid medicine ID.');
    }

    // Get data from form
    $data = [
        'medicine_name' => $this->request->getPost('medicine_name'),
        'category' => $this->request->getPost('category'),
        'quantity' => $this->request->getPost('quantity'),
        'expiry_date' => $this->request->getPost('expiry_date'),
        'price' => $this->request->getPost('price'),
    ];

    // Perform update
    if ($medicinemodel->update($medicine_id, $data)) {
        return redirect()->to('/admin/Medication')->with('success', 'Medicine updated successfully.');
    } else {
        return redirect()->to('/admin/Medication')->with('error', 'Failed to update medicine.');
    }
}


//For Deleting
public function deleteMedicine($medicine_id)
{
    $medicinemodel = new MedicineModel();

    if ($medicinemodel->find($medicine_id)) {
        $medicinemodel->delete($medicine_id);
        return redirect()->to('/admin/Medication')->with('success', 'Medicine deleted successfully.');
    }

    return redirect()->to('/medicines')->with('error', 'Medicine not found.');
}

public function searchMedicine()
{
    $model = new MedicineModel();
    $searchTerm = $this->request->getGet('search');
    
    $data['searchTerm'] = $searchTerm; // Pass the search term to view
    $data['listofmedicines'] = $searchTerm 
        ? $model->like('medicine_name', $searchTerm)->findAll()
        : $model->findAll();
    
    // Check if no results found
    if (empty($data['listofmedicines'])) {
        session()->setFlashdata('error', "No Medicine found for: '$searchTerm'");
    }

    return view('admin/Medication', $data);
}
 protected $appointmentModel;

        public function __construct()
        {
            $this->appointmentModel = new AppointmentModel();
        }
 public function appointments()
        {
            return $this->getAppointments();
        }
//Appointment
 public function getAppointments()
            {
                $appointments = $this->appointmentModel->getAppointmentsWithPatient()->findAll();

                $events = [];

                foreach ($appointments as $appointment) {
                    // Filter: Only include Approved and For Follow up
                    if ($appointment['status'] === 'Approved' || $appointment['status'] === 'For follow up') {
                        $startDateTime = new \DateTime($appointment['appointment_date']);
                        $endDateTime = (clone $startDateTime)->modify('+1 hour'); // Default end time is 1 hour after start

                        $events[] = [
                            'title' => $appointment['patient_name'],
                            'start' => $startDateTime->format('Y-m-d\TH:i:s'),
                            'end'   => $endDateTime->format('Y-m-d\TH:i:s'),
                            'extendedProps' => [
                                'type' => $appointment['appointment_type'],
                                'patient' => $appointment['patient_name'],
                                'status' => $appointment['status'],
                                'notes' => $appointment['notes']
                            ]
                        ];
                    }
                }

                return $this->response->setJSON($events);
            }

 public function fetchAllPatient(): string
    {  
        $patientModel = new PatientModel();
        $data['listofpatients'] = $patientModel->getPatientWithUsers(); // Use new method
    
        return view('admin/Patient', $data);
    }
     public function insertPatient()
    {
        $patientModel = new PatientModel();
        $userModel = new UserModel();
    
        // Prepare user data
        $userData = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
        ];
    
        // Insert into users table
        if ($userModel->insert($userData)) {
            $userId = $userModel->getInsertID(); // Get the last inserted user_id
    
            // Prepare staff data
            $patientData = [
                'user_id' => $userId,
                'full_name' => $this->request->getPost('full_name'),
                'age' => $this->request->getPost('age'),
                'contact_number' => $this->request->getPost('contact_number'),
                'address' => $this->request->getPost('address'),
            ];
    
            // Insert into patient table
            if ($patientModel->insert($patientData)) {
                return redirect()->to('/admin/Patient')->with('success', 'Patient registered successfully.');
            } else {
                log_message('error', 'Failed to insert staff: ' . json_encode($patientModel->errors()));
                return redirect()->back()->with('error', 'Failed to register patient.');
            }
        } else {
            log_message('error', 'Failed to insert user: ' . json_encode($userModel->errors()));
            return redirect()->back()->with('error', 'Failed to add user to the users table.');
        }
    }
 
public function updatePatient()
    {
        $patientModel = new PatientModel();
        
        $patientId = $this->request->getPost('patient_id');
    
        if (!$patientId) {
            return redirect()->back()->with('error', 'Invalid Patient ID.');
        }
    
        // Update patient data
        $patientData = [
            'full_name' => $this->request->getPost('full_name'),
            'age' => $this->request->getPost('age'),
            'contact_number' => $this->request->getPost('contact_number'),
            'address' => $this->request->getPost('address'),
        ];
    
        $patientModel->update($patientId, $patientData);
    
        return redirect()->to('/admin/Patient')->with('success', 'Patient updated successfully.');
    }
public function addAppointment()
    {
        $appointmentModel = new AppointmentModel();
        $patientModel = new PatientModel();

        $patientName = $this->request->getPost('full_name');
        $existingPatient = $patientModel->where('full_name', $patientName)->first();

        $patientId = $existingPatient['patient_id'] ?? null;

        if (!$patientId) {
            if ($patientModel->insert(['full_name' => $patientName])) {
                $patientId = $patientModel->getInsertID();
            } else {
                return redirect()->back()->with('error', 'Failed to add patient.');
            }
        }

        $appointmentData = [
            'patient_id'       => $patientId,
            'appointment_date' => $this->request->getPost('appointment_date'),
            'appointment_type'            => $this->request->getPost('appointment_type'),
            'status'           => $this->request->getPost('status') ?: 'Pending',
            'notes'            => $this->request->getPost('notes'),
        ];

        if ($appointmentModel->insert($appointmentData)) {
            return redirect()->to('/admin/Patient')->with('success', 'Appointment added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to add Appointment.');
        }
    }
 public function PatientRecords($patient_id)
        {
            $prenatalModel = new PrenatalModel();
            $deliveryModel = new DeliveryModel();
             $postnatalModel = new PostnatalModel();
        
            // Get prenatal records for the specific patient ID
            $records = $prenatalModel->getRecordsByPatientId($patient_id);
            $deliveryRecord = $deliveryModel->getDeliveryRecordsByPatientId($patient_id);
            $postnatalRecord = $postnatalModel->getPostnatalRecordsByPatientId($patient_id);
            
        
            // Get staff session data
            $staffFullname = session()->get('first_name') . ' ' . session()->get('last_name');
            $staffId = session()->get('staff_id');
        
            // Return the view with required variables
            return view('admin/PatientRecords', [
                'prenatal_records' => $records,
                'delivery_records' => $deliveryRecord,
                'postnatal_records' => $postnatalRecord,
                'staffFullname'    => $staffFullname,
                'staffId'          => $staffId
            ]);
        }
         public function fetchAllApprovedAppointment(): string
        {
            $appointmentModel = new AppointmentModel();
        
            // Modify the query to include both Approved and For Follow-up appointments
            $data['listofapproveAppointment'] = $appointmentModel
                ->getAppointmentsWithPatientAndStaff()
                ->whereIn('appointments.status', ['Approved', 'For follow up'])  // Include both Approved and For Follow-up
                ->findAll();
        
            return view('admin/Appointment', $data);
        }

         public function profileView()
    {
        $session = session();
        $userId = $session->get('user_id'); // dapat naka-save ito sa session pag login

        $adminModel = new AdminModel();
        $admin = $adminModel
            ->select('admin.*, users.username, users.role')
            ->join('users', 'users.user_id = admin.user_id')
            ->where('admin.user_id', $userId)
            ->first();

        if (!$admin) {
            return redirect()->to('/login'); // fallback kung walang staff found
        }

        return view('admin/Profile', ['admin' => $admin]);
    }

    public function updateProfile()
{
    $adminId = $this->request->getPost('staff_id'); // match the form field

    if (!$adminId) {
        return redirect()->back()->with('error', 'Invalid Admin ID.');
    }

    // Collect form inputs
    $updatedData = [
        'first_name'      => $this->request->getPost('first_name'),
        'last_name'       => $this->request->getPost('last_name'),
        'contact_number'  => $this->request->getPost('contact_number'),
        'email'           => $this->request->getPost('email'),
        'address'         => $this->request->getPost('address'),
    ];

    $adminModel = new \App\Models\AdminModel(); // Make sure the model is correctly namespaced

    if ($adminModel->update($adminId, $updatedData)) {
        return redirect()->to(base_url('admin/Profile'))->with('success', 'Profile updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to update profile.');
    }
}
public function changePassword()
{
    $adminId = session()->get('admin_id');
    $adminModel = new \App\Models\AdminModel();
    $userModel = new \App\Models\UserModel();

    // Get admin record
    $admin = $adminModel->find($adminId);

    if (!$admin) {
        return redirect()->back()->with('error', 'Admin not found.');
    }

    // Get associated user account
    $user = $userModel->find($admin['user_id']);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    // Get input values
    $oldPassword = $this->request->getPost('old_password');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    // Verify old password
    if (!password_verify($oldPassword, $user['password'])) {
        return redirect()->back()->with('error', 'The old password is incorrect.');
    }

    // Check if new passwords match
    if ($newPassword !== $confirmPassword) {
        return redirect()->back()->with('error', 'The new password and confirmation do not match.');
    }

    // Hash and update password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $userModel->update($admin['user_id'], ['password' => $hashedPassword]);

    return redirect()->back()->with('success', 'Password successfully updated.');
}
 
 public function fetchAllBill()
{
    $billingModel = new \App\Models\BillingModel();
    $patientModel = new \App\Models\PatientModel();
    $medicineModel = new \App\Models\MedicineModel(); // Add this

    $data['listofbill'] = $billingModel->getBillingWithPatients();
    $data['patients'] = $patientModel->getPatientWithUsers();      // Patients for the dropdown
    $data['medicines'] = $medicineModel->findAll();                // Medicines for the dropdown

    // Admin info
    $session = session();
    $adminData = [
        'first_name' => $session->get('first_name'),
        'last_name'  => $session->get('last_name'),
        'role'       => $session->get('role'),
    ];
    $data['admin'] = $adminData;

    return view('admin/Bill', $data);
}


public function dispenseMedicine()
{
    $request = service('request');
    $patientId = $request->getPost('patient_id');
    $medicines = $request->getPost('medicines');
    $notes = $request->getPost('notes');

    // Basic validation
    if (!$patientId || !$medicines || !is_array($medicines) || count($medicines) === 0) {
        return redirect()->back()->with('error', 'Invalid input data.');
    }

    $medicineModel = new \App\Models\MedicineModel();
    $billingModel = new \App\Models\BillingModel();
    $dispenseModel = new \App\Models\DispenseModel();

    $db = \Config\Database::connect();
    $db->transStart();

    $totalAmount = 0;

    foreach ($medicines as $item) {
        $medicineId = isset($item['medicine_id']) ? $item['medicine_id'] : null;
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;

        if (!$medicineId || $quantity <= 0) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Invalid medicine data.');
        }

        $medicine = $medicineModel->find($medicineId);

        if (!$medicine) {
            $db->transRollback();
            return redirect()->back()->with('error', "Medicine not found.");
        }

        if ($medicine['quantity'] < $quantity) {
            $db->transRollback();
            return redirect()->back()->with('error', "Not enough stock for {$medicine['medicine_name']}.");
        }

        $subtotal = $medicine['price'] * $quantity;
        $totalAmount += $subtotal;

        // Insert into dispense table
        $dispenseModel->insert([
            'patient_id'    => $patientId,
            'medicine_id'   => $medicineId,
            'quantity'      => $quantity,
            'price'         => $medicine['price'],
            'total'         => $subtotal,
            'dispense_date' => date('Y-m-d H:i:s'),
        ]);

        // Update stock quantity
        $medicineModel->update($medicineId, [
            'quantity' => $medicine['quantity'] - $quantity,
        ]);
    }

    // Insert billing record with default payment_status = 'Unpaid'
    $billingModel->insert([
        'patient_id'     => $patientId,
        'amount'         => $totalAmount,
        'payment_status' => 'Unpaid',
        'payment_date'   => null,
        'notes'          => $notes,
    ]);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Failed to process the invoice.');
    }

    return redirect()->to('admin/Bill')->with('success', 'Invoice created successfully.');
}
public function markAsPaid($billing_id)
{
    $billingModel = new \App\Models\BillingModel();

    $data = [
        'payment_status' => 'Paid',
        'payment_date' => date('Y-m-d H:i:s'),  // Mark current datetime as payment date
    ];

    if ($billingModel->update($billing_id, $data)) {
        return redirect()->back()->with('success', 'Bill marked as Paid.');
    }

    return redirect()->back()->with('error', 'Failed to update the bill status.');
}

public function markAsUnpaid($billing_id)
{
    $billingModel = new \App\Models\BillingModel();

    $data = [
        'payment_status' => 'Unpaid',
        'payment_date' => null,  // Clear payment date
    ];

    if ($billingModel->update($billing_id, $data)) {
        return redirect()->back()->with('success', 'Bill marked as Unpaid.');
    }

    return redirect()->back()->with('error', 'Failed to update the bill status.');
}


public function billingPdf($billingId)
{
    $billingModel = new \App\Models\BillingModel();
    $patientModel = new \App\Models\PatientModel();

    $bill = $billingModel->find($billingId);
    if (!$bill) {
        return redirect()->back()->with('error', 'Billing record not found.');
    }

    $patient = $patientModel->find($bill['patient_id']);

    // ✅ Get base64-encoded image
    $imagePath = FCPATH . 'img/imglogo.png'; // absolute path to image
    if (file_exists($imagePath)) {
        $type = pathinfo($imagePath, PATHINFO_EXTENSION);
        $data = file_get_contents($imagePath);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    } else {
        $logo = ''; // fallback if image not found
    }

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml(view('admin/billing_pdf_template', [
        'bill' => $bill,
        'patient' => $patient,
        'logo' => $logo
    ]));

    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("billing_invoice_{$billingId}.pdf", ["Attachment" => false]);
}


}
    