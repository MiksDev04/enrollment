<?php
require_once '../includes/config.php';

// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit();
}

$stmt = mysqli_prepare($conn, "DELETE FROM courses WHERE id = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php');
    } else {
        if (mysqli_errno($conn) == 1451) {
            header('Location: index.php?error=foreignkey');
        } else {
            echo "Unexpected error: " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare statement: " . mysqli_error($conn);
}
?>
