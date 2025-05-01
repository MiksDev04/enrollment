<?php
require_once '../config.php';
checkAdminLogin();

$professor_id = $_GET['id'] ?? null;
if (!$professor_id) {
    header("Location: index.php");
    exit();
}

// Check if program has any students
$hasSchedule = $conn->query("SELECT COUNT(*) FROM class_schedules WHERE professor_id = $professor_id")->fetch_row()[0];

if ( $hasSchedule > 0) {
    header("Location: index.php?error=Cannot delete professor with associated class schedules");
    exit();
}

// Delete the program
if ($conn->query("DELETE FROM professors WHERE professor_id = $professor_id")) {
    header("Location: index.php?success=Professor deleted successfully");
} else {
    header("Location: index.php?error=Error deleting professor");
}
exit();
?>