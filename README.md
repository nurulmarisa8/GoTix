# 🎵 GoTix - Music Event E-Ticketing System

**GoTix** adalah aplikasi berbasis web untuk manajemen dan pemesanan tiket konser musik. Aplikasi ini menghubungkan **Admin**, **Event Organizer**, dan **Pengunjung (User)** dalam satu platform yang efisien.

Dibuat untuk memenuhi Tugas Final Project Pemrograman Web (Laravel).

---

## 🚀 Fitur Utama

### 1. Role: Guest (Pengunjung Umum)
* **Landing Page Menarik:** Hero section dengan background musik.
* **Pencarian & Filter:** Cari event berdasarkan nama, lokasi, atau kategori (Pop, Rock, Jazz, dll).
* **Katalog Event:** Melihat daftar event terbaru yang belum lewat tanggalnya.
* **Detail Event:** Melihat deskripsi lengkap, lokasi, harga tiket, dan sisa kuota.

### 2. Role: Registered User (Pembeli)
* **Booking Tiket:** Memesan tiket (Status awal: *Pending*).
* **Manajemen Pesanan:**
    * Melihat riwayat tiket ("Tiket Saya").
    * Membatalkan pesanan (jika status masih *Pending*).
    * Download E-Ticket dalam format PDF (jika status *Lunas/Approved*).
* **Favorit (Wishlist):** Menandai event yang disukai agar muncul di paling atas halaman utama.

### 3. Role: Event Organizer (Promotor)
* **Registrasi & Approval:** Akun baru harus disetujui Admin sebelum bisa login.
* **Dashboard Statistik:** Melihat total event, tiket terjual, dan total pendapatan.
* **Manajemen Event (CRUD):** Membuat, mengedit, dan menghapus event sendiri.
* **Manajemen Tiket:** Menambah varian tiket (VIP, Regular) dengan harga dan kuota berbeda.
* **Approval Pesanan:** Menerima atau Menolak pesanan tiket yang masuk dari User.

### 4. Role: Administrator (Super Admin)
* **Full Control:** Mengelola seluruh user dan event.
* **Approval Organizer:** Menyetujui atau menolak pendaftaran akun Organizer baru.
* **Laporan Penjualan:** Melihat rekapitulasi seluruh transaksi yang masuk ke sistem.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel 10 / 11
* **Frontend:** Blade Templates & Tailwind CSS (CDN)
* **Database:** MySQL
* **PDF Generator:** `barryvdh/laravel-dompdf`
* **Fitur Lain:** Laravel Authentication, Middleware, Eloquent Relationships.

---

## ⚙️ Cara Instalasi (Localhost)

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer Anda:

### 1. Clone Repository
```bash
git clone [https://github.com/username-anda/gotix.git](https://github.com/username-anda/gotix.git)
cd gotix