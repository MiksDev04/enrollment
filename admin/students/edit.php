<?php 
require_once '../config.php';
checkAdminLogin();

$programs = getAllRecords("programs");

$student_id = $_GET['id'] ?? null;
if (!$student_id) {
    header("Location: index.php");
    exit();
}
$student = getRecordById("students", $student_id, "student_id");

require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Student</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php" class="btn btn-sm btn-outline-secondary">
                        Back to Students
                    </a>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="../edit_enrollment.php" enctype="multipart/form-data">
                        <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>" readonly>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="<?= htmlspecialchars($student['first_name']) ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="<?= htmlspecialchars($student['last_name']) ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" 
                                       value="<?= htmlspecialchars($student['middle_name']) ?>">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" 
                                       value="<?= $student['birthdate'] ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?= $student['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= $student['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Other" <?= $student['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($student['email']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= htmlspecialchars($student['phone']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($student['address']) ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="program_id" class="form-label">Program</label>
                                <select class="form-select" id="program_id" name="program_id" required>
                                    <option value="">Select Program</option>
                                    <?php foreach ($programs as $program): ?>
                                        <option value="<?= $program['program_id'] ?>" 
                                            <?= $program['program_id'] == $student['program_id'] ? 'selected' : '' ?>>
                                            <?= $program['program_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="year_level" class="form-label">Year Level</label>
                                <select class="form-select" id="year_level" name="year_level" required>
                                    <option value="">Select Year Level</option>
                                    <option value="1" <?= $student['year_level'] == 1 ? 'selected' : '' ?>>1st Year</option>
                                    <option value="2" <?= $student['year_level'] == 2 ? 'selected' : '' ?>>2nd Year</option>
                                    <option value="3" <?= $student['year_level'] == 3 ? 'selected' : '' ?>>3rd Year</option>
                                    <option value="4" <?= $student['year_level'] == 4 ? 'selected' : '' ?>>4th Year</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Regular" <?= $student['status'] == 'Regular' ? 'selected' : '' ?>>Regular</option>
                                    <option value="Irregular" <?= $student['status'] == 'Irregular' ? 'selected' : '' ?>>Irregular</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                            <input type="hidden" value="<?= $student['profile_image']?>" name="former_profile_image">
                            <?php if ($student['profile_image']): ?>
                                <div class="mt-2">
                                    <img src="../<?= $student['profile_image'] ?>" alt="Current Profile Image" class="img-thumbnail" style="max-width: 150px;">
                                    <p class="small text-muted mt-1">Current image</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date Registered</label>
                            <input type="text" class="form-control" 
                                   value="<?= date('M d, Y', strtotime($student['date_registered'])) ?>" readonly>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>