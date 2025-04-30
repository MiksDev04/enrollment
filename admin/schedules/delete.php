<?php
require_once '../../config.php';
checkAdminLogin();

$class_id = $_GET['id'] ?? null;
if (!$class_id) {
    header("Location: index.php");
    exit();
}

// Check if class has any enrollments
$hasEnrollments = $conn->query("SELECT COUNT(*) FROM enrollments WHERE class_id = $class_id")->fetch_row()[0];

if ($hasEnrollments > 0) {
    header("Location: index.php?error=Cannot delete class with enrolled students");
    exit();
}

// Delete the class schedule
if ($conn->query("DELETE FROM class_schedules WHERE class_id = $class_id")) {
    header("Location: index.php?success=Class schedule deleted successfully");
} else {
    header("Location: index.php?error=Error deleting class schedule");
}
exit();
?>