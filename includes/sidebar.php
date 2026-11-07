<?php
// Sidebar + topbar; isi $halaman untuk menandai menu aktif
$halaman = $halaman ?? '';
$aktif = fn(string $k): string => $halaman === $k ? 'active' : '';
$nama = $_SESSION['nama'] ?? 'Admin';
?>
<div class="app">
  <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar">
    <div class="sidebar-inner">
      <div class="sidebar-brand">
        <i class="bi bi-book-half"></i>
        <div><strong>Shelfwise</strong><small>Digital Library</small></div>
      </div>
      <nav>
        <a class="nav-item-ios <?= $aktif('dashboard') ?>" href="<?= BASE_URL ?>/pages/dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <p class="nav-label">Manajemen</p>
        <a class="nav-item-ios <?= $aktif('buku') ?>" href="<?= BASE_URL ?>/pages/books.php"><i class="bi bi-book"></i> Buku</a>
        <a class="nav-item-ios <?= $aktif('tambah') ?>" href="<?= BASE_URL ?>/pages/add-book.php"><i class="bi bi-plus-lg"></i> Tambah Buku</a>
        <hr class="my-3" style="border-color: var(--line); opacity: 1;">
        <a class="nav-item-ios" href="<?= BASE_URL ?>/process/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
      </nav>
    </div>
  </aside>

  <div class="app-main">
    <header class="topbar">
      <button class="menu-btn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-label="Menu">
        <i class="bi bi-list"></i>
      </button>
      <form class="search" action="<?= BASE_URL ?>/pages/books.php" method="get" data-cari="<?= BASE_URL ?>/process/cari.php" autocomplete="off">
        <i class="bi bi-search"></i>
        <input type="search" name="q" placeholder="Cari buku..." value="<?= e($_GET["q"] ?? "") ?>">
        <div class="search-results" id="hasil-cari" hidden></div>
        <?php if (!empty($filterBuku)) require __DIR__ . "/filter-buku.php"; ?>
      </form>
      <button type="button" class="tema-btn ms-auto d-none d-md-flex" data-toggle-tema aria-label="Ganti tema">
        <i class="bi bi-moon icon-moon"></i><i class="bi bi-sun icon-sun"></i>
      </button>
      <div class="dropdown">
        <button class="user-chip" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="avatar"><?= htmlspecialchars(strtoupper(substr($nama, 0, 1))) ?></span>
          <span class="d-none d-sm-inline"><?= htmlspecialchars($nama) ?></span>
          <i class="bi bi-chevron-down small d-none d-sm-inline"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><button type="button" class="dropdown-item" data-toggle-tema><i class="bi bi-circle-half me-2"></i>Ganti tema</button></li>
          <li><a class="dropdown-item" href="<?= BASE_URL ?>/process/logout.php">Keluar</a></li>
        </ul>
      </div>
    </header>
