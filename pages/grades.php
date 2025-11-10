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
        <h2 class="h5">Grades</h2>
        <a href="#" class="btn btn-primary">+ Enter Grades</a>
      </div>

      <div class="card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-sm mb-0">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Class</th>
                  <th>Grade</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Jane Doe</td>
                  <td>Mathematics 101</td>
                  <td>95%</td>
                  <td>Nov 10, 2025</td>
                  <td>
                    <a class="btn btn-sm btn-outline-secondary" href="#">Edit</a>
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
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = htmlspecialchars($_SESSION['user']);
$role = isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : 'Teacher';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Grades — Grade Management System</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="dashboard-layout">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <h2>📚 GradeMS</h2>
        <p>Grade Management</p>
      </div>
      <nav class="sidebar-nav">
        <a href="index.php" class="nav-item">
          <span class="nav-icon">🏠</span>
          <span>Dashboard</span>
        </a>
        <a href="students.php" class="nav-item">
          <span class="nav-icon">👨‍🎓</span>
          <span>Students</span>
        </a>
        <a href="classes.php" class="nav-item">
          <span class="nav-icon">📚</span>
          <span>Classes</span>
        </a>
        <a href="grades.php" class="nav-item active">
          <span class="nav-icon">📊</span>
          <span>Grades</span>
        </a>
        <a href="teachers.php" class="nav-item">
          <span class="nav-icon">👨‍🏫</span>
          <span>Teachers</span>
        </a>
      </nav>
      <div class="sidebar-footer">
        <div class="user-info">
          <div class="user-avatar"><?php echo strtoupper(substr($user, 0, 1)); ?></div>
          <div class="user-details">
            <div class="user-name"><?php echo $user; ?></div>
            <div class="user-role"><?php echo $role; ?></div>
          </div>
        </div>
        <button class="btn-logout" onclick="location.href='logout.php'">Logout</button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <div class="topbar">
        <h1>Grades</h1>
        <div class="topbar-actions">
          <button class="btn btn-primary btn-sm" onclick="openModal('enterGradeModal')">➕ Enter Grade</button>
        </div>
      </div>

      <div class="content-area">
        <!-- Stats -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon green">📈</div>
            <div class="stat-content">
              <div class="stat-label">Average Grade</div>
              <div class="stat-value">85.2%</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon blue">✅</div>
            <div class="stat-content">
              <div class="stat-label">Passing Rate</div>
              <div class="stat-value">92.4%</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon orange">⭐</div>
            <div class="stat-content">
              <div class="stat-label">Honor Students</div>
              <div class="stat-value">187</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon teal">📝</div>
            <div class="stat-content">
              <div class="stat-label">Grades Entered</div>
              <div class="stat-value">2,458</div>
            </div>
          </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="gradeSearch" placeholder="Search by student or class...">
          </div>
          <div class="filter-group">
            <select id="classFilterGrade">
              <option value="">All Classes</option>
              <option value="1">Mathematics 101</option>
              <option value="2">Physics 201</option>
              <option value="3">English Literature</option>
              <option value="4">Chemistry 101</option>
            </select>
            <select id="termFilter">
              <option value="">All Terms</option>
              <option value="midterm">Midterm</option>
              <option value="final">Final</option>
              <option value="quiz">Quiz</option>
            </select>
          </div>
        </div>

        <!-- Grades Table -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Grade Records</h3>
            <span style="color: var(--gray-500); font-size: 14px;">Recent entries</span>
          </div>
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Class</th>
                  <th>Assignment</th>
                  <th>Score</th>
                  <th>Grade</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>John Smith</strong></td>
                  <td>Mathematics 101</td>
                  <td>Midterm Exam</td>
                  <td>92/100</td>
                  <td><strong style="color: var(--success);">A</strong></td>
                  <td>Nov 10, 2025</td>
                  <td><span class="badge badge-success">Excellent</span></td>
                  <td>
                    <button class="btn btn-sm btn-secondary" onclick="editGrade(1)">✏️</button>
                  </td>
                </tr>
                <tr>
                  <td><strong>Emily Johnson</strong></td>
                  <td>Physics 201</td>
                  <td>Lab Report #3</td>
                  <td>88/100</td>
                  <td><strong style="color: var(--success);">B+</strong></td>
                  <td>Nov 10, 2025</td>
                  <td><span class="badge badge-success">Good</span></td>
                  <td>
                    <button class="btn btn-sm btn-secondary" onclick="editGrade(2)">✏️</button>
                  </td>
                </tr>
                <tr>
                  <td><strong>Michael Brown</strong></td>
                  <td>Chemistry 101</td>
                  <td>Quiz #5</td>
                  <td>76/100</td>
                  <td><strong style="color: var(--warning);">C+</strong></td>
                  <td>Nov 9, 2025</td>
                  <td><span class="badge badge-warning">Average</span></td>
                  <td>
                    <button class="btn btn-sm btn-secondary" onclick="editGrade(3)">✏️</button>
                  </td>
                </tr>
                <tr>
                  <td><strong>Sarah Davis</strong></td>
                  <td>English Literature</td>
                  <td>Essay #2</td>
                  <td>95/100</td>
                  <td><strong style="color: var(--success);">A</strong></td>
                  <td>Nov 9, 2025</td>
                  <td><span class="badge badge-success">Excellent</span></td>
                  <td>
                    <button class="btn btn-sm btn-secondary" onclick="editGrade(4)">✏️</button>
                  </td>
                </tr>
                <tr>
                  <td><strong>David Wilson</strong></td>
                  <td>World History</td>
                  <td>Project Presentation</td>
                  <td>82/100</td>
                  <td><strong style="color: var(--success);">B</strong></td>
                  <td>Nov 8, 2025</td>
                  <td><span class="badge badge-success">Good</span></td>
                  <td>
                    <button class="btn btn-sm btn-secondary" onclick="editGrade(5)">✏️</button>
                  </td>
                </tr>
                <tr>
                  <td><strong>Jessica Martinez</strong></td>
                  <td>Biology 102</td>
                  <td>Final Exam</td>
                  <td>89/100</td>
                  <td><strong style="color: var(--success);">B+</strong></td>
                  <td>Nov 8, 2025</td>
                  <td><span class="badge badge-success">Good</span></td>
                  <td>
                    <button class="btn btn-sm btn-secondary" onclick="editGrade(6)">✏️</button>
                  </td>
                </tr>
                <tr>
                  <td><strong>Robert Lee</strong></td>
                  <td>Mathematics 101</td>
                  <td>Homework #8</td>
                  <td>68/100</td>
                  <td><strong style="color: var(--danger);">D+</strong></td>
                  <td>Nov 7, 2025</td>
                  <td><span class="badge badge-danger">Needs Improvement</span></td>
                  <td>
                    <button class="btn btn-sm btn-secondary" onclick="editGrade(7)">✏️</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Enter Grade Modal -->
  <div class="modal" id="enterGradeModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Enter Grade</h3>
        <button class="modal-close" onclick="closeModal('enterGradeModal')">×</button>
      </div>
      <div class="modal-body">
        <form id="enterGradeForm">
          <div class="form-group">
            <label for="studentSelect">Student</label>
            <select id="studentSelect" name="studentSelect" required>
              <option value="">Select Student</option>
              <option value="1">John Smith</option>
              <option value="2">Emily Johnson</option>
              <option value="3">Michael Brown</option>
              <option value="4">Sarah Davis</option>
            </select>
          </div>
          <div class="form-group">
            <label for="classSelect">Class</label>
            <select id="classSelect" name="classSelect" required>
              <option value="">Select Class</option>
              <option value="1">Mathematics 101</option>
              <option value="2">Physics 201</option>
              <option value="3">English Literature</option>
            </select>
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="assignmentType">Assignment Type</label>
              <select id="assignmentType" name="assignmentType" required>
                <option value="">Select Type</option>
                <option value="quiz">Quiz</option>
                <option value="test">Test</option>
                <option value="midterm">Midterm</option>
                <option value="final">Final Exam</option>
                <option value="homework">Homework</option>
                <option value="project">Project</option>
              </select>
            </div>
            <div class="form-group">
              <label for="assignmentName">Assignment Name</label>
              <input type="text" id="assignmentName" name="assignmentName" required>
            </div>
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="score">Score</label>
              <input type="number" id="score" name="score" min="0" max="100" required>
            </div>
            <div class="form-group">
              <label for="maxScore">Max Score</label>
              <input type="number" id="maxScore" name="maxScore" value="100" required>
            </div>
          </div>
          <div class="form-group">
            <label for="comments">Comments (Optional)</label>
            <textarea id="comments" name="comments"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('enterGradeModal')">Cancel</button>
        <button class="btn btn-primary" onclick="saveGrade()">Save Grade</button>
      </div>
    </div>
  </div>

  <script src="js/common.js"></script>
</body>
</html>
