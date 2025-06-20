<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letty's Birthing Home - Portal Login</title>
    <!-- Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/font/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="icon" type="image/png" href="<?= base_url('img/imglogo.png'); ?>">



    <style>
        :root {
            --primary-color: #7d5ba6;
            --primary-dark: #614585;
            --secondary-color: #e3b5cd;
            --secondary-light: #f5e6ee;
            --medical-color: #4e9d76;
            --medical-dark: #3d7c5f;
            --text-color: #4a4a4a;
            --light-color: #f9f7fc;
            --dark-color: #333333;
            --success-color: #66bb6a;
        }
        
        body {
            background: linear-gradient(135deg, #f5e6ee 0%, #e9d8f4 100%);
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
        }
        .brand-logo {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
      
    }
    .brand-logo img {
    width: 60px;
    height: 60px;
    margin-bottom: 10px;
}
        
    </style>
</head>
 
<body>

    <div class="login-wrapper">
       
        <div class="login-container">
            <div class="login-sidebar">
                <div class="sidebar-background"></div>
                <div class="sidebar-content">
    <div class="brand-logo">
        <img src="<?= base_url('img/imglogo.png') ?>" alt="Logo" style="width: 60px; height: 60px; display: block; margin: 0 auto;">
        <div style="margin-top: 10px;">Letty's Birthing Home</div>
    </div>
    <h1 class="welcome-text">Welcome Back</h1>
    <p class="sidebar-text">Access our secure portal to manage appointments, patient records, and staff schedules all in one place.</p>
                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>Appointment Management</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div>Patient Records</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>Analytics Dashboard</div>
                        </div>
                    </div>
                </div>
            </div>
           

            <div class="login-form">
                <div class="login-tabs">
                    <div class="login-tab active" data-tab="admin">Administrator</div>
                    <div class="login-tab" data-tab="medical">Medical Staff</div>
                </div>
                
                <!-- Admin Login Form -->
                <div class="login-form-container active" id="admin-form">
                    <h2 class="form-title">Admin Portal</h2>
                    <p class="form-subtitle">Please sign in to continue</p>

                    <!-- Alert Message -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/login/authenticate" method="post">
                        <input type="hidden" name="role" value="Admin">
                            <div class="form-floating position-relative">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                                <label>Username</label>
                            </div>
        
                            <div class="form-floating position-relative">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                                <label>Password</label>
                            </div>
    
                        <button type="submit" class="btn btn-login btn-admin">Sign In</button>
                    </form>

                </div>
                
                <!-- Medical Staff Login Form -->
                <div class="login-form-container" id="medical-form">
                    <h2 class="form-title" style="color: var(--medical-color);">Medical Staff Portal</h2>
                    <p class="form-subtitle">Access patient records & scheduling</p>
                    
                    <form action="/login/authenticate" method="post">
    <input type="hidden" name="role" value="Staff">
    <div class="form-floating position-relative">
        <input type="text" class="form-control" name="username" placeholder="Staff Username" required>
        <label>Username</label>
    </div>
    
    <div class="form-floating position-relative">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <label>Password</label>
    </div>
    
    <button type="submit" class="btn btn-login btn-medical">Sign In</button>
</form>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper from CDN -->
    <script src="<?= base_url();?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url();?>/assets/js/script.js"></script>
    
    
   
</body>
</html>
