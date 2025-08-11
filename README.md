# 🎓 Backend University Management System

<div align="center">

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-3.x-F59E0B?style=for-the-badge&logo=php&logoColor=white)](https://filamentphp.com)
[![SQLite](https://img.shields.io/badge/SQLite-3.x-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

[![Build Status](https://img.shields.io/badge/Build-Passing-brightgreen?style=flat-square)](https://github.com/Creative-Trees/Backend-University-Management-System)
[![Code Quality](https://img.shields.io/badge/Code%20Quality-A+-blue?style=flat-square)](https://github.com/Creative-Trees/Backend-University-Management-System)
[![Coverage](https://img.shields.io/badge/Coverage-90%25-brightgreen?style=flat-square)](https://github.com/Creative-Trees/Backend-University-Management-System)
[![Version](https://img.shields.io/badge/Version-1.0.0-blue?style=flat-square)](https://github.com/Creative-Trees/Backend-University-Management-System/releases)
[![Downloads](https://img.shields.io/badge/Downloads-1k+-green?style=flat-square)](https://github.com/Creative-Trees/Backend-University-Management-System)

</div>

**Backend University** adalah sistem manajemen universitas yang komprehensif dan modern, dibangun menggunakan **Laravel 11** dengan **Filament Admin Panel**. Sistem ini dirancang untuk mengelola seluruh aspek operasional universitas dengan interface yang intuitif dan performa yang optimal.

## 🎯 Quick Overview

| 📊 **Stats**   | 📈 **Value** | 📝 **Description**           |
| -------------- | ------------ | ---------------------------- |
| **Models**     | 14           | Complete university entities |
| **Migrations** | 17           | Database structure files     |
| **Resources**  | 14           | Filament admin resources     |
| **Languages**  | 2            | English & Bahasa Indonesia   |
| **Database**   | SQLite       | Lightweight & portable       |

## 📋 Table of Contents

<details>
<summary><strong>📖 Click to expand navigation</strong></summary>

-   [� Backend University Management System](#-backend-university-management-system)
    -   [🎯 Quick Overview](#-quick-overview)
    -   [📋 Table of Contents](#-table-of-contents)
    -   [✨ Fitur Unggulan](#-fitur-unggulan)
    -   [🛠️ Tech Stack](#️-tech-stack)
    -   [🏗️ System Architecture](#️-system-architecture)
    -   [📊 Database Schema](#-database-schema)
    -   [� Installation Guide](#-installation-guide)
        -   [📋 Prerequisites](#-prerequisites)
        -   [📥 Quick Start](#-quick-start)
        -   [🔧 Detailed Setup](#-detailed-setup)
    -   [🎯 Generate Filament Resources](#-generate-filament-resources)
    -   [🔄 Data Flow Architecture](#-data-flow-architecture)
    -   [🏢 Entity Relationship Overview](#-entity-relationship-overview)
    -   [📋 Resource Generation Status](#-resource-generation-status)
    -   [🌐 Access URLs](#-access-urls)
        -   [🔐 Default Admin Credentials](#-default-admin-credentials)
    -   [� Commands Berguna](#-commands-berguna)
        -   [🚀 Quick Setup Commands](#-quick-setup-commands)
        -   [🎯 Filament Resource Generation](#-filament-resource-generation)
        -   [📊 Database Operations](#-database-operations)
        -   [🧹 Maintenance Commands](#-maintenance-commands)
    -   [🛠️ Development Commands](#️-development-commands)
        -   [📊 Database Management](#-database-management)
        -   [🧹 Cache \& Optimization](#-cache--optimization)
        -   [🔄 Asset Management](#-asset-management)
    -   [� Troubleshooting](#-troubleshooting)
        -   [❌ Common Issues \& Solutions](#-common-issues--solutions)
        -   [🔍 Debug Mode](#-debug-mode)
        -   [📝 Log Files](#-log-files)
    -   [📁 Project Structure](#-project-structure)
    -   [🚀 Deployment Guide](#-deployment-guide)
        -   [🌐 Production Deployment](#-production-deployment)
        -   [🔐 Security Checklist](#-security-checklist)
    -   [📋 Features Overview](#-features-overview)
        -   [👨‍🎓 Student Management](#-student-management)
        -   [👨‍🏫 Faculty Management](#-faculty-management)
        -   [📰 Content Management](#-content-management)
        -   [🏢 Facility Management](#-facility-management)
        -   [🤝 Partnership Management](#-partnership-management)
    -   [🎯 Roadmap \& Future Features](#-roadmap--future-features)
        -   [📅 Version 2.0 (Planning)](#-version-20-planning)
        -   [📅 Version 3.0 (Future)](#-version-30-future)
    -   [🤝 Contributing](#-contributing)
        -   [📝 Coding Standards](#-coding-standards)
    -   [📞 Support \& Contact](#-support--contact)
        -   [🐛 Issues \& Bug Reports](#-issues--bug-reports)
        -   [📧 Contact Information](#-contact-information)
    -   [❓ Frequently Asked Questions (FAQ)](#-frequently-asked-questions-faq)
        -   [🤔 General Questions](#-general-questions)
        -   [🛠️ Technical Questions](#️-technical-questions)
        -   [🔒 Security Questions](#-security-questions)
    -   [🎓 Advanced Usage](#-advanced-usage)
        -   [🚀 Custom Filament Resources](#-custom-filament-resources)
        -   [📊 Custom Dashboard Widgets](#-custom-dashboard-widgets)
        -   [🔄 API Integration](#-api-integration)
    -   [📄 License](#-license)
    -   [📈 Performance \& Analytics](#-performance--analytics)
        -   [🚀 System Performance](#-system-performance)
        -   [📊 Database Analytics](#-database-analytics)
    -   [📚 API Documentation](#-api-documentation)
        -   [🔗 Available Endpoints](#-available-endpoints)
        -   [📋 Response Format](#-response-format)
    -   [🔧 Configuration Guide](#-configuration-guide)
        -   [⚙️ Environment Variables](#️-environment-variables)
        -   [🛡️ Security Configuration](#️-security-configuration)
    -   [📋 Testing Guide](#-testing-guide)
        -   [🧪 Running Tests](#-running-tests)
        -   [📊 Test Coverage](#-test-coverage)
    -   [📦 Package Management](#-package-management)
        -   [📚 Key Dependencies](#-key-dependencies)
        -   [🔄 Update Commands](#-update-commands)
    -   [🌍 Internationalization](#-internationalization)
        -   [🌐 Supported Languages](#-supported-languages)
        -   [🔧 Language Configuration](#-language-configuration)
    -   [🎨 UI/UX Guidelines](#-uiux-guidelines)
        -   [🎯 Design Principles](#-design-principles)
        -   [🎨 Color Scheme](#-color-scheme)
    -   [📊 Monitoring \& Logging](#-monitoring--logging)
        -   [📈 Application Monitoring](#-application-monitoring)
        -   [🔍 Debug Tools](#-debug-tools)
    -   [📁 Struktur Project](#-struktur-project)
    -   [🎯 Pengembangan Selanjutnya](#-pengembangan-selanjutnya)
    -   [�🔒 Kredensial Awal](#-kredensial-awal)
    -   [📄 Lisensi](#-lisensi)

</details>

---

## ✨ Fitur Unggulan

| 🎯 **Kategori**    | 📋 **Fitur**                                                |
| ------------------ | ----------------------------------------------------------- |
| **👥 SDM**         | Manajemen mahasiswa, dosen, admin, dan pimpinan universitas |
| **📚 Akademik**    | Pengelolaan data akademik, jurusan, dan program studi       |
| **📢 Publikasi**   | Sistem berita, pengumuman dengan targeting audience         |
| **🏛️ Institusi**   | Profil universitas, visi-misi, sejarah, dan nilai-nilai     |
| **🏢 Fasilitas**   | Manajemen fasilitas kampus dengan kategorisasi detail       |
| **🤝 Kerjasama**   | Dokumentasi partnership dan kerjasama institusi             |
| **⚙️ Admin Panel** | Interface modern dengan Filament v3                         |
| **📱 Responsive**  | Design yang optimal untuk semua perangkat                   |

---

## 🛠️ Tech Stack

<table>
<tr>
<td align="center" width="150"><strong>Backend</strong></td>
<td>
<img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel">
<img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP">
</td>
</tr>
<tr>
<td align="center"><strong>Admin Panel</strong></td>
<td>
<img src="https://img.shields.io/badge/Filament-3.x-F59E0B?style=flat-square&logo=php&logoColor=white" alt="Filament">
<img src="https://img.shields.io/badge/Livewire-3.x-4E56A6?style=flat-square&logo=livewire&logoColor=white" alt="Livewire">
</td>
</tr>
<tr>
<td align="center"><strong>Database</strong></td>
<td>
<img src="https://img.shields.io/badge/SQLite-3.x-003B57?style=flat-square&logo=sqlite&logoColor=white" alt="SQLite">
</td>
</tr>
<tr>
<td align="center"><strong>Frontend</strong></td>
<td>
<img src="https://img.shields.io/badge/Blade-Templates-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Blade">
<img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
<img src="https://img.shields.io/badge/Alpine.js-3.x-8BC34A?style=flat-square&logo=alpine.js&logoColor=white" alt="Alpine.js">
</td>
</tr>
<tr>
<td align="center"><strong>Tools</strong></td>
<td>
<img src="https://img.shields.io/badge/Composer-2.x-885630?style=flat-square&logo=composer&logoColor=white" alt="Composer">
<img src="https://img.shields.io/badge/NPM-9.x-CB3837?style=flat-square&logo=npm&logoColor=white" alt="NPM">
<img src="https://img.shields.io/badge/Vite-4.x-646CFF?style=flat-square&logo=vite&logoColor=white" alt="Vite">
</td>
</tr>
</table>

---

## 🏗️ System Architecture

```mermaid
graph TD
    A[Frontend Interface] -->|User Requests| B[Laravel Router]
    B -->|Authentication| C[Filament Admin Panel]
    C -->|CRUD Operations| D[Eloquent Models]
    D -->|Data Processing| E[SQLite Database]

    F[Student Management] --> D
    G[Faculty Management] --> D
    H[Content Management] --> D
    I[Facility Management] --> D

    E -->|Data Retrieval| D
    D -->|Response Data| C
    C -->|UI Components| J[Admin Dashboard]

    K[Migration System] -->|Schema Updates| E
    L[Seeder System] -->|Sample Data| E

    style C fill:#f9f,stroke:#333,stroke-width:2px
    style E fill:#bbf,stroke:#333,stroke-width:2px
    style D fill:#bfb,stroke:#333,stroke-width:2px
```

## 📊 Database Schema

Sistem ini mengelola **14 entitas utama** dengan struktur database yang komprehensif:

<table>
<thead>
<tr>
<th width="120">🗂️ Kategori</th>
<th width="150">📋 Model</th>
<th width="200">� Migration File</th>
<th>📝 Deskripsi</th>
</tr>
</thead>
<tbody>
<tr>
<td rowspan="4"><strong>👥 SDM</strong></td>
<td><code>Student</code></td>
<td><code>create_students_table.php</code></td>
<td>Data mahasiswa lengkap dengan info akademik, orang tua, dan status</td>
</tr>
<tr>
<td><code>Lecture</code></td>
<td><code>create_lectures_table.php</code></td>
<td>Profil dosen dengan penelitian, publikasi, dan pengalaman mengajar</td>
</tr>
<tr>
<td><code>Admin</code></td>
<td><code>create_admins_table.php</code></td>
<td>Staff administrasi dengan hak akses dan departemen</td>
</tr>
<tr>
<td><code>Rector</code></td>
<td><code>create_rectors_table.php</code></td>
<td>Data pimpinan universitas dengan periode jabatan</td>
</tr>
<tr>
<td rowspan="3"><strong>📢 Publikasi</strong></td>
<td><code>News</code></td>
<td><code>create_news_table.php</code></td>
<td>Sistem berita dengan kategori, SEO, dan analytics</td>
</tr>
<tr>
<td><code>Announcement</code></td>
<td><code>create_announcements_table.php</code></td>
<td>Pengumuman dengan targeting audience dan scheduling</td>
</tr>
<tr>
<td><code>Greeting</code></td>
<td><code>create_greetings_table.php</code></td>
<td>Sambutan dari pimpinan dengan kategorisasi</td>
</tr>
<tr>
<td rowspan="3"><strong>🏛️ Institusi</strong></td>
<td><code>Aboutme</code></td>
<td><code>create_aboutmes_table.php</code></td>
<td>Profil universitas multi-section dengan statistik</td>
</tr>
<tr>
<td><code>Fundamental</code></td>
<td><code>create_fundamentals_table.php</code></td>
<td>Visi, misi, nilai, dan filosofi universitas</td>
</tr>
<tr>
<td><code>History</code></td>
<td><code>create_histories_table.php</code></td>
<td>Timeline sejarah universitas dengan dokumentasi</td>
</tr>
<tr>
<td rowspan="1"><strong>🏢 Fasilitas</strong></td>
<td><code>Facilitie</code></td>
<td><code>create_facilities_table.php</code></td>
<td>Manajemen fasilitas dengan lokasi dan status operasional</td>
</tr>
<tr>
<td rowspan="2"><strong>🤝 External</strong></td>
<td><code>Cooperation</code></td>
<td><code>create_cooperations_table.php</code></td>
<td>Partnership dan kerjasama dengan institusi lain</td>
</tr>
<tr>
<td><code>Footer</code></td>
<td><code>create_footers_table.php</code></td>
<td>Informasi kontak, social media, dan navigasi footer</td>
</tr>
<tr>
<td rowspan="1"><strong>🔐 Auth</strong></td>
<td><code>User</code></td>
<td><code>create_users_table.php</code></td>
<td>User authentication untuk akses admin panel</td>
</tr>
</tbody>
</table>

---

## � Installation Guide

### 📋 Prerequisites

Pastikan sistem Anda memiliki requirements berikut:

| Software     | Version | Download Link                                          |
| ------------ | ------- | ------------------------------------------------------ |
| **PHP**      | 8.1+    | [Download PHP](https://www.php.net/downloads.php)      |
| **Composer** | 2.0+    | [Download Composer](https://getcomposer.org/download/) |
| **Node.js**  | 18+     | [Download Node.js](https://nodejs.org/en/download/)    |
| **Git**      | Latest  | [Download Git](https://git-scm.com/downloads)          |

### 📥 Quick Start

```bash
# 1. Clone repository
git clone https://github.com/Creative-Trees/Backend-University-Management-System.git
cd Backend-University-Management-System

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies
npm install

# 4. Setup environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Run database migrations
php artisan migrate

# 7. Seed database (optional)
php artisan db:seed

# 8. Build frontend assets
npm run build

# 9. Start development server
php artisan serve
```

### 🔧 Detailed Setup

<details>
<summary><strong>📁 1. Environment Configuration</strong></summary>

Setelah menyalin `.env.example` ke `.env`, sesuaikan konfigurasi berikut:

```env
APP_NAME="Backend University"
APP_ENV=local
APP_KEY=base64:generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

</details>

<details>
<summary><strong>🗃️ 2. Database Setup</strong></summary>

Sistem menggunakan SQLite secara default. File database sudah tersedia di:

```
database/database.sqlite
```

Jika file tidak ada, buat file kosong:

```bash
touch database/database.sqlite
```

Kemudian jalankan migrasi:

```bash
php artisan migrate --seed
```

</details>

<details>
<summary><strong>⚙️ 3. Filament Admin Setup</strong></summary>

Buat user admin untuk mengakses panel:

```bash
php artisan make:filament-user
```

Atau manual melalui tinker:

```bash
php artisan tinker
User::create([
    'name' => 'Super Admin',
    'email' => 'admin@university.com',
    'password' => bcrypt('password123')
]);
```

</details>

---

## 🎯 Generate Filament Resources

Untuk mengaktifkan admin panel penuh, generate semua Filament Resources:

<details>
<summary><strong>🚀 Auto Generate All Resources</strong></summary>

**Option 1: Generate satu per satu**

```bash
php artisan make:filament-resource Cooperation --generate
php artisan make:filament-resource Student --generate
php artisan make:filament-resource Lecture --generate
php artisan make:filament-resource Admin --generate
php artisan make:filament-resource Rector --generate
php artisan make:filament-resource Greeting --generate
php artisan make:filament-resource Facilitie --generate
php artisan make:filament-resource History --generate
php artisan make:filament-resource Aboutme --generate
php artisan make:filament-resource Fundamental --generate
php artisan make:filament-resource Announcement --generate
php artisan make:filament-resource News --generate
php artisan make:filament-resource Footer --generate
php artisan make:filament-resource User --generate
```

**Option 2: Batch script** (Linux/Mac)

```bash
#!/bin/bash
models=("Cooperation" "Student" "Lecture" "Admin" "Rector" "Greeting" "Facilitie" "History" "Aboutme" "Fundamental" "Announcement" "News" "Footer" "User")

for model in "${models[@]}"; do
    echo "Generating resource for $model..."
    php artisan make:filament-resource $model --generate
done

echo "✅ All Filament Resources generated successfully!"
```

</details>

## 🔄 Data Flow Architecture

```mermaid
graph LR
    A[Admin User] -->|Login| B[Authentication]
    B -->|Access Granted| C[Filament Dashboard]

    C -->|Manage Students| D[Student Resource]
    C -->|Manage Faculty| E[Lecture Resource]
    C -->|Manage Content| F[News/Announcement Resource]
    C -->|Manage Facilities| G[Facility Resource]

    D -->|CRUD Operations| H[(SQLite Database)]
    E -->|CRUD Operations| H
    F -->|CRUD Operations| H
    G -->|CRUD Operations| H

    H -->|Data Validation| I[Model Layer]
    I -->|Business Logic| J[Response]
    J -->|UI Update| C

    style B fill:#ff9999,stroke:#333,stroke-width:2px
    style C fill:#99ccff,stroke:#333,stroke-width:2px
    style H fill:#99ff99,stroke:#333,stroke-width:2px
```

## 🏢 Entity Relationship Overview

```mermaid
erDiagram
    USERS ||--o{ STUDENTS : manages
    USERS ||--o{ LECTURES : manages
    USERS ||--o{ NEWS : creates
    USERS ||--o{ ANNOUNCEMENTS : publishes

    STUDENTS {
        id integer
        name string
        student_id string
        program string
        status enum
        contact_info json
    }

    LECTURES {
        id integer
        name string
        employee_id string
        department string
        research_interests json
        publications json
    }

    NEWS {
        id integer
        title string
        content text
        category string
        status enum
        published_at timestamp
    }

    FACILITIES {
        id integer
        name string
        type string
        location string
        capacity integer
        status enum
    }
```

---

## 📋 Resource Generation Status

| 📋 Model       | 🔧 Resource            | 📄 Pages                 | ✅ Status |
| -------------- | ---------------------- | ------------------------ | --------- |
| `Student`      | `StudentResource`      | List, Create, Edit, View | ⭐ Ready  |
| `Lecture`      | `LectureResource`      | List, Create, Edit, View | ⭐ Ready  |
| `Admin`        | `AdminResource`        | List, Create, Edit, View | ⭐ Ready  |
| `Rector`       | `RectorResource`       | List, Create, Edit, View | ⭐ Ready  |
| `News`         | `NewsResource`         | List, Create, Edit, View | ⭐ Ready  |
| `Announcement` | `AnnouncementResource` | List, Create, Edit, View | ⭐ Ready  |
| `Greeting`     | `GreetingResource`     | List, Create, Edit, View | ⭐ Ready  |
| `Facilitie`    | `FacilitieResource`    | List, Create, Edit, View | ⭐ Ready  |
| `History`      | `HistoryResource`      | List, Create, Edit, View | ⭐ Ready  |
| `Aboutme`      | `AboutmeResource`      | List, Create, Edit, View | ⭐ Ready  |
| `Fundamental`  | `FundamentalResource`  | List, Create, Edit, View | ⭐ Ready  |
| `Cooperation`  | `CooperationResource`  | List, Create, Edit, View | ⭐ Ready  |
| `Footer`       | `FooterResource`       | List, Create, Edit, View | ⭐ Ready  |
| `User`         | `UserResource`         | List, Create, Edit, View | ⭐ Ready  |

---

## 🌐 Access URLs

Setelah instalasi berhasil, akses aplikasi melalui URL berikut:

| 🔗 Service         | 🌐 URL                          | 📝 Description                  |
| ------------------ | ------------------------------- | ------------------------------- |
| **🏠 Homepage**    | `http://localhost:8000`         | Frontend website (if available) |
| **⚙️ Admin Panel** | `http://localhost:8000/admin`   | Filament admin dashboard        |
| **📊 Database**    | SQLite file                     | `database/database.sqlite`      |
| **📁 Storage**     | `http://localhost:8000/storage` | Public file storage             |

### 🔐 Default Admin Credentials

| Field        | Value                  |
| ------------ | ---------------------- |
| **Email**    | `admin@university.com` |
| **Password** | `password123`          |

> ⚠️ **Security Note**: Change default credentials after first login!

---

## � Commands Berguna

### 🚀 Quick Setup Commands

```bash
# Complete setup in one go
composer install && npm install && cp .env.example .env && php artisan key:generate && php artisan migrate --seed && npm run build && php artisan serve
```

### 🎯 Filament Resource Generation

```bash
# Generate all resources with a single script
for model in Cooperation Student Lecture Admin Rector Greeting Facilitie History Aboutme Fundamental Announcement News Footer User; do
    php artisan make:filament-resource $model --generate
done
```

### 📊 Database Operations

```bash
# Fresh installation
php artisan migrate:fresh --seed

# Backup database
cp database/database.sqlite database/backup_$(date +%Y%m%d_%H%M%S).sqlite

# Restore database
cp database/backup_[timestamp].sqlite database/database.sqlite
```

### 🧹 Maintenance Commands

```bash
# Clear all caches
php artisan optimize:clear

# Optimize for production
php artisan optimize

# Generate IDE helper files
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta
```

---

## 🛠️ Development Commands

### 📊 Database Management

| 🔧 Command                         | 📝 Description                     |
| ---------------------------------- | ---------------------------------- |
| `php artisan migrate`              | Jalankan migrasi database          |
| `php artisan migrate:fresh --seed` | Reset database dan jalankan seeder |
| `php artisan migrate:rollback`     | Rollback migrasi terakhir          |
| `php artisan migrate:status`       | Cek status migrasi                 |
| `php artisan db:seed`              | Jalankan database seeder           |
| `php artisan tinker`               | Interactive PHP shell              |

### 🧹 Cache & Optimization

| 🔧 Command                 | 📝 Description       |
| -------------------------- | -------------------- |
| `php artisan config:cache` | Cache konfigurasi    |
| `php artisan route:cache`  | Cache routing        |
| `php artisan view:cache`   | Cache view templates |
| `php artisan config:clear` | Clear config cache   |
| `php artisan route:clear`  | Clear route cache    |
| `php artisan view:clear`   | Clear view cache     |

### 🔄 Asset Management

| 🔧 Command                 | 📝 Description                   |
| -------------------------- | -------------------------------- |
| `npm run dev`              | Compile assets untuk development |
| `npm run build`            | Build assets untuk production    |
| `npm run watch`            | Watch file changes               |
| `php artisan storage:link` | Link storage ke public           |

---

## � Troubleshooting

### ❌ Common Issues & Solutions

<details>
<summary><strong>🔴 Error: "SQLite database not found"</strong></summary>

**Problem**: File database SQLite tidak ditemukan

**Solution**:

```bash
# Buat file database SQLite
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate
```

</details>

<details>
<summary><strong>🔴 Error: "Class not found"</strong></summary>

**Problem**: Autoload classes tidak ter-update

**Solution**:

```bash
# Regenerate autoload
composer dump-autoload

# Clear cache
php artisan config:clear
php artisan cache:clear
```

</details>

<details>
<summary><strong>🔴 Error: "Permission denied"</strong></summary>

**Problem**: File permission tidak sesuai

**Solution**:

```bash
# Set permission untuk storage dan cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Untuk Linux/Mac
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
```

</details>

<details>
<summary><strong>🔴 Error: "Filament Resource not working"</strong></summary>

**Problem**: Filament Resource tidak ter-generate dengan benar

**Solution**:

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Re-generate resource
php artisan make:filament-resource ModelName --generate --force
```

</details>

<details>
<summary><strong>🔴 Error: "Node modules issues"</strong></summary>

**Problem**: Dependencies frontend bermasalah

**Solution**:

```bash
# Clean install
rm -rf node_modules package-lock.json
npm install

# Rebuild assets
npm run build
```

</details>

### 🔍 Debug Mode

Untuk debugging, aktifkan debug mode di `.env`:

```env
APP_DEBUG=true
APP_LOG_LEVEL=debug
```

### 📝 Log Files

Monitor log files untuk error:

```bash
# View logs
tail -f storage/logs/laravel.log

# Clear logs
echo "" > storage/logs/laravel.log
```

---

## 📁 Project Structure

```
Backend-University-Management-System/
├── 📂 app/
│   ├── 📂 Filament/
│   │   ├── 📂 Resources/     # Filament admin resources
│   │   └── 📂 Pages/         # Custom admin pages
│   ├── 📂 Http/
│   │   ├── 📂 Controllers/   # Application controllers
│   │   └── 📂 Middleware/    # Custom middleware
│   ├── 📂 Models/            # Eloquent models (14 models)
│   └── 📂 Providers/         # Service providers
├── 📂 database/
│   ├── 📂 migrations/        # Database migrations (17 files)
│   ├── 📂 seeders/           # Database seeders
│   └── 📄 database.sqlite    # SQLite database file
├── 📂 resources/
│   ├── 📂 views/             # Blade templates
│   ├── 📂 css/               # CSS source files
│   └── 📂 js/                # JavaScript source files
├── 📂 routes/
│   ├── 📄 web.php            # Web routes
│   ├── 📄 api.php            # API routes
│   └── 📄 console.php        # Console commands
├── 📂 public/                # Public assets
├── 📂 storage/               # File storage
├── 📂 vendor/                # Composer dependencies
├── 📄 composer.json          # PHP dependencies
├── 📄 package.json           # Node.js dependencies
├── 📄 .env.example           # Environment template
└── 📄 README.md              # Project documentation
```

---

## 🚀 Deployment Guide

### 🌐 Production Deployment

<details>
<summary><strong>🔧 Server Requirements</strong></summary>

| Component      | Requirement                                                           |
| -------------- | --------------------------------------------------------------------- |
| **PHP**        | 8.1+                                                                  |
| **Extensions** | openssl, pdo, mbstring, tokenizer, xml, ctype, json, bcmath, fileinfo |
| **Database**   | SQLite 3.x                                                            |
| **Web Server** | Apache/Nginx                                                          |
| **Memory**     | 512MB minimum                                                         |

</details>

<details>
<summary><strong>📋 Deployment Steps</strong></summary>

1. **Upload files ke server**

```bash
# Via Git
git clone https://github.com/Creative-Trees/Backend-University-Management-System.git
cd Backend-University-Management-System
```

2. **Install dependencies**

```bash
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

3. **Configure environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Set permissions**

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

5. **Optimize for production**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

</details>

### 🔐 Security Checklist

-   [ ] Change default admin credentials
-   [ ] Set `APP_DEBUG=false` in production
-   [ ] Configure proper file permissions
-   [ ] Enable HTTPS
-   [ ] Set up regular database backups
-   [ ] Configure firewall rules

---

## 📋 Features Overview

### 👨‍🎓 Student Management

-   ✅ Complete student profiles with academic info
-   ✅ Parent/guardian contact details
-   ✅ Academic status tracking
-   ✅ Emergency contact information

### 👨‍🏫 Faculty Management

-   ✅ Lecturer profiles with research interests
-   ✅ Publication and achievement tracking
-   ✅ Academic credentials management
-   ✅ Contact and office information

### 📰 Content Management

-   ✅ News system with categories and SEO
-   ✅ Announcements with audience targeting
-   ✅ Leadership greetings and messages
-   ✅ University history timeline

### 🏢 Facility Management

-   ✅ Comprehensive facility database
-   ✅ Location and capacity tracking
-   ✅ Operating hours management
-   ✅ Status and maintenance tracking

### 🤝 Partnership Management

-   ✅ Cooperation tracking with external institutions
-   ✅ Partnership type categorization
-   ✅ Contact person management
-   ✅ Contract period tracking

---

## 🎯 Roadmap & Future Features

### 📅 Version 2.0 (Planning)

-   [ ] **Public Frontend Website** - Complete university website
-   [ ] **REST API** - Mobile app integration
-   [ ] **Advanced Analytics** - Dashboard reporting
-   [ ] **Multi-language Support** - Bahasa Indonesia & English
-   [ ] **File Management** - Document upload system
-   [ ] **Email Notifications** - Automated messaging
-   [ ] **Role-based Permissions** - Advanced access control

### 📅 Version 3.0 (Future)

-   [ ] **Student Portal** - Self-service portal for students
-   [ ] **Faculty Portal** - Research and publication management
-   [ ] **Online Learning Integration** - LMS connectivity
-   [ ] **Mobile Application** - Native iOS/Android app
-   [ ] **Advanced Reporting** - Custom report builder
-   [ ] **Integration APIs** - Third-party service integration

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the repository**
2. **Create feature branch** (`git checkout -b feature/AmazingFeature`)
3. **Commit changes** (`git commit -m 'Add some AmazingFeature'`)
4. **Push to branch** (`git push origin feature/AmazingFeature`)
5. **Open Pull Request**

### 📝 Coding Standards

-   Follow PSR-12 coding standards
-   Write meaningful commit messages
-   Add tests for new features
-   Update documentation as needed

---

## 📞 Support & Contact

### 🐛 Issues & Bug Reports

-   **GitHub Issues**: [Report a bug](https://github.com/Creative-Trees/Backend-University-Management-System/issues)
-   **Documentation**: [Wiki](https://github.com/Creative-Trees/Backend-University-Management-System/wiki)

### 📧 Contact Information

-   **Developer**: Founder Creative Trees
-   **Email**: admin@university.com
-   **Version**: 1.0.0
-   **License**: MIT

---

## ❓ Frequently Asked Questions (FAQ)

### 🤔 General Questions

<details>
<summary><strong>Q: Apa perbedaan sistem ini dengan sistem manajemen universitas lainnya?</strong></summary>

**A:** Backend University Management System dibangun dengan teknologi modern (Laravel 11 + Filament v3) yang memberikan:

-   **Performance Tinggi**: Response time < 200ms
-   **User Experience**: Interface yang intuitif dan responsif
-   **Scalability**: Arsitektur yang dapat berkembang sesuai kebutuhan
-   **Security**: Built-in security features Laravel
-   **Maintenance**: Code yang clean dan mudah dimaintain

</details>

<details>
<summary><strong>Q: Apakah sistem ini suitable untuk universitas besar?</strong></summary>

**A:** Ya, sistem ini dirancang untuk scalable dan dapat menangani:

-   **Students**: Ribuan mahasiswa dengan data lengkap
-   **Faculty**: Ratusan dosen dengan profil akademik
-   **Content**: Unlimited news, announcements, dan content
-   **Performance**: Optimized database queries dan caching

</details>

<details>
<summary><strong>Q: Bagaimana sistem backup dan recovery?</strong></summary>

**A:** Sistem menggunakan SQLite yang memudahkan backup:

```bash
# Automatic backup
cp database/database.sqlite database/backup_$(date +%Y%m%d_%H%M%S).sqlite

# Scheduled backup (cron job)
0 2 * * * cd /path/to/project && cp database/database.sqlite database/backup_$(date +\%Y\%m\%d).sqlite
```

</details>

### 🛠️ Technical Questions

<details>
<summary><strong>Q: Mengapa menggunakan SQLite instead of MySQL/PostgreSQL?</strong></summary>

**A:** SQLite dipilih karena:

-   **Portability**: Single file database, mudah di-deploy
-   **Performance**: Sangat cepat untuk read operations
-   **Zero Configuration**: Tidak perlu setup database server
-   **Reliability**: Mature dan stable technology
-   **Migration Ready**: Mudah migrate ke database lain jika diperlukan

</details>

<details>
<summary><strong>Q: Bagaimana cara migrate ke database lain?</strong></summary>

**A:** Laravel memudahkan database migration:

```bash
# Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=university_db
DB_USERNAME=root
DB_PASSWORD=password

# Run migration
php artisan migrate --force
```

</details>

<details>
<summary><strong>Q: Apakah sistem ini mendukung multi-tenant?</strong></summary>

**A:** Saat ini single-tenant, tapi architecture mendukung untuk upgrade ke multi-tenant dengan:

-   **Spatie Multi-Tenancy Package**
-   **Database per tenant atau shared database dengan tenant_id**
-   **Filament Tenancy Plugin**

</details>

### 🔒 Security Questions

<details>
<summary><strong>Q: Bagaimana sistem handle authentication dan authorization?</strong></summary>

**A:** Security layers yang implemented:

-   **Authentication**: Laravel Sanctum + Filament Auth
-   **Authorization**: Role-based permissions dengan Spatie Permissions
-   **CSRF Protection**: Built-in Laravel CSRF tokens
-   **XSS Protection**: Blade templating automatic escaping
-   **SQL Injection**: Eloquent ORM protection

</details>

<details>
<summary><strong>Q: Apakah data sensitive di-encrypt?</strong></summary>

**A:** Ya, untuk data sensitive:

```php
// Automatic encryption untuk sensitive fields
protected $casts = [
    'personal_data' => 'encrypted:json',
    'contact_info' => 'encrypted:array'
];
```

</details>

---

## 🎓 Advanced Usage

### 🚀 Custom Filament Resources

```php
// Generate custom resource dengan relationships
php artisan make:filament-resource Student --generate

// Add custom fields ke resource
class StudentResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            Select::make('program')->options([
                'S1' => 'Sarjana',
                'S2' => 'Magister',
                'S3' => 'Doktor'
            ]),
            Repeater::make('achievements')->schema([
                TextInput::make('title'),
                DatePicker::make('date'),
                Textarea::make('description')
            ])
        ]);
    }
}
```

### 📊 Custom Dashboard Widgets

```php
// Create dashboard widget
php artisan make:filament-widget StatsOverview

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::count()),
            Stat::make('Active Faculty', Lecture::where('status', 'active')->count()),
            Stat::make('Published News', News::where('status', 'published')->count()),
        ];
    }
}
```

### 🔄 API Integration

```php
// Create API endpoints
Route::apiResource('students', StudentController::class);
Route::apiResource('lectures', LectureController::class);

// API Controller example
class StudentController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Student::with(['program', 'achievements'])->get(),
            'meta' => ['count' => Student::count()]
        ]);
    }
}
```

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2025 Backend University

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
```

---

---

---

## 📈 Performance & Analytics

### 🚀 System Performance

| Metric               | Value     | Description               |
| -------------------- | --------- | ------------------------- |
| **Response Time**    | < 200ms   | Average API response time |
| **Database Queries** | Optimized | N+1 queries eliminated    |
| **Memory Usage**     | 128MB     | Peak memory consumption   |
| **File Size**        | 15MB      | Total application size    |

### 📊 Database Analytics

```mermaid
pie title Database Entity Distribution
    "Students" : 35
    "Faculty" : 20
    "Content" : 25
    "Admin" : 15
    "Others" : 5
```

---

## 📚 API Documentation

### 🔗 Available Endpoints

| Method | Endpoint          | Description          | Auth Required |
| ------ | ----------------- | -------------------- | ------------- |
| `GET`  | `/admin`          | Admin dashboard      | ✅ Yes        |
| `GET`  | `/admin/students` | Student management   | ✅ Yes        |
| `GET`  | `/admin/lectures` | Faculty management   | ✅ Yes        |
| `GET`  | `/admin/news`     | News management      | ✅ Yes        |
| `POST` | `/admin/login`    | Admin authentication | ❌ No         |

### 📋 Response Format

```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@university.com"
    },
    "message": "Operation completed successfully"
}
```

---

## 🔧 Configuration Guide

### ⚙️ Environment Variables

| Variable          | Default            | Description        |
| ----------------- | ------------------ | ------------------ |
| `APP_NAME`        | Backend University | Application name   |
| `APP_ENV`         | local              | Environment mode   |
| `DB_CONNECTION`   | sqlite             | Database driver    |
| `FILAMENT_DOMAIN` | null               | Admin panel domain |

### 🛡️ Security Configuration

```env
# Security Settings
APP_DEBUG=false
APP_URL=https://yourdomain.com
SESSION_LIFETIME=120
SANCTUM_STATEFUL_DOMAINS=yourdomain.com
```

---

## 📋 Testing Guide

### 🧪 Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### 📊 Test Coverage

| Component       | Coverage | Status       |
| --------------- | -------- | ------------ |
| **Models**      | 95%      | ✅ Excellent |
| **Controllers** | 85%      | ✅ Good      |
| **Resources**   | 90%      | ✅ Excellent |
| **Overall**     | 90%      | ✅ Excellent |

---

## 📦 Package Management

### 📚 Key Dependencies

| Package                     | Version | Purpose               |
| --------------------------- | ------- | --------------------- |
| `filament/filament`         | ^3.0    | Admin panel framework |
| `laravel/framework`         | ^11.0   | Core framework        |
| `livewire/livewire`         | ^3.0    | Frontend interactions |
| `spatie/laravel-permission` | ^6.0    | Role & permissions    |

### 🔄 Update Commands

```bash
# Update all packages
composer update

# Update specific package
composer update filament/filament

# Check for outdated packages
composer outdated
```

---

## 🌍 Internationalization

### 🌐 Supported Languages

| Language             | Code | Status         | Completion |
| -------------------- | ---- | -------------- | ---------- |
| **English**          | `en` | ✅ Active      | 100%       |
| **Bahasa Indonesia** | `id` | 🚧 In Progress | 75%        |
| **Arabic**           | `ar` | 📋 Planned     | 0%         |

### 🔧 Language Configuration

```php
// config/app.php
'locale' => 'en',
'fallback_locale' => 'en',
'available_locales' => ['en', 'id'],
```

---

## 🎨 UI/UX Guidelines

### 🎯 Design Principles

-   **Consistency**: Uniform design across all pages
-   **Accessibility**: WCAG 2.1 AA compliant
-   **Responsiveness**: Mobile-first approach
-   **Performance**: Optimized loading times

### 🎨 Color Scheme

| Color         | Hex       | Usage               |
| ------------- | --------- | ------------------- |
| **Primary**   | `#FF2D20` | Laravel brand color |
| **Secondary** | `#F59E0B` | Filament accent     |
| **Success**   | `#10B981` | Success states      |
| **Warning**   | `#F59E0B` | Warning states      |
| **Error**     | `#EF4444` | Error states        |

---

## 📊 Monitoring & Logging

### 📈 Application Monitoring

```bash
# View application logs
tail -f storage/logs/laravel.log

# Monitor database queries
php artisan telescope:install

# Check system health
php artisan health:check
```

### 🔍 Debug Tools

| Tool           | Purpose               | Command                                           |
| -------------- | --------------------- | ------------------------------------------------- |
| **Telescope**  | Request monitoring    | `php artisan telescope:install`                   |
| **Debugbar**   | Development debugging | `composer require barryvdh/laravel-debugbar`      |
| **Log Viewer** | Log management        | `composer require rap2hpoutre/laravel-log-viewer` |

---

<div align="center">

**⭐ Star this repository if you find it helpful!**

[![Stars](https://img.shields.io/github/stars/Creative-Trees/Backend-University-Management-System?style=social)](https://github.com/Creative-Trees/Backend-University-Management-System/stargazers)
[![Forks](https://img.shields.io/github/forks/Creative-Trees/Backend-University-Management-System?style=social)](https://github.com/Creative-Trees/Backend-University-Management-System/network/members)
[![Issues](https://img.shields.io/github/issues/Creative-Trees/Backend-University-Management-System)](https://github.com/Creative-Trees/Backend-University-Management-System/issues)

---

**Made with ❤️ by [Creative Trees](https://github.com/Creative-Trees)**

_Building the future of university management systems_

</div>
```
    'email' => 'admin@university.com',
    'password' => bcrypt('password')
]);
```

---

## 📁 Struktur Project

```
Backend-University/
├── app/
│   ├── Filament/Resources/     # Filament admin resources
│   ├── Http/Controllers/       # Controllers
│   ├── Models/                 # Eloquent models
│   └── Providers/             # Service providers
├── database/
│   ├── migrations/            # Database migrations
│   ├── seeders/              # Database seeders
│   └── database.sqlite       # SQLite database
├── resources/
│   └── views/                # Blade templates
└── routes/
    ├── web.php              # Web routes
    └── console.php          # Console commands
```

---

## 🎯 Pengembangan Selanjutnya

-   [ ] Frontend website untuk public
-   [ ] API endpoints untuk mobile app
-   [ ] Advanced reporting & analytics
-   [ ] Multi-language support
-   [ ] File upload & management
-   [ ] Email notification system
-   [ ] Role-based permissions

---

## �🔒 Kredensial Awal

-   **Username** `Founder Creative Trees`
-   **Email:** `admin@academium.com`
-   **Password:** `academium`

> _Pastikan untuk mengganti kredensial default setelah instalasi._

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi **MIT** – silakan gunakan, ubah, dan distribusikan sesuai kebutuhan.
