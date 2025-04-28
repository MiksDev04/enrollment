<?php
require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
}

$id = $_GET['id'];
$message = '';

// Fetch all students and courses for the dropdown menus
$students = mysqli_query($conn, 'SELECT id, student_number, first_name, last_name FROM students ORDER BY last_name, first_name');
$courses = mysqli_query($conn, 'SELECT id, course_code, course_name FROM courses ORDER BY course_name');

// Fetch enrollment data
$query = "SELECT * FROM enrollments WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $enrollment = mysqli_fetch_assoc($result);
    
    if (!$enrollment) {
        header('Location: index.php');
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    $message = 'Error: ' . mysqli_error($conn);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Check if changing student or course, and if new combination already exists
        if ($enrollment['student_id'] != $_POST['student_id'] || $enrollment['course_id'] != $_POST['course_id']) {
            $checkQuery = "SELECT COUNT(*) FROM enrollments WHERE student_id = ? AND course_id = ? AND id != ?";
            $checkStmt = mysqli_prepare($conn, $checkQuery);
            mysqli_stmt_bind_param($checkStmt, "iii", $_POST['student_id'], $_POST['course_id'], $id);
            mysqli_stmt_execute($checkStmt);
            mysqli_stmt_bind_result($checkStmt, $exists);
            mysqli_stmt_fetch($checkStmt);

            if ($exists) {
                $message = 'Student is already enrolled in this course.';
                goto skip_update;
            }

            mysqli_stmt_close($checkStmt);
        }

        // Update enrollment data
        $updateQuery = "UPDATE enrollments SET 
            student_id = ?, 
            course_id = ?, 
            enrollment_date = ?, 
            status = ? 
            WHERE id = ?";
        
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "iissi", $_POST['student_id'], $_POST['course_id'], $_POST['enrollment_date'], $_POST['status'], $id);
        mysqli_stmt_execute($updateStmt);
        
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
}

skip_update:
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Enrollment - Enrollment System</title>
    <link rel="stylesheet" href="../includes/style.css">
    <link href="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
        include '../includes/nav.php';
    ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>Edit Enrollment</h2>
                <?php if ($message): ?>
                    <div class="alert alert-danger"><?= $message ?></div>
                <?php endif; ?>
                
                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student</label>
                        <select class="form-select" id="student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?= $student['id'] ?>" <?= $student['id'] == $enrollment['student_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($student['student_number'] . ' - ' . 
                                        $student['first_name'] . ' ' . $student['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-select" id="course_id" name="course_id" required>
                            <option value="">Select Course</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= $course['id'] ?>" <?= $course['id'] == $enrollment['course_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($course['course_code'] . ' - ' . $course['course_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="enrollment_date" class="form-label">Enrollment Date</label>
                        <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" 
                               value="<?= htmlspecialchars($enrollment['enrollment_date']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" <?= $enrollment['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= $enrollment['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= $enrollment['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Enrollment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>