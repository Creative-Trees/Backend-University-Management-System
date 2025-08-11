# 🎓 Backend University Management System

<div align="center">

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-3.x-F59E0B?style=for-the-badge&logo=php&logoColor=white)](https://filamentphp.com)
[![SQLite](https://img.shields.io/badge/SQLite-3.x-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

</div>

**Backend University** adalah sistem manajemen universitas yang komprehensif dan modern, dibangun menggunakan **Laravel 11** dengan **Filament Admin Panel**. Sistem ini dirancang untuk mengelola seluruh aspek operasional universitas dengan interface yang intuitif dan performa yang optimal.

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
git clone https://github.com/username/Backend-University.git
cd Backend-University

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

### 📋 Resource Generation Status

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

> ⚠️ **Security Note**: Ubah kredensial default setelah login pertama!

---

## � Commands Berguna

### **Generate Filament Resources**

```bash
# Generate semua resources sekaligus
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
---

## 📁 Project Structure

```

Backend-University/
├── 📂 app/
│ ├── 📂 Filament/
│ │ ├── 📂 Resources/ # Filament admin resources
│ │ └── 📂 Pages/ # Custom admin pages
│ ├── 📂 Http/
│ │ ├── 📂 Controllers/ # Application controllers
│ │ └── 📂 Middleware/ # Custom middleware
│ ├── 📂 Models/ # Eloquent models (14 models)
│ └── 📂 Providers/ # Service providers
├── 📂 database/
│ ├── 📂 migrations/ # Database migrations (17 files)
│ ├── 📂 seeders/ # Database seeders
│ └── 📄 database.sqlite # SQLite database file
├── 📂 resources/
│ ├── 📂 views/ # Blade templates
│ ├── 📂 css/ # CSS source files
│ └── 📂 js/ # JavaScript source files
├── 📂 routes/
│ ├── 📄 web.php # Web routes
│ ├── 📄 api.php # API routes
│ └── 📄 console.php # Console commands
├── 📂 public/ # Public assets
├── 📂 storage/ # File storage
└── 📂 vendor/ # Composer dependencies

````

---

## 🚀 Deployment Guide

### 🌐 Production Deployment

<details>
<summary><strong>🔧 Server Requirements</strong></summary>

| Component | Requirement |
|-----------|-------------|
| **PHP** | 8.1+ |
| **Extensions** | openssl, pdo, mbstring, tokenizer, xml, ctype, json, bcmath, fileinfo |
| **Database** | SQLite 3.x |
| **Web Server** | Apache/Nginx |
| **Memory** | 512MB minimum |

</details>

<details>
<summary><strong>📋 Deployment Steps</strong></summary>

1. **Upload files ke server**
```bash
# Via Git
git clone https://github.com/username/Backend-University.git
cd Backend-University
````

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

-   **GitHub Issues**: [Report a bug](https://github.com/username/Backend-University/issues)
-   **Documentation**: [Wiki](https://github.com/username/Backend-University/wiki)

### 📧 Contact Information

-   **Developer**: Founder Creative Trees
-   **Email**: admin@university.com
-   **Version**: 1.0.0
-   **License**: MIT

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

<div align="center">

**⭐ Star this repository if you find it helpful!**

[![Stars](https://img.shields.io/github/stars/username/Backend-University?style=social)](https://github.com/username/Backend-University/stargazers)
[![Forks](https://img.shields.io/github/forks/username/Backend-University?style=social)](https://github.com/username/Backend-University/network/members)
[![Issues](https://img.shields.io/github/issues/username/Backend-University)](https://github.com/username/Backend-University/issues)

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
