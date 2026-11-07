<?php
// Fungsi bantu bersama; juga memulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pindah halaman
function redirect(string $path): never
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

// Simpan pesan sekali tampil
function setFlash(string $type, string $msg): void
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

// Ambil pesan lalu hapus
function getFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

// Escape teks untuk ditampilkan di HTML
function e(?string $teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

// Label status dari stok: [teks, kelas warna]
function statusBuku(int $stok): array
{
    if ($stok > 0) {
        return ['Tersedia', 'ok'];
    }
    return ['Dipinjam', 'warn'];
}

const SAMPUL_MAKS = 2 * 1024 * 1024;
const SAMPUL_TIPE = ['image/jpeg' => 'jpg', 'image/png' => 'png'];

// Proses upload sampul; hasil [nama file atau null, pesan error atau null]
function uploadSampul(array $file): array
{
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        return [null, 'Ukuran sampul maksimal 2MB.'];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [null, 'Upload sampul gagal, coba lagi.'];
    }
    if ($file['size'] > SAMPUL_MAKS) {
        return [null, 'Ukuran sampul maksimal 2MB.'];
    }

    // Cek tipe dari isi file, bukan dari ekstensi
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset(SAMPUL_TIPE[$mime])) {
        return [null, 'Sampul harus berupa gambar JPG atau PNG.'];
    }

    // Nama acak supaya tidak bentrok dan tidak bisa ditebak
    $nama = bin2hex(random_bytes(8)) . '.' . SAMPUL_TIPE[$mime];
    if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../uploads/' . $nama)) {
        return [null, 'Gagal menyimpan file sampul.'];
    }
    return [$nama, null];
}
