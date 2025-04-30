<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'enrollment';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if admin is logged in
function checkAdminLogin() {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }
}

// Upload directory
define('UPLOAD_DIR', '../assets/uploads/');

// Function to get all records from a table
function getAllRecords($table) {
    global $conn;
    $result = $conn->query("SELECT * FROM $table");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get single record
function getRecordById($table, $id, $idColumn = null) {
    global $conn;
    $idColumn = $idColumn ?: $table . '_id';
    $result = $conn->query("SELECT * FROM $table WHERE $idColumn='$id'");
    return $result->fetch_assoc();
}
?>