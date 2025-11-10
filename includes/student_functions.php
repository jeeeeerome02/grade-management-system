<?php
// Helper functions for student-specific queries

function getEnrolledClasses($pdo, $student_id) {
    $stmt = $pdo->prepare("
        SELECT 
            e.enrollment_id,
            c.class_code,
            s.subject_code,
            s.subject_name,
            s.units,
            u.fullname as teacher_name,
            c.schedule,
            c.room,
            c.section,
            e.status
        FROM enrollments e
        JOIN classes c ON e.class_id = c.class_id
        JOIN subjects s ON c.subject_id = s.subject_id
        JOIN users u ON c.teacher_id = u.user_id
        WHERE e.student_id = :student_id AND e.status = 'Enrolled'
        ORDER BY s.subject_name
    ");
    $stmt->execute([':student_id' => $student_id]);
    return $stmt->fetchAll();
}

function getStudentGrades($pdo, $student_id) {
    $stmt = $pdo->prepare("
        SELECT 
            s.subject_name,
            c.class_code,
            g.grade_type,
            g.score,
            g.max_score,
            g.percentage,
            g.date_recorded
        FROM grades g
        JOIN enrollments e ON g.enrollment_id = e.enrollment_id
        JOIN classes c ON e.class_id = c.class_id
        JOIN subjects s ON c.subject_id = s.subject_id
        WHERE e.student_id = :student_id
        ORDER BY g.date_recorded DESC
        LIMIT 10
    ");
    $stmt->execute([':student_id' => $student_id]);
    return $stmt->fetchAll();
}

function getStudentFinalGrades($pdo, $student_id) {
    $stmt = $pdo->prepare("
        SELECT 
            s.subject_name,
            s.subject_code,
            fg.final_grade,
            fg.letter_grade,
            fg.gpa_value,
            fg.remarks
        FROM final_grades fg
        JOIN enrollments e ON fg.enrollment_id = e.enrollment_id
        JOIN classes c ON e.class_id = c.class_id
        JOIN subjects s ON c.subject_id = s.subject_id
        WHERE e.student_id = :student_id
        ORDER BY s.subject_name
    ");
    $stmt->execute([':student_id' => $student_id]);
    return $stmt->fetchAll();
}

function calculateStudentGPA($pdo, $student_id) {
    $stmt = $pdo->prepare("
        SELECT AVG(fg.gpa_value) as gpa
        FROM final_grades fg
        JOIN enrollments e ON fg.enrollment_id = e.enrollment_id
        WHERE e.student_id = :student_id AND fg.gpa_value IS NOT NULL
    ");
    $stmt->execute([':student_id' => $student_id]);
    $result = $stmt->fetch();
    return $result['gpa'] ? round($result['gpa'], 2) : 0.00;
}

function getStudentAnnouncements($pdo, $student_id) {
    $stmt = $pdo->prepare("
        SELECT 
            a.title,
            a.content,
            u.fullname as posted_by,
            a.created_at,
            s.subject_name
        FROM announcements a
        JOIN users u ON a.posted_by = u.user_id
        LEFT JOIN classes c ON a.class_id = c.class_id
        LEFT JOIN subjects s ON c.subject_id = s.subject_id
        WHERE a.target_role IN ('All', 'Student')
        AND (a.class_id IS NULL OR a.class_id IN (
            SELECT class_id FROM enrollments WHERE student_id = :student_id
        ))
        ORDER BY a.created_at DESC
        LIMIT 5
    ");
    $stmt->execute([':student_id' => $student_id]);
    return $stmt->fetchAll();
}
