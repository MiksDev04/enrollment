<?php 
require_once '../config.php';
checkAdminLogin();

$enrollment_id = $_GET['id'] ?? null;
if (!$enrollment_id) {
    header("Location: index.php");
    exit();
}

// Get enrollment data
$enrollment = $conn->query("SELECT * FROM enrollments WHERE enrollment_id = $enrollment_id")->fetch_assoc();
if (!$enrollment) {
    header("Location: index.php");
    exit();
}

// Get students and classes for dropdowns
$students = $conn->query("SELECT * FROM students");
$classes = $conn->query("
    SELECT cs.class_id, c.course_name, p.first_name, p.last_name, cs.day, cs.time_start, cs.time_end
    FROM class_schedules cs
    JOIN courses c ON cs.course_id = c.course_id
    JOIN professors p ON cs.professor_id = p.professor_id
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $class_id = $_POST['class_id'] ?? '';
    $status = $_POST['status'] ?? 'Enrolled';
    $grade = $_POST['grade'] ?? null;

    $stmt = $conn->prepare("UPDATE enrollments SET student_id = ?, class_id = ?, status = ?, grade = ? WHERE enrollment_id = ?");
    $stmt->bind_param("sissi", $student_id, $class_id, $status, $grade, $enrollment_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=Enrollment updated successfully");
        exit();
    } else {
        $error = "Error updating enrollment: " . $conn->error;
    }
}

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Enrollment</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Enrollments
                    </a>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="student_id" class="form-label">Student</label>
                                    <select class="form-select" id="student_id" name="student_id" required>
                                        <option value="">Select Student</option>
                                        <?php while ($student = $students->fetch_assoc()): ?>
                                            <option value="<?= $student['student_id'] ?>" <?= $student['student_id'] == $enrollment['student_id'] ? 'selected' : '' ?>>
                                                <?= $student['student_id'] ?> - <?= $student['first_name'] ?> <?= $student['last_name'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="class_id" class="form-label">Class</label>
                                    <select class="form-select" id="class_id" name="class_id" required>
                                        <option value="">Select Class</option>
                                        <?php while ($class = $classes->fetch_assoc()): ?>
                                            <option value="<?= $class['class_id'] ?>" <?= $class['class_id'] == $enrollment['class_id'] ? 'selected' : '' ?>>
                                                <?= $class['course_name'] ?> - <?= $class['first_name'] ?> <?= $class['last_name'] ?> 
                                                (<?= $class['day'] ?> <?= date('h:i A', strtotime($class['time_start'])) ?>-<?= date('h:i A', strtotime($class['time_end'])) ?>)
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="Enrolled" <?= $enrollment['status'] == 'Enrolled' ? 'selected' : '' ?>>Enrolled</option>
                                        <option value="Dropped" <?= $enrollment['status'] == 'Dropped' ? 'selected' : '' ?>>Dropped</option>
                                        <option value="Completed" <?= $enrollment['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="grade" class="form-label">Grade (optional)</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control" id="grade" name="grade" 
                                           value="<?= $enrollment['grade'] ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Enrollment</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>