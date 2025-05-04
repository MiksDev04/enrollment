<?php
require_once '../includes/config.php';
session_start(); // ✅ REQUIRED to access session data
// Check if student is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    header("Location: /enrollment/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student = $conn->query("SELECT * FROM students WHERE student_id='$student_id'")->fetch_assoc();

if (!$student) {
    session_destroy();
    header("Location: login.php?error=Student+not+found&type=student");
    exit();
}

// Get student's program and department
$program = $conn->query("SELECT * FROM programs WHERE program_id={$student['program_id']}")->fetch_assoc();
$department = $conn->query("SELECT * FROM departments WHERE department_id={$program['department_id']}")->fetch_assoc();

// Get enrolled courses
$enrollments = $conn->query("
    SELECT e.*, c.course_code, c.course_name, c.units, 
           cs.day, cs.time_start, cs.time_end, cs.room,
           p.first_name AS prof_first, p.last_name AS prof_last
    FROM enrollments e
    JOIN class_schedules cs ON e.class_id = cs.class_id
    JOIN courses c ON cs.course_id = c.course_id
    JOIN professors p ON cs.professor_id = p.professor_id
    WHERE e.student_id='$student_id' AND e.status='Enrolled'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --secondary-blue: #0d47a1;
            --light-blue: #e8f0fe;
        }
        
        .profile-header {
            background-color: var(--primary-blue);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 5px solid white;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .schedule-table th {
            background-color: var(--light-blue);
            color: var(--secondary-blue);
        }
        
        .logout-btn {
            background-color: var(--secondary-blue);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card mb-4">
            <div class="profile-header p-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <?php if ($student['profile_image']): ?>
                            <img src="<?= $student['profile_image'] ?>" class="profile-img rounded-circle">
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="white" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-10">
                        <h2><?= "{$student['first_name']} {$student['last_name']}" ?></h2>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <p><strong>Student ID:</strong> <?= $student['student_id'] ?></p>
                                <p><strong>Program:</strong> <?= $program['program_name'] ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Year Level:</strong> <?= $student['year_level'] ?></p>
                                <p><strong>Status:</strong> <?= $student['status'] ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Department:</strong> <?= $department['department_name'] ?></p>
                                <p><strong>Email:</strong> <?= $student['email'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">My Course Schedule</h4>
                    <a href="../logout.php" class="btn logout-btn">Logout</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table schedule-table">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Units</th>
                                <th>Professor</th>
                                <th>Schedule</th>
                                <th>Room</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($enrollment = $enrollments->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $enrollment['course_code'] ?></td>
                                    <td><?= $enrollment['course_name'] ?></td>
                                    <td><?= $enrollment['units'] ?></td>
                                    <td><?= "{$enrollment['prof_first']} {$enrollment['prof_last']}" ?></td>
                                    <td>
                                        <?= $enrollment['day'] ?> 
                                        <?= date('h:i A', strtotime($enrollment['time_start'])) ?> - 
                                        <?= date('h:i A', strtotime($enrollment['time_end'])) ?>
                                    </td>
                                    <td><?= $enrollment['room'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>