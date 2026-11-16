<?php

session_start();
if (!isset($_SESSION['siswa']) && !isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_aspirasi.php';
require_once __DIR__ . '/../../template/layout.php';

$isAdmin = isset($_SESSION['admin']);
$id = (int) ($_GET['id'] ?? 0);
$r = $id > 0 ? (new Aspirasi())->getById($id) : null;

// Siswa hanya boleh melihat laporannya sendiri.
if (!$r || (!$isAdmin && (int) $r['nis'] !== (int) $_SESSION['nis'])) {
    $_SESSION['error'] = 'Aspirasi tidak ditemukan.';
    header('Location: ' . ($isAdmin ? '../ADMIN/v_DataAspirasi.php' : 'daftar_laporan.php'));
    exit;
}

$kembali = $isAdmin ? '../ADMIN/v_DataAspirasi.php' : 'daftar_laporan.php';

renderHead('Detail Aspirasi #' . $id);
renderNavbar($isAdmin ? 'admin' : 'siswa', $isAdmin ? 'aspirasi' : 'laporan');
?>
<main>
    <section class="form-card">
        <a class="back" href="<?= e($kembali) ?>">← Kembali</a>

        <span class="eyebrow">Aspirasi #<?= (int) $r['id_aspirasi'] ?></span>
        <h1>Detail Aspirasi</h1>

        <div class="report-summary">
            <div><span class="k">NIS</span><b><?= e($r['nis']) ?></b></div>
            <div><span class="k">Kelas</span><b><?= e($r['kelas']) ?></b></div>
            <div><span class="k">Kategori</span><b><?= e($r['ket_kategori']) ?></b></div>
            <div><span class="k">Status</span><b><?= badgeStatus($r['status']) ?></b></div>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan Kerusakan</label>
            <textarea id="keterangan" rows="4" readonly><?= e($r['keterangan'] ?? '-') ?></textarea>
        </div>

        <div class="form-group">
            <label for="feedback">Feedback Admin</label>
            <textarea id="feedback" rows="3" readonly><?= e($r['feedback'] ?? 'Belum ada feedback') ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto Bukti Kerusakan</label>
            <?php if (!empty($r['foto'])): ?>
                <a href="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>" target="_blank">
                    <img class="detail-photo" src="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>" alt="Foto bukti kerusakan">
                </a>
            <?php else: ?>
                <p class="muted">Foto tidak tersedia.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php renderFoot(); ?>
