<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_umpanbalik.php';
require_once __DIR__ . '/../../template/layout.php';

$m = new UmpanBalik();
$data = $m->getAll();
$selectedId = (int) ($_GET['id'] ?? 0);
$selected = $selectedId > 0 ? $m->getById($selectedId) : null;

renderHead('Umpan Balik');
renderNavbar('admin', 'umpan');
?>
<main>
    <div class="page-head">
        <div>
            <span class="eyebrow">Komunikasi Admin</span>
            <h1>💬 Umpan Balik</h1>
            <p>Berikan tanggapan langsung pada laporan siswa.</p>
        </div>
        <a class="btn btn-light" href="v_DataAspirasi.php">📋 Kelola Aspirasi</a>
    </div>

    <?php flashMessages(); ?>

    <div class="feedback-layout">
        <section class="table-card">
            <div class="section-head">
                <div>
                    <h2>Daftar Laporan</h2>
                    <p>Pilih laporan untuk memberikan atau memperbarui feedback.</p>
                </div>
                <span class="count-pill"><?= count($data) ?> laporan</span>
            </div>

            <div class="feedback-list">
                <?php if (!$data): ?>
                    <div class="empty">Belum ada aspirasi yang masuk.</div>
                <?php endif; ?>

                <?php foreach ($data as $r): ?>
                    <?php $id = (int) $r['id_aspirasi']; ?>
                    <a class="feedback-item <?= $selectedId === $id ? 'selected' : '' ?>" href="?id=<?= $id ?>">
                        <div class="feedback-top">
                            <strong>#<?= $id ?> · <?= e($r['ket_kategori']) ?></strong>
                            <?= badgeStatus($r['status']) ?>
                        </div>
                        <div class="feedback-meta">NIS <?= e($r['nis']) ?> · <?= e($r['kelas']) ?></div>
                        <div class="feedback-preview"><?= e($r['feedback'] ?: 'Belum ada umpan balik') ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="form-card feedback-form">
            <?php if ($selected): ?>
                <span class="eyebrow">Laporan #<?= (int) $selected['id_aspirasi'] ?></span>
                <h2>Berikan Umpan Balik</h2>
                <p class="sub">Tanggapan ini akan tampil pada akun siswa.</p>

                <div class="report-summary">
                    <div><span class="k">NIS</span><b><?= e($selected['nis']) ?></b></div>
                    <div><span class="k">Kelas</span><b><?= e($selected['kelas']) ?></b></div>
                    <div><span class="k">Kategori</span><b><?= e($selected['ket_kategori']) ?></b></div>
                    <div><span class="k">Status</span><b><?= badgeStatus($selected['status']) ?></b></div>
                </div>

                <form method="post" action="../../CONTROLLER/c_umpanbalik.php">
                    <input type="hidden" name="id_aspirasi" value="<?= (int) $selected['id_aspirasi'] ?>">

                    <div class="form-group">
                        <label for="feedback">Umpan Balik</label>
                        <textarea id="feedback" name="feedback" rows="7" maxlength="255"
                                  placeholder="Tulis tanggapan untuk siswa..." required><?= e($selected['feedback'] ?? '') ?></textarea>
                        <small class="hint">Maksimal 255 karakter.</small>
                    </div>

                    <button class="btn btn-primary feedback-submit" type="submit" name="simpan_feedback">💬 Simpan &amp; Kirim Feedback</button>
                </form>
            <?php else: ?>
                <div class="feedback-empty">
                    <div class="empty-icon">💬</div>
                    <h2>Pilih laporan</h2>
                    <p>Pilih salah satu aspirasi di sebelah kiri untuk mulai memberikan umpan balik.</p>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php renderFoot(); ?>
