<?php
require_once '../config.php';
checkAdminLogin();

$enrollment_id = $_GET['id'] ?? null;
if (!$enrollment_id) {
    header("Location: index.php");
    exit();
}

// Delete the enrollment
if ($conn->query("DELETE FROM enrollments WHERE enrollment_id = $enrollment_id")) {
    header("Location: index.php?success=Enrollment deleted successfully");
} else {
    header("Location: index.php?error=Error deleting enrollment");
}
exit();
?>