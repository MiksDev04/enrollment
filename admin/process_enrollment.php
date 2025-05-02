<?php
require_once 'config.php';

function generateStudentID($conn) {
    $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
    $result = mysqli_fetch_assoc($query);
    $count = $result['total'] + 1;
    return 'STU-' . date('Y') . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
}

// Function to save student data
function saveStudent($data, $photoPath) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO students (
        student_id, first_name, last_name, middle_name, birthdate, 
        gender, email, phone, address, profile_image, 
        program_id, year_level, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param(
        "ssssssssssiis",
        $data['student_id'],
        $data['first_name'],
        $data['last_name'],
        $data['middle_name'],
        $data['birthdate'],
        $data['gender'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $photoPath,
        $data['program_id'],
        $data['year_level'],
        $data['status']
    );
    
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate student ID
    $student_id = generateStudentID($conn);
    
    // Handle file upload
    $photoPath = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $student_id . '.' . $extension;
        $destination =  UPLOAD_DIR . $filename;
        
        // Check if file is an image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (in_array($file['type'], $allowed_types)) {
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $photoPath = $destination;
            }
        }
    }
    echo "<script>alert(" . json_encode($photoPath) . ");</script>";

    
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
        header("Location: students/index.php");
        exit();
    } else {
        // Error
        $error = "There was an error processing your enrollment. Please try again.";
    }
}

// If we get here, there was an error
header("Location: students/create.php?error=" . urlencode($error));
exit();
?>