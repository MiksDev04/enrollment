<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
}

$id = $_GET['id'];

// Prepare and execute the DELETE statement
$query = "DELETE FROM enrollments WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: list.php');
        exit();
    } else {
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Error: Failed to prepare statement.');
}
?>
