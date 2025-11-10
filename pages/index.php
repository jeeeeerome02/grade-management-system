<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { 
    header('Location: ../login.php'); 
    exit; 
}

require_once __DIR__ . '/../database/db_config.php';

$pdo = getDBConnection();
$user_role = $_SESSION['role'] ?? 'Student';
$user_id = $_SESSION['user_id'];

// Load role-specific functions
if ($user_role === 'Student') {
    require_once __DIR__ . '/../includes/student_functions.php';
    $enrolled_classes = getEnrolledClasses($pdo, $user_id);
    $recent_grades = getStudentGrades($pdo, $user_id);
    $final_grades = getStudentFinalGrades($pdo, $user_id);
    $gpa = calculateStudentGPA($pdo, $user_id);
    $announcements = getStudentAnnouncements($pdo, $user_id);
} else {
    require_once __DIR__ . '/../includes/teacher_functions.php';
    $teacher_classes = getTeacherClasses($pdo, $user_id);
    $teacher_stats = getTeacherStats($pdo, $user_id);
    $recent_grade_entries = getRecentGradeEntries($pdo, $user_id, 10);
}

include __DIR__ . '/../includes/header.php';
?>

<style>
  .stat-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  .stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
  }
  .badge-grade {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
  }
  .table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
  }
</style>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="col content-col ps-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
          <p class="text-muted mb-0">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong>!</p>
        </div>
        <div class="text-end">
          <small class="text-muted d-block">School Year: <?php echo htmlspecialchars($_SESSION['school_year'] ?? '2024-2025'); ?></small>
          <small class="text-muted">Department: <?php echo htmlspecialchars($_SESSION['department'] ?? 'N/A'); ?></small>
        </div>
      </div>

      <?php if ($user_role === 'Student'): ?>
        <!-- STUDENT DASHBOARD -->
        
        <!-- GPA and Quick Stats -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="card stat-card text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
              <div class="card-body">
                <div class="stat-icon mx-auto mb-2" style="background: rgba(255,255,255,0.2);">
                  <i class="bi bi-trophy-fill"></i>
                </div>
                <h6 class="mb-1">Current GPA</h6>
                <h2 class="mb-0"><?php echo $gpa; ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card stat-card">
              <div class="card-body text-center">
                <div class="stat-icon mx-auto mb-2" style="background: #dbeafe; color: #1e40af;">
                  <i class="bi bi-book-fill"></i>
                </div>
                <h6 class="text-muted mb-1">Enrolled Classes</h6>
                <h2 class="mb-0"><?php echo count($enrolled_classes); ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card stat-card">
              <div class="card-body text-center">
                <div class="stat-icon mx-auto mb-2" style="background: #d1fae5; color: #065f46;">
                  <i class="bi bi-clipboard-check-fill"></i>
                </div>
                <h6 class="text-muted mb-1">Completed</h6>
                <h2 class="mb-0"><?php echo count($final_grades); ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card stat-card">
              <div class="card-body text-center">
                <div class="stat-icon mx-auto mb-2" style="background: #fef3c7; color: #92400e;">
                  <i class="bi bi-bell-fill"></i>
                </div>
                <h6 class="text-muted mb-1">Announcements</h6>
                <h2 class="mb-0"><?php echo count($announcements); ?></h2>
              </div>
            </div>
          </div>
        </div>

        <!-- Enrolled Classes -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0"><i class="bi bi-journal-bookmark-fill me-2"></i>My Enrolled Classes</h5>
          </div>
          <div class="card-body">
            <?php if (empty($enrolled_classes)): ?>
              <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>You are not enrolled in any classes yet.
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>Class Code</th>
                      <th>Subject</th>
                      <th>Teacher</th>
                      <th>Schedule</th>
                      <th>Room</th>
                      <th>Units</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($enrolled_classes as $class): ?>
                      <tr>
                        <td><strong><?php echo htmlspecialchars($class['class_code']); ?></strong></td>
                        <td><?php echo htmlspecialchars($class['subject_name']); ?></td>
                        <td><?php echo htmlspecialchars($class['teacher_name']); ?></td>
                        <td><?php echo htmlspecialchars($class['schedule'] ?? 'TBA'); ?></td>
                        <td><?php echo htmlspecialchars($class['room'] ?? 'TBA'); ?></td>
                        <td><?php echo htmlspecialchars($class['units']); ?></td>
                        <td><span class="badge bg-success"><?php echo htmlspecialchars($class['status']); ?></span></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="row">
          <!-- Recent Grades -->
          <div class="col-md-7">
            <div class="card mb-4 shadow-sm">
              <div class="card-header bg-white border-0 pt-3">
                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Recent Grades</h5>
              </div>
              <div class="card-body">
                <?php if (empty($recent_grades)): ?>
                  <p class="text-muted">No grades recorded yet.</p>
                <?php else: ?>
                  <div class="table-responsive">
                    <table class="table table-sm table-hover">
                      <thead class="table-light">
                        <tr>
                          <th>Subject</th>
                          <th>Type</th>
                          <th>Score</th>
                          <th>Percentage</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($recent_grades as $grade): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($grade['grade_type']); ?></span></td>
                            <td><?php echo htmlspecialchars($grade['score']); ?>/<?php echo htmlspecialchars($grade['max_score']); ?></td>
                            <td>
                              <?php 
                              $pct = $grade['percentage'];
                              $color = $pct >= 90 ? 'success' : ($pct >= 75 ? 'primary' : 'warning');
                              ?>
                              <span class="badge badge-grade bg-<?php echo $color; ?>"><?php echo round($pct, 2); ?>%</span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($grade['date_recorded'])); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Announcements -->
          <div class="col-md-5">
            <div class="card mb-4 shadow-sm">
              <div class="card-header bg-white border-0 pt-3">
                <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>Announcements</h5>
              </div>
              <div class="card-body">
                <?php if (empty($announcements)): ?>
                  <p class="text-muted">No announcements at this time.</p>
                <?php else: ?>
                  <?php foreach ($announcements as $announcement): ?>
                    <div class="mb-3 pb-3 border-bottom">
                      <h6 class="mb-1"><?php echo htmlspecialchars($announcement['title']); ?></h6>
                      <small class="text-muted d-block mb-2">
                        By <?php echo htmlspecialchars($announcement['posted_by']); ?> • 
                        <?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>
                        <?php if ($announcement['subject_name']): ?>
                          <span class="badge bg-info ms-1"><?php echo htmlspecialchars($announcement['subject_name']); ?></span>
                        <?php endif; ?>
                      </small>
                      <p class="mb-0 small"><?php echo htmlspecialchars(substr($announcement['content'], 0, 100)); ?>...</p>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

      <?php else: ?>
        <!-- TEACHER DASHBOARD -->
        
        <!-- Teacher Stats -->
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="card stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
              <div class="card-body text-center">
                <div class="stat-icon mx-auto mb-2" style="background: rgba(255,255,255,0.2);">
                  <i class="bi bi-book-half"></i>
                </div>
                <h6 class="mb-1">Active Classes</h6>
                <h2 class="mb-0"><?php echo $teacher_stats['total_classes']; ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card stat-card">
              <div class="card-body text-center">
                <div class="stat-icon mx-auto mb-2" style="background: #dbeafe; color: #1e40af;">
                  <i class="bi bi-people-fill"></i>
                </div>
                <h6 class="text-muted mb-1">Total Students</h6>
                <h2 class="mb-0"><?php echo $teacher_stats['total_students']; ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card stat-card">
              <div class="card-body text-center">
                <div class="stat-icon mx-auto mb-2" style="background: #d1fae5; color: #065f46;">
                  <i class="bi bi-bar-chart-fill"></i>
                </div>
                <h6 class="text-muted mb-1">Class Average</h6>
                <h2 class="mb-0"><?php echo $teacher_stats['average_grade']; ?>%</h2>
              </div>
            </div>
          </div>
        </div>

        <!-- My Classes -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0"><i class="bi bi-collection-fill me-2"></i>My Classes</h5>
          </div>
          <div class="card-body">
            <?php if (empty($teacher_classes)): ?>
              <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No classes assigned yet.
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>Class Code</th>
                      <th>Subject</th>
                      <th>Section</th>
                      <th>Schedule</th>
                      <th>Room</th>
                      <th>Enrolled/Max</th>
                      <th>Semester</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($teacher_classes as $class): ?>
                      <tr>
                        <td><strong><?php echo htmlspecialchars($class['class_code']); ?></strong></td>
                        <td><?php echo htmlspecialchars($class['subject_name']); ?></td>
                        <td><?php echo htmlspecialchars($class['section'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($class['schedule'] ?? 'TBA'); ?></td>
                        <td><?php echo htmlspecialchars($class['room'] ?? 'TBA'); ?></td>
                        <td><?php echo $class['enrolled_students']; ?>/<?php echo $class['max_students']; ?></td>
                        <td><?php echo htmlspecialchars($class['semester']); ?></td>
                        <td>
                          <?php 
                          $statusColor = $class['status'] === 'Active' ? 'success' : 'secondary';
                          ?>
                          <span class="badge bg-<?php echo $statusColor; ?>"><?php echo htmlspecialchars($class['status']); ?></span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Recent Grade Entries -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Recent Grade Entries</h5>
          </div>
          <div class="card-body">
            <?php if (empty($recent_grade_entries)): ?>
              <p class="text-muted">No grade entries yet.</p>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-sm table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>Student</th>
                      <th>Subject</th>
                      <th>Type</th>
                      <th>Score</th>
                      <th>Percentage</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($recent_grade_entries as $entry): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($entry['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($entry['subject_name']); ?></td>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($entry['grade_type']); ?></span></td>
                        <td><?php echo htmlspecialchars($entry['score']); ?>/<?php echo htmlspecialchars($entry['max_score']); ?></td>
                        <td>
                          <?php 
                          $pct = $entry['percentage'];
                          $color = $pct >= 90 ? 'success' : ($pct >= 75 ? 'primary' : 'warning');
                          ?>
                          <span class="badge badge-grade bg-<?php echo $color; ?>"><?php echo round($pct, 2); ?>%</span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($entry['date_recorded'])); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>

      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
