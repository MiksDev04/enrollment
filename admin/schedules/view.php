<?php 
require_once '../config.php';
checkAdminLogin();

$class_id = $_GET['id'] ?? null;
if (!$class_id) {
    header("Location: index.php");
    exit();
}

$schedule = $conn->query("
    SELECT cs.*, c.course_code, c.course_name, p.first_name, p.last_name 
    FROM class_schedules cs
    JOIN courses c ON cs.course_id = c.course_id
    JOIN professors p ON cs.professor_id = p.professor_id
    WHERE cs.class_id = $class_id
")->fetch_assoc();

if (!$schedule) {
    header("Location: index.php");
    exit();
}

// Get enrollments for this class
$enrollments = $conn->query("
    SELECT e.*, s.first_name, s.last_name, s.student_id
    FROM enrollments e
    JOIN students s ON e.student_id = s.student_id
    WHERE e.class_id = $class_id
");

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Class Schedule Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5><?= $schedule['course_code'] ?> - <?= $schedule['course_name'] ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Course:</strong> <?= $schedule['course_code'] ?> - <?= $schedule['course_name'] ?></p>
                            <p><strong>Professor:</strong> <?= $schedule['first_name'] ?> <?= $schedule['last_name'] ?></p>
                            <p><strong>Section:</strong> <?= $schedule['section'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Schedule:</strong> <?= $schedule['day'] ?> <?= date('h:i A', strtotime($schedule['time_start'])) ?> - <?= date('h:i A', strtotime($schedule['time_end'])) ?></p>
                            <p><strong>Room:</strong> <?= $schedule['room'] ?></p>
                            <p><strong>Semester:</strong> <?= $schedule['semester'] ?> <?= $schedule['academic_year'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="edit.php?id=<?= $schedule['class_id'] ?>" class="btn btn-primary">
                        Edit Schedule
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Enrolled Students</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Enrollment Date</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($enrollment = $enrollments->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $enrollment['student_id'] ?></td>
                                        <td><?= $enrollment['first_name'] ?> <?= $enrollment['last_name'] ?></td>
                                        <td><?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></td>
                                        <td><?= $enrollment['status'] ?></td>
                                        <td><?= $enrollment['grade'] ?? '-' ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>