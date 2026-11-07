<?php
require __DIR__ . '/../includes/auth.php';
$judul = 'Profil';
$halaman = 'profil';
$flash = getFlash();

// Data akun yang sedang login
$stmt = $pdo->prepare('SELECT username, nama, role, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$akun = $stmt->fetch();
if (!$akun) {
    redirect('/process/logout.php');
}
$admin = $akun['role'] === 'admin';

require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/sidebar.php';
?>
<div class="mb-3">
  <h1 class="page-title">Profil</h1>
</div>

<?php if ($flash): ?>
  <div class="alert-ios <?= e($flash['type']) ?>" role="alert"><?= e($flash['msg']) ?></div>
<?php endif; ?>

<div class="row g-3">
  <div class="col-lg-4">
    <div class="panel text-center">
      <div class="avatar-besar"><?= e(strtoupper(substr($akun['nama'], 0, 1))) ?></div>
      <h2 class="h5 fw-bold mb-1"><?= e($akun['nama']) ?></h2>
      <p class="text-muted-ios mb-2">@<?= e($akun['username']) ?></p>
      <span class="badge-peran"><?= $admin ? 'Admin' : 'Pengunjung' ?></span>
      <div class="info-row mt-3"><span class="text-muted-ios">Bergabung</span><span><?= e(date('d/m/Y', strtotime($akun['created_at']))) ?></span></div>
      <div class="info-row"><span class="text-muted-ios">Hak akses</span><span><?= $admin ? 'Kelola buku' : 'Lihat dan cari buku' ?></span></div>
    </div>
  </div>

  <div class="col-lg-8">
    <form class="panel" action="<?= BASE_URL ?>/process/ganti-password.php" method="post">
      <h2 class="h5 fw-bold mb-3">Ganti password</h2>

      <label class="form-label-ios" for="pw-lama">Password saat ini</label>
      <label class="field">
        <i class="bi bi-lock"></i>
        <input type="password" id="pw-lama" name="lama" autocomplete="current-password" required>
        <button type="button" class="btn p-0 border-0" data-toggle-password="#pw-lama"><i class="bi bi-eye-slash"></i></button>
      </label>

      <label class="form-label-ios mt-3" for="pw-baru">Password baru</label>
      <label class="field">
        <i class="bi bi-key"></i>
        <input type="password" id="pw-baru" name="baru" minlength="8" autocomplete="new-password" required>
        <button type="button" class="btn p-0 border-0" data-toggle-password="#pw-baru"><i class="bi bi-eye-slash"></i></button>
      </label>
      <p class="form-hint">Minimal 8 karakter dan berbeda dari password saat ini.</p>

      <label class="form-label-ios" for="pw-ulang">Ulangi password baru</label>
      <label class="field">
        <i class="bi bi-key"></i>
        <input type="password" id="pw-ulang" name="ulang" minlength="8" autocomplete="new-password" required>
        <button type="button" class="btn p-0 border-0" data-toggle-password="#pw-ulang"><i class="bi bi-eye-slash"></i></button>
      </label>

      <div class="form-actions">
        <button type="submit" class="btn-main"><i class="bi bi-check-lg"></i> Simpan password</button>
      </div>
    </form>
  </div>
</div>
<?php
require __DIR__ . '/../includes/layout_end.php';
require __DIR__ . '/../includes/footer.php';
