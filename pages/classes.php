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
        <h2 class="h5">Classes</h2>
        <a href="#" class="btn btn-primary">+ Add Class</a>
      </div>

      <div class="card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th>Class Code</th>
                  <th>Title</th>
                  <th>Teacher</th>
                  <th>Schedule</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>MATH101</td>
                  <td>Mathematics 101</td>
                  <td>Dr. Alan Turing</td>
                  <td>Mon/Wed 09:00 - 10:30</td>
                  <td><a class="btn btn-sm btn-outline-secondary" href="#">Edit</a></td>
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
