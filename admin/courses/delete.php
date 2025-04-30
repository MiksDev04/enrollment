<?php
require_once '../config.php';
checkAdminLogin();

$course_id = $_GET['id'] ?? null;
if (!$course_id) {
    header("Location: index.php");
    exit();
}

// Check if course has any scheduled classes
$hasClasses = $conn->query("SELECT COUNT(*) FROM class_schedules WHERE course_id = $course_id")->fetch_row()[0];

if ($hasClasses > 0) {
    header("Location: index.php?error=Cannot delete course with scheduled classes");
    exit();
}

// Delete the course
if ($conn->query("DELETE FROM courses WHERE course_id = $course_id")) {
    header("Location: index.php?success=Course deleted successfully");
} else {
    header("Location: index.php?error=Error deleting course");
}
exit();
?> 