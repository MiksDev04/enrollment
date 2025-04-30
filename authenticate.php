<?php
require_once 'includes/config.php';
session_start(); // ✅ Start the session immediately after config

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_type = $_POST['user_type'] ?? '';
    if ($user_type === 'student') {
        // Student authentication
        $lastname = $conn->real_escape_string($_POST['lastname']);
        $student_id = $conn->real_escape_string($_POST['student_id']);
        
        $result = $conn->query("SELECT * FROM students WHERE student_id='$student_id' AND last_name='$lastname'");
        
        if ($result->num_rows === 1) {
            $_SESSION['user_type'] = 'student';
            $_SESSION['student_id'] = $student_id;
            header("Location: student/student_info.php");
            exit();
        } else {
            header("Location: login.php?error=Invalid+student+credentials&type=student");
            exit();
        }
    } 
    elseif ($user_type === 'admin') {
        // Admin authentication
        $username = $conn->real_escape_string($_POST['username']);
        $password = $_POST['password']; // In production, use password_hash() and password_verify()
        
        // This is a simple example - in production, use prepared statements and password hashing
        $result = $conn->query("SELECT * FROM admins WHERE username='$username' AND password='$password'");
        
        if ($result->num_rows === 1) {
            $_SESSION['user_type'] = 'admin';
            $_SESSION['admin_username'] = $username;
            header("Location: admin/dashboard/index.php");
            exit();
        } else {
            header("Location: login.php?error=Invalid+admin+credentials&type=admin");
            exit();
        }
    }
}

header("Location: login.php");
exit();
?>