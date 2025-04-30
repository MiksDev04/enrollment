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
                    <h5><?= $professor['first_name'] . ' ' . $professor['last_name'] ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <?php if ($professor['profile_image']): ?>
                                <img src="<?= $professor['profile_image'] ?>" class="img-thumbnail mb-3" style="max-width: 200px;">
                            <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="#ccc" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Professor ID:</strong> <?= $professor['professor_id'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Department:</strong> <?= $professor['department_name'] ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
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