-- Create the database
CREATE DATABASE IF NOT EXISTS enrollment_system;
USE enrollment_system;

-- Create students table
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_number VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    description TEXT,
    credits INT NOT NULL DEFAULT 3,
    capacity INT NOT NULL DEFAULT 30,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create enrollments table
CREATE TABLE IF NOT EXISTS enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, course_id)
) ENGINE=InnoDB;
 
-- Add some sample data
INSERT INTO students (student_number, first_name, last_name, email, phone, address) VALUES
('2023-0001', 'John', 'Doe', 'john.doe@example.com', '1234567890', '123 Main St'),
('2023-0002', 'Jane', 'Smith', 'jane.smith@example.com', '0987654321', '456 Oak Ave'),
('2023-0003', 'Mike', 'Johnson', 'mike.johnson@example.com', '5555555555', '789 Pine Rd');

INSERT INTO courses (course_code, cfourse_name, description, credits, capacity) VALUES
('CS101', 'Introduction to Programming', 'Basic programming concepts using Python', 3, 30),
('CS102', 'Web Development', 'HTML, CSS, and JavaScript fundamentals', 3, 25),
('MATH101', 'College Algebra', 'Basic algebraic concepts and problem solving', 3, 35);