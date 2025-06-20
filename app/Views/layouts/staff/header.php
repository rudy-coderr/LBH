<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letty's Birthing Home </title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/font/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">

  
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand-logo">Letty's Birthing Home</div>
            <div class="brand-icon"><i class="fas fa-baby"></i></div>
        </div>
        <button class="toggle-sidebar" id="toggle-sidebar">
            <i class="fas fa-chevron-left" id="sidebar-icon"></i>
        </button>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="patient.html">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Patients</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Appointment.html">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="nav-text">Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-pills"></i>
                    <span class="nav-text">Medication</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-line"></i>
                    <span class="nav-text">Reports</span>
                </a>
            </li>
            <li class="nav-item mt-5">
                <a class="nav-link" href="#">
                    <i class="fas fa-cog"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
