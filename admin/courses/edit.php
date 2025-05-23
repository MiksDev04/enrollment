<?php 
require_once '../config.php';
checkAdminLogin();

$course_id = $_GET['id'] ?? null;
if (!$course_id) {
    header("Location: index.php");
    exit();
}

// Get course data
$course = $conn->query("SELECT * FROM courses WHERE course_id = $course_id")->fetch_assoc();
if (!$course) {
    header("Location: index.php");
    exit();
}

// Get programs for dropdown
$programs = $conn->query("SELECT * FROM programs");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_code = $_POST['course_code'] ?? '';
    $course_name = $_POST['course_name'] ?? '';
    $units = $_POST['units'] ?? '';
    $program_id = $_POST['program_id'] ?? '';

    $stmt = $conn->prepare("UPDATE courses SET course_code = ?, course_name = ?, units = ?, program_id = ? WHERE course_id = ?");
    $stmt->bind_param("ssiii", $course_code, $course_name, $units, $program_id, $course_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=Course updated successfully");
        exit();
    } else {
        $error = "Error updating course: " . $conn->error;
    }
}

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Course</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Courses
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
                            <label for="course_code" class="form-label">Course Code</label>
                            <input type="text" class="form-control" id="course_code" name="course_code" 
                                   value="<?= htmlspecialchars($course['course_code']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="course_name" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" 
                                   value="<?= htmlspecialchars($course['course_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="units" class="form-label">Units</label>
                            <input type="number" class="form-control" id="units" name="units" 
                                   value="<?= $course['units'] ?>" required min="1">
                        </div>
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Program</label>
                            <select class="form-select" id="program_id" name="program_id" required>
                                <option value="">Select Program</option>
                                <?php while ($program = $programs->fetch_assoc()): ?>
                                    <option value="<?= $program['program_id'] ?>" 
                                        <?= $program['program_id'] == $course['program_id'] ? 'selected' : '' ?>>
                                        <?= $program['program_name'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Course</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>