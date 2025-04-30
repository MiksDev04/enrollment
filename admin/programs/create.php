<?php 
require_once '../config.php';
checkAdminLogin();

// Get departments for dropdown
$departments = $conn->query("SELECT * FROM departments");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $program_code = $_POST['program_code'] ?? '';
    $program_name = $_POST['program_name'] ?? '';
    $department_id = $_POST['department_id'] ?? '';

    $stmt = $conn->prepare("INSERT INTO programs (program_code, program_name, department_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $program_code, $program_name, $department_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=Program added successfully");
        exit();
    } else {
        $error = "Error adding program: " . $conn->error;
    }
}

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Program</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Programs
                    </a>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="program_code" class="form-label">Program Code</label>
                            <input type="text" class="form-control" id="program_code" name="program_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="program_name" class="form-label">Program Name</label>
                            <input type="text" class="form-control" id="program_name" name="program_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select class="form-select" id="department_id" name="department_id" required>
                                <option value="">Select Department</option>
                                <?php while ($department = $departments->fetch_assoc()): ?>
                                    <option value="<?= $department['department_id'] ?>"><?= $department['department_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Program</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>