<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Login System</title>
    <link href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --secondary-blue: #0d47a1;
            --light-blue: #e8f0fe;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-header {
            background-color: var(--primary-blue);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 20px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #495057;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-blue);
            border-bottom: 3px solid var(--primary-blue);
            background: transparent;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
        }
        
        .login-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: block;
            color: var(--primary-blue);
        }
        
        .tab-content {
            padding: 20px 0;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header position-relative d-flex flex-wrap gap-2 align-items-center ">
                <a href="home.php" class="  btn text-white d-flex align-items-center gap-2" style="left: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="1.2rem" height="1.2rem" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                    <span class=" fw-medium">Back</span>
                </a>
                <h2 class=" text-center">University Portal Login</h2>
            </div>
            <div class="login-body">
                <svg class="login-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                
                <ul class="nav nav-tabs" id="loginTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab">
                            Student Login
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab">
                            Admin Login
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="loginTabsContent">
                    <!-- Student Login Form -->
                    <div class="tab-pane fade show active" id="student" role="tabpanel">
                        <form action="authenticate.php" method="post">
                            <input type="hidden" name="user_type" value="student">
                            
                            <?php if (isset($_GET['error']) && $_GET['type'] == 'student'): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="student_lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="student_lastname" name="lastname" required>
                            </div>
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="student_id" name="student_id" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login as Student</button>
                        </form>
                    </div>
                    
                    <!-- Admin Login Form -->
                    <div class="tab-pane fade" id="admin" role="tabpanel">
                        <form action="authenticate.php" method="post">
                            <input type="hidden" name="user_type" value="admin">
                            
                            <?php if (isset($_GET['error']) && $_GET['type'] == 'admin'): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="admin_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="admin_username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="admin_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="admin_password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login as Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>