<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate student ID
    $student_id = generateStudentID();
    
    // Handle file upload
    $photoPath = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $student_id . '.' . $extension;
        $destination = UPLOAD_DIR . $filename;
        
        // Check if file is an image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file['type'], $allowed_types)) {
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $photoPath = $destination;
            }
        }
    }
    
    // Prepare student data
    $student_data = [
        'student_id' => $student_id,
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'middle_name' => $_POST['middle_name'],
        'birthdate' => $_POST['birthdate'],
        'gender' => $_POST['gender'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'program_id' => $_POST['program_id'],
        'year_level' => $_POST['year_level'],
        'status' => $_POST['status']
    ];
    
    // Save to database
    if (saveStudent($student_data, $photoPath)) {
        // Success - redirect to confirmation page
        header("Location: enrollment_success.php?id=" . $student_id);
        exit();
    } else {
        // Error
        $error = "There was an error processing your enrollment. Please try again.";
    }
}

// If we get here, there was an error
header("Location: enrollment_form.php?error=" . urlencode($error));
exit();
?>