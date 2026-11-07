<?php // Chip kategori (statistik sekaligus filter); butuh $kategoriList, $total, $kat ?>
<div class="chips">
  <a class="chip <?= $kat === '' ? 'active' : '' ?>" href="<?= BASE_URL ?>/pages/books.php">Semua <span class="chip-n"><?= $total ?></span></a>
  <?php foreach ($kategoriList as $k): ?>
    <a class="chip <?= $kat === $k['kategori'] ? 'active' : '' ?>" href="<?= BASE_URL ?>/pages/books.php?kategori=<?= rawurlencode($k['kategori']) ?>">
      <?= e($k['kategori']) ?> <span class="chip-n"><?= (int) $k['jml'] ?></span>
    </a>
  <?php endforeach; ?>
</div>
