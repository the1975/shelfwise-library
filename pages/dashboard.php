<?php
require __DIR__ . '/../includes/auth.php';
$judul = 'Dashboard';
$halaman = 'dashboard';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/sidebar.php';
?>
<h1 class="page-title">Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</h1>
<p class="text-muted-ios">Kelola koleksi buku perpustakaan dengan mudah.</p>
<?php
require __DIR__ . '/../includes/layout_end.php';
require __DIR__ . '/../includes/footer.php';
