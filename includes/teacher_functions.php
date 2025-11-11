<?php
// Helper functions for teacher-specific queries

function getTeacherClasses($pdo, $teacher_id) {
    $stmt = $pdo->prepare("
        SELECT 
            c.class_id,
            c.class_code,
            s.subject_code,
            s.subject_name,
            c.section,
            c.schedule,
            c.room,
            c.semester,
            c.school_year,
            c.max_students,
            COUNT(e.enrollment_id) as enrolled_students,
            c.status
        FROM classes c
        JOIN subjects s ON c.subject_id = s.subject_id
        LEFT JOIN enrollments e ON c.class_id = e.class_id AND e.status = 'Enrolled'
        WHERE c.teacher_id = :teacher_id
        GROUP BY c.class_id
        ORDER BY c.status = 'Active' DESC, s.subject_name
    ");
    $stmt->execute([':teacher_id' => $teacher_id]);
    return $stmt->fetchAll();
}

function getClassStudents($pdo, $class_id) {
    $stmt = $pdo->prepare("
        SELECT 
            u.user_id,
            u.id_no,
            u.fullname,
            u.email,
            u.department,
            e.enrollment_id,
            e.enrollment_date,
            e.status
        FROM enrollments e
        JOIN users u ON e.student_id = u.user_id
        WHERE e.class_id = :class_id
        ORDER BY u.fullname
    ");
    $stmt->execute([':class_id' => $class_id]);
    return $stmt->fetchAll();
}

function getTeacherStats($pdo, $teacher_id) {
    // Total classes
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM classes WHERE teacher_id = :teacher_id AND status = 'Active'");
    $stmt->execute([':teacher_id' => $teacher_id]);
    $total_classes = $stmt->fetch()['total'];

    // Total students
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT e.student_id) as total
        FROM enrollments e
        JOIN classes c ON e.class_id = c.class_id
        WHERE c.teacher_id = :teacher_id AND e.status = 'Enrolled'
    ");
    $stmt->execute([':teacher_id' => $teacher_id]);
    $total_students = $stmt->fetch()['total'];

    // Average class grade
    $stmt = $pdo->prepare("
        SELECT AVG(fg.final_grade) as avg_grade
        FROM final_grades fg
        JOIN enrollments e ON fg.enrollment_id = e.enrollment_id
        JOIN classes c ON e.class_id = c.class_id
        WHERE c.teacher_id = :teacher_id
    ");
    $stmt->execute([':teacher_id' => $teacher_id]);
    $avg_grade = $stmt->fetch()['avg_grade'];

    return [
        'total_classes' => $total_classes,
        'total_students' => $total_students,
        'average_grade' => $avg_grade ? round($avg_grade, 2) : 0
    ];
}

function getRecentGradeEntries($pdo, $teacher_id, $limit = 10) {
    $stmt = $pdo->prepare("
        SELECT 
            u.fullname as student_name,
            s.subject_name,
            c.class_code,
            g.grade_type,
            g.score,
            g.max_score,
            g.percentage,
            g.date_recorded
        FROM grades g
        JOIN enrollments e ON g.enrollment_id = e.enrollment_id
        JOIN users u ON e.student_id = u.user_id
        JOIN classes c ON e.class_id = c.class_id
        JOIN subjects s ON c.subject_id = s.subject_id
        WHERE c.teacher_id = :teacher_id AND g.recorded_by = :recorded_by
        ORDER BY g.date_recorded DESC
        LIMIT :limit
    ");
    $stmt->bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
    $stmt->bindValue(':recorded_by', $teacher_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
