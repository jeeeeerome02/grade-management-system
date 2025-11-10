// Common JS for the UI (placeholder for future features)
document.addEventListener('DOMContentLoaded', function(){
  // simple auto-dismiss alerts after 5s
  var alerts = document.querySelectorAll('.alert');
  alerts.forEach(function(a){ setTimeout(function(){ a.classList.add('fade'); a.addEventListener('transitionend', function(){ a.remove(); }); }, 5000); });
});
// Grade Management System - Common JavaScript
// Modal management, search, and interactive components

// Modal functions
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

// Close modal on background click
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('modal') && e.target.classList.contains('active')) {
    closeModal(e.target.id);
  }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    const activeModal = document.querySelector('.modal.active');
    if (activeModal) {
      closeModal(activeModal.id);
    }
  }
});

// Search functionality (placeholder - would connect to backend)
function setupSearch(inputId, tableSelector) {
  const searchInput = document.getElementById(inputId);
  if (!searchInput) return;
  
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.querySelector(tableSelector);
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(function(row) {
      const text = row.textContent.toLowerCase();
      if (text.includes(searchTerm)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
}

// Initialize search on page load
document.addEventListener('DOMContentLoaded', function() {
  setupSearch('studentSearch', 'table');
  setupSearch('classSearch', 'table');
  setupSearch('gradeSearch', 'table');
  setupSearch('teacherSearch', 'table');
});

// Student management functions (placeholders)
function editStudent(id) {
  alert('Edit student #' + id + '\n\nThis would open an edit form with the student\'s data.\n(Backend integration required)');
}

function viewStudent(id) {
  alert('View student #' + id + '\n\nThis would show detailed student information.\n(Backend integration required)');
}

function saveStudent() {
  alert('Student saved!\n\nThis would submit the form to the backend.\n(Backend integration required)');
  closeModal('addStudentModal');
}

// Class management functions (placeholders)
function editClass(id) {
  alert('Edit class #' + id + '\n\nThis would open an edit form with the class data.\n(Backend integration required)');
}

function viewClass(id) {
  alert('View class #' + id + '\n\nThis would show detailed class information and enrolled students.\n(Backend integration required)');
}

function saveClass() {
  alert('Class saved!\n\nThis would submit the form to the backend.\n(Backend integration required)');
  closeModal('addClassModal');
}

// Grade management functions (placeholders)
function editGrade(id) {
  alert('Edit grade #' + id + '\n\nThis would open an edit form with the grade data.\n(Backend integration required)');
}

function saveGrade() {
  alert('Grade saved!\n\nThis would submit the form to the backend.\n(Backend integration required)');
  closeModal('enterGradeModal');
}

// Teacher management functions (placeholders)
function editTeacher(id) {
  alert('Edit teacher #' + id + '\n\nThis would open an edit form with the teacher\'s data.\n(Backend integration required)');
}

function viewTeacher(id) {
  alert('View teacher #' + id + '\n\nThis would show detailed teacher information and assigned classes.\n(Backend integration required)');
}

function saveTeacher() {
  alert('Teacher saved!\n\nThis would submit the form to the backend.\n(Backend integration required)');
  closeModal('addTeacherModal');
}

// Form validation helper
function validateForm(formId) {
  const form = document.getElementById(formId);
  if (!form) return false;
  
  const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
  let valid = true;
  
  inputs.forEach(function(input) {
    if (!input.value.trim()) {
      valid = false;
      input.style.borderColor = '#dc2626';
    } else {
      input.style.borderColor = '';
    }
  });
  
  return valid;
}

// Sidebar toggle for mobile
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  if (sidebar) {
    sidebar.classList.toggle('active');
  }
}

// Add mobile menu button functionality if needed
document.addEventListener('DOMContentLoaded', function() {
  // Check if we're on mobile
  if (window.innerWidth <= 768) {
    const topbar = document.querySelector('.topbar');
    if (topbar && !document.querySelector('.menu-toggle')) {
      const menuBtn = document.createElement('button');
      menuBtn.className = 'btn btn-icon menu-toggle';
      menuBtn.innerHTML = '☰';
      menuBtn.style.marginRight = '12px';
      menuBtn.onclick = toggleSidebar;
      topbar.insertBefore(menuBtn, topbar.firstChild);
    }
  }
});

// Table sorting (optional enhancement)
function sortTable(table, column, asc = true) {
  const tbody = table.querySelector('tbody');
  const rows = Array.from(tbody.querySelectorAll('tr'));
  
  rows.sort((a, b) => {
    const aText = a.children[column].textContent.trim();
    const bText = b.children[column].textContent.trim();
    
    return asc ? aText.localeCompare(bText) : bText.localeCompare(aText);
  });
  
  rows.forEach(row => tbody.appendChild(row));
}

// Console message
console.log('%c📚 Grade Management System', 'font-size: 20px; color: #1e40af; font-weight: bold;');
console.log('%cUI Framework loaded successfully', 'color: #059669;');
console.log('%cNote: Backend integration required for full functionality', 'color: #d97706;');
