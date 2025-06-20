<?= $this->extend("layouts/staff/base"); ?>
<?= $this->section("content"); ?>

<div class="main-content" id="main-content">
    <div class="top-navbar">
        <h4 class="page-title">Patient Records</h4>

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

            <div class="action-buttons">
                <a href="<?= base_url('staff/Patient'); ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

        </div>
             <!-- Prenatal Records Section -->
             <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Prenatal Records</h5>
                    
            </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Consulted By</th>
                        <th>Date Visit</th>
                        <th>Gestational Age</th>
                        <th>Blood Pressure</th>
                        <th>Weight</th>
                        <th>Remarks</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($prenatal_records)): ?>
                        <?php foreach ($prenatal_records as $record): ?>
                            <tr>
                                <td><?= esc($record['patient_name']) ?></td>
                                <td><?= esc($record['staff_first_name']) . ' ' . esc($record['staff_last_name']) ?></td>
                                <td><?= esc(date('M d, Y h:i A', strtotime($record['visit_date']))) ?></td>
                                <td><?= esc($record['gestational_age']) ?></td>
                                <td><?= esc($record['blood_pressure']) ?></td>
                                <td><?= esc($record['weight']) ?></td>
                                <td><?= esc($record['remarks']) ?></td>
                               
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No records found for this patient</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
      <!-- Delivery Records Section -->
      <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Delivery Records</h5>
                   
            </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Consulted By</th>
                        <th>Delivery Date</th>
                        <th>Delivery Type</th>
                        <th>Complications</th>
                        <th>Baby Weight</th>
                        <th>Baby Sex</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($delivery_records)): ?>
                        <?php foreach ($delivery_records as $deliveryRecords): ?>
                            <tr>
                                <td><?= esc($deliveryRecords['patient_name']) ?></td>
                                <td><?= esc($deliveryRecords['staff_first_name']) . ' ' . esc($deliveryRecords['staff_last_name']) ?></td>
                                <td><?= esc(date('M d, Y h:i A', strtotime($deliveryRecords['delivery_date']))) ?></td>
                                <td><?= esc($deliveryRecords['delivery_type']) ?></td>
                                <td><?= esc($deliveryRecords['complications']) ?></td>
                                <td><?= esc($deliveryRecords['baby_weight']) ?></td>
                                <td><?= esc($deliveryRecords['baby_sex']) ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No records found for this patient</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>

    
    <!-- Postnatal Records Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Postnatal Records</h5>
                  
            </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Consulted By</th>
                        <th>Visit Date</th>
                        <th>Baby Weight</th>
                        <th>Breast Feeding Status</th>
                        <th>Mental Health Check</th>
                        <th>Remarks</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($postnatal_records)): ?>
                        <?php foreach ($postnatal_records as $postnatalRecords): ?>
                            <tr>
                                <td><?= esc($postnatalRecords['patient_name']) ?></td>
                                <td><?= esc($postnatalRecords['staff_first_name']) . ' ' . esc($postnatalRecords['staff_last_name']) ?></td>
                                <td><?= esc(date('M d, Y h:i A', strtotime($postnatalRecords['visit_date']))) ?></td>
                                <td><?= esc($postnatalRecords['baby_weight']) ?></td>
                                <td><?= esc($postnatalRecords['breastfeeding_status']) ?></td>
                                <td><?= esc($postnatalRecords['mental_health_check']) ?></td>
                                <td><?= esc($postnatalRecords['remarks']) ?></td>
                               
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No records found for this patient</td>
                        </tr>
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

<?= $this->endSection(); ?>
<?= $this->extend("layouts/staff/base"); ?>