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

// Pencarian langsung di halaman Buku
const formCari = document.querySelector('.search');
const hasil = document.getElementById('hasil-buku');
if (formCari && hasil) {
  const input = formCari.querySelector('input[name="q"]');
  let timer, ctrl;

  input.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(async () => {
      ctrl?.abort();
      ctrl = new AbortController();
      const url = new URL(formCari.action);
      url.searchParams.set('q', input.value.trim());
      try {
        const res = await fetch(url, { signal: ctrl.signal });
        const doc = new DOMParser().parseFromString(await res.text(), 'text/html');
        hasil.innerHTML = doc.getElementById('hasil-buku').innerHTML;
        document.getElementById('jumlah').textContent = doc.getElementById('jumlah').textContent.trim();
        history.replaceState(null, '', url);
      } catch (err) {
        if (err.name !== 'AbortError') console.error(err);
      }
    }, 300);
  });
}
