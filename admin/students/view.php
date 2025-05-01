<?php 
require_once '../config.php';
checkAdminLogin();

$student_id = $_GET['id'] ?? null;
if (!$student_id) {
    header("Location: index.php");
    exit();
}

// Get student information
$student = $conn->query("
    SELECT s.*, p.program_name, d.department_name 
    FROM students s
    LEFT JOIN programs p ON s.program_id = p.program_id
    LEFT JOIN departments d ON p.department_id = d.department_id
    WHERE s.student_id = '$student_id'
")->fetch_assoc();

if (!$student) {
    header("Location: index.php");
    exit();
}

// Get enrolled courses for this student
$enrollments = $conn->query("
    SELECT e.*, c.course_code, c.course_name, cs.day, cs.time_start, cs.time_end, cs.room,
           p.first_name AS prof_first, p.last_name AS prof_last
    FROM enrollments e
    JOIN class_schedules cs ON e.class_id = cs.class_id
    JOIN courses c ON cs.course_id = c.course_id
    JOIN professors p ON cs.professor_id = p.professor_id
    WHERE e.student_id = '$student_id'
    ORDER BY e.status, c.course_name
");

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Student Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Students
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Student Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <?php if ($student['profile_image']): ?>
                                <img src="../<?= $student['profile_image'] ?>" class="img-thumbnail mb-3" style="max-width: 200px;">
                            <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="#ccc" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Student ID:</strong> <?= $student['student_id'] ?></p>
                                    <p><strong>Name:</strong> <?= $student['first_name'] ?> <?= $student['middle_name'] ? $student['middle_name'] . ' ' : '' ?><?= $student['last_name'] ?></p>
                                    <p><strong>Birthdate:</strong> <?= date('F j, Y', strtotime($student['birthdate'])) ?></p>
                                    <p><strong>Gender:</strong> <?= $student['gender'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Program:</strong> <?= $student['program_name'] ?></p>
                                    <p><strong>Department:</strong> <?= $student['department_name'] ?></p>
                                    <p><strong>Year Level:</strong> <?= $student['year_level'] ?></p>
                                    <p><strong>Status:</strong> <?= $student['status'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> <?= $student['email'] ?></p>
                                    <p><strong>Phone:</strong> <?= $student['phone'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Registration Date:</strong> <?= date('F j, Y', strtotime($student['date_registered'])) ?></p>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p><strong>Address:</strong> <?= nl2br($student['address']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="edit.php?id=<?= $student['student_id'] ?>" class="btn btn-primary">
                        Edit Student
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Enrolled Courses</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Professor</th>
                                    <th>Schedule</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($enrollment = $enrollments->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $enrollment['course_code'] ?></td>
                                        <td><?= $enrollment['course_name'] ?></td>
                                        <td><?= $enrollment['prof_first'] ?> <?= $enrollment['prof_last'] ?></td>
                                        <td>
                                            <?= $enrollment['day'] ?> 
                                            <?= date('h:i A', strtotime($enrollment['time_start'])) ?> - 
                                            <?= date('h:i A', strtotime($enrollment['time_end'])) ?>
                                        </td>
                                        <td><?= $enrollment['room'] ?></td>
                                        <td>
                                            <span class="badge <?= 
                                                $enrollment['status'] == 'Enrolled' ? 'bg-success' : 
                                                ($enrollment['status'] == 'Dropped' ? 'bg-danger' : 'bg-primary') 
                                            ?>">
                                                <?= $enrollment['status'] ?>
                                            </span>
                                        </td>
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