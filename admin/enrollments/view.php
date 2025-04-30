<?php 
require_once '../config.php';
checkAdminLogin();

$enrollment_id = $_GET['id'] ?? null;
if (!$enrollment_id) {
    header("Location: index.php");
    exit();
}

$enrollment = $conn->query("
    SELECT e.*, s.first_name AS student_first, s.last_name AS student_last, s.student_id,
           c.course_name, p.first_name AS prof_first, p.last_name AS prof_last,
           cs.day, cs.time_start, cs.time_end, cs.room, cs.section
    FROM enrollments e
    JOIN students s ON e.student_id = s.student_id
    JOIN class_schedules cs ON e.class_id = cs.class_id
    JOIN courses c ON cs.course_id = c.course_id
    JOIN professors p ON cs.professor_id = p.professor_id
    WHERE e.enrollment_id = $enrollment_id
")->fetch_assoc();

if (!$enrollment) {
    header("Location: index.php");
    exit();
}

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Enrollment Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Student Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Student ID:</strong> <?= $enrollment['student_id'] ?></p>
                            <p><strong>Name:</strong> <?= $enrollment['student_first'] ?> <?= $enrollment['student_last'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Enrollment Date:</strong> <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></p>
                            <p><strong>Status:</strong> <?= $enrollment['status'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Class Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Course:</strong> <?= $enrollment['course_name'] ?></p>
                            <p><strong>Professor:</strong> <?= $enrollment['prof_first'] ?> <?= $enrollment['prof_last'] ?></p>
                            <p><strong>Section:</strong> <?= $enrollment['section'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Schedule:</strong> <?= $enrollment['day'] ?> <?= date('h:i A', strtotime($enrollment['time_start'])) ?> - <?= date('h:i A', strtotime($enrollment['time_end'])) ?></p>
                            <p><strong>Room:</strong> <?= $enrollment['room'] ?></p>
                            <p><strong>Grade:</strong> <?= $enrollment['grade'] ?? '-' ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="edit.php?id=<?= $enrollment['enrollment_id'] ?>" class="btn btn-primary">
                        Edit Enrollment
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>