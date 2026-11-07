<?php
require __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/pages/add-book.php');
}

$judul    = trim($_POST['judul'] ?? '');
$penulis  = trim($_POST['penulis'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$tahun    = (int) ($_POST['tahun_terbit'] ?? 0);
$stok     = filter_var($_POST['stok'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 9999]]);

// Validasi isian
$error = null;
if ($judul === '' || $penulis === '' || $kategori === '') {
    $error = 'Judul, penulis, dan kategori wajib diisi.';
} elseif ($tahun < 1901 || $tahun > (int) date('Y') + 1) {
    $error = 'Tahun terbit tidak valid.';
} elseif ($stok === false) {
    $error = 'Stok harus berupa angka 0 sampai 9999.';
}

// Validasi dan simpan sampul
$sampul = null;
if (!$error) {
    [$sampul, $error] = uploadSampul($_FILES['sampul'] ?? ['error' => UPLOAD_ERR_NO_FILE]);
}

if ($error) {
    $_SESSION['old'] = $_POST;
    setFlash('danger', $error);
    redirect('/pages/add-book.php');
}

// Simpan ke database; hapus file kalau query gagal
try {
    $stmt = $pdo->prepare('INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, sampul) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$judul, $kategori, $penulis, $tahun, $stok, $sampul]);
} catch (PDOException $e) {
    if ($sampul) {
        unlink(__DIR__ . '/../uploads/' . $sampul);
    }
    $_SESSION['old'] = $_POST;
    setFlash('danger', 'Gagal menyimpan buku, coba lagi.');
    redirect('/pages/add-book.php');
}

setFlash('success', 'Buku "' . $judul . '" berhasil ditambahkan.');
redirect('/pages/books.php');
