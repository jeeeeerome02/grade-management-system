<?php
session_start();
// Secure session check: verify user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
$user = htmlspecialchars($_SESSION['user']);
include __DIR__ . '/includes/header.php';
?>

<div class="row mb-3">
  <div class="col-12">
    <h1 class="h3">Dashboard</h1>
    <p class="text-muted">Welcome back, <?php echo $user; ?>.</p>
  </div>
</div>

<div class="row">
  <div class="col-md-3 mb-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Students</h5>
        <p class="card-text">Manage student records.</p>
        <a href="pages/students.php" class="btn btn-outline-primary btn-sm">Open</a>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Grades</h5>
        <p class="card-text">View and input grades.</p>
        <a href="pages/grades.php" class="btn btn-outline-primary btn-sm">Open</a>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Classes</h5>
        <p class="card-text">Manage class lists and schedules.</p>
        <a href="pages/classes.php" class="btn btn-outline-primary btn-sm">Open</a>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-3">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Teachers</h5>
        <p class="card-text">Manage teacher accounts.</p>
        <a href="pages/teachers.php" class="btn btn-outline-primary btn-sm">Open</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
