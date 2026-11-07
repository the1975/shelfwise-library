<?php
require __DIR__ . '/../includes/auth.php';
$judul = 'Buku';
$halaman = 'buku';
$flash = getFlash();

// Cari berdasarkan judul, penulis, atau kategori
$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt = $pdo->prepare('SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY id DESC');
    $stmt->execute([$like, $like, $like]);
} else {
    $stmt = $pdo->query('SELECT * FROM buku ORDER BY id DESC');
}
$daftar = $stmt->fetchAll();

require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
  <div>
    <h1 class="page-title">Buku</h1>
    <p class="text-muted-ios m-0">
      <?= $q !== '' ? count($daftar) . ' hasil untuk "' . e($q) . '"' : count($daftar) . ' buku terdaftar' ?>
    </p>
  </div>
  <a class="btn-main" href="<?= BASE_URL ?>/pages/add-book.php"><i class="bi bi-plus-lg"></i> Tambah Buku</a>
</div>

<?php if ($flash): ?>
  <div class="alert-ios <?= e($flash['type']) ?>" role="alert"><?= e($flash['msg']) ?></div>
<?php endif; ?>

<div class="panel">
  <div class="table-responsive">
    <table class="table table-ios table-hover align-middle">
      <thead>
        <tr>
          <th>Buku</th>
          <th class="d-none d-md-table-cell">Kategori</th>
          <th class="d-none d-md-table-cell">Tahun</th>
          <th class="d-none d-sm-table-cell">Stok</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$daftar): ?>
          <tr><td colspan="6" class="text-center text-muted-ios py-4">
            <?= $q !== '' ? 'Buku tidak ditemukan.' : 'Belum ada buku.' ?>
          </td></tr>
        <?php endif; ?>
        <?php foreach ($daftar as $b): [$label, $warna] = statusBuku((int) $b['stok']); ?>
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <?php if ($b['sampul']): ?>
                  <img class="cover" src="<?= BASE_URL ?>/uploads/<?= rawurlencode($b['sampul']) ?>" alt="">
                <?php else: ?>
                  <div class="cover"><i class="bi bi-book"></i></div>
                <?php endif; ?>
                <div>
                  <p class="book-title m-0"><?= e($b['judul']) ?></p>
                  <p class="book-meta m-0"><?= e($b['penulis']) ?></p>
                </div>
              </div>
            </td>
            <td class="d-none d-md-table-cell"><?= e($b['kategori']) ?></td>
            <td class="d-none d-md-table-cell"><?= e((string) $b['tahun_terbit']) ?></td>
            <td class="d-none d-sm-table-cell"><?= (int) $b['stok'] ?></td>
            <td><span class="pill <?= $warna ?>"><?= $label ?></span></td>
            <td class="text-end text-nowrap">
              <a class="icon-btn" href="<?= BASE_URL ?>/pages/edit-book.php?id=<?= (int) $b['id'] ?>" aria-label="Edit"><i class="bi bi-pencil"></i></a>
              <button type="button" class="icon-btn danger btn-hapus" data-id="<?= (int) $b['id'] ?>" data-judul="<?= e($b['judul']) ?>" aria-label="Hapus"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
require __DIR__ . '/../includes/layout_end.php';
require __DIR__ . '/../includes/footer.php';
