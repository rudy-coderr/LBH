<?php
// Get the user's role from the session
$userRole = session()->get('role');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 500px;
            text-align: center;
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .icon {
            font-size: 3.5rem;
            color: #e74c3c;
            margin-bottom: 1rem;
        }
        
        h1 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .message {
            color: #5d6778;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        
        .error-code {
            display: inline-block;
            background-color: #f8f9fa;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .actions {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            margin-top: 1rem;
        }
        
        .primary-button {
            background-color: #3498db;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
            cursor: pointer;
            border: none;
            display: inline-block;
            text-align: center;
        }
        
        .primary-button:hover {
            background-color: #2980b9;
        }
        
        .secondary-button {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .secondary-button:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .help-text {
            font-size: 0.85rem;
            color: #7f8c8d;
            margin-top: 1.5rem;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="icon">&#128274;</div>
        <h1>Access Denied</h1>
        <span class="error-code">Error 401</span>
        <p class="message">You don't have permission to access this page. This could be due to insufficient privileges or an expired session.</p>
        
        <div class="actions">
            <button onclick="redirectToDashboard()" class="primary-button">Return to Home</button>
            <a href="/logout" class="secondary-button">Sign in again</a>
        </div>
        
    </div>

    <script>
        var userRole = "<?php echo strtolower($userRole); ?>"; // Convert to lowercase for consistency

        function redirectToDashboard() {
            if (userRole === 'admin') {
                window.location.href = "/admin/dashboard";
            } else if (userRole === 'staff') {
                window.location.href = "/staff/dashboard";
            } else {
                window.location.href = "/login"; // Redirect to login if no valid role
            }
        }

        console.log("User Role:", userRole); // Debugging log
    </script>

</body>
</html>
