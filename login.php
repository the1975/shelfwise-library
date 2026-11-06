<?php
require __DIR__ . '/config/database.php';
$judul = 'Masuk';
require __DIR__ . '/includes/header.php';
?>
<main class="container d-flex align-items-center justify-content-center min-vh-100 py-4">
  <div class="w-100" style="max-width: 400px;">
    <div class="text-end mb-3">
      <button class="btn btn-link text-muted-ios p-0" data-toggle-tema aria-label="Ganti tema">
        <i class="bi bi-circle-half fs-5"></i>
      </button>
    </div>
    <div class="card-ios text-center">
      <div class="brand-icon mx-auto mb-3"><i class="bi bi-book-half"></i></div>
      <h1 class="h3 fw-semibold mb-1">Perpustakaan</h1>
      <p class="text-muted-ios mb-4">Masuk untuk mengelola koleksi buku.</p>
      <form action="<?= BASE_URL ?>/process/login.php" method="post" class="text-start">
        <label class="field">
          <i class="bi bi-person"></i>
          <input type="text" name="username" placeholder="Username" required autofocus>
        </label>
        <label class="field">
          <i class="bi bi-lock"></i>
          <input type="password" id="password" name="password" placeholder="Password" required>
          <button type="button" class="btn p-0 border-0" data-toggle-password="#password">
            <i class="bi bi-eye-slash"></i>
          </button>
        </label>
        <div class="form-check form-switch my-3">
          <input class="form-check-input" type="checkbox" role="switch" id="ingat" name="ingat">
          <label class="form-check-label" for="ingat">Ingat saya</label>
        </div>
        <button type="submit" class="btn-accent">Masuk</button>
      </form>
    </div>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
