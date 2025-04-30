<?php
require_once '../config.php';
checkAdminLogin();

$department_id = $_GET['id'] ?? null;
if (!$department_id) {
    header("Location: index.php");
    exit();
}

// Check if department has any programs
$hasPrograms = $conn->query("SELECT COUNT(*) FROM programs WHERE department_id = $department_id")->fetch_row()[0];

// Check if department has any professors
$hasProfessors = $conn->query("SELECT COUNT(*) FROM professors WHERE department_id = $department_id")->fetch_row()[0];

if ($hasPrograms > 0 || $hasProfessors > 0) {
    header("Location: index.php?error=Cannot delete department with associated programs or professors");
    exit();
}

// Delete the department
if ($conn->query("DELETE FROM departments WHERE department_id = $department_id")) {
    header("Location: index.php?success=Department deleted successfully");
} else {
    header("Location: index.php?error=Error deleting department");
}
exit();
?>