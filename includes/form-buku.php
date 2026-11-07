<?php
// Form buku bersama (tambah dan edit)
// Butuh: $aksi, $data, $sampulLama, $idBuku; opsional $tombol
$tombol = $tombol ?? 'Simpan';
?>
<form class="panel" action="<?= e($aksi) ?>" method="post" enctype="multipart/form-data">
  <?php if ($idBuku): ?>
    <input type="hidden" name="id" value="<?= (int) $idBuku ?>">
  <?php endif; ?>
  <div class="row g-4">
    <div class="col-md-4 col-lg-3">
      <label class="upload" for="sampul">
        <img id="preview" alt="Pratinjau sampul" <?= $sampulLama ? 'src="' . e(BASE_URL . '/uploads/' . rawurlencode($sampulLama)) . '"' : 'hidden' ?>>
        <span class="upload-hint"><i class="bi bi-image"></i><small>Pilih sampul<br>JPG/PNG, maks 2MB</small></span>
      </label>
      <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png" hidden>
      <?php if ($sampulLama): ?>
        <p class="form-hint text-center mt-2 mb-0">Klik gambar untuk mengganti sampul.</p>
      <?php endif; ?>
    </div>

    <div class="col-md-8 col-lg-9">
      <label class="form-label-ios" for="judul">Judul Buku</label>
      <div class="field"><input id="judul" name="judul" maxlength="150" value="<?= e($data['judul'] ?? '') ?>" required></div>

      <label class="form-label-ios" for="penulis">Penulis</label>
      <div class="field"><input id="penulis" name="penulis" maxlength="100" value="<?= e($data['penulis'] ?? '') ?>" required></div>

      <label class="form-label-ios" for="kategori">Kategori</label>
      <div class="field">
        <input id="kategori" name="kategori" maxlength="50" list="daftar-kategori" value="<?= e($data['kategori'] ?? '') ?>" required>
        <datalist id="daftar-kategori">
          <option>Novel</option><option>Sastra</option><option>Teknologi</option>
          <option>Pengembangan Diri</option><option>Psikologi</option><option>Sains</option>
          <option>Sejarah</option><option>Pendidikan</option>
        </datalist>
      </div>

      <div class="row g-3">
        <div class="col-6">
          <label class="form-label-ios" for="tahun_terbit">Tahun Terbit</label>
          <div class="field"><input type="number" id="tahun_terbit" name="tahun_terbit" min="1901" max="<?= date('Y') + 1 ?>" value="<?= e((string) ($data['tahun_terbit'] ?? '')) ?>" required></div>
        </div>
        <div class="col-6">
          <label class="form-label-ios" for="stok">Stok</label>
          <div class="field"><input type="number" id="stok" name="stok" min="0" max="9999" value="<?= e((string) ($data['stok'] ?? '')) ?>" required></div>
        </div>
      </div>
      <p class="form-hint">Status otomatis: Tersedia kalau stok lebih dari 0, Dipinjam kalau 0.</p>

      <div class="form-actions">
        <a class="btn-soft" href="<?= BASE_URL ?>/pages/books.php">Batal</a>
        <button type="submit" class="btn-main"><i class="bi bi-check-lg"></i> <?= e($tombol) ?></button>
      </div>
    </div>
  </div>
</form>
