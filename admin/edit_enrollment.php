<?php
require_once 'config.php';

// function generateStudentID($conn)
// {
//     $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
//     $result = mysqli_fetch_assoc($query);
//     $count = $result['total'] + 1;
//     return 'STU-' . date('Y') . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
// }

// Function to save student data
function saveStudent($data, $photoPath)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE students SET 
    first_name = ?, 
    last_name = ?, 
    middle_name = ?, 
    birthdate = ?, 
    gender = ?, 
    email = ?, 
    phone = ?, 
    address = ?, 
    profile_image = ?, 
    program_id = ?, 
    year_level = ?, 
    status = ? 
    WHERE student_id = ?");

    $stmt->bind_param(
        "sssssssssiiss",
        $first_name,
        $last_name,
        $middle_name,
        $birthdate,
        $gender,
        $email,
        $phone,
        $address,
        $profile_image,
        $program_id,
        $year_level,
        $status,
        $student_id
    );

    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $profile_image = $_POST['former_profile_image'];
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $middle_name = $_POST['middle_name'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $program_id = $_POST['program_id'] ?? '';
    $year_level = $_POST['year_level'] ?? '';
    $status = $_POST['status'] ?? '';
    
    // Handle file upload if a new image is provided
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $student_id . '.' . $extension;
        $destination = UPLOAD_DIR . $filename;
        
        // Check if file is an image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (in_array($file['type'], $allowed_types)) {
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // Delete old image if it exists
                if ($profile_image && file_exists($profile_image)) {
                    unlink($profile_image);
                }
                $profile_image = $destination;
            }
        }
    }
    
    $stmt = $conn->prepare("UPDATE students SET 
        first_name = ?, 
        last_name = ?, 
        middle_name = ?, 
        birthdate = ?, 
        gender = ?, 
        email = ?, 
        phone = ?, 
        address = ?, 
        profile_image = ?, 
        program_id = ?, 
        year_level = ?, 
        status = ? 
        WHERE student_id = ?");
    
    $stmt->bind_param(
        "sssssssssiiss",
        $first_name,
        $last_name,
        $middle_name,
        $birthdate,
        $gender,
        $email,
        $phone,
        $address,
        $profile_image,
        $program_id,
        $year_level,
        $status,
        $student_id
    );
    
    if ($stmt->execute()) {
        header("Location: students/index.php");
        exit();
    } else {
        $error = "Error updating student: " . $conn->error;
    }
}
// If we get here, there was an error
header("Location: students/edit.php?error=" . urlencode($error));
exit();
