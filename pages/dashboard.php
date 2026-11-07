<?php
require __DIR__ . '/../includes/auth.php';
$judul = 'Dashboard';
$halaman = 'dashboard';

// Statistik dan 5 buku terbaru
$total    = (int) $pdo->query('SELECT COUNT(*) FROM buku')->fetchColumn();
$tersedia = (int) $pdo->query('SELECT COUNT(*) FROM buku WHERE stok > 0')->fetchColumn();
$dipinjam = $total - $tersedia;
$terbaru  = $pdo->query('SELECT * FROM buku ORDER BY id DESC LIMIT 5')->fetchAll();

require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/sidebar.php';
?>
<div class="row g-3 mb-4">
  <div class="col-4">
    <div class="panel stat">
      <div class="stat-icon tone-blue"><i class="bi bi-book"></i></div>
      <div><div class="stat-num"><?= $total ?></div><div class="stat-label">Total Buku</div></div>
    </div>
  </div>
  <div class="col-4">
    <div class="panel stat">
      <div class="stat-icon tone-green"><i class="bi bi-check-lg"></i></div>
      <div><div class="stat-num"><?= $tersedia ?></div><div class="stat-label">Buku Tersedia</div></div>
    </div>
  </div>
  <div class="col-4">
    <div class="panel stat">
      <div class="stat-icon tone-orange"><i class="bi bi-clock"></i></div>
      <div><div class="stat-num"><?= $dipinjam ?></div><div class="stat-label">Buku Dipinjam</div></div>
    </div>
  </div>
</div>

<section class="panel">
  <div class="panel-head">
    <h2 class="h5 fw-bold m-0">Buku Terbaru</h2>
    <a class="btn-soft" href="<?= BASE_URL ?>/pages/books.php">Lihat Semua</a>
  </div>
  <?php if (!$terbaru): ?>
    <p class="text-muted-ios m-0 py-3">Belum ada buku. <a class="link-accent" href="<?= BASE_URL ?>/pages/add-book.php">Tambah buku pertama</a></p>
  <?php endif; ?>
  <?php foreach ($terbaru as $b): [$label, $warna] = statusBuku((int) $b['stok']); ?>
    <div class="book-row">
      <?php if ($b['sampul']): ?>
        <img class="cover" src="<?= BASE_URL ?>/uploads/<?= rawurlencode($b['sampul']) ?>" alt="">
      <?php else: ?>
        <div class="cover"><i class="bi bi-book"></i></div>
      <?php endif; ?>
      <div class="book-info">
        <p class="book-title text-truncate"><?= e($b['judul']) ?></p>
        <p class="book-meta text-truncate"><?= e($b['penulis']) ?> · <?= e((string) $b['tahun_terbit']) ?></p>
      </div>
      <span class="pill <?= $warna ?>"><?= $label ?></span>
    </div>
  <?php endforeach; ?>
</section>
<?php
require __DIR__ . '/../includes/layout_end.php';
require __DIR__ . '/../includes/footer.php';
