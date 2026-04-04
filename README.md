# SMARTELLIB - Sistem Perpustakaan Digital

Aplikasi perpustakaan digital untuk manajemen e-book dengan fitur berlangganan, pembacaan PDF, dan laporan penjualan.

---

## 📚 Tentang Aplikasi

**SMARTELLIB** adalah website untuk mengelola perpustakaan digital berbasis web. Aplikasi ini dilengkapi dengan:

- Sistem login untuk admin, petugas dan anggota
- Koleksi e-book yang bisa dibaca langsung di browser
- Pelacakan riwayat membaca
- Laporan peminjaman buku
- Ekspor otomatis dalam format PDF

---

## ✨ Fitur - Fitur yang ada

### Untuk Anggota

- ✅ Daftar dan login akun
- ✅ Cari dan jelajahi koleksi buku
- ✅ Baca buku langsung dengan PDF reader atau langsung dalam website
- ✅ Lihat riwayat membaca
- ✅ Lihat dan download PDF

### Untuk Petugas

- ✅ Tambah, edit, hapus buku
- ✅ Konfirmasi anggota
- ✅ Manajemen pembayaran denda
- ✅ Dashboard dengan statistik

### Untuk Admin

- ✅ Dashboard dengan statistik
- ✅ Lihat data Anggota, Petugas dan buku
- ✅ Lihat laporan peminjaman buku
- ✅ Export laporan ke PDF
- ✅ Manajemen kategori buku dan petugas
- ✅ Pengaturan sistem

---

## 🛠️ Teknologi

- **Backend:** Laravel 10, PHP 8.2+
- **Frontend:** Tailwind CSS v3
- **Database:** MySQL 8.0+
- **PDF Reader:** PDF.js
- **Build Tool:** npm

---

## 📦 Instalasi dengan XAMPP

### Prasyarat

Sebelum mulai, pastikan semua tools berikut sudah terinstall di komputer kamu:

| Tools                             | Keterangan             |  Disediakan XAMPP?  |
| --------------------------------- | ---------------------- | :-----------------: |
| XAMPP (Apache + MySQL + PHP 8.2+) | Web server & database  |        ✅ Ya        |
| Git                               | Untuk clone repository | ❌ Install terpisah |
| Composer                          | Package manager PHP    | ❌ Install terpisah |
| Node.js (v18+) + npm              | Build frontend assets  | ❌ Install terpisah |

---

### ⚙️ Instalasi Tools Tambahan

#### 1. Install Git

1. Download Git di [https://git-scm.com/download/win](https://git-scm.com/download/win)
2. Jalankan installer, ikuti langkah default, klik **Next** sampai selesai
3. Cek instalasi berhasil:

```bash
git --version
# Output: git version 2.x.x
```

#### 2. Install Composer

1. Download Composer di [https://getcomposer.org/Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)
2. Jalankan installer — Composer akan otomatis mendeteksi PHP dari XAMPP
3. Pastikan path PHP mengarah ke `C:\xampp\php\php.exe` saat instalasi
4. Cek instalasi berhasil:

```bash
composer --version
# Output: Composer version 2.x.x
```

> ⚠️ Jika Composer tidak menemukan PHP secara otomatis, arahkan manual ke `C:\xampp\php\php.exe`

#### 3. Install Node.js

1. Download Node.js (versi LTS) di [https://nodejs.org/](https://nodejs.org/)
2. Jalankan installer, ikuti langkah default
3. npm akan terinstall otomatis bersama Node.js
4. Cek instalasi berhasil:

```bash
node --version
# Output: v18.x.x atau lebih baru

npm --version
# Output: 9.x.x atau lebih baru
```

#### 4. Tambahkan PHP XAMPP ke PATH (jika belum)

Agar perintah `php` bisa dijalankan dari CMD manapun:

1. Buka **Start Menu** → cari **"Environment Variables"**
2. Klik **"Edit the system environment variables"**
3. Klik tombol **"Environment Variables..."**
4. Pada bagian **System variables**, pilih **Path** → klik **Edit**
5. Klik **New** dan tambahkan: `C:\xampp\php`
6. Klik **OK** pada semua jendela
7. Buka CMD baru dan cek:

```bash
php --version
# Output: PHP 8.2.x ...
```

---

### Langkah Instalasi

**1. Clone folder SMARTELLIB ke folder `xampp/htdocs`**

```bash
# Buka Command Prompt atau Terminal
cd C:\xampp\htdocs
git clone <url-repository> smartellib
cd smartellib
code .
```

> Perintah `code .` akan membuka project di VS Code

**2. Install dependencies PHP**

```bash
composer install
```

**3. Install dependencies npm**

```bash
npm install
```

**4. Setup environment file**

```bash
# Copy file environment
copy .env.example .env

# Generate app key
php artisan key:generate
```

**5. Konfigurasi database**

File `.env` sudah dikonfigurasi untuk XAMPP secara default:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elibrary
DB_USERNAME=root
DB_PASSWORD=
```

> Jika konfigurasi MySQL XAMPP kamu berbeda, sesuaikan nilai di atas pada file `.env`

**6. Buat database di phpMyAdmin**

- Buka browser, akses `http://localhost/phpmyadmin`
- Klik **New** dan buat database dengan nama `elibrary`

**7. Setup database & seeder**

```bash
# Jalankan migrasi dan seeding (pertama kali)
php artisan migrate --seed
```

**8. Build frontend assets (Opsional pada setup awal)**

```bash
npm run build
```

✅ **Instalasi selesai!**

---

## 🚀 Cara Menjalankan

### 1. Mulai XAMPP

- Buka aplikasi **XAMPP Control Panel**
- Klik tombol **Start** pada **Apache** dan **MySQL**
- Pastikan kedua service sudah berjalan (status berubah hijau ✅)

### 2. Jalankan Development Mode

Buka **2 jendela Command Prompt / Terminal**:

**Terminal 1 - Jalankan Laravel Server**

```bash
cd C:\xampp\htdocs\smartellib
php artisan serve
```

> Server akan berjalan di `http://127.0.0.1:8000`

**Terminal 2 - Jalankan Vite Development Server**

```bash
cd C:\xampp\htdocs\smartellib
npm run dev
```

> Tunggu sampai Vite siap (akan muncul pesan seperti `Local: http://localhost:5173`)

Biarkan kedua terminal tetap berjalan selama development.

### 3. Akses Aplikasi di Browser

| Halaman      | URL                           |
| ------------ | ----------------------------- |
| Landing Page | `http://127.0.0.1:8000/`      |
| Login        | `http://127.0.0.1:8000/login` |

> Atau bisa juga diakses lewat: `http://localhost/smartellib/public/`

---

## 🧪 Akun Test (Seeder)

### Admin

```
Email:    alex123@gmail.com
Password: alex123
Username: Alex
```

### Anggota (Member)

```
Email:    padlan123@gmail.com
Password: padlan123
Username: Padlan Padilah
```

> **Info:** Ada 4 akun anggota tambahan lainnya di database untuk testing. Cek detail di `database/seeders/DatabaseSeeder.php`

---

## 📁 Struktur Folder

```
smartellib/
├── app/
│   ├── Models/              # Model database
│   └── Http/
│       ├── Controllers/     # Controller
│       └── Middleware/      # Middleware
├── resources/
│   ├── views/               # Template HTML
│   └── css/                 # Style Tailwind
├── routes/
│   └── web.php              # Route aplikasi
├── database/
│   ├── migrations/          # Schema database
│   └── seeders/             # Data dummy
├── public/                  # File publik
└── config/                  # Konfigurasi
```

---

## 👥 Peran Pengguna

### Admin

- Akses penuh ke dashboard admin
- Kelola buku, member, dan langganan
- Lihat laporan dan statistik

### Petugas

- Tambah dan kelola koleksi buku
- Konfirmasi pendaftaran anggota
- Manajemen pembayaran denda

### Member (Anggota)

- Akses halaman member
- Baca buku dan lihat detail
- Langganan paket
- Lihat dan download invoice

---

## 🔐 Keamanan

- ✅ Sistem login dengan Laravel Authentication
- ✅ Proteksi CSRF otomatis
- ✅ Password di-hash dengan bcrypt
- ✅ Role-based access control
- ✅ Session aman berbasis database

---

## 📚 Fitur Utama

### Pembaca PDF

- Baca buku langsung di browser
- Navigasi halaman mudah
- Tracking halaman terakhir dibaca

### Manajemen Langganan

- Berbagai paket pilihan
- Track status langganan
- History transaksi
- Invoice dapat didownload sebagai PDF

### Laporan

- Laporan berlangganan
- Data buku
- Export ke PDF

---

## ❓ Troubleshooting

| Masalah                     | Solusi                                                              |
| --------------------------- | ------------------------------------------------------------------- |
| `php` tidak dikenali di CMD | Tambahkan `C:\xampp\php` ke PATH environment variable               |
| Port 80 sudah dipakai       | Ganti port Apache di XAMPP config, atau gunakan `php artisan serve` |
| Database tidak bisa connect | Pastikan MySQL di XAMPP sudah **Start** dan nama DB sudah dibuat    |
| Halaman blank / error 500   | Cek file `.env` sudah di-copy dan `APP_KEY` sudah di-generate       |

---

## 📧 Support

Ada pertanyaan atau masalah? Buat issue di repository ini.

---

**Dibuat dengan ❤️ oleh tim development**
