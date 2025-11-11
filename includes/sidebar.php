<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Guest';
$role = isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : 'Student';
$id_no = isset($_SESSION['id_no']) ? htmlspecialchars($_SESSION['id_no']) : 'N/A';

// Role-based badge colors
$role_colors = [
    'Student' => 'primary',
    'Teacher' => 'success',
    'Admin' => 'danger'
];
$badge_color = $role_colors[$role] ?? 'secondary';

// Current page detection
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
  /* Mobile Menu Toggle Button */
  .mobile-menu-toggle {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1050;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .mobile-menu-toggle:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.5);
  }
  
  .mobile-menu-toggle:active {
    transform: scale(0.95);
  }
  
  /* Sidebar Styles */
  .sidebar-col {
    flex: 0 0 280px;
    width: 280px;
    max-width: 280px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow: hidden;
    z-index: 1000;
  }
  
  .sidebar {
    width: 280px;
    height: 100%;
    padding: 20px 15px;
    overflow-y: auto;
    overflow-x: hidden;
  }
  
  /* Hide scrollbar for Chrome, Safari and Opera */
  .sidebar::-webkit-scrollbar {
    width: 6px;
  }
  
  .sidebar::-webkit-scrollbar-track {
    background: transparent;
  }
  
  .sidebar::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
  }
  
  .sidebar::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
  }
  
  /* Add padding to content to account for fixed sidebar */
  .content-col {
    margin-left: 280px;
  }
  
  .sidebar-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
  }
  
  .sidebar-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 700;
    margin: 0 auto;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }
  
  .sidebar-nav .nav-link {
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 4px;
    color: #374151;
    font-weight: 500;
    transition: all 0.2s ease;
  }
  
  .sidebar-nav .nav-link:hover {
    background-color: #f3f4f6;
    color: #667eea;
    transform: translateX(4px);
  }
  
  .sidebar-nav .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }
  
  .sidebar-nav .nav-link i {
    width: 20px;
    margin-right: 8px;
  }
  
  .content-col {
    flex: 1;
    max-width: calc(100% - 280px);
    margin-left: 280px;
  }
  
  /* Mobile Responsive */
  @media (max-width: 991px) {
    .mobile-menu-toggle {
      display: flex;
    }
    
    .sidebar-col {
      position: fixed;
      top: 0;
      left: -280px;
      height: 100vh;
      z-index: 1040;
      background: white;
      transition: left 0.3s ease;
      overflow-y: auto;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    
    .sidebar-col.show {
      left: 0;
    }
    
    .sidebar {
      position: relative;
      top: 0;
      padding: 70px 15px 15px 15px;
    }
    
    .content-col {
      max-width: 100%;
      margin-left: 0;
      padding-left: 1rem !important;
      padding-right: 1rem;
      margin-top: 60px;
    }
    
    /* Overlay for mobile menu */
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1030;
      display: none;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .sidebar-overlay.show {
      display: block;
      opacity: 1;
    }
  }
  
  @media (max-width: 768px) {
    .sidebar-avatar {
      width: 60px;
      height: 60px;
      font-size: 28px;
    }
    
    .sidebar-card {
      margin-bottom: 15px;
    }
  }
</style>

<!-- Mobile Menu Toggle Button -->
<button class="mobile-menu-toggle" id="mobileMenuToggle" onclick="toggleMobileSidebar()">
  <i class="bi bi-list"></i>
</button>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar()"></div>

<div class="col sidebar-col" id="sidebarCol">
  <div class="sidebar">
    <div class="card sidebar-card">
      <div class="card-body p-4">
        <!-- User Profile Section -->
        <div class="text-center mb-4">
          <div class="sidebar-avatar mb-3">
            <?php echo strtoupper(substr($user, 0, 1)); ?>
          </div>
          <h5 class="mb-1 fw-bold"><?php echo $user; ?></h5>
          <p class="text-muted small mb-2"><?php echo $id_no; ?></p>
          <span class="badge bg-<?php echo $badge_color; ?> px-3 py-2">
            <i class="bi bi-shield-fill me-1"></i><?php echo $role; ?>
          </span>
        </div>

        <hr>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav nav flex-column">
          <a class="nav-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?>" href="index.php">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
          
          <?php if ($role === 'Student'): ?>
            <a class="nav-link <?php echo $current_page === 'classes.php' ? 'active' : ''; ?>" href="classes.php">
              <i class="bi bi-journal-bookmark"></i> My Classes
            </a>
            <a class="nav-link <?php echo $current_page === 'grades.php' ? 'active' : ''; ?>" href="grades.php">
              <i class="bi bi-bar-chart-line"></i> My Grades
            </a>
          <?php elseif ($role === 'Teacher'): ?>
            <a class="nav-link <?php echo $current_page === 'classes.php' ? 'active' : ''; ?>" href="classes.php">
              <i class="bi bi-collection"></i> My Classes
            </a>
            <a class="nav-link <?php echo $current_page === 'grades.php' ? 'active' : ''; ?>" href="grades.php">
              <i class="bi bi-pencil-square"></i> Grade Management
            </a>
            <a class="nav-link <?php echo $current_page === 'students.php' ? 'active' : ''; ?>" href="students.php">
              <i class="bi bi-people"></i> Students
            </a>
          <?php else: // Admin ?>
            <a class="nav-link <?php echo $current_page === 'students.php' ? 'active' : ''; ?>" href="students.php">
              <i class="bi bi-people"></i> Students
            </a>
            <a class="nav-link <?php echo $current_page === 'teachers.php' ? 'active' : ''; ?>" href="teachers.php">
              <i class="bi bi-person-badge"></i> Teachers
            </a>
            <a class="nav-link <?php echo $current_page === 'classes.php' ? 'active' : ''; ?>" href="classes.php">
              <i class="bi bi-book"></i> Classes
            </a>
            <a class="nav-link <?php echo $current_page === 'grades.php' ? 'active' : ''; ?>" href="grades.php">
              <i class="bi bi-graph-up"></i> All Grades
            </a>
          <?php endif; ?>
          
          <hr class="my-2">
          
          <a class="nav-link text-danger" href="../logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </nav>
      </div>
    </div>

    <!-- Quick Info Card -->
    <div class="card sidebar-card mt-3">
      <div class="card-body p-3">
        <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Quick Info</h6>
        <small class="d-block text-muted mb-1">
          <i class="bi bi-calendar3 me-2"></i>
          <?php echo date('l, F j, Y'); ?>
        </small>
        <small class="d-block text-muted">
          <i class="bi bi-building me-2"></i>
          <?php echo htmlspecialchars($_SESSION['department'] ?? 'N/A'); ?>
        </small>
      </div>
    </div>
  </div>
</div>
