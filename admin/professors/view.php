<?php 
require_once '../config.php';
checkAdminLogin();

$professor_id = $_GET['id'] ?? null;
if (!$professor_id) {
    header("Location: index.php");
    exit();
}

$professor = $conn->query("
    SELECT p.*, d.department_name 
    FROM professors p
    LEFT JOIN departments d ON p.department_id = d.department_id
    WHERE p.professor_id = $professor_id
")->fetch_assoc();

if (!$professor) {
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
                <h1 class="h2">Professor Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Professor Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Professor Name:</strong> <?= $professor['first_name'] . ' ' . $professor['last_name'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Professor ID:</strong> <?= $professor['professor_id'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Department:</strong> <?= $professor['department_name'] ?></p>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> <?= $professor['email'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Phone:</strong> <?= $professor['phone'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="edit.php?id=<?= $professor['professor_id'] ?>" class="btn btn-primary">
                        Edit Professor
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Assigned Classes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Schedule</th>
                                    <th>Room</th>
                                    <th>Semester</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $classes = $conn->query("
                                    SELECT cs.*, c.course_name 
                                    FROM class_schedules cs
                                    JOIN courses c ON cs.course_id = c.course_id
                                    WHERE cs.professor_id = $professor_id
                                ");
                                
                                while ($class = $classes->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $class['course_name'] ?></td>
                                        <td><?= $class['section'] ?></td>
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