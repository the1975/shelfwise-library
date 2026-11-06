<?php
require __DIR__ . '/../includes/auth.php';
$judul = 'Dashboard';
require __DIR__ . '/../includes/header.php';
?>
<main class="container py-5">
  <h1 class="h3">Halo, <?= htmlspecialchars($_SESSION['nama']) ?></h1>
  <a href="<?= BASE_URL ?>/process/logout.php" class="text-muted-ios">Keluar</a>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
