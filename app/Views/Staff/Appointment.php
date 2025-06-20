<?= $this->extend("layouts/staff/base"); ?>
<?= $this->section("content");?>

<div class="main-content" id="main-content">
        <div class="top-navbar">
            <h4 class="page-title">Appointment Approved List</h4>
            
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
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search Patients">
            </div>
        </div>
            <!-- Patient Table -->
          
                <div class="table-responsive">
                    <table class="table ">
                        <thead >
                            <tr>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Approved By</th>
                                <th>Appointment Schedule</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($listofapproveAppointment)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No pending appointments.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listofapproveAppointment as $appointments): ?>
                            <tr>
                                <td><?= $appointments['patient_id'] ?></td>
                                <td><?= $appointments['patient_name'] ?></td>
                                <td><?= $appointments['staff_first_name'] . ' ' . $appointments['staff_last_name'] ?></td>
                                <td><?= date('M d, Y h:i A', strtotime($appointments['appointment_date'])) ?></td>
                                <td><?= $appointments['notes'] ?></td>
                                <td><span class="badge bg-success"><?=$appointments['status']?></span></td>
                                <td>
                                <div class="btn-group gap-2" role="group">
                                <button 
                                    class="btn btn-outline-primary btn-sm add-consultation-btn"
                                    data-id="<?= $appointments['patient_id']; ?>"
                                    data-name="<?= $appointments['patient_name']; ?>"
                                    data-appointment="<?= $appointments['appointment_id']; ?>"
                                    data-type="<?= $appointments['appointment_type']; ?>"
                                    title="Consult"
                                >
                                    <i class="fas fa-stethoscope"></i>
                                </button>




                                   
                                </div>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                         <?php endif; ?>
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

    <!-- Consultation -->
   <!--Prenatal Consultation Modal -->
   <div class="modal fade" id="addPrenatalConsultationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-md me-2"></i> Patient Prenatal Consultation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('staff/addPrenatalRecord') ?>" method="post">
                    <?php
                        $session = session();
                        $staffId = $session->get('staff_id');
                        $staffFullname = esc($session->get('first_name')) . ' ' . esc($session->get('last_name'));
                    ?>
                    
                    <div class="row mb-3">
                                 <!-- Patient Info -->
                        <div class="col-md-6">
                            <label for="patientFullname" class="form-label">Patient Name</label>
                            <input type="text" id="patientFullname" class="form-control" name="patient_name" readonly>
                            <input type="hidden" id="patientId" name="patient_id">
                            <input type="hidden" id="appointmentId" name="appointment_id">
                        </div>

                    <!-- Staff Who Conducted -->
                        <div class="col-md-6">
                            <label class="form-label">Consulted By</label>
                            <input type="text" class="form-control" value="<?= $staffFullname ?>" readonly>
                            <input type="hidden" name="staff_id" value="<?= $staffId ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                      
                    <div class="col-md-6">
                        <label for="visit_date" class="form-label">Visit Date</label>
                        <input type="datetime-local" id="visit_date" name="visit_date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="gestational_age">Gestational Age</label>
                        <input type="text" class="form-control" name="gestational_age" required>
                    </div>
                    </div>
                   
                    <div class="row mb-3">
                        <!-- Prescription -->
                     <div class="col-md-6">
                        <label for="blood_pressure">Blood Pressure</label>
                            <input type="text" class="form-control" name="blood_pressure" required>
                        </div>

                        <div class="col-md-6">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control" name="weight" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                       
                    <div class="col-md-6">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" name="remarks" rows="3"></textarea>
                    </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Consult</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Delivery Consultation Modal -->
<div class="modal fade" id="addDeliveryConsultationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-md me-2"></i> Patient Delivery Consultation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('staff/addDeliveryRecord') ?>" method="post">
                    <?php
                        $session = session();
                        $staffId = $session->get('staff_id');
                        $staffFullname = esc($session->get('first_name')) . ' ' . esc($session->get('last_name'));
                    ?>
                    
                    <div class="row mb-3">
                                 <!-- Patient Info -->
                        <div class="col-md-6">
                            <label for="patientFullname" class="form-label">Patient Name</label>
                            <input type="text" id="patientFullname" class="form-control" name="patient_name" readonly>
                            <input type="hidden" id="patientId" name="patient_id">
                            <input type="hidden" id="appointmentId" name="appointment_id">
                        </div>

                    <!-- Staff Who Conducted -->
                        <div class="col-md-6">
                            <label class="form-label">Consulted By</label>
                            <input type="text" class="form-control" value="<?= $staffFullname ?>" readonly>
                            <input type="hidden" name="staff_id" value="<?= $staffId ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                      
                    <div class="col-md-6">
                        <label for="delivery_date" class="form-label">Delivery Date</label>
                        <input type="datetime-local" id="delivery_date" name="delivery_date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="delivery_type">Delivery Type</label>
                        <select class="form-control" name="delivery_type" id="delivery_type" required>
                            <option value="">-- Select Delivery Type --</option>
                            <option value="Normal">Normal</option>
                            <option value="Caesarean">Caesarean</option>
                            <option value="Assisted">Assisted</option>
                        </select>
                    </div>

                    </div>
                   
                    <div class="row mb-3">
                        <!-- Prescription -->
                     <div class="col-md-6">
                        <label for="complications">Complications</label>
                            <input type="text" class="form-control" name="complications" required>
                        </div>

                        <div class="col-md-6">
                            <label for="baby_weight">Baby Weight</label>
                            <input type="text" class="form-control" name="baby_weight" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                       
                    <div class="col-md-6">
                        <label for="baby_sex">Baby Sex</label>
                        <select class="form-control" name="baby_sex" id="baby_sex" required>
                            <option value="">-- Select Sex Type --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Consult</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Postnatal Consultation Modal -->
<div class="modal fade" id="addPostnatalConsultationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-md me-2"></i> Patient Postnatal Consultation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('staff/addPostnatalRecord') ?>" method="post">
                    <?php
                        $session = session();
                        $staffId = $session->get('staff_id');
                        $staffFullname = esc($session->get('first_name')) . ' ' . esc($session->get('last_name'));
                    ?>
                    
                    <div class="row mb-3">
                                 <!-- Patient Info -->
                        <div class="col-md-6">
                            <label for="patientFullname" class="form-label">Patient Name</label>
                            <input type="text" id="patientFullname" class="form-control" name="patient_name" readonly>
                            <input type="hidden" id="patientId" name="patient_id">
                            <input type="hidden" id="appointmentId" name="appointment_id">
                        </div>

                    <!-- Staff Who Conducted -->
                        <div class="col-md-6">
                            <label class="form-label">Consulted By</label>
                            <input type="text" class="form-control" value="<?= $staffFullname ?>" readonly>
                            <input type="hidden" name="staff_id" value="<?= $staffId ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                      
                    <div class="col-md-6">
                        <label for="visit_date" class="form-label">Visit Date</label>
                        <input type="datetime-local" id="visit_date" name="visit_date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                            <label for="baby_weight">Baby Weight</label>
                            <input type="text" class="form-control" name="baby_weight" required>
                        </div>
                    </div>
                   
                    <div class="row mb-3">
                        <!-- Prescription -->
                     <div class="col-md-6">
                        <label for="breastfeeding_status">Breast Feeding Status</label>
                        <select class="form-control" name="breastfeeding_status" id="breastfeeding_status" required>
                            <option value="">-- Select Breast feeding Type --</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Partially">Partially</option>
                        </select>
                        </div>

                        <div class="col-md-6">
                            <label for="mental_health_check">Mental Health Check</label>
                            <select class="form-control" name="mental_health_check" id="mental_health_check" required>
                            <option value="">-- Select Mental Health Type --</option>
                            <option value="Good">Good</option>
                            <option value="Fair">Fair</option>
                            <option value="Poor">Poor</option>
                            </select>
                        </div>

                    </div>
                    <div class="row mb-3">
                       
                    <div class="col-md-6">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" name="remarks" rows="3"></textarea>
                    </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Consult</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <?= $this->endSection();?> 
   <?= $this->extend("layouts/staff/base"); ?>