<?php
// Secure signup using MySQL (PDO) and password_hash
// DB: grade_system_db, table: users (user_id, id_no, fullname, email, department, password, school_year)
session_start();

require_once __DIR__ . '/database/db_config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_no = isset($_POST['id_no']) ? trim($_POST['id_no']) : '';
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $department = isset($_POST['department']) ? trim($_POST['department']) : '';
  $role = isset($_POST['role']) ? trim($_POST['role']) : 'Student';
    $school_year = isset($_POST['school_year']) ? trim($_POST['school_year']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

    if ($id_no === '' || $fullname === '' || $email === '' || $department === '' || $school_year === '' || $password === '' || $password2 === '') {
        $error = 'All fields are required.';
    } elseif ($password !== $password2) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        try {
            $pdo = getDBConnection();
            
            // Check if email or id_no already exists
            $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = :email OR id_no = :id_no LIMIT 1');
            $stmt->execute([':email' => $email, ':id_no' => $id_no]);
            if ($stmt->fetch()) {
                $error = 'A user with that email or ID No. already exists.';
            } else {
                // Insert new user with hashed password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
          $stmt = $pdo->prepare('INSERT INTO users (id_no, fullname, email, department, role, password, school_year) VALUES (:id_no, :fullname, :email, :department, :role, :password, :school_year)');
          $stmt->execute([
            ':id_no' => $id_no,
            ':fullname' => $fullname,
            ':email' => $email,
            ':department' => $department,
            ':role' => $role,
            ':password' => $password_hash,
            ':school_year' => $school_year
          ]);
                
                header('Location: login.php?registered=1'); 
                exit;
            }
        } catch (PDOException $e) {
            $error = 'An error occurred during registration. Please try again.';
            // In production, log $e->getMessage() securely
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up — Grade Management System with Descriptive Analytics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { 
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
      min-height: 100vh; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      padding: 40px 15px;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .signup-card { 
      max-width: 720px; 
      width: 100%;
    }
    .card {
      border-radius: 20px;
      border: none;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .card-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 20px 20px 0 0 !important;
      padding: 2rem 1.5rem;
      border: none;
    }
    .card-header h3 {
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 0.25rem;
    }
    .card-header p {
      opacity: 0.95;
      font-size: 0.95rem;
      margin: 0;
    }
    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      border: none;
      padding: 14px;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
    }
    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }
    .form-control, .form-select {
      border-radius: 10px;
      border: 2px solid #e5e7eb;
      padding: 12px 16px;
      transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .form-label {
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.5rem;
    }
    a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
    }
    a:hover {
      color: #764ba2;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card signup-card mx-auto">
          <div class="card-header text-center">
            <h3><i class="bi bi-graph-up-arrow"></i> Grade Management System</h3>
            <p>with Descriptive Analytics</p>
          </div>
          <div class="card-body p-4">
            <h5 class="text-center mb-4 text-muted">Create your account</h5>
            
            <?php if ($error): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <form method="post" action="signup.php" id="signupForm">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-person-badge me-2"></i>ID Number</label>
                  <input type="text" name="id_no" class="form-control" placeholder="e.g. 2025-001" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-person me-2"></i>Full Name</label>
                  <input type="text" name="fullname" class="form-control" placeholder="Jane Doe" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-envelope me-2"></i>Email Address</label>
                  <input type="email" name="email" class="form-control" placeholder="you@school.edu" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-building me-2"></i>Department</label>
                  <input type="text" name="department" class="form-control" placeholder="e.g. Mathematics" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-calendar-check me-2"></i>School Year</label>
                  <input type="text" name="school_year" class="form-control" placeholder="e.g. 2024-2025" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-shield-check me-2"></i>Role</label>
                  <select name="role" class="form-select" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="Student">Student</option>
                    <option value="Teacher">Teacher</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-lock-fill me-2"></i>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label"><i class="bi bi-lock-fill me-2"></i>Confirm Password</label>
                  <input type="password" name="password2" class="form-control" placeholder="Re-enter password" required>
                </div>
              </div>

              <div class="d-grid mb-3">
                <button class="btn btn-success btn-lg" type="submit">
                  <i class="bi bi-person-plus me-2"></i>Create Account
                </button>
              </div>
            </form>

            <hr class="my-4">
            <p class="text-center mb-0">
              <i class="bi bi-box-arrow-in-right me-1"></i>
              Already have an account? <a href="login.php">Sign in here</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
