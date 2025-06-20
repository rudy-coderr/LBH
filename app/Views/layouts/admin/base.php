<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letty's Birthing Home </title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/font/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="icon" type="image/png" href="<?= base_url('img/imglogo.png'); ?>">
    <!-- FullCalendar CSS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
 <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">


</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
    
    <div class="brand-icon" style="display: flex; justify-content: center; align-items: center;">
        <img src="<?= base_url('img/imglogo.png') ?>" alt="Logo" style="width: 50px; height: 50px;">
    </div>
    <div class="brand-logo">Letty's Birthing Home</div>
</div>
        <button class="toggle-sidebar" id="toggle-sidebar">
            <i class="fas fa-chevron-left" id="sidebar-icon"></i>
        </button>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>"
                    href="<?= base_url('admin/dashboard') ?>">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() == 'admin/Patient') ? 'active' : '' ?>"
                    href="<?= base_url('admin/Patient') ?>">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Patients</span>
                </a>
            </li>

           <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'admin/Appointment') ? 'active' : '' ?>"
                    href="<?= base_url('admin/Appointment') ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="nav-text">Appointment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() == 'admin/Staff') ? 'active' : '' ?>"
                    href="<?= base_url('admin/Staff') ?>">
                    <i class="fas fa-user-tie"></i>
                    <span class="nav-text">Staff</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() == 'admin/Medication') ? 'active' : '' ?>"
                    href="<?= base_url('admin/Medication') ?>">
                    <i class="fas fa-pills"></i>
                    <span class="nav-text">Medication</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() == 'admin/Bill') ? 'active' : '' ?>"
                    href="<?= base_url('admin/Bill') ?>">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span class="nav-text">Bill</span>
                </a>
            </li>
          
            <li class="nav-item mt-5">
                <a class="nav-link" href="#settingsSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="settingsSubmenu">
                    <i class="fas fa-cog"></i>
                    <span class="nav-text">Settings</span>
                </a>
                <div class="collapse" id="settingsSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?= (uri_string() == 'admin/Profile') ? 'active' : '' ?>" href="<?= base_url('admin/Profile') ?>">
                            <i class="fas fa-user"></i>
                            <span class="nav-text">Profile</span>
                        </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/logout'); ?>" onclick="return confirm('Are you sure you want to logout?');">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="nav-text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>

    <?= $this->renderSection("content"); ?>

    <script src="<?= base_url(); ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/script.js"></script>
    <script src="<?= base_url(); ?>/assets/js/js.js"></script>
</body>

</html>