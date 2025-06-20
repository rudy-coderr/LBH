<?= $this->extend("layouts/staff/base"); ?>
<?= $this->section("content"); ?>

<div class="main-content" id="main-content">
    <div class="top-navbar">
        <h4 class="page-title">Registered Patient</h4>

            <!-- Display User details -->
        <?php
            $session = session();
            $firstName = esc($session->get('first_name') ?? 'Unknown');
            $lastName  = esc($session->get('last_name') ?? '');
            $role      = esc($session->get('role') ?? 'Staff');

            // Get initials (e.g., Sarah Johnson → SJ)
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
            ?>

            <div class="user-profile">
                <div class="user-info">
                    <p class="user-name"><?= $firstName . ' ' . $lastName ?></p>
                    <p class="user-role"><?= $role ?></p>
                </div>
                <div class="user-image"><?= $initials ?></div>
            </div>

    </div>
            <!-- Alert Message -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

    <!-- Filters and Actions -->
    <div class="patient-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="sort-container">
                <label for="sortDisplay" class="me-2">Show:</label>
                <select id="sortDisplay" class="form-select">
                    <option value="10">10</option>
                    <option value="25">15</option>
                    <option value="50">20</option>
                    <option value="100">30</option>
                </select>
            </div>

            <div class="search-container d-flex align-items-center">
                <form action="<?= site_url('staff/searchPatient') ?>" method="GET" class="d-flex w-100">
                <input type="text" name="search" class="form-control flex-grow-1 me-2" placeholder="Search by Username or Name" value="<?= esc($searchTerm ?? '') ?>" required>
                    <button type="submit" class="btn btn-primary" >Search</button>
                </form>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    <i class="fas fa-plus"></i> Register Patient
                </button>

            </div>
        </div>

        <!-- Patient Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listofpatients as $patients): ?>
                    <tr>
                    <td><?= esc($patients['patient_id']) ?></td>
                    <td><?= esc($patients['full_name']) ?></td> 
                    <td><?= esc($patients['age']) ?></td>
                    <td><?= esc($patients['contact_number']) ?></td>
                    <td><?= esc($patients['address']) ?></td>
                    <td>
                            <div class="btn-group gap-2" role="group">
                            <a href="<?= base_url('staff/PatientRecords/' . $patients['patient_id']); ?>"
                                class="btn btn-outline-primary btn-sm" title="View Records">
                                <i class="fas fa-eye"></i>
                            </a>

                                <a href="#" class="btn btn-outline-warning btn-sm" onclick='openUpdatePatient(<?= json_encode($patients) ?>)' title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-success btn-sm add-appointment-btn"
                                    title="Add Appointment"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addAppointmentModal"
                                    data-id="<?= $patients['patient_id']; ?>"
                                    data-name="<?= $patients['full_name']; ?>">
                                    <i class="fas fa-calendar-plus"></i>
                                </button>


                            </div>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Patient list pagination" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!--  Register Patient Modal -->
<div class="modal fade" id="addPatientModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Register New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('staff/patients/insertPatient') ?>" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Patient Name</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Enter patient Fullname" required>
                        </div>
                        <div class="col-md-6">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" id="age" name="age" class="form-control" placeholder="Enter age" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Phone Number</label>
                            <input type="tel" id="contact_number" name="contact_number" class="form-control" placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Enter address" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="" selected disabled>Select Role</option>
                                <option value="patient">Patient</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
                        </div>
                    </div>                                     
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>  
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-times me-2"></i>Add Patient Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('staff/addAppointment') ?>" method="post">
                <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="full_name" class="form-label">Patient Name</label>
                        <input type="text" id="patientName" class="form-control" name="full_name" readonly>
                        </div>
                        <div class="col-md-6">
                        <label for="appointment_type" class="form-label">Appointment Type</label>
                    <select id="appointment_type" name="appointment_type" class="form-select" required>
                        <option value="" selected disabled>Select Appointment Type</option>
                        <option value="Prenatal Checkup">Prenatal Checkup</option>
                        <option value="Postnatal Checkup">Postnatal Checkup</option>
                        <option value="In Labor">In Labor</option>
                        <option value="Follow-Up">Follow-Up</option>
                    </select>
                        </div>
                    </div>
                   
                    <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="appointment_date" class="form-label">Appointment Schedule</label>
                        <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                        <label for="notes" class="form-label">Reason</label>
                        <input type="text" class="form-control" id="notes" name="notes" rows="3" required></input>
                    </select>
                        </div>
                    </div>
                
             
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Appointment</button>
                </div>
            </form>
          </div>
            
        </div>
    </div>
</div>

<!-- Update Patient -->
<div class="modal fade" id="updatePatientModal" tabindex="-1" aria-labelledby="updatePatientModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePatientModalLabel"><i class="fas fa-edit me-2"></i>Update Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('staff/updatePatient') ?>" method="POST">
                    <input type="hidden" id="update_patient_id" name="patient_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_full_name" class="form-label">Full Name</label>
                            <input type="text" id="update_full_name" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="update_age" class="form-label">Age</label>
                            <input type="number" id="update_age" name="age" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_contact_number" class="form-label">Contact Number</label>
                            <input type="text" id="update_contact_number" name="contact_number" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="update_address" class="form-label">Address</label>
                            <input type="text" id="update_address" name="address" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
<?= $this->extend("layouts/staff/base"); ?>