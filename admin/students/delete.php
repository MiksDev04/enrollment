<?php
require_once '../config.php';
checkAdminLogin();

$student_id = $_GET['id'] ?? null;
if (!$student_id) {
    header("Location: index.php");
    exit();
}

// Check if program has any students
$hasStudent = $conn->query("SELECT COUNT(*) FROM enrollments WHERE student_id = '$student_id'")->fetch_row()[0];

if ( $hasStudent > 0) {
    header("Location: index.php?error=Cannot delete student with associated enrollments");
    exit();
}
// Delete the program
if ($conn->query("DELETE FROM students WHERE student_id = '$student_id'")) {
    header("Location: index.php?success=Student deleted successfully");
} else {
    header("Location: index.php?error=Error deleting program");
}
exit();
?>