<?php
require_once '../includes/config.php';

// Define a function to fetch enrollments
    $sql = "
        SELECT e.*, 
               s.first_name, s.last_name, s.student_number,
               c.course_code, c.course_name
        FROM enrollments e
        INNER JOIN students s ON e.student_id = s.id
        INNER JOIN courses c ON e.course_id = c.id
        ORDER BY e.enrollment_date DESC
    ";

    $result = mysqli_query($conn, $sql);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollments List - Enrollment System</title>
    <link rel="stylesheet" href="../includes/style.css">
    <link href="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
        include '../includes/nav.php';
    ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Enrollments List</h2>
            <a href="add.php" class="btn btn-primary">Add New Enrollment</a>
        </div>
        <?php if(mysqli_num_rows($result) > 0):?>
        <div class="table-responsive">
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Enrollment Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($enrollment = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($enrollment['student_number']) ?> - 
                            <?= htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($enrollment['course_code']) ?> - 
                            <?= htmlspecialchars($enrollment['course_name']) ?>
                        </td>
                        <td><?= htmlspecialchars($enrollment['enrollment_date']) ?></td>
                        <td>
                            <span class="badge bg-<?= $enrollment['status'] === 'approved' ? 'success' : 
                                ($enrollment['status'] === 'pending' ? 'warning' : 'danger') ?>">
                                <?= ucfirst(htmlspecialchars($enrollment['status'])) ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $enrollment['id'] ?>" class="btn btn-sm btn-primary">🛠️</a>
                            <a href="delete.php?id=<?= $enrollment['id'] ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this enrollment?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="alert alert-info">No enrollments found.</div>
        <?php endif; ?>
    </div>

    <script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>    
</body>
</html>