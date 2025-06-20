<?= $this->extend("layouts/admin/base"); ?>
<?= $this->section("content");?>

<div class="main-content" id="main-content">
<div class="top-navbar">
            <h4 class="page-title">Admin Dashboard</h4>

            <!-- New Search Bar -->
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search here">
            </div>

            <!-- User Profile with Notification Icon -->
            <div class="user-actions">
                <!-- Notification Bell -->
                <div class="notification-bell" id="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">4</span>

                    <!-- Notification Dropdown (Hidden by Default) -->

                </div>
 <!-- User Profile -->
 <?php
            $firstName = esc($first_name ?? 'Unknown');
            $lastName  = esc($last_name ?? '');
            $role      = esc($role ?? 'Admin');
            $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
            ?>

            <div class="user-profile">
                <div class="user-info">
                    <p class="user-name"><?= $firstName . ' ' . $lastName ?></p>
                    <p class="user-role"><?= $role ?></p>
                </div>
                <div class="user-image"><?= $initials ?></div>
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="dashboard-card">
                    <div class="card-icon bg-primary-light">
                        <i class="fas fa-users"></i>
                    </div>
                    <p class="stat-card-title">Total Staff</p>
                    <h3 class="stat-card-value"><?= esc($totalStaff) ?></h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="dashboard-card">
                    <div class="card-icon bg-primary-light">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <p class="stat-card-title">Total Patients</p>
                    <h3 class="stat-card-value"><?= esc($totalPatient) ?></h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="dashboard-card">
                    <div class="card-icon bg-primary-light">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <p class="stat-card-title">Monthly Appointments</p>
                   <h3 class="stat-card-value"><?= esc($monthlyAppointments) ?></h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="dashboard-card">
                    <div class="card-icon bg-danger-light">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <p class="stat-card-title">Pending Actions</p>
                    <h3 class="stat-card-value">7</h3>
                </div>
            </div>
        </div>
   <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-calendar-alt mr-2"></i> Appointments Calendar
                    </div>

                </div>
                
                <!-- Calendar Filters -->
                <div class="calendar-filters mb-3">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="form-check mr-4 mb-2">
                            <input class="form-check-input" type="checkbox" id="filterPrenatal" checked>
                            <label class="form-check-label" for="filterPrenatal">
                                <span class="status-badge status-prenatal">Prenatal</span>
                            </label>
                        </div>
                        <div class="form-check mr-4 mb-2">
                            <input class="form-check-input" type="checkbox" id="filterLabor" checked>
                            <label class="form-check-label" for="filterLabor">
                                <span class="status-badge status-labor">Labor</span>
                            </label>
                        </div>
                        <div class="form-check mr-4 mb-2">
                            <input class="form-check-input" type="checkbox" id="filterPostpartum" checked>
                            <label class="form-check-label" for="filterPostpartum">
                                <span class="status-badge status-postpartum">Postpartum</span>
                            </label>
                        </div>
                        <div class="form-check mr-4 mb-2">
                            <input class="form-check-input" type="checkbox" id="filterCheckup" checked>
                            <label class="form-check-label" for="filterCheckup">
                                <span class="status-badge" style="background: #e8f5e9; color: #4caf50;">Checkup</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Calendar Container -->
                <div class="calendar-container">
                    <div id="calendarr"></div>
                </div>
            </div>
        </div>
    </div>
   

<?= $this->endSection();?> 
