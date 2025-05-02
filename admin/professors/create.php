<?php 
require_once '../config.php';
checkAdminLogin();

// Get departments for dropdown
$departments = $conn->query("SELECT * FROM departments");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $department_id = $_POST['department_id'] ?? '';

    $stmt = $conn->prepare("INSERT INTO professors (first_name, last_name, email, phone, department_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $department_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=Professor added successfully");
        exit();
    } else {
        $error = "Error adding professor: " . $conn->error;
    }
}

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Professor</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Professors
                    </a>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
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
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Professor</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
