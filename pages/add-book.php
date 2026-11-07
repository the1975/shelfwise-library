<?php
require __DIR__ . '/../includes/auth.php';
$judul = 'Tambah Buku';
$halaman = 'tambah';
$flash = getFlash();

// Isian sebelumnya kalau validasi gagal
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/sidebar.php';
?>
<div class="mb-3">
  <h1 class="page-title">Tambah Buku</h1>
  <p class="text-muted-ios m-0">Isi data buku dan unggah sampulnya.</p>
</div>

<?php if ($flash): ?>
  <div class="alert-ios <?= e($flash['type']) ?>" role="alert"><?= e($flash['msg']) ?></div>
<?php endif; ?>

<form class="panel" action="<?= BASE_URL ?>/process/tambah.php" method="post" enctype="multipart/form-data">
  <div class="row g-4">
    <div class="col-md-4 col-lg-3">
      <label class="upload" for="sampul">
        <img id="preview" alt="Pratinjau sampul" hidden>
        <span class="upload-hint"><i class="bi bi-image"></i><small>Pilih sampul<br>JPG/PNG, maks 2MB</small></span>
      </label>
      <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png" hidden>
    </div>

    <div class="col-md-8 col-lg-9">
      <label class="form-label-ios" for="judul">Judul Buku</label>
      <div class="field"><input id="judul" name="judul" maxlength="150" value="<?= e($old['judul'] ?? '') ?>" required></div>

      <label class="form-label-ios" for="penulis">Penulis</label>
      <div class="field"><input id="penulis" name="penulis" maxlength="100" value="<?= e($old['penulis'] ?? '') ?>" required></div>

      <label class="form-label-ios" for="kategori">Kategori</label>
      <div class="field">
        <input id="kategori" name="kategori" maxlength="50" list="daftar-kategori" value="<?= e($old['kategori'] ?? '') ?>" required>
        <datalist id="daftar-kategori">
          <option>Novel</option><option>Sastra</option><option>Teknologi</option>
          <option>Pengembangan Diri</option><option>Psikologi</option><option>Sains</option>
          <option>Sejarah</option><option>Pendidikan</option>
        </datalist>
      </div>

      <div class="row g-3">
        <div class="col-6">
          <label class="form-label-ios" for="tahun_terbit">Tahun Terbit</label>
          <div class="field"><input type="number" id="tahun_terbit" name="tahun_terbit" min="1901" max="<?= date('Y') + 1 ?>" value="<?= e($old['tahun_terbit'] ?? '') ?>" required></div>
        </div>
        <div class="col-6">
          <label class="form-label-ios" for="stok">Stok</label>
          <div class="field"><input type="number" id="stok" name="stok" min="0" max="9999" value="<?= e($old['stok'] ?? '1') ?>" required></div>
        </div>
      </div>
      <p class="form-hint">Status otomatis: Tersedia kalau stok lebih dari 0, Dipinjam kalau 0.</p>

      <div class="form-actions">
        <a class="btn-soft" href="<?= BASE_URL ?>/pages/books.php">Batal</a>
        <button type="submit" class="btn-main"><i class="bi bi-check-lg"></i> Simpan</button>
      </div>
    </div>
  </div>
</form>
<?php
require __DIR__ . '/../includes/layout_end.php';
require __DIR__ . '/../includes/footer.php';
