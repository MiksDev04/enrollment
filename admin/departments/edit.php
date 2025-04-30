<?php 
require_once '../config.php';
checkAdminLogin();

$department_id = $_GET['id'] ?? null;
if (!$department_id) {
    header("Location: index.php");
    exit();
}

// Get department data
$department = $conn->query("SELECT * FROM departments WHERE department_id = $department_id")->fetch_assoc();
if (!$department) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department_name = $_POST['department_name'] ?? '';
    $office_head = $_POST['office_head'] ?? '';

    $stmt = $conn->prepare("UPDATE departments SET department_name = ?, office_head = ? WHERE department_id = ?");
    $stmt->bind_param("ssi", $department_name, $office_head, $department_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=Department updated successfully");
        exit();
    } else {
        $error = "Error updating department: " . $conn->error;
    }
}

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Department</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Departments
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
                            <label for="department_name" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="department_name" name="department_name" 
                                   value="<?= htmlspecialchars($department['department_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="office_head" class="form-label">Office Head</label>
                            <input type="text" class="form-control" id="office_head" name="office_head" 
                                   value="<?= htmlspecialchars($department['office_head']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Department</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>