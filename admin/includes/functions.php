<?php
require_once '../config.php';

// Function to generate student ID
function generateStudentID($conn) {
    $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
    $result = mysqli_fetch_assoc($query);
    $count = $result['total'] + 1;
    return 'STU-' . date('Y') . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
}

// Function to get programs from database
function getPrograms() {
    global $conn;
    $programs = array();
    $sql = "SELECT program_id, program_name FROM programs";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $programs[] = $row;
        }
    }
    return $programs;
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
?>