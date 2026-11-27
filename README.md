# 🏢 HR Management System (HR-RRT)

A web-based Human Resource Management System built with Laravel 10 for managing employee data, attendance, leave, and payroll.

## 📋 About

HR-RRT is a comprehensive Human Resource Management System designed to streamline:
- **Employee Management** - Complete employee information including personal data, employment status, division, and position
- **Attendance** - Recording employee check-in and check-out times
- **Leave Management** - Managing leave requests and leave history
- **Payroll** - Salary calculation, allowances, deductions, and payslip generation

## ✨ Key Features

### 👥 Employee Management
- Full CRUD operations for employee data with photo upload
- Employee search and filtering
- Complete data: biodata, contact, status, division, position, blood type, religion, etc.

### ⏰ Attendance & Smart Camera System
- Real-time webcam face & camera attendance with photo snapshot verification
- Automated biometrics face recognition sync from employee profile photos
- Filter attendance by date and track check-in and check-out times
- Import attendance data from CSV files and sync directly with payroll calculations
- Integrated REST API & standalone Python client for CCTV / edge device integration

### 🏖️ Leave Management
- Record employee leave history
- Leave quota based on employment status
- Leave history per employee

### 💰 Payroll & PPh 21 TER
- Automatic salary calculation with Indonesian PPh 21 TER tax regulation (PP 58/2023 & PMK 168/2023)
- PTKP status categories (Category A, B, C) with automatic bracket evaluation
- Allowances (meal, transport, performance, overtime)
- Deductions (BPJS Ketenagakerjaan & Kesehatan, PPh 21 TER, other deductions)
- Export payslip (PDF with official TER label & Excel)

### 🔐 Role & Permission
- Roles: Admin & User
- Authentication with Laravel Sanctum
- Permission management with Spatie Laravel Permission

## 🛠️ Tech Stack

- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Database**: MySQL
- **Frontend**: Bootstrap 5, jQuery
- **Authentication**: Laravel Sanctum + Spatie Permission
- **PDF**: DomPDF
- **Excel**: PhpSpreadsheet
- **Icons**: Remix Icon, Line Awesome

## 📊 Database Structure

### Main Tables
| Table | Description |
|-------|-----------|
| `users` | User login (admin/user) |
| `employments` | Employee data |
| `employment_statuses` | Status (Intern, Contract, Permanent) |
| `employment_roles` | Position (Dept Head, SPV, Staff, Opt) |
| `employment_divisions` | Division (10 divisions) |
| `absences` | Daily attendance data |
| `history_leaves` | Leave history |
| `benefits` | Salary & allowance data |

### ERD Relationships
```
employment_statuses ──┐
employment_divisions ─┼──► employments ──┬──► absences
employment_roles ─────┘                  ├──► history_leaves
                                         └──► benefits
```

## 🚀 Installation

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM (optional, for compiling assets)

### Installation Steps

1. **Clone Repository**
```bash
git clone https://github.com/SSSalvan/HR-RRT.git
cd HR-RRT
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit `.env` file and configure your database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_database
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migration & Seeder**
```bash
php artisan migrate --seed
```

6. **Storage Link**
```bash
php artisan storage:link
```

7. **Run Development Server**
```bash
php artisan serve
```

The application will run at `http://localhost:8000`

## 👤 Default Credentials

### Admin
- Email: `admin@admin.id`
- Password: `password`

### User
- Email: `user@admin.id`
- Password: `password`

## 📦 Seeders

### Available Default Data:
- **2 Users** (1 Admin, 1 User)
- **3 Employment Status** (Intern, Contract, Permanent)
- **4 Roles** (Dept Head, SPV, Staff, Operational)
- **10 Divisions** (Production, PPIC, QC, QA, R&D, etc.)
- **30 Dummy Employees** with complete and unique data

### Running Seeders:
```bash
# All seeders
php artisan db:seed

# Fresh migration + seeder
php artisan migrate:fresh --seed

# Specific seeder
php artisan db:seed --class=EmploymentSeeder
```

## 📁 Project Structure

```
hr_rev/
├── app/
│   ├── Http/Controllers/    # Controllers
│   ├── Models/              # Eloquent Models
│   ├── Exports/             # Excel Exports
│   └── helpers.php          # Helper Functions
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/             # Database Seeders
├── public/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript
│   └── images/              # Images & uploads
├── resources/
│   └── views/               # Blade Templates
└── routes/
    ├── web.php              # Web Routes
    └── api.php              # API Routes
```

## 🎯 Usage

### Employee Management
1. Login as Admin
2. Navigate to **Employee** → **List Employee**
3. Add, edit, or delete employee data

### Attendance Import
1. Navigate to **Absence** → **List Absence**
2. Upload CSV file with the required format
3. Attendance data will be automatically saved

### Payroll
1. Navigate to **Benefit** → **List Employee**
2. Select employee and period
3. Input salary and allowance data
4. Export payslip (PDF/Excel)
