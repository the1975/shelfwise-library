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
