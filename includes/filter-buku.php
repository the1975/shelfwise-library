<?php
// Tombol filter di kolom cari; butuh $kategoriList, $total, $kat, $status
$statusList = ['' => 'Semua', 'tersedia' => 'Tersedia', 'dipinjam' => 'Dipinjam'];
$aktif = $kat !== '' || $status !== '';
$link = fn(string $k, string $s): string => BASE_URL . '/pages/books.php?' . http_build_query(array_filter(['kategori' => $k, 'status' => $s], 'strlen'));
?>
<div class="dropdown">
  <button type="button" class="filter-btn" data-bs-toggle="dropdown" aria-label="Filter">
    <i class="bi bi-sliders"></i>
    <?php if ($aktif): ?><span class="filter-dot"></span><?php endif; ?>
  </button>
  <div class="dropdown-menu dropdown-menu-end filter-menu">
    <p class="filter-title">Status</p>
    <?php foreach ($statusList as $val => $nama): ?>
      <a class="filter-item <?= $status === $val ? 'on' : '' ?>" href="<?= e($link($kat, $val)) ?>">
        <span><?= $status === $val ? '<i class="bi bi-check-lg"></i> ' : '' ?><?= e($nama) ?></span>
      </a>
    <?php endforeach; ?>

    <p class="filter-title">Kategori</p>
    <a class="filter-item <?= $kat === '' ? 'on' : '' ?>" href="<?= e($link('', $status)) ?>">
      <span><?= $kat === '' ? '<i class="bi bi-check-lg"></i> ' : '' ?>Semua</span><span class="n"><?= (int) $total ?></span>
    </a>
    <?php foreach ($kategoriList as $k): ?>
      <a class="filter-item <?= $kat === $k['kategori'] ? 'on' : '' ?>" href="<?= e($link($k['kategori'], $status)) ?>">
        <span><?= $kat === $k['kategori'] ? '<i class="bi bi-check-lg"></i> ' : '' ?><?= e($k['kategori']) ?></span><span class="n"><?= (int) $k['jml'] ?></span>
      </a>
    <?php endforeach; ?>

    <?php if ($aktif): ?>
      <a class="filter-reset" href="<?= BASE_URL ?>/pages/books.php">Hapus filter</a>
    <?php endif; ?>
  </div>
</div>
