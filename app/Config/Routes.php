<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 $routes->get( '/', 'LoginController::index');
 $routes->get('/login', 'LoginController::index');
 $routes->post('/login/authenticate', 'LoginController::authenticate');
 $routes->get('/logout', 'LoginController::logout');

 
//  $routes->get('/staff/patient', 'StaffController::patient'); 
  $routes->get('/staff/patient-records', 'StaffController::records'); 
//  $routes->get('/staff/appointment-record', 'StaffController::appointment'); 
//  $routes->get('/staff/pending-appointment', 'StaffController::pending'); 
// $routes->get('/admin/dashboard', 'AdminController::index'); 
// $routes->get('/admin/patient-record', 'AdminController::patient'); 
// $routes->get('/admin/appointment-record', 'AdminController::appointment');
//$routes->get('/staff/dashboard', 'StaffController::index');
//$routes->get('/admin/dashboard', 'AdminController::index');
$routes->get('/unauthorized', function () {
    return view('unauthorized');
});

// Staff Routes
$routes->group('staff', ['filter' => 'auth:staff'], function($routes) {
    // Admin Dashboard
    $routes->get('/', 'StaffController::index'); 
    $routes->get('dashboard', 'StaffController::index');
    $routes->get('Patient', 'StaffController::fetchAllPatient');
    $routes->post('patients/insertPatient', 'StaffController::insertPatient');
    $routes->post('updatePatient', 'StaffController::updatePatient');
    $routes->get('searchPatient', 'StaffController::searchPatient');
    $routes->get('PatientRecords', 'StaffController::fetchPatientRecord' );
    $routes->post('addAppointment', 'StaffController::addAppointment');
    $routes->get('PendingAppointment', 'StaffController::fetchAllPendingAppointment');
    $routes->get('Appointment', 'StaffController::fetchAllApprovedAppointment');
    $routes->get('approveAppointment/(:num)', 'StaffController::approveAppointment/$1');
    $routes->get('Profile', 'StaffController::profileView');
    $routes->post('updateProfile', 'StaffController::updateProfile');
    $routes->post('changePassword', 'StaffController::changePassword');
    $routes->get('declineAppointment/(:num)', 'StaffController::declineAppointment/$1');


    // Medication Management  
    $routes->get('Medication', 'StaffController::AllMedicines'); 
    $routes->get('searchMedicine', 'StaffController::searchMedicine');
    $routes->post('addPrenatalRecord', 'StaffController::addPrenatalRecord');
    $routes->post('addDeliveryRecord', 'StaffController::addDeliveryRecord');
    $routes->post('addPostnatalRecord', 'StaffController::addPostnatalRecord');
    $routes->get('PatientRecords/(:num)', 'StaffController::PatientRecords/$1');
    $routes->get('appointments', 'StaffController::getAppointments');




});

//Admin Routes
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    // Admin Dashboard
    $routes->get('/', 'AdminController::index'); 
    $routes->get('dashboard', 'AdminController::index');
    // Medication Management
    
    $routes->get('Medication', 'AdminController::fetchAllMedicines'); 
    $routes->post('medicines/insertMedicine', 'AdminController::insertMedicine');
    $routes->get('medicines/deleteMedicine/(:num)', 'AdminController::deleteMedicine/$1');
    $routes->post('medicines/updateMedicine', 'AdminController::updateMedicine');
    $routes->get('searchMedicine', 'AdminController::searchMedicine');
    $routes->get('Patient', 'AdminController::fetchAllPatient');
    $routes->post('patients/insertPatient', 'AdminController::insertPatient');
    $routes->post('updatePatient', 'AdminController::updatePatient');
    $routes->post('addAppointment', 'AdminController::addAppointment');
    $routes->get('PatientRecords/(:num)', 'AdminController::PatientRecords/$1');
    $routes->get('Appointment', 'AdminController::fetchAllApprovedAppointment');
    $routes->get('Profile', 'AdminController::profileView');
    $routes->post('updateProfile', 'AdminController::updateProfile');
    $routes->post('changePassword', 'AdminController::changePassword');
    $routes->get('Bill', 'AdminController::fetchAllBill');
    $routes->post('dispenseMedicine', 'AdminController::dispenseMedicine');
    $routes->get('markAsPaid/(:num)', 'AdminController::markAsPaid/$1');
$routes->get('markAsUnpaid/(:num)', 'AdminController::markAsUnpaid/$1');
$routes->get('billing/pdf/(:num)', 'AdminController::billingPdf/$1');
 $routes->get('appointments', 'AdminController::getAppointments');





    // Staff Management
    $routes->get('Staff', 'AdminController::fetchAllStaff'); // Likely unnecessary
    $routes->post('insertStaff', 'AdminController::insertStaff');
    $routes->get('deleteStaff/(:num)', 'AdminController::deleteStaff/$1');
    $routes->post('updateStaff', 'AdminController::updateStaff');
    $routes->get('searchStaff', 'AdminController::searchStaff');
});