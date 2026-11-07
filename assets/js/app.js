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

// Pencarian langsung di halaman lain: dropdown hasil singkat
if (formCari && !hasil) {
  const input = formCari.querySelector('input[name="q"]');
  const kotak = document.getElementById('hasil-cari');
  let timer, ctrl;

  const el = (tag, cls, teks) => {
    const n = document.createElement(tag);
    n.className = cls;
    if (teks) n.textContent = teks;
    return n;
  };
  const tutup = () => { kotak.hidden = true; kotak.replaceChildren(); };
  const urlBuku = (q) => `${formCari.action}?q=${encodeURIComponent(q)}`;

  // Susun daftar hasil (textContent, bukan innerHTML, supaya aman dari XSS)
  const tampil = (data, q) => {
    kotak.replaceChildren();
    if (!data.length) kotak.append(el('p', 'search-empty', 'Buku tidak ditemukan.'));
    data.forEach(b => {
      const baris = el('a', 'search-item');
      baris.href = urlBuku(b.judul);
      const info = el('div', 'book-info');
      info.append(
        el('p', 'book-title text-truncate m-0', b.judul),
        el('p', 'book-meta text-truncate m-0', `${b.penulis} · ${b.tahun}`)
      );
      baris.append(info, el('span', `pill ${b.warna}`, b.status));
      kotak.append(baris);
    });
    if (data.length) {
      const semua = el('a', 'search-all', 'Lihat semua hasil');
      semua.href = urlBuku(q);
      kotak.append(semua);
    }
    kotak.hidden = false;
  };

  input.addEventListener('input', () => {
    clearTimeout(timer);
    const q = input.value.trim();
    if (!q) return tutup();
    timer = setTimeout(async () => {
      ctrl?.abort();
      ctrl = new AbortController();
      try {
        const res = await fetch(`${formCari.dataset.cari}?q=${encodeURIComponent(q)}`, { signal: ctrl.signal });
        tampil(await res.json(), q);
      } catch (err) {
        if (err.name !== 'AbortError') tutup();
      }
    }, 300);
  });

  // Tutup dengan Esc atau klik di luar
  input.addEventListener('keydown', e => { if (e.key === 'Escape') tutup(); });
  document.addEventListener('click', e => { if (!formCari.contains(e.target)) tutup(); });
}
