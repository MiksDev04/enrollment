<?php
session_start();

// Database connection
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'enrollment');

// Create connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
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