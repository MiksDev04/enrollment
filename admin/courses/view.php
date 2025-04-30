<?php 
require_once '../config.php';
checkAdminLogin();

$course_id = $_GET['id'] ?? null;
if (!$course_id) {
    header("Location: index.php");
    exit();
}

$course = $conn->query("
    SELECT c.*, p.program_name 
    FROM courses c
    LEFT JOIN programs p ON c.program_id = p.program_id
    WHERE c.course_id = $course_id
")->fetch_assoc();

if (!$course) {
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
                <h1 class="h2">Course Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5><?= $course['course_code'] ?> - <?= $course['course_name'] ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Course Code:</strong> <?= $course['course_code'] ?></p>
                            <p><strong>Course Name:</strong> <?= $course['course_name'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Units:</strong> <?= $course['units'] ?></p>
                            <p><strong>Program:</strong> <?= $course['program_name'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="edit.php?id=<?= $course['course_id'] ?>" class="btn btn-primary">
                        Edit Course
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Scheduled Classes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Professor</th>
                                    <th>Schedule</th>
                                    <th>Room</th>
                                    <th>Semester</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $classes = $conn->query("
                                    SELECT cs.*, p.first_name, p.last_name 
                                    FROM class_schedules cs
                                    JOIN professors p ON cs.professor_id = p.professor_id
                                    WHERE cs.course_id = $course_id
                                ");
                                
                                while ($class = $classes->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $class['section'] ?></td>
                                        <td><?= $class['first_name'] . ' ' . $class['last_name'] ?></td>
                                        <td>
                                            <?= $class['day'] ?> 
                                            <?= date('h:i A', strtotime($class['time_start'])) ?> - 
                                            <?= date('h:i A', strtotime($class['time_end'])) ?>
                                        </td>
                                        <td><?= $class['room'] ?></td>
                                        <td><?= $class['semester'] ?></td>
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