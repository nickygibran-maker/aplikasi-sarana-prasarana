<?php

session_start();
if (!isset($_SESSION['siswa']) && !isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_histori.php';
require_once __DIR__ . '/../../template/layout.php';

$h = new Histori();
$isAdmin = isset($_SESSION['admin']);
$data = $isAdmin ? $h->getAll() : $h->getBySiswa((int) $_SESSION['nis']);

renderHead('Histori Aspirasi');
renderNavbar($isAdmin ? 'admin' : 'siswa', 'histori');
?>
<main>
    <div class="page-head">
        <div>
            <span class="eyebrow">Riwayat</span>
            <h1>🕘 Histori Aspirasi</h1>
            <p>Riwayat laporan, foto bukti, perubahan status, dan feedback.</p>
        </div>
    </div>

    <section class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Aspirasi</th>
                        <th>NIS</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Foto Bukti</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$data): ?>
                    <tr><td colspan="9" class="empty">Belum ada histori.</td></tr>
                <?php endif; ?>

                <?php foreach ($data as $r): ?>
                    <tr>
                        <td>#<?= (int) $r['id_histori'] ?></td>
                        <td>#<?= (int) $r['id_aspirasi'] ?></td>
                        <td><?= e($r['nis']) ?></td>
                        <td><?= e($r['ket_kategori'] ?? '-') ?></td>
                        <td class="td-note"><?= !empty($r['keterangan']) ? nl2br(e($r['keterangan'])) : '<span class="muted">-</span>' ?></td>
                        <td>
                            <?php if (!empty($r['foto'])): ?>
                                <a class="thumb-link" href="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>" target="_blank" title="Klik untuk melihat foto">
                                    <img class="thumb" src="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>" alt="Bukti kerusakan">
                                    <small>Klik foto</small>
                                </a>
                            <?php else: ?>
                                <span class="muted">Tidak ada foto</span>
                            <?php endif; ?>
                        </td>
                        <td><?= badgeStatus($r['status']) ?></td>
                        <td class="td-note"><?= e($r['feedback'] ?? '-') ?></td>
                        <td><?= e($r['tanggal']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php renderFoot(); ?>
