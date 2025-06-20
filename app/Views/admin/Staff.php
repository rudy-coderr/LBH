<?= $this->extend("layouts/admin/base"); ?>
<?= $this->section("content"); ?>

<div class="main-content" id="main-content">
    <div class="top-navbar">
        <h4 class="page-title">All Staff</h4>

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
           
            <div class="search-container d-flex align-items-center">
                <form action="<?= site_url('admin/searchStaff') ?>" method="GET" class="d-flex w-100">
                <input type="text" name="search" class="form-control flex-grow-1 me-2" placeholder="Search by Username or Name" value="<?= esc($searchTerm ?? '') ?>" required>
                    <button type="submit" class="btn btn-primary" >Search</button>
                </form>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                    <i class="fas fa-plus"></i> Add Staff
                </button>

            </div>
        </div>

       <!-- Staff Table -->
<!-- Staff Table -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Date Hired</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listofstaff as $staff): ?>
                <tr>
                    <td><?= esc($staff['staff_id']) ?></td>
                    <td><?= esc($staff['first_name']) ?></td> 
                    <td><?= esc($staff['last_name']) ?></td>
                    <td><?= esc($staff['position']) ?></td>
                    <td><?= esc($staff['contact_number']) ?></td>
                    <td><?= esc($staff['email']) ?></td>
                    <td><?= esc($staff['address']) ?></td>
                    <td><?= esc($staff['date_hired']) ?></td>
                    <td><?= esc($staff['username']) ?></td>
                    <td><?= esc($staff['role']) ?></td>
                    <td>
                        <div class="btn-group gap-2" role="group">
                            <a href="#" class="btn btn-outline-warning btn-sm" onclick='openUpdateModal(<?= json_encode($staff) ?>)' title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="<?= site_url('admin/deleteStaff/' . esc($staff['staff_id'])) ?>" 
                               onclick="return confirm('Are you sure?')" 
                               class="btn btn-outline-danger btn-sm" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
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

<!--  Add Patient Modal -->
<div class="modal fade" id="addStaffModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Add New Staff
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="<?= base_url('admin/insertStaff') ?>" method="post">
                    <!-- Personal Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for ="first_name"class="form-label">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter full name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter full name" required>
                        </div>
                        
                    </div>

                    <!-- Contact and Position -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Phone Number</label>
                            <input type="tel" id="contact_number" name="contact_number" class="form-control" placeholder="Enter phone number">
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter username">
                        </div>
                    </div>
                    
                    <!-- Role Selection -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="" selected disabled>Select Role</option>
                                <option value="staff">Staff</option>
                                <option value="staff">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <select id="position" name="position" class="form-select">
                                <option value="" selected disabled>Select Position</option>
                                <option value="midwife">Midwife</option>
                                <option value="nurse">Nurse</option>
                                <option value="doctor">Doctor</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Employment Details -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date_hired" class="form-label">Date Hired</label>
                            <input type="date" id="date_hired" name="date_hired" class="form-control">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Enter address">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email"name="email" class="form-control" placeholder="Enter email address" required>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update  -->
<div class="modal fade" id="updateStaffModal" tabindex="-1" aria-labelledby="updateStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStaffModalLabel"><i class="fas fa-edit me-2"></i>Update Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('admin/updateStaff') ?>" method="POST">
                    <input type="hidden" id="update_staff_id" name="staff_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_first_name" class="form-label">First Name</label>
                            <input type="text" id="update_first_name" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="update_last_name" class="form-label">Last Name</label>
                            <input type="text" id="update_last_name" name="last_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_contact_number" class="form-label">Contact Number</label>
                            <input type="text" id="update_contact_number" name="contact_number" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="update_username" class="form-label">Username</label>
                            <input type="text" id="update_username" name="username" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_role" class="form-label">Role</label>
                            <select name="role" id="update_role" class="form-select">
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="update_position" class="form-label">Position</label>
                            <select id="update_position" name="position" class="form-select">
                                <option value="midwife">Midwife</option>
                                <option value="nurse">Nurse</option>
                                <option value="doctor">Doctor</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_date_hired" class="form-label">Date Hired</label>
                            <input type="date" id="update_date_hired" name="date_hired" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="update_email" class="form-label">Email</label>
                            <input type="email" id="update_email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="update_address" class="form-label">Address</label>
                            <input type="text" id="update_address" name="address" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>
<?= $this->extend("layouts/admin/base"); ?>