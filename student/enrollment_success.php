<?php
require_once '../includes/config.php';

$student_id = $_GET['id'] ?? null;

// Fetch student data
$student = null;
if ($student_id) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
}

if (!$student) {
    header("Location: enrollment_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Successful</title>
    <link href="../bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="enrollment-container">
        <div class="enrollment-header text-center">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h1>Enrollment Successful!</h1>
            <p>Thank you for registering with us.</p>
        </div>

        <div class="success-details">
            <div class="row">
                <div class="col-md-4">
                    <?php if ($student['profile_image']): ?>
                        <div class="student-photo">
                            <img src="<?php echo $student['profile_image']; ?>" alt="Student Photo" class="img-fluid rounded">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <h3>Your Student Information</h3>
                    <div class="student-info">
                        <p><strong>Student ID:</strong> <?php echo $student['student_id']; ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . htmlspecialchars($student['last_name'])); ?></p>
                        <p><strong>Program:</strong>
                            <?php
                            $program_stmt = $conn->prepare("SELECT program_name FROM programs WHERE program_id = ?");
                            $program_stmt->bind_param("i", $student['program_id']);
                            $program_stmt->execute();
                            $program_result = $program_stmt->get_result();
                            $program = $program_result->fetch_assoc();
                            echo htmlspecialchars($program['program_name']);
                            ?>
                        </p>
                        <p><strong>Year Level:</strong> <?php echo $student['year_level']; ?></p>
                        <p><strong>Status:</strong> <?php echo $student['status']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="next-steps mt-4">
            <h4>Next Steps</h4>
            <ul>
                <li>You will receive an email with further instructions</li>
                <li>Attend the orientation session on [date]</li>
                <li>Complete your registration by confirming your class schedule</li>
            </ul>

        </div>

        <div class="text-center mt-4">
            <a href="../home.php" class="btn btn-primary">Return to Home</a>
        </div>
    </div>
    <script src="../bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>

</html>