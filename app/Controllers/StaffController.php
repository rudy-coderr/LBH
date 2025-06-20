<?php

namespace App\Controllers;
use App\Models\StaffModel;
use App\Models\MedicineModel;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\AppointmentModel;
use App\Models\ConsultationModel;
use App\Models\PrenatalModel;
use App\Models\DeliveryModel;
use App\Models\PostnatalModel;
use \DateTime;

class StaffController extends BaseController
{
    

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        // Get session data
        $data = [
            'first_name' => session()->get('first_name'),
            'last_name'  => session()->get('last_name'),
            'role'       => session()->get('role')
        ];
    
        // Count all patients
        $patientModel = new PatientModel();
        $data['totalPatients'] = $patientModel->countAll();
    
        // Initialize Appointment Model
        $appointmentModel = new AppointmentModel();
    
        // Count Today's Appointments (only approved)
        $today = date('Y-m-d');
        $data['todaysAppointments'] = $appointmentModel
            ->where("DATE(appointment_date)", $today)
            ->where("status", "Approved")
            ->countAllResults();
    
        // Get the start and end date of this week (from Sunday to Saturday)
        $startOfWeek = date('Y-m-d', strtotime('last sunday', strtotime('tomorrow')));
        $endOfWeek = date('Y-m-d', strtotime('next saturday'));
    
        // Count Appointments Due This Week (only approved)
        $data['dueThisWeek'] = $appointmentModel
            ->where("DATE(appointment_date) >=", $startOfWeek)
            ->where("DATE(appointment_date) <=", $endOfWeek)
            ->where("status", "Approved")
            ->countAllResults();
    
        // Count Pending Appointments
        $data['pendingAppointments'] = $appointmentModel
            ->where("status", "Pending")
            ->countAllResults();
    
        // Pass all data to the view
        return view('staff/dashboard', $data);
    }
    
    // Profile
    public function profileView()
    {
        $session = session();
        $userId = $session->get('user_id'); // dapat naka-save ito sa session pag login

        $staffModel = new StaffModel();
        $staff = $staffModel
            ->select('staff.*, users.username, users.role')
            ->join('users', 'users.user_id = staff.user_id')
            ->where('staff.user_id', $userId)
            ->first();

        if (!$staff) {
            return redirect()->to('/login'); // fallback kung walang staff found
        }

        return view('staff/Profile', ['staff' => $staff]);
    }
    public function updateProfile()
    {
        $staffId = $this->request->getPost('staff_id');
        
        // Check if staffId exists
        if (!$staffId) {
            return redirect()->back()->with('error', 'Invalid Staff ID.');
        }
    
        // Prepare the updated data
        $updatedData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'contact_number' => $this->request->getPost('contact_number'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ];
    
        $staffModel = new StaffModel();
    
        // Update the staff data
        if ($staffModel->update($staffId, $updatedData)) {
            return redirect()->to('staff/Profile')->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile.');
        }
    }
    
   
public function changePassword()
{
    $staffId = session()->get('staff_id');
    $staffModel = new \App\Models\StaffModel();
    $userModel = new \App\Models\UserModel();

    // Fetch staff data
    $staff = $staffModel->find($staffId);

    if (!$staff) {
        return redirect()->back()->with('error', 'Staff not found.');
    }

    // Fetch user data (which contains the hashed password)
    $user = $userModel->find($staff['user_id']); // assuming 'user_id' is the FK in staff

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

    // Confirm new password match
    if ($newPassword !== $confirmPassword) {
        return redirect()->back()->with('error', 'The new password and confirmation do not match.');
    }

    // Hash and update new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $userModel->update($staff['user_id'], ['password' => $hashedPassword]);

    return redirect()->back()->with('success', 'Password successfully updated.');
}



    
    // display in the headear
    public function getStaffDetails()
    {
        $session = session();
        $staffId = $session->get('staff_id');
    
        if (!$staffId) {
            return redirect()->to('/login');
        }
    
        $staffModel = new StaffModel();
        $staff = $staffModel->find($staffId);
    
        $data = [
            'first_name' => $staff['first_name'] ?? 'Unknown',
            'last_name'  => $staff['last_name'] ?? '',
            'role'       => $staff['role'] ?? 'Staff'
        ];
    
        return view('staff/dashboard', $data);
    }
    
    
    public function appointment(){
        $data =[ ];
        return view ("staff/Appointment", $data);           
    }
    public function pending(){
        $data =[  ];
        return view ("staff/PendingAppointment", $data);    
        
    } 
    


    // Medicine
    public function AllMedicines(): string{  
        //Fetching All products
       $medicinemodel= new MedicineModel();
       $data['listofmedicines'] = $medicinemodel->findAll();
    
       return view('staff/Medication', $data);
    
    //    echo '<pre>';
    //    print_r($data);
    //    echo'</pre>';
    //    exit;
    }

    // Patient
    public function fetchAllPatient(): string
    {  
        $patientModel = new PatientModel();
        $data['listofpatients'] = $patientModel->getPatientWithUsers(); // Use new method
    
        return view('staff/Patient', $data);
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
                return redirect()->to('/staff/Patient')->with('success', 'Patient registered successfully.');
            } else {
                log_message('error', 'Failed to insert staff: ' . json_encode($patientModel->errors()));
                return redirect()->back()->with('error', 'Failed to register patient.');
            }
        } else {
            log_message('error', 'Failed to insert user: ' . json_encode($userModel->errors()));
            return redirect()->back()->with('error', 'Failed to add user to the users table.');
        }
    }

    // Update
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
    
        return redirect()->to('/staff/Patient')->with('success', 'Patient updated successfully.');
    }

    // Search
    public function searchPatient()
    {
        $patientModel = new PatientModel();
        $searchTerm = $this->request->getGet('search');
    
        if (!empty($searchTerm)) {
            $patientModel->select('patients.*, users.username, users.role');
            $patientModel->join('users', 'users.user_id = patients.user_id'); // Fixed join condition
            $patientModel->groupStart()
                ->like('patients.full_name', $searchTerm) // Fixed alias
                ->orLike('users.username', $searchTerm)
                ->groupEnd();
        }
    
        $listofpatients = $patientModel->findAll();
    
        if (empty($listofpatients)) {
            session()->setFlashdata('error', "No patient found for: '$searchTerm'");
        }
    
        $data = [
            'listofpatients' => $listofpatients,
            'searchTerm' => $searchTerm,
        ];
    
        return view('staff/Patient', $data);
    }

    public function fetchPatientRecord(){
        $data =[  ];
        return view ("staff/PatientRecords", $data);    
        
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
            return redirect()->to('/staff/Patient')->with('success', 'Appointment added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to add Appointment.');
        }
    }

    public function fetchAllPendingAppointment(): string
    {
        $appointmentModel = new AppointmentModel();

        $data['listofappointment'] = $appointmentModel
            ->getAppointmentsWithPatient()
            ->where('appointments.status', 'Pending')
            ->findAll();

        return view('staff/PendingAppointment', $data);
    }

    public function approveAppointment($appointmentId)
    {
        $staffId = session()->get('staff_id');

        $appointmentModel = new AppointmentModel();
        $appointmentModel->update($appointmentId, [
            'status'   => 'Approved',
            'staff_id' => $staffId,
        ]);

        return redirect()->to('/staff/PendingAppointment')->with('success', 'Appointment approved!');
    }



        public function fetchAllApprovedAppointment(): string
        {
            $appointmentModel = new AppointmentModel();
        
            // Modify the query to include both Approved and For Follow-up appointments
            $data['listofapproveAppointment'] = $appointmentModel
                ->getAppointmentsWithPatientAndStaff()
                ->whereIn('appointments.status', ['Approved', 'For follow up'])  // Include both Approved and For Follow-up
                ->findAll();
        
            return view('staff/Appointment', $data);
        }
        
        

        // Consultation
        public function addPrenatalRecord()
        {
            $validation = \Config\Services::validation();
            $data = $this->request->getPost();
        
            // Validate required fields
            $validation->setRules([
                'patient_id'       => 'required|integer',
                'staff_id'         => 'required|integer',
                'appointment_id'   => 'required|integer',
                'gestational_age'  => 'required',
                'blood_pressure'   => 'required',
                'weight'           => 'required',
            ]);
        
            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
        
            $prenatalModel = new PrenatalModel();
            $appointmentModel = new \App\Models\AppointmentModel(); // <-- make sure meron ka nito
        
            $insertData = [
                'patient_id'      => $data['patient_id'],
                'staff_id'        => $data['staff_id'],
                'appointment_id'  => $data['appointment_id'],
                'visit_date'      => date('Y-m-d H:i:s'),
                'gestational_age' => $data['gestational_age'],
                'blood_pressure'  => $data['blood_pressure'],
                'weight'          => $data['weight'],
                'remarks'         => $data['remarks'] ?? null,
                'status'          => null
            ];
        
            if ($prenatalModel->insert($insertData)) {
                // ✅ Update appointment status to null (or 'Complete' or 'Consulted')
                $appointmentModel->update($data['appointment_id'], ['status' => null]);
        
                return redirect()->back()->with('success', 'Prenatal record added successfully.');
            }
        
            return redirect()->back()->withInput()->with('error', 'Failed to add prenatal record.');
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
            return view('staff/PatientRecords', [
                'prenatal_records' => $records,
                'delivery_records' => $deliveryRecord,
                'postnatal_records' => $postnatalRecord,
                'staffFullname'    => $staffFullname,
                'staffId'          => $staffId
            ]);
        }

        // Consultation
        public function addDeliveryRecord()
        {
            $validation = \Config\Services::validation();
        
            $data = $this->request->getPost();
        
            // Validate required fields
            $validation->setRules([
                'patient_id'       => 'required|integer',
                'staff_id'         => 'required|integer',
                'appointment_id'   => 'required|integer',
                'delivery_type'  => 'required',
                'complications'  => 'required',
                'baby_weight'     => 'required',
                'baby_sex'     => 'required',
            ]);
        
            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
        
            $deliveryModel = new DeliveryModel();
        
            $insertData = [
                'patient_id'      => $data['patient_id'],
                'staff_id'        => $data['staff_id'],
                'appointment_id'  => $data['appointment_id'],
                'delivery_date'      => date('Y-m-d H:i:s'),
                'delivery_type' => $data['delivery_type'],
                'complications' => $data['complications'],
                'baby_weight'  => $data['baby_weight'],
                'baby_sex'          => $data['baby_sex'],
                 'status'          => null
              
            ];
        
            if ($deliveryModel->insert($insertData)) {
                $appointmentModel->update($data['appointment_id'], ['status' => null]);
                return redirect()->back()->with('success', 'Delivery record added successfully.');
            }
        
            return redirect()->back()->withInput()->with('error', 'Failed to add Delivery record.');
        }

        public function addPostnatalRecord()
        {
            $validation = \Config\Services::validation();
            $data = $this->request->getPost();
        
            // Validate required fields
            $validation->setRules([
                'patient_id'            => 'required|integer',
                'staff_id'              => 'required|integer',
                'appointment_id'        => 'required|integer',
                'visit_date'            => 'required|valid_date',
                'baby_weight'           => 'required',
                'breastfeeding_status'  => 'required',
                'mental_health_check'   => 'required',
            ]);
        
            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
        
            $postnatalModel = new PostnatalModel();
            $appointmentModel = new \App\Models\AppointmentModel();
        
            $insertData = [
                'patient_id'            => $data['patient_id'],
                'staff_id'              => $data['staff_id'],
                'appointment_id'        => $data['appointment_id'],
                'visit_date'            => $data['visit_date'], // Use provided visit date
                'baby_weight'           => $data['baby_weight'],
                'breastfeeding_status'  => $data['breastfeeding_status'],
                'mental_health_check'   => $data['mental_health_check'],
                'remarks'               => $data['remarks'] ?? null,
                'status'                => null // Keep status null
            ];
        
            if ($postnatalModel->insert($insertData)) {
                $appointmentModel->update($data['appointment_id'], ['status' => null]);
                return redirect()->back()->with('success', 'Postnatal record added successfully.');
            }
        
            return redirect()->back()->withInput()->with('error', 'Failed to add postnatal record.');
        }

        public function declineAppointment($appointment_id)
{
    $appointmentModel = new \App\Models\AppointmentModel();

    // Optional: check if appointment exists first
    $appointment = $appointmentModel->find($appointment_id);

    if (!$appointment) {
        return redirect()->back()->with('error', 'Appointment not found.');
    }

    // Update status to 'Declined'
    $appointmentModel->update($appointment_id, ['status' => 'Declined']);

    return redirect()->back()->with('success', 'Appointment declined successfully.');
}

        protected $appointmentModel;

        public function __construct()
        {
            $this->appointmentModel = new AppointmentModel();
        }
        
        // Route for fetching appointments (API)
        public function appointments()
        {
            return $this->getAppointments();
        }
        
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

        
    }
        

        


