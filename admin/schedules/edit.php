<?php 
require_once '../config.php';
checkAdminLogin();

$class_id = $_GET['id'] ?? null;
if (!$class_id) {
    header("Location: index.php");
    exit();
}

// Get class schedule data
$schedule = $conn->query("SELECT * FROM class_schedules WHERE class_id = $class_id")->fetch_assoc();
if (!$schedule) {
    header("Location: index.php");
    exit();
}

// Get courses and professors for dropdowns
$courses = $conn->query("SELECT * FROM courses");
$professors = $conn->query("SELECT * FROM professors");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'] ?? '';
    $professor_id = $_POST['professor_id'] ?? '';
    $section = $_POST['section'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $academic_year = $_POST['academic_year'] ?? '';
    $day = $_POST['day'] ?? '';
    $time_start = $_POST['time_start'] ?? '';
    $time_end = $_POST['time_end'] ?? '';
    $room = $_POST['room'] ?? '';

    $stmt = $conn->prepare("UPDATE class_schedules SET course_id = ?, professor_id = ?, section = ?, semester = ?, academic_year = ?, day = ?, time_start = ?, time_end = ?, room = ? WHERE class_id = ?");
    $stmt->bind_param("iisssssssi", $course_id, $professor_id, $section, $semester, $academic_year, $day, $time_start, $time_end, $room, $class_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=Class schedule updated successfully");
        exit();
    } else {
        $error = "Error updating class schedule: " . $conn->error;
    }
}

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Class Schedule</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Schedules
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
                                    <label for="course_id" class="form-label">Course</label>
                                    <select class="form-select" id="course_id" name="course_id" required>
                                        <option value="">Select Course</option>
                                        <?php while ($course = $courses->fetch_assoc()): ?>
                                            <option value="<?= $course['course_id'] ?>" <?= $course['course_id'] == $schedule['course_id'] ? 'selected' : '' ?>>
                                                <?= $course['course_code'] ?> - <?= $course['course_name'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="professor_id" class="form-label">Professor</label>
                                    <select class="form-select" id="professor_id" name="professor_id" required>
                                        <option value="">Select Professor</option>
                                        <?php while ($professor = $professors->fetch_assoc()): ?>
                                            <option value="<?= $professor['professor_id'] ?>" <?= $professor['professor_id'] == $schedule['professor_id'] ? 'selected' : '' ?>>
                                                <?= $professor['first_name'] ?> <?= $professor['last_name'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="section" class="form-label">Section</label>
                                    <input type="text" class="form-control" id="section" name="section" 
                                           value="<?= htmlspecialchars($schedule['section']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="semester" class="form-label">Semester</label>
                                    <select class="form-select" id="semester" name="semester" required>
                                        <option value="">Select Semester</option>
                                        <option value="1st" <?= $schedule['semester'] == '1st' ? 'selected' : '' ?>>1st Semester</option>
                                        <option value="2nd" <?= $schedule['semester'] == '2nd' ? 'selected' : '' ?>>2nd Semester</option>
                                        <option value="Summer" <?= $schedule['semester'] == 'Summer' ? 'selected' : '' ?>>Summer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="academic_year" class="form-label">Academic Year</label>
                                    <input type="text" class="form-control" id="academic_year" name="academic_year" 
                                           value="<?= htmlspecialchars($schedule['academic_year']) ?>" placeholder="YYYY-YYYY" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="day" class="form-label">Day</label>
                                    <select class="form-select" id="day" name="day" required>
                                        <option value="">Select Day</option>
                                        <option value="M" <?= $schedule['day'] == 'M' ? 'selected' : '' ?>>Monday</option>
                                        <option value="T" <?= $schedule['day'] == 'T' ? 'selected' : '' ?>>Tuesday</option>
                                        <option value="W" <?= $schedule['day'] == 'W' ? 'selected' : '' ?>>Wednesday</option>
                                        <option value="TH" <?= $schedule['day'] == 'TH' ? 'selected' : '' ?>>Thursday</option>
                                        <option value="F" <?= $schedule['day'] == 'F' ? 'selected' : '' ?>>Friday</option>
                                        <option value="S" <?= $schedule['day'] == 'S' ? 'selected' : '' ?>>Saturday</option>
                                        <option value="SU" <?= $schedule['day'] == 'SU' ? 'selected' : '' ?>>Sunday</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="time_start" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="time_start" name="time_start" 
                                           value="<?= $schedule['time_start'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="time_end" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="time_end" name="time_end" 
                                           value="<?= $schedule['time_end'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="room" class="form-label">Room</label>
                            <input type="text" class="form-control" id="room" name="room" 
                                   value="<?= htmlspecialchars($schedule['room']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>