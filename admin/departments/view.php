<?php 
require_once '../config.php';
checkAdminLogin();

$department_id = $_GET['id'] ?? null;
if (!$department_id) {
    header("Location: index.php");
    exit();
}

$department = $conn->query("SELECT * FROM departments WHERE department_id = $department_id")->fetch_assoc();

if (!$department) {
    header("Location: index.php");
    exit();
}

// Get programs in this department
$programs = $conn->query("SELECT * FROM programs WHERE department_id = $department_id");

// Get professors in this department
$professors = $conn->query("SELECT * FROM professors WHERE department_id = $department_id");

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Department Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5><?= $department['department_name'] ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Department Name:</strong> <?= $department['department_name'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Office Head:</strong> <?= $department['office_head'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="edit.php?id=<?= $department['department_id'] ?>" class="btn btn-primary">
                        Edit Department
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Programs in this Department</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($program = $programs->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $program['program_code'] ?></td>
                                                <td><?= $program['program_name'] ?></td>
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
                            <h5>Professors in this Department</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($professor = $professors->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $professor['first_name'] ?> <?= $professor['last_name'] ?></td>
                                                <td><?= $professor['email'] ?></td>
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