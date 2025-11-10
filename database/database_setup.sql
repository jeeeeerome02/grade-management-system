-- Grade Management System with Descriptive Analytics
-- Database: grade_system_db
-- Run this in phpMyAdmin or MySQL command line

CREATE DATABASE IF NOT EXISTS grade_system_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE grade_system_db;

-- 1. Users table (authentication for both students and teachers)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    id_no VARCHAR(50) NOT NULL UNIQUE,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    department VARCHAR(100) NOT NULL,
    role ENUM('Student', 'Teacher', 'Admin') NOT NULL DEFAULT 'Student',
    password VARCHAR(255) NOT NULL COMMENT 'password_hash() output',
    school_year VARCHAR(20) NOT NULL,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_id_no (id_no),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Subjects table
CREATE TABLE IF NOT EXISTS subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(20) NOT NULL UNIQUE,
    subject_name VARCHAR(255) NOT NULL,
    description TEXT,
    units INT DEFAULT 3,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Classes table (specific instances of subjects taught by teachers)
CREATE TABLE IF NOT EXISTS classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_code VARCHAR(50) NOT NULL UNIQUE,
    subject_id INT NOT NULL,
    teacher_id INT NOT NULL,
    section VARCHAR(50),
    schedule VARCHAR(255),
    room VARCHAR(50),
    school_year VARCHAR(20) NOT NULL,
    semester ENUM('1st Semester', '2nd Semester', 'Summer') NOT NULL,
    max_students INT DEFAULT 40,
    status ENUM('Active', 'Completed', 'Cancelled') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_teacher (teacher_id),
    INDEX idx_school_year (school_year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Enrollments table (students enrolled in classes)
CREATE TABLE IF NOT EXISTS enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    class_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Enrolled', 'Dropped', 'Completed') DEFAULT 'Enrolled',
    FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, class_id),
    INDEX idx_student (student_id),
    INDEX idx_class (class_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Grades table
CREATE TABLE IF NOT EXISTS grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_id INT NOT NULL,
    grade_type ENUM('Quiz', 'Assignment', 'Midterm', 'Final', 'Project', 'Attendance') NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    max_score DECIMAL(5,2) NOT NULL,
    percentage DECIMAL(5,2) GENERATED ALWAYS AS ((score / max_score) * 100) STORED,
    remarks TEXT,
    date_recorded DATE NOT NULL,
    recorded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(enrollment_id) ON DELETE CASCADE,
    FOREIGN KEY (recorded_by) REFERENCES users(user_id),
    INDEX idx_enrollment (enrollment_id),
    INDEX idx_type (grade_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Final grades table (computed final grades per class)
CREATE TABLE IF NOT EXISTS final_grades (
    final_grade_id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_id INT NOT NULL,
    midterm_grade DECIMAL(5,2),
    final_exam_grade DECIMAL(5,2),
    final_grade DECIMAL(5,2) NOT NULL,
    letter_grade VARCHAR(5),
    gpa_value DECIMAL(3,2),
    remarks ENUM('Passed', 'Failed', 'Incomplete', 'Withdrawn') DEFAULT 'Passed',
    computed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(enrollment_id) ON DELETE CASCADE,
    UNIQUE KEY unique_final_grade (enrollment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Announcements table
CREATE TABLE IF NOT EXISTS announcements (
    announcement_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    posted_by INT NOT NULL,
    target_role ENUM('All', 'Student', 'Teacher') DEFAULT 'All',
    class_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES users(user_id),
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE CASCADE,
    INDEX idx_created (created_at DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample subjects
INSERT INTO subjects (subject_code, subject_name, description, units) VALUES
('MATH101', 'Mathematics 101', 'Basic Mathematics', 3),
('ENG101', 'English 101', 'English Composition', 3),
('SCI101', 'Science 101', 'Introduction to Science', 3),
('HIST101', 'History 101', 'World History', 3),
('PE101', 'Physical Education', 'Physical Fitness', 2);

-- Insert sample admin user (password: admin123)
INSERT INTO users (id_no, fullname, email, department, role, password, school_year) VALUES
('ADMIN-001', 'System Administrator', 'admin@school.edu', 'Administration', 'Admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-2025');
