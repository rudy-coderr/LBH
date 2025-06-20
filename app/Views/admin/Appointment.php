<?= $this->extend("layouts/admin/base"); ?>
<?= $this->section("content");?>

<div class="main-content" id="main-content">
        <div class="top-navbar">
            <h4 class="page-title">Appointment Approved List</h4>
            
             <!-- Display User details -->
            <?php
                $session = session();
                $firstName = esc($session->get('first_name') ?? 'Unknown');
                $lastName  = esc($session->get('last_name') ?? '');
                $role      = esc($session->get('role') ?? 'Admin');

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

   

    <?= $this->endSection();?> 
   <?= $this->extend("layouts/admin/base"); ?>