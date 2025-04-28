<?php
require_once '../includes/config.php';

// Fetch all students
$query = "SELECT * FROM students ORDER BY last_name, first_name";
$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List - Enrollment System</title>
    <link rel="stylesheet" href="../includes/style.css">
    <link href="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
        include '../includes/nav.php';
    ?>

    <div class="container mt-4">
        <?php if (isset($_GET['error']) && $_GET['error'] == 'foreignkey'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error">
                Cannot delete student: record is referenced in enrollments.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success">
                Student successfully deleted.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Students List</h2>
            <a href="add.php" class="btn btn-primary">Add New Student</a>
        </div>

        <?php if(mysqli_num_rows($result) > 0):?>
            <div class="table-responsive">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($student = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($student['student_number']) ?></td>
                                <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                                <td><?= htmlspecialchars($student['email']) ?></td>
                                <td><?= htmlspecialchars($student['phone']) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-primary">🛠️</a>
                                    <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">🗑️</a>
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