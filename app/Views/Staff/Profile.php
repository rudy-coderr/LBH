<?= $this->extend("layouts/staff/base"); ?>
<?= $this->section("content"); ?>

<?php
    $firstName = esc($staff['first_name']);
    $lastName  = esc($staff['last_name']);
    $role      = esc($staff['role']);
    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
?>

<div class="main-content" id="main-content">
    <div class="top-navbar">
        <h4 class="page-title">Staff Profile</h4>

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

    <div class="profile-container">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="profile-cover"></div>
            <div class="profile-avatar-container">
                <div class="profile-avatar"><?= $initials ?></div>
                <h3 class="profile-name"><?= $firstName . ' ' . $lastName ?></h3>
                <p class="profile-position"><?= ucfirst($role) ?></p>
                <span class="profile-status">
                    <i class="fas fa-circle me-1" style="font-size: 10px;"></i> Active
                </span>
            </div>

            <div class="profile-contact">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div class="contact-label">Phone</div>
                        <div class="contact-value"><?= esc($staff['contact_number']) ?></div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-value"><?= esc($staff['email']) ?></div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="contact-label">Address</div>
                        <div class="contact-value"><?= esc($staff['address']) ?></div>
                    </div>
                </div>
            </div>

            <div class="profile-action-buttons">
                <button type="button" class="btn-profile-action btn-edit-profile" onclick='openUpdateProfileModal()'>
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </button>

                <a href="#" class="btn-profile-action btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-lock me-2"></i>Change Password
                </a>

            </div>
        </div>

        <!-- Main Profile -->
        <div class="profile-main">
            <div class="profile-section">
                <h5 class="section-title">
                    <i class="fas fa-user-circle section-icon"></i>
                    Personal Information
                </h5>
                <div class="profile-info-grid">
                    <div class="info-card">
                        <div class="info-label">First Name</div>
                        <div class="info-value"><?= esc($staff['first_name']) ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Last Name</div>
                        <div class="info-value"><?= esc($staff['last_name']) ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Position</div>
                        <div class="info-value"><?= esc($staff['position']) ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Contact Number</div>
                        <div class="info-value"><?= esc($staff['contact_number']) ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?= esc($staff['email']) ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Address</div>
                        <div class="info-value"><?= esc($staff['address']) ?></div>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <h5 class="section-title">
                    <i class="fas fa-briefcase section-icon"></i>
                    Employment Information
                </h5>
                <div class="profile-info-grid">
                    <div class="info-card">
                        <div class="info-label">Date Hired</div>
                        <div class="info-value"><?= esc(date('F d, Y', strtotime($staff['date_hired']))) ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Username</div>
                        <div class="info-value"><?= esc($staff['username']) ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Role</div>
                        <div class="info-value"><?= esc($staff['role']) ?></div>
                    </div>
                    <?php if (!empty($staff['employee_id'])): ?>
                    <div class="info-card">
                        <div class="info-label">Employee ID</div>
                        <div class="info-value"><?= esc($staff['employee_id']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateStaffModal" tabindex="-1" aria-labelledby="updateStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStaffModalLabel"><i class="fas fa-edit me-2"></i>Update Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('staff/updateProfile') ?>" method="POST">
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
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel"><i class="fas fa-lock me-2"></i>Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('staff/changePassword') ?>" method="POST">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Old Password</label>
                        <input type="password" id="old_password" name="old_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   
// Update Profile Modal
function openUpdateProfileModal() {
    // Set form fields with staff data (using PHP)
    document.getElementById('update_staff_id').value = '<?= esc($staff['staff_id']) ?>';
    document.getElementById('update_first_name').value = '<?= esc($staff['first_name']) ?>';
    document.getElementById('update_last_name').value = '<?= esc($staff['last_name']) ?>';
    document.getElementById('update_contact_number').value = '<?= esc($staff['contact_number']) ?>';
    document.getElementById('update_email').value = '<?= esc($staff['email']) ?>';
    document.getElementById('update_address').value = '<?= esc($staff['address']) ?>';

    // Open the modal
    var myModal = new bootstrap.Modal(document.getElementById('updateStaffModal'));
    myModal.show();
}


</script>
<?= $this->endSection(); ?>
