<?php
session_start();
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Load Data for Lists
$beritaData = [];
$wmagzData = [];
if ($isLoggedIn) {
    if (file_exists('assets/json/data-berita.json')) {
        $beritaData = json_decode(file_get_contents('assets/json/data-berita.json'), true) ?? [];
    }
    if (file_exists('assets/json/data-wmagz.json')) {
        $wData = json_decode(file_get_contents('assets/json/data-wmagz.json'), true);
        $wmagzData = $wData['magazines'] ?? [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMKG Tarakan - Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
    </script>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<?php if (!$isLoggedIn): ?>
    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <img src="assets/image/LOGO.png" alt="Logo" width="60" class="mb-3">
                <h4>Admin Login</h4>
                <p class="text-muted">Silakan verifikasi identitas Anda</p>
            </div>
            <form id="loginForm">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Kode Keamanan</label>
                    <div class="d-flex align-items-center mb-2">
                        <img src="api/captcha.php" alt="CAPTCHA" id="captchaImage" class="rounded border me-2" style="cursor:pointer;" title="Klik untuk memuat ulang" onclick="this.src='api/captcha.php?r='+Math.random()">
                        <i class='bx bx-refresh fs-3 text-muted' style="cursor:pointer;" onclick="document.getElementById('captchaImage').src='api/captcha.php?r='+Math.random()"></i>
                    </div>
                    <input type="text" name="captcha" class="form-control" required placeholder="Masukkan 5 huruf/angka di atas" autocomplete="off" style="text-transform:uppercase;">
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('api/login.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if(data.success) { window.location.reload(); } 
                else { Swal.fire('Error', data.message, 'error').then(() => { window.location.reload(); }); }
            });
        });
    </script>

<?php else: ?>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="brand">
                <img src="assets/image/LOGO.png" alt="Logo" width="30">
                BMKG Admin
            </div>
            <div class="nav flex-column nav-pills mt-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-berita-list-tab" data-bs-toggle="pill" data-bs-target="#v-pills-berita-list" type="button" role="tab"><i class='bx bx-list-ul'></i> Daftar Berita</button>
                <button class="nav-link" id="v-pills-berita-add-tab" data-bs-toggle="pill" data-bs-target="#v-pills-berita-add" type="button" role="tab"><i class='bx bx-plus-circle'></i> Tambah Berita</button>
                <hr style="border-color: rgba(255,255,255,0.1)">
                <button class="nav-link" id="v-pills-wmagz-list-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wmagz-list" type="button" role="tab"><i class='bx bx-list-ul'></i> Daftar W'Magz</button>
                <button class="nav-link" id="v-pills-wmagz-add-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wmagz-add" type="button" role="tab"><i class='bx bx-plus-circle'></i> Tambah W'Magz</button>
                <a href="api/logout.php" class="nav-link mt-auto text-danger"><i class='bx bx-log-out'></i> Keluar</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard <span class="badge bg-warning text-dark" style="font-size: 0.4em; vertical-align: middle;">Full CRUD & Auto-Webp</span></h2>
                <a href="index.php" target="_blank" class="btn btn-outline-secondary"><i class='bx bx-link-external'></i> Lihat Website</a>
            </div>

            <div class="tab-content" id="v-pills-tabContent">
                
                <!-- DAFTAR BERITA -->
                <div class="tab-pane fade show active" id="v-pills-berita-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">Daftar Berita</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Gambar</th>
                                            <th>Judul Berita</th>
                                            <th>Tanggal</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($beritaData)): ?>
                                            <tr><td colspan="5" class="text-center text-muted">Belum ada berita.</td></tr>
                                        <?php else: ?>
                                            <?php foreach($beritaData as $berita): ?>
                                            <tr>
                                                <td><?= $berita['id'] ?></td>
                                                <td><img src="<?= $berita['image'] ?>" width="60" class="rounded" alt="img"></td>
                                                <td><strong><?= htmlspecialchars($berita['title']) ?></strong><br><small class="text-muted"><?= htmlspecialchars(substr($berita['summary'], 0, 50)) ?>...</small></td>
                                                <td><?= htmlspecialchars($berita['date']) ?></td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-primary" onclick='editBerita(<?= json_encode($berita) ?>)'><i class='bx bx-edit'></i> Edit</button>
                                                    <button class="btn btn-sm btn-danger" onclick='deleteBerita(<?= $berita['id'] ?>)'><i class='bx bx-trash'></i></button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAMBAH BERITA -->
                <div class="tab-pane fade" id="v-pills-berita-add" role="tabpanel">
                    <div class="card">
                        <div class="card-header">Unggah Berita Baru</div>
                        <div class="card-body">
                            <form id="formBerita">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Berita</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal (Contoh: 18 Januari 2026)</label>
                                            <input type="text" name="date" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ringkasan (Summary)</label>
                                            <textarea name="summary" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Konten Lengkap</label>
                                            <textarea name="details" class="form-control" rows="8" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Gambar Dokumentasi</label>
                                            <input type="file" name="image" id="imageBerita" class="form-control" accept="image/*" required>
                                            <small class="text-muted d-block mt-1">Akan otomatis dikompres ke format .webp</small>
                                            <div class="image-preview mt-3" id="previewBerita"><span class="text-muted">Preview Gambar</span></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mt-4" id="btnSubmitBerita"><i class='bx bx-cloud-upload'></i> Publikasikan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- DAFTAR W'MAGZ -->
                <div class="tab-pane fade" id="v-pills-wmagz-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">Daftar W'Magazine</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tahun & Bulan</th>
                                            <th>Kover</th>
                                            <th>Judul & Topik</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($wmagzData)): ?>
                                            <tr><td colspan="4" class="text-center text-muted">Belum ada majalah.</td></tr>
                                        <?php else: ?>
                                            <?php foreach($wmagzData as $year => $months): ?>
                                                <?php foreach($months as $month => $magz): ?>
                                                <tr>
                                                    <td><strong><?= $month ?> <?= $year ?></strong></td>
                                                    <td><img src="<?= $magz['coverImage'] ?>" width="60" class="rounded" alt="cover"></td>
                                                    <td><strong><?= htmlspecialchars($magz['title']) ?></strong><br><small class="text-muted"><?= htmlspecialchars($magz['summary']) ?></small></td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-primary" onclick='editWmagz(<?= json_encode($magz) ?>, "<?= $year ?>", "<?= $month ?>")'><i class='bx bx-edit'></i> Edit</button>
                                                        <button class="btn btn-sm btn-danger" onclick='deleteWmagz("<?= $year ?>", "<?= $month ?>")'><i class='bx bx-trash'></i></button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAMBAH W'MAGZ -->
                <div class="tab-pane fade" id="v-pills-wmagz-add" role="tabpanel">
                    <div class="card">
                        <div class="card-header">Unggah Edisi W'Magz</div>
                        <div class="card-body">
                            <form id="formWmagz">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tahun</label>
                                                <input type="number" name="year" class="form-control" value="<?= date('Y') ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Bulan</label>
                                                <select name="month" class="form-select" required>
                                                    <option value="January">Januari</option>
                                                    <option value="February">Februari</option>
                                                    <option value="March">Maret</option>
                                                    <option value="April">April</option>
                                                    <option value="May">Mei</option>
                                                    <option value="June">Juni</option>
                                                    <option value="July">Juli</option>
                                                    <option value="August">Agustus</option>
                                                    <option value="September">September</option>
                                                    <option value="October">Oktober</option>
                                                    <option value="November">November</option>
                                                    <option value="December">Desember</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Judul Edisi</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Sub-Judul / Topik Utama</label>
                                            <input type="text" name="summary" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">File Majalah (PDF)</label>
                                            <input type="file" name="pdfFile" id="pdfWmagz" class="form-control" accept="application/pdf" required>
                                            <input type="hidden" name="coverImageBase64" id="coverImageBase64">
                                            <div class="image-preview mt-3" id="previewWmagz"><span class="text-muted">Preview Kover</span></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mt-4" id="btnSubmitWmagz"><i class='bx bx-cloud-upload'></i> Terbitkan Majalah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT BERITA -->
    <div class="modal fade" id="modalEditBerita" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditBerita">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Berita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editBeritaId">
                        <div class="mb-3">
                            <label class="form-label">Judul Berita</label>
                            <input type="text" name="title" id="editBeritaTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="text" name="date" id="editBeritaDate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ringkasan</label>
                            <textarea name="summary" id="editBeritaSummary" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konten Lengkap</label>
                            <textarea name="details" id="editBeritaDetails" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar (Kosongkan jika tidak diganti)</label>
                            <input type="file" name="image" id="editImageBerita" class="form-control" accept="image/*">
                            <div class="image-preview mt-2" id="previewEditBerita" style="height:120px"><span class="text-muted">Preview Gambar</span></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveBerita">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT WMAGZ -->
    <div class="modal fade" id="modalEditWmagz" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditWmagz">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit W'Magz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="year" id="editWmagzYear">
                        <input type="hidden" name="month" id="editWmagzMonth">
                        <div class="alert alert-warning"><i class='bx bx-info-circle'></i> Tahun dan Bulan dikunci (<strong id="lblWmagzTime"></strong>). Hapus data ini jika Anda ingin mengubah tahun/bulannya.</div>
                        <div class="mb-3">
                            <label class="form-label">Judul Edisi</label>
                            <input type="text" name="title" id="editWmagzTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub-Judul / Topik</label>
                            <input type="text" name="summary" id="editWmagzSummary" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ganti File PDF (Kosongkan jika tidak diganti)</label>
                            <input type="file" name="pdfFile" id="editPdfWmagz" class="form-control" accept="application/pdf">
                            <input type="hidden" name="coverImageBase64" id="editCoverImageBase64">
                            <div class="image-preview mt-2" id="previewEditWmagz" style="height:120px"><span class="text-muted">Preview Kover</span></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveWmagz">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Delete Actions
        function deleteBerita(id) {
            Swal.fire({
                title: 'Hapus Berita?',
                text: "Berita yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fd = new FormData(); fd.append('id', id);
                    fetch('api/delete_berita.php', { method: 'POST', body: fd })
                    .then(r=>r.json()).then(d => { if(d.success) window.location.reload(); });
                }
            })
        }

        function deleteWmagz(year, month) {
            Swal.fire({
                title: `Hapus Majalah ${month} ${year}?`,
                text: "Data dan file PDF/Kover akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fd = new FormData(); fd.append('year', year); fd.append('month', month);
                    fetch('api/delete_wmagz.php', { method: 'POST', body: fd })
                    .then(r=>r.json()).then(d => { if(d.success) window.location.reload(); });
                }
            })
        }

        // Edit Modals
        const modalEditBerita = new bootstrap.Modal(document.getElementById('modalEditBerita'));
        function editBerita(data) {
            document.getElementById('editBeritaId').value = data.id;
            document.getElementById('editBeritaTitle').value = data.title;
            document.getElementById('editBeritaDate').value = data.date;
            document.getElementById('editBeritaSummary').value = data.summary;
            document.getElementById('editBeritaDetails').value = data.details;
            document.getElementById('previewEditBerita').innerHTML = `<img src="${data.image}">`;
            modalEditBerita.show();
        }

        const modalEditWmagz = new bootstrap.Modal(document.getElementById('modalEditWmagz'));
        function editWmagz(data, year, month) {
            document.getElementById('editWmagzYear').value = year;
            document.getElementById('editWmagzMonth').value = month;
            document.getElementById('lblWmagzTime').innerText = `${month} ${year}`;
            document.getElementById('editWmagzTitle').value = data.title;
            document.getElementById('editWmagzSummary').value = data.summary;
            document.getElementById('previewEditWmagz').innerHTML = `<img src="${data.coverImage}">`;
            modalEditWmagz.show();
        }

        // Form Submit Helpers
        function setupSubmit(formId, apiEndpoint, btnId, isReload = true) {
            document.getElementById(formId).addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = document.getElementById(btnId);
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Memproses...';
                btn.disabled = true;
                
                fetch(apiEndpoint, { method: 'POST', body: new FormData(this) })
                .then(r => r.json())
                .then(data => {
                    btn.innerHTML = originalText; btn.disabled = false;
                    if(data.success) {
                        Swal.fire('Sukses!', data.message, 'success').then(() => { if(isReload) window.location.reload(); });
                        if(!isReload) this.reset();
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                });
            });
        }
        setupSubmit('formBerita', 'api/upload_berita.php', 'btnSubmitBerita');
        setupSubmit('formWmagz', 'api/upload_wmagz.php', 'btnSubmitWmagz');
        setupSubmit('formEditBerita', 'api/update_berita.php', 'btnSaveBerita');
        setupSubmit('formEditWmagz', 'api/update_wmagz.php', 'btnSaveWmagz');

        // Previews
        function bindImagePreview(inputId, previewId) {
            document.getElementById(inputId).addEventListener('change', function(e) {
                if (e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(ev) { document.getElementById(previewId).innerHTML = `<img src="${ev.target.result}">`; }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }
        bindImagePreview('imageBerita', 'previewBerita');
        bindImagePreview('editImageBerita', 'previewEditBerita');

        function bindPdfPreview(inputId, previewId, hiddenId) {
            document.getElementById(inputId).addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type === 'application/pdf') {
                    document.getElementById(previewId).innerHTML = '<i class="bx bx-loader-alt bx-spin text-muted" style="font-size: 2rem;"></i>';
                    const fileReader = new FileReader();
                    fileReader.onload = function() {
                        pdfjsLib.getDocument(new Uint8Array(this.result)).promise.then(pdf => pdf.getPage(1))
                        .then(page => {
                            const viewport = page.getViewport({scale: 1.5});
                            const canvas = document.createElement('canvas');
                            canvas.height = viewport.height; canvas.width = viewport.width;
                            return page.render({canvasContext: canvas.getContext('2d'), viewport: viewport}).promise.then(() => {
                                const base64Data = canvas.toDataURL('image/jpeg', 0.8);
                                document.getElementById(hiddenId).value = base64Data;
                                document.getElementById(previewId).innerHTML = `<img src="${base64Data}">`;
                            });
                        });
                    };
                    fileReader.readAsArrayBuffer(file);
                }
            });
        }
        bindPdfPreview('pdfWmagz', 'previewWmagz', 'coverImageBase64');
        bindPdfPreview('editPdfWmagz', 'previewEditWmagz', 'editCoverImageBase64');
    </script>
<?php endif; ?>
</body>
</html>
