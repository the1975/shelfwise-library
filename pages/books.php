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
$kosong = $q !== '' ? 'Buku tidak ditemukan.' : 'Belum ada buku.';

// Statistik seluruh koleksi (tidak terpengaruh pencarian)
$total    = (int) $pdo->query('SELECT COUNT(*) FROM buku')->fetchColumn();
$tersedia = (int) $pdo->query('SELECT COUNT(*) FROM buku WHERE stok > 0')->fetchColumn();
$dipinjam = $total - $tersedia;

require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/sidebar.php';
?>
<?php require __DIR__ . '/../includes/stat-cards.php'; ?>

<?php if ($flash): ?>
  <div class="alert-ios <?= e($flash['type']) ?>" role="alert"><?= e($flash['msg']) ?></div>
<?php endif; ?>

<div class="panel" id="hasil-buku">

  <!-- Layar lebar: tabel -->
  <div class="table-responsive d-none d-md-block">
    <table class="table table-ios table-hover align-middle">
      <thead>
        <tr>
          <th>Buku</th><th>Kategori</th><th>Tahun</th><th>Stok</th><th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$daftar): ?>
          <tr><td colspan="6" class="text-center text-muted-ios py-4"><?= $kosong ?></td></tr>
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
            <td><?= e($b['kategori']) ?></td>
            <td><?= e((string) $b['tahun_terbit']) ?></td>
            <td><?= (int) $b['stok'] ?></td>
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

  <!-- HP: baris yang bisa digeser -->
  <div class="d-md-none">
    <?php if (!$daftar): ?>
      <p class="text-center text-muted-ios py-3 m-0"><?= $kosong ?></p>
    <?php else: ?>
      <p class="text-muted-ios small mb-2"><i class="bi bi-arrow-left-right"></i> Geser baris ke kiri untuk edit atau hapus</p>
    <?php endif; ?>
    <?php foreach ($daftar as $b): [$label, $warna] = statusBuku((int) $b['stok']); ?>
      <div class="swipe">
        <div class="swipe-content">
          <?php if ($b['sampul']): ?>
            <img class="cover" src="<?= BASE_URL ?>/uploads/<?= rawurlencode($b['sampul']) ?>" alt="">
          <?php else: ?>
            <div class="cover"><i class="bi bi-book"></i></div>
          <?php endif; ?>
          <div class="book-info">
            <p class="book-title text-truncate m-0"><?= e($b['judul']) ?></p>
            <p class="book-meta text-truncate m-0"><?= e($b['penulis']) ?> · <?= e((string) $b['tahun_terbit']) ?></p>
          </div>
          <span class="pill <?= $warna ?>"><?= $label ?></span>
        </div>
        <div class="swipe-actions">
          <a class="edit" href="<?= BASE_URL ?>/pages/edit-book.php?id=<?= (int) $b['id'] ?>"><i class="bi bi-pencil"></i>Edit</a>
          <button type="button" class="hapus btn-hapus" data-id="<?= (int) $b['id'] ?>" data-judul="<?= e($b['judul']) ?>"><i class="bi bi-trash"></i>Hapus</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
<?php
require __DIR__ . '/../includes/layout_end.php';
require __DIR__ . '/../includes/footer.php';
