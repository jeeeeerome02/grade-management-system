# Grade Management System with Descriptive Analytics - Setup Guide

## 🚀 IMPORTANT: Database Setup Required

### Step 1: Create Database and Tables
1. Open **phpMyAdmin** in your browser: http://localhost/phpmyadmin
2. Click on the **SQL** tab at the top
3. Open the file `database/database_setup.sql` in a text editor
4. **Copy ALL the content** from that file
5. **Paste** it into the SQL tab in phpMyAdmin
6. Click the **Go** button to execute

### What This Creates:
✅ Database: `grade_system_db`
✅ 7 Tables: users, subjects, classes, enrollments, grades, final_grades, announcements
✅ Sample data: 5 subjects (MATH101, ENG101, SCI101, HIST101, PE101)
✅ Admin account: ID `ADMIN-001`, Password `admin123`

---

## 🔑 Test the System

### Default Login:
- URL: http://localhost/grade-management-system/login.php
- **ID Number:** ADMIN-001
- **Password:** admin123

### Create Accounts:
- Signup URL: http://localhost/grade-management-system/signup.php
- Create Teacher accounts (Role: Teacher)
- Create Student accounts (Role: Student)

---

## 📊 Features Overview

### Student Features:
✅ View enrolled classes with schedules
✅ Track grades (Quiz, Assignment, Midterm, Final)
✅ Monitor GPA
✅ View announcements
✅ Dashboard with performance analytics

### Teacher Features:
✅ View assigned classes
✅ See enrolled students per class
✅ Track class statistics
✅ View recent grade entries
✅ Dashboard with teaching analytics

### Admin Features:
✅ Full system access
✅ Manage students, teachers, classes
✅ System-wide analytics

---

## 🎨 UI Improvements Made

✨ Modern purple gradient theme
✨ Role-based sidebar navigation
✨ Interactive stat cards with icons
✨ User-friendly login/signup forms
✨ Bootstrap Icons throughout
✨ Responsive design
✨ Role-specific dashboards

---

## ⚠️ If You See Errors:

**"No database selected"**
→ Run the SQL script in phpMyAdmin first!

**"Table doesn't exist"**
→ Make sure ALL the SQL was executed (scroll down in database_setup.sql)

**Login not working**
→ After running SQL, use ID: ADMIN-001, Password: admin123

---

## 📁 File Structure
```
grade-management-system/
├── database/
│   ├── db_config.php          # DB connection
│   └── database_setup.sql     # ⭐ RUN THIS IN PHPMYADMIN
├── includes/
│   ├── header.php             
│   ├── footer.php             
│   ├── sidebar.php            # Role-aware sidebar
│   ├── student_functions.php  # Student queries
│   └── teacher_functions.php  # Teacher queries
├── pages/
│   └── index.php              # Main dashboard
├── login.php                  # ⭐ START HERE
├── signup.php                 
└── SETUP_INSTRUCTIONS.md      # This file
```

---

## 🎯 Quick Start (5 Minutes)

1. **Run SQL** → Open phpMyAdmin → SQL tab → Paste `database_setup.sql` → Go
2. **Login** → http://localhost/grade-management-system/login.php
3. **Use:** ID: `ADMIN-001`, Password: `admin123`
4. **Create** → Make teacher and student accounts via signup
5. **Explore** → Check the role-based dashboards!

---

## 🔧 Technical Details

- **PHP:** 8.2 with PDO (prepared statements)
- **MySQL:** grade_system_db
- **Frontend:** Bootstrap 5.3.2 + Bootstrap Icons
- **Security:** Password hashing, session management
- **Architecture:** Role-based access control

---

## 📈 Next Development Steps

To make this fully functional:
1. Create class management UI (teachers/admins create classes)
2. Create enrollment system (students enroll in classes)
3. Create grade input forms (teachers enter grades)
4. Add Chart.js for visual analytics
5. Add grade distribution charts
6. Add performance trend graphs

Current Status: ✅ Database ready, ✅ UI ready, ✅ Role system ready
Missing: Class creation UI, Enrollment UI, Grade input UI

---

## 💡 Tips

- **Admin account** has full access to test everything
- **Different roles** see different sidebar menus
- **Dashboard** shows real data from database
- **Empty tables?** That's normal - add data through signup or phpMyAdmin
- **Test with multiple accounts** to see role differences

---

## 📞 Need Help?

Check these first:
1. Is XAMPP MySQL running? (Green light in XAMPP Control Panel)
2. Did you run the complete SQL script?
3. Are you using the correct login credentials?
4. Check browser console for JavaScript errors (F12)

Database connection settings in `database/db_config.php`:
- Host: 127.0.0.1
- Database: grade_system_db
- User: root
- Password: (empty)
