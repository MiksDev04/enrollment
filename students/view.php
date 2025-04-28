<?php
require_once '../includes/config.php';

// Check if student id is provided
if (!isset($_GET['id'])) {
    header('Location: index.php'); // Redirect to students list if no ID
    exit;
}

$student_id = intval($_GET['id']);

// Fetch student information
$student_query = "SELECT * FROM students WHERE id = $student_id";
$student_result = mysqli_query($conn, $student_query);

if (!$student = mysqli_fetch_assoc($student_result)) {
    echo "Student not found.";
    exit;
}

// Fetch courses the student is enrolled in
$enroll_query = "
    SELECT c.course_code, c.course_name, c.credits, e.enrollment_date, e.status
    FROM enrollments e
    INNER JOIN courses c ON e.course_id = c.id
    WHERE e.student_id = $student_id
    ORDER BY e.enrollment_date DESC
";
$enroll_result = mysqli_query($conn, $enroll_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student - Enrollment System</title>
    <link rel="stylesheet" href="../includes/style.css">
    <link href="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/nav.php'; ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Student Details</h2>
        <a href="index.php" class="btn btn-secondary">Back to Students List</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></h4>
            <p><strong>Student Number:</strong> <?= htmlspecialchars($student['student_number']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone'] ?? 'N/A') ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($student['address'] ?? 'N/A') ?></p>
            <p><strong>Created At:</strong> <?= htmlspecialchars($student['created_at']) ?></p>
        </div>
    </div>

    <h3>Enrolled Courses</h3>

    <?php if (mysqli_num_rows($enroll_result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Enrollment Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($course = mysqli_fetch_assoc($enroll_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['course_code']) ?></td>
                            <td><?= htmlspecialchars($course['course_name']) ?></td>
                            <td><?= htmlspecialchars($course['credits']) ?></td>
                            <td><?= htmlspecialchars($course['enrollment_date']) ?></td>
                            <td><?= htmlspecialchars(ucfirst($course['status'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">This student is not enrolled in any course yet.</div>
    <?php endif; ?>

</div>

<script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>
