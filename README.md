# 🚓 FIR Management System

A modern, professional First Information Report (FIR) management system designed for police stations to digitize their record-keeping.

---

## 📋 Prerequisites

1.  **WAMP Server** (for the MySQL Database).
    *   Make sure the WAMP icon is **GREEN** in your taskbar.

---

## 🚀 How to Run the Project

We have included a portable PHP version so you don't need to install anything extra!

### Step 1: Start the Server
Open your terminal (PowerShell or CMD) in this folder and run:

```powershell
bin\php\php.exe -S localhost:8000
```

### Step 2: Open in Browser
Go to: **[http://localhost:8000](http://localhost:8000)**

---

## 🗄️ Database Setup (First Time Only)

1.  Start **WAMP Server**.
2.  Open **[http://localhost/phpmyadmin](http://localhost/phpmyadmin)**.
3.  Login (Default: Username `root`, Password empty).
4.  Create a new database named `fir_system`.
5.  Click **Import** -> Choose File -> Select `sql/init_mysql.sql` from this project folder.
6.  Click **Go**.

---

## 🔑 Admin Credentials

To access the Admin Dashboard:

*   **URL:** [http://localhost:8000/admin/login.php](http://localhost:8000/admin/login.php)
*   **Username:** `admin`
*   **Password:** `admin123`

---

## 📂 Project Structure

*   `admin/` - Admin dashboard and management logic.
*   `assets/` - CSS, JavaScript, and images.
*   `bin/` - Portable PHP 8.2 environment.
*   `includes/` - Database connection and helper functions.
*   `sql/` - Database initialization script.
*   `*.php` - Frontend pages for users to view and submit FIRs.

---

*College Project Demonstration*
