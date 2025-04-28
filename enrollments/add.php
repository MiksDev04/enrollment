<?php
require_once '../includes/config.php';

$message = '';

// Fetch all students and courses for the dropdown menus
$queryStudents = "SELECT id, student_number, first_name, last_name FROM students ORDER BY last_name, first_name";
$queryCourses = "SELECT id, course_code, course_name FROM courses ORDER BY course_name";

// Execute the queries
$students = mysqli_query($conn, $queryStudents);
$courses = mysqli_query($conn, $queryCourses);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form values
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $enrollment_date = $_POST['enrollment_date'];

    // Check if the student is already enrolled in this course
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM enrollments WHERE student_id = ? AND course_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $exists);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($exists) {
        $message = 'Student is already enrolled in this course.';
    } else {
        // Insert the enrollment record
        $stmt = mysqli_prepare($conn, "INSERT INTO enrollments (student_id, course_id, enrollment_date, status) VALUES (?, ?, ?, 'pending')");
        mysqli_stmt_bind_param($stmt, "iis", $student_id, $course_id, $enrollment_date);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php');
            exit();
        } else {
            $message = 'Error: ' . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Enrollment - Enrollment System</title>
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
                <h2>Add New Enrollment</h2>
                <?php if ($message): ?>
                    <div class="alert alert-danger"><?= $message ?></div>
                <?php endif; ?>
                
                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student</label>
                        <select class="form-select" id="student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?= $student['id'] ?>">
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
                                <option value="<?= $course['id'] ?>">
                                    <?= htmlspecialchars($course['course_code'] . ' - ' . $course['course_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="enrollment_date" class="form-label">Enrollment Date</label>
                        <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Enrollment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>