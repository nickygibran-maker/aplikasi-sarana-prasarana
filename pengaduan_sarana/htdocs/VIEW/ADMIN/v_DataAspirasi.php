<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_aspirasi.php';
require_once __DIR__ . '/../../template/layout.php';

$data = (new Aspirasi())->getAll();

renderHead('Data Aspirasi');
renderNavbar('admin', 'aspirasi');
?>
<main>
    <div class="page-head">
        <div>
            <span class="eyebrow">Laporan Masuk</span>
            <h1>📋 Data Aspirasi</h1>
            <p>Kelola status laporan kerusakan dan lihat foto bukti dari siswa.</p>
        </div>
        <a class="btn btn-primary" href="UmpanBalik.php">💬 Umpan Balik</a>
    </div>

    <?php flashMessages(); ?>

    <section class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Foto Bukti</th>
                        <th>Status</th>
                        <th>Admin</th>
                        <th>Feedback &amp; Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$data): ?>
                    <tr><td colspan="9" class="empty">Belum ada data aspirasi.</td></tr>
                <?php endif; ?>

                <?php foreach ($data as $r): ?>
                    <?php $id = (int) $r['id_aspirasi']; ?>
                    <tr>
                        <td>
                            <?php /* Form diberi id agar input di kolom lain bisa dikaitkan lewat atribut form= */ ?>
                            <form id="form-<?= $id ?>" method="post" action="../../CONTROLLER/c_aspirasi.php"></form>
                            <b>#<?= $id ?></b>
                        </td>
                        <td><?= e($r['nis']) ?></td>
                        <td><?= e($r['kelas']) ?></td>
                        <td><?= e($r['ket_kategori']) ?></td>
                        <td class="td-note"><?= !empty($r['keterangan']) ? nl2br(e($r['keterangan'])) : '<span class="muted">-</span>' ?></td>
                        <td>
                            <?php if (!empty($r['foto'])): ?>
                                <a class="thumb-link" href="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>" target="_blank" title="Lihat foto ukuran penuh">
                                    <img class="thumb" src="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>" alt="Bukti kerusakan">
                                    <small>Klik foto</small>
                                </a>
                            <?php else: ?>
                                <span class="muted">Tidak ada foto</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <select name="status" form="form-<?= $id ?>" aria-label="Status aspirasi #<?= $id ?>">
                                <?php foreach (['Menunggu', 'Proses', 'Selesai'] as $opsi): ?>
                                    <option value="<?= $opsi ?>" <?= $r['status'] === $opsi ? 'selected' : '' ?>><?= $opsi ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?= e($r['username'] ?? '-') ?></td>
                        <td>
                            <div class="inline-form">
                                <input type="hidden" name="id_aspirasi" value="<?= $id ?>" form="form-<?= $id ?>">
                                <input class="feedback-input" name="feedback" form="form-<?= $id ?>"
                                       value="<?= e($r['feedback'] ?? '') ?>" placeholder="Tulis feedback">
                                <button class="btn btn-primary btn-sm" type="submit" name="ubah_status" form="form-<?= $id ?>">Simpan</button>
                                <a class="btn btn-light btn-sm" href="UmpanBalik.php?id=<?= $id ?>">💬 Feedback</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php renderFoot(); ?>
