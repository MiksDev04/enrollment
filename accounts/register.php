<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: ../home/index.php");
    exit();
}

require '../includes/config.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'student';
    
    $check = $conn->prepare("SELECT user_id FROM USERS WHERE user_name = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();
    
    if($check->num_rows > 0){
        $error = "Username already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO USERS (user_name, user_password, user_role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        
        if($stmt->execute()){
            $success = "Registration successful! Please login.";
        } else {
            $error = "Registration failed! Please try again.";
        }
        $stmt->close();
    }
    $check->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f9fafb;
            --text: #1f2937;
            --light: #f3f4f6;
        }
        body {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .auth-container {
            max-width: 420px;
            margin: 3rem auto;
            padding: 2.5rem;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        .auth-container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }
        .auth-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: block;
            color: var(--primary);
            filter: drop-shadow(0 4px 6px rgba(79, 70, 229, 0.2));
        }
        .auth-title {
            color: var(--text);
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.8rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        .btn-primary-custom {
            background: var(--primary);
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
        }
        .auth-footer a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        .auth-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        .input-group-text {
            background: var(--light);
            border: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-container animate__animated animate__fadeIn">
            <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            <h2 class="auth-title">Create Account</h2>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger animate__animated animate__shakeX"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if(isset($success)): ?>
                <div class="alert alert-success animate__animated animate__fadeIn"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary-custom w-100 btn-lg">Register</button>
                <p class="auth-footer">Already have an account? <a href="../index.php">Sign in</a></p>
            </form>
        </div>
    </div>
    <script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>