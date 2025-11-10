<?php
// Secure session-based login using MySQL (PDO) and password_verify
// DB: grade_system_db, table: users
session_start();

require_once __DIR__ . '/database/db_config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_no = isset($_POST['id_no']) ? trim($_POST['id_no']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($id_no === '' || $password === '') {
        $error = 'Please enter both ID No. and password.';
    } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare('SELECT user_id, id_no, fullname, email, department, password, school_year, role FROM users WHERE id_no = :id_no LIMIT 1');
            $stmt->execute([':id_no' => $id_no]);
            $user = $stmt->fetch();

            if (!$user) {
                $error = 'Invalid ID No. or password.';
            } else {
                // Verify password (assumes password column stores password_hash output)
                if (!password_verify($password, $user['password'])) {
                    $error = 'Invalid ID No. or password.';
                } else {
                    // Secure session: regenerate session ID to prevent fixation attacks
                    session_regenerate_id(true);
                    
                    // Store user info in session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user'] = $user['fullname'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['id_no'] = $user['id_no'];
                    $_SESSION['role'] = isset($user['role']) ? $user['role'] : 'Student';
                    $_SESSION['department'] = $user['department'];
                    $_SESSION['logged_in'] = true;
                    
                    header('Location: pages/index.php'); 
                    exit;
                }
            }
        } catch (PDOException $e) {
            $error = 'An error occurred. Please try again later.';
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
  <title>Login — Grade Management System with Descriptive Analytics</title>
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
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .login-card { 
      max-width: 480px; 
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
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      padding: 14px;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
    .form-control {
      border-radius: 10px;
      border: 2px solid #e5e7eb;
      padding: 12px 16px;
      transition: all 0.3s ease;
    }
    .form-control:focus {
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
    .input-group-text {
      background: white;
      border: 2px solid #e5e7eb;
      border-right: none;
      border-radius: 10px 0 0 10px;
    }
    .input-group .form-control {
      border-left: none;
      border-radius: 0 10px 10px 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card login-card mx-auto">
          <div class="card-header text-center">
            <h3><i class="bi bi-graph-up-arrow"></i> Grade Management System</h3>
            <p>with Descriptive Analytics</p>
          </div>
          <div class="card-body p-4">
            <h5 class="text-center mb-4 text-muted">Sign in to your account</h5>
            
            <?php if ($error): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <?php if (isset($_GET['registered'])): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>Registration successful. Please log in.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <form method="post" action="login.php" id="loginForm">
              <div class="mb-4">
                <label class="form-label"><i class="bi bi-person-badge me-2"></i>ID Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-hash"></i></span>
                  <input type="text" name="id_no" class="form-control" placeholder="Enter your ID number" required autofocus>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label"><i class="bi bi-lock-fill me-2"></i>Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-key"></i></span>
                  <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
              </div>
              <div class="d-grid mb-3">
                <button class="btn btn-primary btn-lg" type="submit">
                  <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
              </div>
            </form>

            <hr class="my-4">
            <p class="text-center mb-0">
              <i class="bi bi-person-plus me-1"></i>
              Don't have an account? <a href="signup.php">Create one here</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>