<?php
require_once '../config.php';
checkAdminLogin();

$program_id = $_GET['id'] ?? null;
if (!$program_id) {
    header("Location: index.php");
    exit();
}

// Check if program has any courses
$hasCourses = $conn->query("SELECT COUNT(*) FROM courses WHERE program_id = $program_id")->fetch_row()[0];

// Check if program has any students
$hasStudents = $conn->query("SELECT COUNT(*) FROM students WHERE program_id = $program_id")->fetch_row()[0];

if ($hasCourses > 0 || $hasStudents > 0) {
    header("Location: index.php?error=Cannot delete program with associated courses or students");
    exit();
}

// Delete the program
if ($conn->query("DELETE FROM programs WHERE program_id = $program_id")) {
    header("Location: index.php?success=Program deleted successfully");
} else {
    header("Location: index.php?error=Error deleting program");
}
exit();
?>