<?= $this->extend("layouts/staff/base"); ?>

<?= $this->section("content"); ?>

<!-- Main Content -->
<div class="main-content" id="main-content">
    <!-- Top Navbar -->
    <div class="top-navbar">
        <h4 class="page-title">Staff Dashboard</h4>

        <!-- Search Bar -->
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
            </div>

            <!-- User Profile -->
            <?php
            $firstName = esc($first_name ?? 'Unknown');
            $lastName  = esc($last_name ?? '');
            $role      = esc($role ?? 'Staff');
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

    <!-- Dashboard Stats -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon bg-primary-light">
                    <i class="fas fa-user-plus"></i>
                </div>
                <p class="stat-card-title">Registered Patients</p>
                <h3 class="stat-card-value"><?= esc($totalPatients) ?></h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon bg-secondary-light">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <p class="stat-card-title">Today's Appointments</p>
                <h3 class="stat-card-value"><?= isset($todaysAppointments) ? esc($todaysAppointments) : '0'; ?></h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon bg-warning-light">
                    <i class="fas fa-baby"></i>
                </div>
                <p class="stat-card-title">Due This Week</p>
                <h3 class="stat-card-value"><?= esc($dueThisWeek) ?></h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="card-icon bg-danger-light">
                    <i class="fas fa-clock"></i> 
                </div>
                <p class="stat-card-title">Pending Appointments</p>
                <h3 class="stat-card-value"><?= esc($pendingAppointments) ?></h3>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
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
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    

<?= $this->endSection(); ?>