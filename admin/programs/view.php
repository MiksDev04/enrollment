<?php 
require_once '../config.php';
checkAdminLogin();

$program_id = $_GET['id'] ?? null;
if (!$program_id) {
    header("Location: index.php");
    exit();
}

$program = $conn->query("
    SELECT p.*, d.department_name, d.office_head 
    FROM programs p
    LEFT JOIN departments d ON p.department_id = d.department_id
    WHERE p.program_id = $program_id
")->fetch_assoc();

if (!$program) {
    header("Location: index.php");
    exit();
}

// Get courses for this program
$courses = $conn->query("SELECT * FROM courses WHERE program_id = $program_id");

// Get students in this program
$students = $conn->query("
    SELECT s.* 
    FROM students s
    WHERE s.program_id = $program_id
    ORDER BY s.last_name, s.first_name
");

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Program Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5><?= $program['program_code'] ?> - <?= $program['program_name'] ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Program Code:</strong> <?= $program['program_code'] ?></p>
                            <p><strong>Program Name:</strong> <?= $program['program_name'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Department:</strong> <?= $program['department_name'] ?></p>
                            <p><strong>Department Head:</strong> <?= $program['office_head'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="edit.php?id=<?= $program['program_id'] ?>" class="btn btn-primary">
                        Edit Program
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Courses in this Program</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Units</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($course = $courses->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $course['course_code'] ?></td>
                                                <td><?= $course['course_name'] ?></td>
                                                <td><?= $course['units'] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Students in this Program</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Year Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($student = $students->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $student['student_id'] ?></td>
                                                <td><?= $student['first_name'] ?> <?= $student['last_name'] ?></td>
                                                <td><?= $student['year_level'] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>