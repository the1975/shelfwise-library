# Shelfwise — Digital Library

Shelfwise adalah aplikasi perpustakaan digital sederhana berbasis web untuk mengelola koleksi buku. Aplikasi menyediakan dashboard, pencarian dan filter buku, serta pengelolaan akun dengan dua peran: **admin** dan **pengunjung**.

## Fitur

### Umum
- Login dan logout pengguna.
- Dashboard dengan ringkasan jumlah buku, buku tersedia, dan buku dengan stok nol.
- Daftar koleksi buku dengan pencarian berdasarkan judul, penulis, atau kategori.
- Filter koleksi berdasarkan kategori dan status ketersediaan.
- Pencarian buku secara langsung.
- Halaman profil untuk mengubah data akun dan password.
- Pilihan tema terang dan gelap yang tersimpan di browser.
- Tampilan responsif untuk desktop dan perangkat mobile.

### Admin
- Menambahkan data buku.
- Mengubah data buku.
- Menghapus buku dengan konfirmasi.
- Mengunggah sampul buku JPG/PNG (maksimal 2 MB).
- Melihat dan mengelola koleksi buku.

### Pengunjung
- Melihat koleksi buku.
- Mencari dan memfilter buku.
- Mengubah data profil dan password.

> Status “Tersedia” atau “Dipinjam” ditentukan dari nilai stok: stok lebih dari 0 berarti tersedia, sedangkan stok 0 ditampilkan sebagai dipinjam.

## Teknologi

- **Backend:** PHP 8.1+
- **Database:** MySQL
- **Koneksi database:** PDO
- **Frontend:** HTML, CSS, JavaScript
- **CSS framework:** Bootstrap 5.3.3
- **Icon:** Bootstrap Icons
- **Font:** Inter
- **Asynchronous request:** Fetch API

## Struktur Proyek

```text
shelfwise-library/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── config/
│   └── database.example.php
├── database/
│   └── db_perpustakaan.sql
├── includes/
│   ├── auth.php
│   ├── filter-buku.php
│   ├── footer.php
│   ├── form-buku.php
│   ├── functions.php
│   ├── header.php
│   ├── layout_end.php
│   ├── modal-hapus.php
│   ├── sidebar.php
│   └── stat-cards.php
├── pages/
│   ├── add-book.php
│   ├── books.php
│   ├── dashboard.php
│   ├── edit-book.php
│   └── profile.php
├── process/
│   ├── cari.php
│   ├── edit.php
│   ├── ganti-password.php
│   ├── hapus.php
│   ├── login.php
│   ├── logout.php
│   ├── profil.php
│   └── tambah.php
├── screenshots/
├── uploads/
├── index.php
├── login.php
└── README.md
```

## Persyaratan

Pastikan perangkat sudah memiliki:

- PHP **8.1 atau lebih baru**.
- MySQL atau MariaDB.
- Web server lokal, misalnya XAMPP, Laragon, atau MAMP.
- Ekstensi PHP `pdo_mysql`, `fileinfo`, dan `session`.
- Browser modern dan koneksi internet untuk memuat Bootstrap, Bootstrap Icons, serta Google Fonts dari CDN.

## Instalasi

1. **Clone atau unduh repository**

   ```bash
   git clone <URL-REPOSITORY>
   ```

   Letakkan folder proyek di direktori web server lokal. Contohnya, pada XAMPP gunakan folder `htdocs`.

2. **Buat database**

   Buat database bernama `db_perpustakaan` melalui phpMyAdmin atau MySQL.

3. **Import struktur database**

   Import file berikut ke database yang sudah dibuat:

   ```text
   database/db_perpustakaan.sql
   ```

4. **Buat konfigurasi koneksi**

   Salin `config/database.example.php` menjadi `config/database.php`, kemudian sesuaikan konfigurasi berikut dengan lingkungan lokal:

   ```php
   const DB_HOST = 'localhost';
   const DB_NAME = 'db_perpustakaan';
   const DB_USER = 'root';
   const DB_PASS = '';
   const BASE_URL = '/shelfwise-library';
   ```

   `BASE_URL` harus disesuaikan dengan alamat folder proyek. Jika proyek dijalankan langsung dari root domain, gunakan string kosong (`''`).

   File `config/database.php` sengaja tidak disertakan dalam repository karena berisi konfigurasi lokal dan diabaikan oleh Git.

5. **Pastikan folder upload dapat ditulis**

   Folder `uploads/` digunakan untuk menyimpan sampul buku dan foto profil. Pastikan PHP memiliki izin untuk menulis ke folder tersebut.

6. **Jalankan aplikasi**

   Nyalakan web server dan MySQL, lalu buka alamat proyek melalui browser. Contoh:

   ```text
   http://localhost/shelfwise-library/
   ```

## Membuat Akun Admin Pertama

Struktur database menyediakan tabel `users`, tetapi file SQL belum menyertakan akun bawaan maupun halaman registrasi. Buat hash password terlebih dahulu menggunakan PHP:

```bash
php -r "echo password_hash('GantiPassword123!', PASSWORD_DEFAULT), PHP_EOL;"
```

Salin hasil hash, lalu jalankan query berikut di database. Ganti username, nama, dan hash sesuai kebutuhan:

```sql
INSERT INTO users (username, password, nama, role)
VALUES (
  'admin',
  'TEMPEL_HASH_PASSWORD_DI_SINI',
  'Administrator',
  'admin'
);
```

Setelah itu, masuk menggunakan username dan password yang telah dibuat. Demi keamanan, gunakan password pribadi yang kuat dan jangan memakai contoh password di atas untuk penggunaan sebenarnya.

## Catatan Penggunaan

- Admin memiliki akses untuk menambah, mengubah, dan menghapus buku.
- Pengunjung hanya dapat melihat koleksi dan mengelola profilnya sendiri.
- Kategori buku yang tersedia didefinisikan pada konstanta `KATEGORI` di `includes/functions.php`.
- Sampul buku dan foto profil menerima gambar JPG atau PNG dengan ukuran maksimal 2 MB.
- Pastikan konfigurasi database dan `BASE_URL` sudah benar jika aplikasi dipasang pada subfolder atau hosting.

## Screenshot

Beberapa tampilan aplikasi tersedia di folder [`screenshots/`](screenshots/), antara lain:

- Login
- Dashboard
- Daftar buku
- Form tambah dan edit buku
- Profil pengguna
- Tampilan koleksi pengunjung

---

Dibuat sebagai proyek aplikasi **Digital Library** dengan PHP dan MySQL.
