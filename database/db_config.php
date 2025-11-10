<?php
// Database configuration for grade_system_db (MySQL via PDO)
// PHP 8.2 compatible, session-based secure login

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'grade_system_db');
define('DB_USER', 'root');           // Change to your MySQL username
define('DB_PASS', '');               // Change to your MySQL password (XAMPP default is empty)
define('DB_CHARSET', 'utf8mb4');

function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // In production, log this error securely, don't expose to user
        die("Database connection failed. Please contact administrator.");
    }
}
