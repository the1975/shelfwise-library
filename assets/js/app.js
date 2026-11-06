// Ganti tema terang/gelap dan simpan pilihan
document.querySelectorAll('[data-toggle-tema]').forEach(btn => {
  btn.addEventListener('click', () => {
    const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
    document.documentElement.dataset.theme = next;
    localStorage.setItem('tema', next);
  });
});

// Tampilkan/sembunyikan password
document.querySelectorAll('[data-toggle-password]').forEach(btn => {
  btn.addEventListener('click', () => {
    const input = document.querySelector(btn.dataset.togglePassword);
    const tampil = input.type === 'password';
    input.type = tampil ? 'text' : 'password';
    btn.querySelector('i').className = tampil ? 'bi bi-eye' : 'bi bi-eye-slash';
  });
});
