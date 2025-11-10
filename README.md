# Grade Management System (Bootstrap + MySQL + PHP 8.2)

## What's Included
- **Secure Session-Based Authentication** using PDO and MySQL
- **Clean Bootstrap 5 UI** for login and signup (no navbar on auth pages)
- **Dashboard** with protected pages (Students, Grades, Classes, Teachers)
- **Database**: `grade_system_db` with `users` table

## Database Setup

### 1. Create the Database
Run the SQL file in phpMyAdmin or MySQL command line:
```bash
mysql -u root -p < database_setup.sql
```

Or manually:
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create database: `grade_system_db`
3. Import `database_setup.sql` or run the SQL inside it

### 2. Database Schema
```
users table:
- user_id (INT, AUTO_INCREMENT, PRIMARY KEY) - hidden in forms
- id_no (VARCHAR, UNIQUE) - Student/Staff ID
- fullname (VARCHAR) - Full name
- email (VARCHAR, UNIQUE) - Login email
- department (VARCHAR) - Department name
- password (VARCHAR) - Hashed password (password_hash)
- school_year (VARCHAR) - School year
- created_at, updated_at (TIMESTAMP)
```

## Configuration

### Update Database Credentials
Edit `db_config.php`:
```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'grade_system_db');
define('DB_USER', 'root');           // Your MySQL username
define('DB_PASS', '');               // Your MySQL password (XAMPP default: empty)
```

## Security Features
✅ **Session Regeneration** - Prevents session fixation attacks  
✅ **Password Hashing** - Uses `password_hash()` and `password_verify()`  
✅ **PDO Prepared Statements** - Prevents SQL injection  
✅ **Secure Session Checks** - `$_SESSION['logged_in']` validation on all protected pages  
✅ **Input Validation** - Server-side validation on all forms  

## How to Run (XAMPP)

1. **Start Services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL

2. **Setup Database**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Import or run `database_setup.sql`

3. **Access the Application**
   - Login: http://localhost/grade-management-system/login.php
   - Signup: http://localhost/grade-management-system/signup.php

4. **Create an Account**
   - Fill in all fields (ID No., Fullname, Email, Department, School Year, Password)
   - Password must be at least 6 characters
   - Click "Create Account"

5. **Login**
   - Use your email and password
   - On success, you'll be redirected to the dashboard

## File Structure
```
grade-management-system/
├── db_config.php          # Database connection (PDO)
├── database_setup.sql     # Database schema
├── login.php              # Secure login page (standalone UI)
├── signup.php             # Secure signup page (standalone UI)
├── logout.php             # Logout and session destroy
├── index.php              # Dashboard (requires login)
├── students.php           # Students management (UI)
├── grades.php             # Grades management (UI)
├── classes.php            # Classes management (UI)
├── teachers.php           # Teachers management (UI)
├── includes/
│   ├── header.php         # Bootstrap header with navbar
│   └── footer.php         # Bootstrap footer
├── css/
│   └── custom.css         # Custom styles
└── js/
    ├── common.js          # Common JavaScript
    └── login.js           # Login validation
```

## Session Variables
After successful login, the following session variables are set:
- `$_SESSION['user_id']` - User ID from database
- `$_SESSION['user']` - User's full name
- `$_SESSION['email']` - User's email
- `$_SESSION['department']` - User's department
- `$_SESSION['logged_in']` - Boolean flag (true)

## Troubleshooting

### "Database connection failed"
- Check if MySQL is running in XAMPP
- Verify database name is `grade_system_db`
- Check credentials in `db_config.php`

### "Table 'users' doesn't exist"
- Run `database_setup.sql` in phpMyAdmin

### Session not persisting
- Check if `session_start()` is at the top of protected pages
- Clear browser cookies/cache

## Production Deployment (Important!)
Before deploying to production:
1. ✅ Enable HTTPS (SSL certificate)
2. ✅ Change default database password
3. ✅ Add CSRF tokens to forms
4. ✅ Enable error logging (disable display_errors)
5. ✅ Add rate limiting on login attempts
6. ✅ Implement password strength requirements
7. ✅ Add email verification on signup
# Grade Management System - UI Documentation

## Overview
A complete, modern Grade Management System UI built with PHP 8.2, HTML5, CSS3, and vanilla JavaScript. This is a **frontend-only** implementation with placeholder backend functions ready for MySQL integration.

## Features

### 🔐 Authentication
- **Login Page** (`login.php`) - Secure login with session management
- **Signup Page** (`signup.php`) - User registration with role assignment
- Demo credentials: `admin` / `password123`
- Password hashing with PHP's `password_hash()`

### 📊 Dashboard (`index.php`)
- Overview statistics (students, classes, teachers, average grades)
- Recent activity table
- Quick action buttons
- Responsive sidebar navigation

### 👨‍🎓 Students Management (`students.php`)
- Student directory table
- Search and filter functionality
- Add/Edit student modals
- Student profiles with:
  - ID, name, grade level
  - Email, phone, address
  - Average grade tracking
  - Status badges

### 📚 Classes Management (`classes.php`)
- Class cards grid layout
- Class information:
  - Class name, code, department
  - Assigned teacher
  - Student enrollment count
  - Schedule
  - Semester
- Add/Edit class forms

### 📊 Grades Management (`grades.php`)
- Grade entry and tracking
- Statistics dashboard
- Filter by class, term, assignment type
- Grade records table with:
  - Student, class, assignment
  - Score, letter grade
  - Performance badges
- Grade entry modal

### 👨‍🏫 Teachers Management (`teachers.php`)
- Teacher directory with profile cards
- Teacher information:
  - Name, department, email
  - Assigned classes count
  - Student count
  - Years of experience
- Add/Edit teacher forms

## File Structure

```
grade-management-system/
├── index.php              # Dashboard (requires login)
├── login.php              # Login page
├── signup.php             # Registration page
├── logout.php             # Logout handler
├── students.php           # Students management
├── classes.php            # Classes management
├── grades.php             # Grades management
├── teachers.php           # Teachers management
├── users.json             # Local user storage (dev only)
├── css/
│   ├── style.css          # Main stylesheet (all components)
│   └── login.css          # Legacy (replaced by style.css)
└── js/
    ├── common.js          # Shared utilities, modals, search
    └── login.js           # Auth form validation
```

## Design System

### Color Palette
- **Primary**: `#1e40af` (Blue) - Main actions, navigation
- **Secondary**: `#0891b2` (Teal) - Accents
- **Success**: `#059669` (Green) - Positive states
- **Warning**: `#d97706` (Orange) - Alerts
- **Danger**: `#dc2626` (Red) - Errors
- **Gray Scale**: `#f9fafb` to `#111827`

### Components
- **Cards**: White background, subtle shadow, rounded corners
- **Buttons**: Primary, Secondary, Success with hover states
- **Badges**: Success, Warning, Danger, Info
- **Tables**: Hover states, responsive scroll
- **Modals**: Overlay, centered, with header/body/footer
- **Forms**: Labeled inputs, grid layout, validation states
- **Sidebar**: Fixed navigation with user profile
- **Topbar**: Page title and action buttons

### Typography
- **Font**: Inter, system fonts fallback
- **Sizes**: 12px–24px with semantic naming
- **Weights**: 400 (regular), 600 (semibold), 700 (bold)

## Installation & Setup

### Prerequisites
- XAMPP (Apache + PHP 8.2)
- Web browser (Chrome, Firefox, Edge, Safari)

### Steps

1. **Copy files to XAMPP**
   ```powershell
   # Files should be in: c:\xampp\htdocs\grade-management-system\
   ```

2. **Start Apache**
   - Open XAMPP Control Panel
   - Click "Start" next to Apache

3. **Access the application**
   ```powershell
   start 'http://localhost/grade-management-system/login.php'
   ```

4. **Login**
   - Username: `admin`
   - Password: `password123`

## Current State (Frontend Only)

### ✅ Completed
- Full UI/UX design system
- Responsive layout (desktop + mobile)
- Session-based authentication
- Modal system
- Search functionality (client-side)
- Form validation
- Navigation system
- User roles (stored in session)

### 🔧 Requires Backend Integration
All CRUD operations currently show alerts. To make functional:

1. **Database Setup**
   - Create MySQL database
   - Design tables: `users`, `students`, `classes`, `grades`, `teachers`
   - Update connection settings

2. **Backend PHP**
   - Replace placeholder functions in `js/common.js`
   - Add AJAX handlers or form submissions
   - Implement:
     - `save_student.php`, `edit_student.php`, `delete_student.php`
     - `save_class.php`, `edit_class.php`, etc.
     - `save_grade.php`, `edit_grade.php`, etc.
     - `save_teacher.php`, `edit_teacher.php`, etc.

3. **Data Loading**
   - Replace hardcoded tables with PHP loops fetching from MySQL
   - Add pagination
   - Implement real-time search (server-side)

## Security Notes

### Current Implementation (Development)
- ✅ Password hashing with `password_hash()`
- ✅ Session-based authentication
- ✅ HTML escaping with `htmlspecialchars()`
- ⚠️ Uses JSON file for users (local dev only)

### Production Recommendations
- Move to MySQL for user storage
- Add CSRF tokens to all forms
- Implement rate limiting on login
- Add input sanitization (prepared statements)
- Enable HTTPS
- Add permission checks (role-based access)
- Implement audit logging
- Add password strength requirements
- Set secure session cookie flags

## Customization

### Change Colors
Edit `:root` variables in `css/style.css`:
```css
:root {
  --primary: #1e40af;     /* Your primary color */
  --secondary: #0891b2;    /* Your secondary color */
  /* ... */
}
```

### Add New Pages
1. Copy structure from existing page (e.g., `students.php`)
2. Update sidebar navigation in all pages
3. Add route handling in new file
4. Add JS functions in `js/common.js`

### Modify Layouts
- **Sidebar width**: `.sidebar { width: 260px; }`
- **Card spacing**: `.stats-grid { gap: 20px; }`
- **Font sizes**: Adjust in `:root` or component classes

## Browser Support
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (responsive design)

## JavaScript Dependencies
**None!** Pure vanilla JavaScript - no jQuery, React, or other libraries required.

## Performance
- Lightweight CSS (~25KB uncompressed)
- Minimal JavaScript (~5KB)
- No external CDN dependencies
- Fast page loads

## Accessibility
- Semantic HTML5 elements
- Form labels and ARIA where needed
- Keyboard navigation support (ESC closes modals)
- Focus states on interactive elements

## Testing Checklist

### ✅ Functional Tests
- [ ] Login with correct credentials
- [ ] Login with incorrect credentials
- [ ] Signup new user
- [ ] Navigate between pages
- [ ] Open/close modals
- [ ] Search functionality
- [ ] Logout

### ✅ UI Tests
- [ ] Responsive on mobile (< 768px)
- [ ] All buttons clickable
- [ ] Forms validate required fields
- [ ] Tables scroll horizontally on small screens
- [ ] Sidebar collapses on mobile

## Next Steps for Full Implementation

1. **Database Schema**
   ```sql
   CREATE TABLE students (
     id INT PRIMARY KEY AUTO_INCREMENT,
     first_name VARCHAR(100),
     last_name VARCHAR(100),
     email VARCHAR(255) UNIQUE,
     grade_level INT,
     phone VARCHAR(20),
     dob DATE,
     address TEXT,
     status ENUM('active', 'inactive'),
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   
   -- Add similar tables for classes, grades, teachers
   ```

2. **API Endpoints**
   - `api/students.php` - GET (list), POST (create)
   - `api/students.php?id=1` - GET (view), PUT (update), DELETE
   - Similar for classes, grades, teachers

3. **AJAX Integration**
   - Replace alert() calls with fetch() or XMLHttpRequest
   - Update tables dynamically without page reload
   - Show loading states

## Support & Credits

**Built for**: School grade management, educational institutions  
**Tech Stack**: PHP 8.2, HTML5, CSS3, Vanilla JS  
**License**: Open for educational use  

## Changelog

### v1.0.0 (Nov 10, 2025)
- Initial UI release
- Complete authentication system
- Dashboard with statistics
- Students, Classes, Grades, Teachers pages
- Responsive design
- Modal system
- Search and filter UI

---

**Note**: This is a UI-only implementation. Backend integration with MySQL is required for production use.
