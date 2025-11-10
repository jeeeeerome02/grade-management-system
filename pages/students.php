<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { header('Location: ../login.php'); exit; }
include __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col content-col ps-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5">Students</h2>
        <a href="#" class="btn btn-primary">+ Add Student</a>
      </div>

      <div class="card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead>
                <tr>
                  <th>ID No.</th>
                  <th>Fullname</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>S2025-001</td>
                  <td>Jane Doe</td>
                  <td>jane@example.edu</td>
                  <td>Mathematics</td>
                  <td>
                    <a class="btn btn-sm btn-outline-secondary" href="#">Edit</a>
                    <a class="btn btn-sm btn-outline-danger" href="#">Delete</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
