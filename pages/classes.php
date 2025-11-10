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
  <title>Classes — Grade Management System</title>
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
        <a href="classes.php" class="nav-item active">
          <span class="nav-icon">📚</span>
          <span>Classes</span>
        </a>
        <a href="grades.php" class="nav-item">
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
        <h1>Classes</h1>
        <div class="topbar-actions">
          <button class="btn btn-primary btn-sm" onclick="openModal('addClassModal')">➕ Add Class</button>
        </div>
      </div>

      <div class="content-area">
        <!-- Toolbar -->
        <div class="toolbar">
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="classSearch" placeholder="Search classes by name or code...">
          </div>
          <div class="filter-group">
            <select id="departmentFilter">
              <option value="">All Departments</option>
              <option value="math">Mathematics</option>
              <option value="science">Science</option>
              <option value="english">English</option>
              <option value="history">History</option>
            </select>
            <select id="semesterFilter">
              <option value="">All Semesters</option>
              <option value="fall">Fall 2025</option>
              <option value="spring">Spring 2026</option>
            </select>
          </div>
        </div>

        <!-- Classes Grid -->
        <div class="stats-grid">
          <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
              <div>
                <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Mathematics 101</h3>
                <p style="margin: 0; color: var(--gray-500); font-size: 13px;">MAT-101 • Fall 2025</p>
              </div>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: flex; gap: 20px; font-size: 14px;">
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Students</div>
                  <div style="font-weight: 700; color: var(--gray-800);">32</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Teacher</div>
                  <div style="font-weight: 600; color: var(--gray-800);">Dr. Smith</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Schedule</div>
                  <div style="font-weight: 600; color: var(--gray-800);">MWF 9:00</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editClass(1)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewClass(1)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
              <div>
                <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Physics 201</h3>
                <p style="margin: 0; color: var(--gray-500); font-size: 13px;">PHY-201 • Fall 2025</p>
              </div>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: flex; gap: 20px; font-size: 14px;">
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Students</div>
                  <div style="font-weight: 700; color: var(--gray-800);">28</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Teacher</div>
                  <div style="font-weight: 600; color: var(--gray-800);">Prof. Johnson</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Schedule</div>
                  <div style="font-weight: 600; color: var(--gray-800);">TTh 10:30</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editClass(2)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewClass(2)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
              <div>
                <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">English Literature</h3>
                <p style="margin: 0; color: var(--gray-500); font-size: 13px;">ENG-301 • Fall 2025</p>
              </div>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: flex; gap: 20px; font-size: 14px;">
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Students</div>
                  <div style="font-weight: 700; color: var(--gray-800);">25</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Teacher</div>
                  <div style="font-weight: 600; color: var(--gray-800);">Ms. Davis</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Schedule</div>
                  <div style="font-weight: 600; color: var(--gray-800);">MWF 2:00</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editClass(3)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewClass(3)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
              <div>
                <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Chemistry 101</h3>
                <p style="margin: 0; color: var(--gray-500); font-size: 13px;">CHM-101 • Fall 2025</p>
              </div>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: flex; gap: 20px; font-size: 14px;">
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Students</div>
                  <div style="font-weight: 700; color: var(--gray-800);">30</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Teacher</div>
                  <div style="font-weight: 600; color: var(--gray-800);">Dr. Wilson</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Schedule</div>
                  <div style="font-weight: 600; color: var(--gray-800);">TTh 1:00</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editClass(4)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewClass(4)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
              <div>
                <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">World History</h3>
                <p style="margin: 0; color: var(--gray-500); font-size: 13px;">HIS-201 • Fall 2025</p>
              </div>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: flex; gap: 20px; font-size: 14px;">
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Students</div>
                  <div style="font-weight: 700; color: var(--gray-800);">27</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Teacher</div>
                  <div style="font-weight: 600; color: var(--gray-800);">Mr. Martinez</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Schedule</div>
                  <div style="font-weight: 600; color: var(--gray-800);">MWF 11:00</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editClass(5)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewClass(5)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
              <div>
                <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Biology 102</h3>
                <p style="margin: 0; color: var(--gray-500); font-size: 13px;">BIO-102 • Fall 2025</p>
              </div>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: flex; gap: 20px; font-size: 14px;">
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Students</div>
                  <div style="font-weight: 700; color: var(--gray-800);">29</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Teacher</div>
                  <div style="font-weight: 600; color: var(--gray-800);">Dr. Taylor</div>
                </div>
                <div>
                  <div style="color: var(--gray-500); font-size: 12px;">Schedule</div>
                  <div style="font-weight: 600; color: var(--gray-800);">MWF 3:00</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editClass(6)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewClass(6)">👁️ View</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Add Class Modal -->
  <div class="modal" id="addClassModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add New Class</h3>
        <button class="modal-close" onclick="closeModal('addClassModal')">×</button>
      </div>
      <div class="modal-body">
        <form id="addClassForm">
          <div class="form-grid">
            <div class="form-group">
              <label for="className">Class Name</label>
              <input type="text" id="className" name="className" required>
            </div>
            <div class="form-group">
              <label for="classCode">Class Code</label>
              <input type="text" id="classCode" name="classCode" required>
            </div>
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="department">Department</label>
              <select id="department" name="department" required>
                <option value="">Select Department</option>
                <option value="math">Mathematics</option>
                <option value="science">Science</option>
                <option value="english">English</option>
                <option value="history">History</option>
              </select>
            </div>
            <div class="form-group">
              <label for="teacher">Teacher</label>
              <select id="teacher" name="teacher" required>
                <option value="">Select Teacher</option>
                <option value="1">Dr. Smith</option>
                <option value="2">Prof. Johnson</option>
                <option value="3">Ms. Davis</option>
              </select>
            </div>
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="schedule">Schedule</label>
              <input type="text" id="schedule" name="schedule" placeholder="e.g., MWF 9:00">
            </div>
            <div class="form-group">
              <label for="semester">Semester</label>
              <select id="semester" name="semester" required>
                <option value="fall">Fall 2025</option>
                <option value="spring">Spring 2026</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('addClassModal')">Cancel</button>
        <button class="btn btn-primary" onclick="saveClass()">Add Class</button>
      </div>
    </div>
  </div>

  <script src="js/common.js"></script>
</body>
</html>
