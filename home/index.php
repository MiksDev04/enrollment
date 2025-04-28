<?php
// Database connection
require_once '../includes/config.php';

// Get student count
$student_count = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) FROM students");
if ($result) {
    $row = mysqli_fetch_row($result);
    $student_count = $row[0];
}

// Get course count
$course_count = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) FROM courses");
if ($result) {
    $row = mysqli_fetch_row($result);
    $course_count = $row[0];
}

// Get enrollment count
$enrollment_count = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) FROM enrollments");
if ($result) {
    $row = mysqli_fetch_row($result);
    $enrollment_count = $row[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment System</title>
    <link rel="stylesheet" href="../includes/style.css">
    <link href="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  
    <?php
        include '../includes/nav.php';
    ?>
    <div class="container mt-4">
        <div class="welcome-section">
            <h1 class="text-center mb-3">Welcome to Student Enrollment System</h1>
            <p class="text-center mb-0">Manage student records, courses, and enrollments in one place</p>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card students h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                <svg class="card-icon" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Students
                            </h5>
                            <span class="badge bg-primary rounded-pill"><?php echo $student_count; ?></span>
                        </div>
                        <p class="card-text">Manage student information and records</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../students/index.php" class="btn btn-primary">View Students</a>
                            <small class="text-muted"><?php echo $student_count; ?> records</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card courses h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                <svg class="card-icon" viewBox="0 0 24 24">
                                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                                </svg>
                                Courses
                            </h5>
                            <span class="badge bg-success rounded-pill"><?php echo $course_count; ?></span>
                        </div>
                        <p class="card-text">Manage available courses and their details</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../courses/index.php" class="btn btn-primary">View Courses</a>
                            <small class="text-muted"><?php echo $course_count; ?> records</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card enrollments h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                <svg class="card-icon" viewBox="0 0 24 24">
                                    <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                                Enrollments
                            </h5>
                            <span class="badge bg-warning rounded-pill text-dark"><?php echo $enrollment_count; ?></span>
                        </div>
                        <p class="card-text">Manage student course enrollments</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../enrollments/index.php" class="btn btn-primary">View Enrollments</a>
                            <small class="text-muted"><?php echo $enrollment_count; ?> records</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>