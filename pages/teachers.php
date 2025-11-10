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
        <h2 class="h5">Teachers</h2>
        <a href="#" class="btn btn-primary">+ Add Teacher</a>
      </div>

      <div class="card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Dr. Alan Turing</td>
                  <td>alan@school.edu</td>
                  <td>Computer Science</td>
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
  <title>Teachers — Grade Management System</title>
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
        <a href="grades.php" class="nav-item">
          <span class="nav-icon">📊</span>
          <span>Grades</span>
        </a>
        <a href="teachers.php" class="nav-item active">
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
        <h1>Teachers</h1>
        <div class="topbar-actions">
          <button class="btn btn-primary btn-sm" onclick="openModal('addTeacherModal')">➕ Add Teacher</button>
        </div>
      </div>

      <div class="content-area">
        <!-- Toolbar -->
        <div class="toolbar">
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="teacherSearch" placeholder="Search teachers by name or department...">
          </div>
          <div class="filter-group">
            <select id="deptFilter">
              <option value="">All Departments</option>
              <option value="math">Mathematics</option>
              <option value="science">Science</option>
              <option value="english">English</option>
              <option value="history">History</option>
            </select>
          </div>
        </div>

        <!-- Teachers Grid -->
        <div class="stats-grid">
          <div class="card">
            <div style="text-align: center; margin-bottom: 16px;">
              <div style="width: 80px; height: 80px; margin: 0 auto 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">DS</div>
              <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Dr. Sarah Smith</h3>
              <p style="margin: 0 0 8px; color: var(--gray-500); font-size: 13px;">Mathematics Department</p>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                <div>
                  <div style="color: var(--gray-500);">Email</div>
                  <div style="font-weight: 600; color: var(--gray-800);">s.smith@school.edu</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Classes</div>
                  <div style="font-weight: 600; color: var(--gray-800);">4 classes</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Students</div>
                  <div style="font-weight: 600; color: var(--gray-800);">128 students</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Experience</div>
                  <div style="font-weight: 600; color: var(--gray-800);">12 years</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editTeacher(1)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewTeacher(1)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="text-align: center; margin-bottom: 16px;">
              <div style="width: 80px; height: 80px; margin: 0 auto 12px; background: linear-gradient(135deg, var(--success), var(--secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">PJ</div>
              <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Prof. Paul Johnson</h3>
              <p style="margin: 0 0 8px; color: var(--gray-500); font-size: 13px;">Science Department</p>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                <div>
                  <div style="color: var(--gray-500);">Email</div>
                  <div style="font-weight: 600; color: var(--gray-800);">p.johnson@school.edu</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Classes</div>
                  <div style="font-weight: 600; color: var(--gray-800);">3 classes</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Students</div>
                  <div style="font-weight: 600; color: var(--gray-800);">95 students</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Experience</div>
                  <div style="font-weight: 600; color: var(--gray-800);">8 years</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editTeacher(2)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewTeacher(2)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="text-align: center; margin-bottom: 16px;">
              <div style="width: 80px; height: 80px; margin: 0 auto 12px; background: linear-gradient(135deg, var(--warning), var(--danger)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">MD</div>
              <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Ms. Maria Davis</h3>
              <p style="margin: 0 0 8px; color: var(--gray-500); font-size: 13px;">English Department</p>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                <div>
                  <div style="color: var(--gray-500);">Email</div>
                  <div style="font-weight: 600; color: var(--gray-800);">m.davis@school.edu</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Classes</div>
                  <div style="font-weight: 600; color: var(--gray-800);">5 classes</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Students</div>
                  <div style="font-weight: 600; color: var(--gray-800);">142 students</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Experience</div>
                  <div style="font-weight: 600; color: var(--gray-800);">15 years</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editTeacher(3)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewTeacher(3)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="text-align: center; margin-bottom: 16px;">
              <div style="width: 80px; height: 80px; margin: 0 auto 12px; background: linear-gradient(135deg, var(--primary), var(--danger)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">RW</div>
              <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Dr. Robert Wilson</h3>
              <p style="margin: 0 0 8px; color: var(--gray-500); font-size: 13px;">Science Department</p>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                <div>
                  <div style="color: var(--gray-500);">Email</div>
                  <div style="font-weight: 600; color: var(--gray-800);">r.wilson@school.edu</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Classes</div>
                  <div style="font-weight: 600; color: var(--gray-800);">3 classes</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Students</div>
                  <div style="font-weight: 600; color: var(--gray-800);">87 students</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Experience</div>
                  <div style="font-weight: 600; color: var(--gray-800);">10 years</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editTeacher(4)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewTeacher(4)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="text-align: center; margin-bottom: 16px;">
              <div style="width: 80px; height: 80px; margin: 0 auto 12px; background: linear-gradient(135deg, var(--secondary), var(--success)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">JM</div>
              <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Mr. James Martinez</h3>
              <p style="margin: 0 0 8px; color: var(--gray-500); font-size: 13px;">History Department</p>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                <div>
                  <div style="color: var(--gray-500);">Email</div>
                  <div style="font-weight: 600; color: var(--gray-800);">j.martinez@school.edu</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Classes</div>
                  <div style="font-weight: 600; color: var(--gray-800);">4 classes</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Students</div>
                  <div style="font-weight: 600; color: var(--gray-800);">112 students</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Experience</div>
                  <div style="font-weight: 600; color: var(--gray-800);">6 years</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editTeacher(5)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewTeacher(5)">👁️ View</button>
            </div>
          </div>

          <div class="card">
            <div style="text-align: center; margin-bottom: 16px;">
              <div style="width: 80px; height: 80px; margin: 0 auto 12px; background: linear-gradient(135deg, var(--danger), var(--warning)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">LT</div>
              <h3 style="margin: 0 0 4px; font-size: 18px; color: var(--gray-800);">Dr. Linda Taylor</h3>
              <p style="margin: 0 0 8px; color: var(--gray-500); font-size: 13px;">Science Department</p>
              <span class="badge badge-success">Active</span>
            </div>
            <div style="padding: 12px 0; border-top: 1px solid var(--gray-200); margin-bottom: 12px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;">
                <div>
                  <div style="color: var(--gray-500);">Email</div>
                  <div style="font-weight: 600; color: var(--gray-800);">l.taylor@school.edu</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Classes</div>
                  <div style="font-weight: 600; color: var(--gray-800);">3 classes</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Students</div>
                  <div style="font-weight: 600; color: var(--gray-800);">91 students</div>
                </div>
                <div>
                  <div style="color: var(--gray-500);">Experience</div>
                  <div style="font-weight: 600; color: var(--gray-800);">9 years</div>
                </div>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="btn btn-sm btn-secondary" onclick="editTeacher(6)">✏️ Edit</button>
              <button class="btn btn-sm btn-secondary" onclick="viewTeacher(6)">👁️ View</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Add Teacher Modal -->
  <div class="modal" id="addTeacherModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add New Teacher</h3>
        <button class="modal-close" onclick="closeModal('addTeacherModal')">×</button>
      </div>
      <div class="modal-body">
        <form id="addTeacherForm">
          <div class="form-grid">
            <div class="form-group">
              <label for="teacherFirstName">First Name</label>
              <input type="text" id="teacherFirstName" name="teacherFirstName" required>
            </div>
            <div class="form-group">
              <label for="teacherLastName">Last Name</label>
              <input type="text" id="teacherLastName" name="teacherLastName" required>
            </div>
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="teacherEmail">Email</label>
              <input type="email" id="teacherEmail" name="teacherEmail" required>
            </div>
            <div class="form-group">
              <label for="teacherDepartment">Department</label>
              <select id="teacherDepartment" name="teacherDepartment" required>
                <option value="">Select Department</option>
                <option value="math">Mathematics</option>
                <option value="science">Science</option>
                <option value="english">English</option>
                <option value="history">History</option>
              </select>
            </div>
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="teacherPhone">Phone</label>
              <input type="tel" id="teacherPhone" name="teacherPhone">
            </div>
            <div class="form-group">
              <label for="teacherExperience">Years of Experience</label>
              <input type="number" id="teacherExperience" name="teacherExperience" min="0">
            </div>
          </div>
          <div class="form-group">
            <label for="teacherBio">Biography (Optional)</label>
            <textarea id="teacherBio" name="teacherBio"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('addTeacherModal')">Cancel</button>
        <button class="btn btn-primary" onclick="saveTeacher()">Add Teacher</button>
      </div>
    </div>
  </div>

  <script src="js/common.js"></script>
</body>
</html>
