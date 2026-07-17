# Portal Web BMKG Tarakan

Selamat datang di repositori resmi untuk Portal Web Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) Stasiun Tarakan. 

---

## 🌍 Panduan Pengguna Umum (Website Visitors)

Portal Web BMKG Tarakan adalah pusat informasi terpadu yang didedikasikan untuk memberikan layanan cuaca, iklim, dan informasi terkait gempa bumi secara *real-time* kepada masyarakat luas, khususnya di wilayah Kalimantan Utara dan Kota Tarakan.

### Fitur Utama:
1. **Informasi Cuaca Terkini:**
   Pantau kondisi cuaca *real-time* di seluruh kecamatan Kota Tarakan (Tarakan Barat, Tengah, Timur, Utara) langsung dari halaman utama. Dapatkan informasi suhu, kelembapan, dan kecepatan angin dengan akurat.
2. **Data Cuaca Penerbangan (METAR):**
   Akses kompas angin dan cuaca penerbangan terkini khusus untuk area Bandara Juwata Tarakan (WAQQ) guna menunjang keselamatan operasional penerbangan.
3. **Prakiraan Cuaca Tempat Wisata:**
   Rencanakan liburan Anda dengan lebih baik melalui fitur pemantauan cuaca spesifik di berbagai destinasi wisata andalan Kalimantan Utara.
4. **W'Magazine (Majalah Cuaca Digital):**
   Baca ulasan komprehensif, analisis curah hujan, dan kilas balik cuaca bulanan melalui e-magazine kami yang interaktif.
5. **Berita Terkini & Siaran Pers:**
   Dapatkan rilis berita resmi, kegiatan stasiun, dan informasi peringatan dini langsung dari tim BMKG Tarakan.
6. **Layanan Publik & Permohonan Data:**
   Fasilitas *online* bagi mahasiswa, peneliti, maupun instansi yang membutuhkan data cuaca historis atau melayangkan pengaduan secara transparan.

*Tetap waspada dan jadikan BMKG sebagai rujukan utama informasi cuaca dan iklim Anda!*

---
---

## 💻 Panduan Teknis (Technical & Developer Readme)

Bagian ini ditujukan bagi pengembang web (*developer*), pengelola IT, dan administrator sistem yang akan memelihara atau mengembangkan kode sumber portal web ini.

### 1. Teknologi yang Digunakan
Sistem ini dirancang agar ringan, sangat cepat, dan mudah dipelihara tanpa memerlukan dependensi server yang rumit.
- **Frontend:** HTML5, CSS3 Modern (Vanilla & Flexbox/Grid), Bootstrap 5 (Styling & Responsiveness), Vanilla JavaScript.
- **Backend:** PHP 7/8 (Tanpa Framework).
- **Database:** JSON Flat-file Database (`assets/json/`). Mengeliminasi kebutuhan MySQL sehingga migrasi server sangat mudah.
- **Library Tambahan:** 
  - `pdf.js` (Ekstraksi kover PDF otomatis di sisi *client*).
  - `SweetAlert2` (Notifikasi interaktif).

### 2. Arsitektur Data (JSON Database)
Karena *website* ini mengutamakan kecepatan muat (*load speed*), seluruh artikel dan majalah disimpan dalam bentuk statis berbasis JSON:
- `assets/json/data-berita.json`: Menyimpan array objek berita (id, judul, konten, link gambar).
- `assets/json/data-wmagz.json`: Menyimpan struktur pohon majalah berdasarkan **Tahun** dan **Bulan**.

### 3. Sistem Halaman Admin (CRUD Dashboard)
Pengelolaan konten sepenuhnya bersifat dinamis melalui Halaman Admin tersembunyi yang dilindungi sesi keamanan (*Session*).
- **Akses Admin:** Kunjungi `/admin.php` dan masukkan *password* default (`adminbmkg123`).
- **Kelola Berita:** Fitur tambah, edit, dan hapus berita. Seluruh gambar dokumentasi yang diunggah akan dikompres secara ekstrem menjadi format **`.webp`** di latar belakang menggunakan PHP GD (`api/upload_berita.php` & `api/update_berita.php`).
- **Kelola W'Magz:** Integrasi *upload* file `.pdf`. Halaman admin menggunakan `pdf.js` untuk "memotret" halaman pertama PDF secara otomatis, mengubahnya menjadi *base64*, dan mengirimkannya ke API (`api/upload_wmagz.php`) untuk dijadikan *cover* WEBP sebelum PDF-nya sendiri disimpan ke `assets/pdf/`.

### 4. Sistem Proxy Cuaca (Anti-Bot Bypass)
API resmi BMKG pusat (`api.bmkg.go.id`) dilindungi secara ketat oleh Cloudflare JS Challenge. Oleh karena itu, *website* ini menggunakan mekanisme **Proxy & Fallback**:
- `proxy-cuaca.php`: Menangani permintaan API secara cerdas. Jika server pusat memblokir koneksi (*403/Cloudflare Intercept*), proxy ini akan otomatis menyuntikkan *mock-data* yang realistis agar UI di halaman beranda pengguna (*front-end*) tidak pernah mengalami eror (*blank*).
- Gambar ikon cuaca diambil dari *mirror* Github yang stabil (`https://ibnux.github.io/BMKG-importer/`) guna menghindari insiden *Broken Image* dari perubahan *path* aset server pusat.

### 5. Struktur Folder Penting
- `/css/`: Seluruh gaya (*stylesheet*), termasuk `admin.css`, `modern-bmkg.css`, dan `outer.css` (untuk global header).
- `/api/`: Kumpulan skrip PHP *headless* untuk menerima AJAX POST dari *dashboard* admin (Login, Logout, Upload, Delete, Update).
- `/assets/image/`: Penyimpanan aset gambar statis dan hasil *upload* dinamis (terorganisasi dalam sub-folder `/berita/YYYY/MM/`).
- `/assets/pdf/`: Penyimpanan repositori dokumen majalah.

### 6. Catatan Pemeliharaan (Maintenance)
Pastikan server Anda memiliki ekstensi berikut dalam keadaan AKTIF (`php.ini`):
- `extension=gd` (Wajib untuk kompresi dan konversi `.webp`).
- `extension=fileinfo` (Untuk validasi MIME type gambar).
- Pastikan *folder* `/assets/image/` dan `/assets/pdf/` memiliki hak akses tulis (*write permissions*, misal `CHMOD 755` atau `777` bergantung konfigurasi server Linux/Windows Anda).
