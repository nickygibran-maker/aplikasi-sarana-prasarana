<?php

session_start();
if (!isset($_SESSION['siswa'])) {
    header('Location: ../auth/v_login.php?type=siswa');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_aspirasi.php';
require_once __DIR__ . '/../../template/layout.php';

$data = (new Aspirasi())->getByNis((int) $_SESSION['nis']);

renderHead('Aspirasi Saya');
renderNavbar('siswa', 'laporan');
?>
<main>
    <div class="page-head">
        <div>
            <span class="eyebrow">Laporan Saya</span>
            <h1>Aspirasi Saya</h1>
            <p>Daftar laporan yang kamu kirim beserta perkembangannya.</p>
        </div>
        <a class="btn btn-primary" href="v_form_aspirasi.php">＋ Kirim Aspirasi</a>
    </div>

    <?php flashMessages(); ?>

    <section class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Admin</th>
                        <th>Feedback</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$data): ?>
                    <tr><td colspan="6" class="empty">Belum ada aspirasi.</td></tr>
                <?php endif; ?>

                <?php foreach ($data as $r): ?>
                    <tr>
                        <td><b>#<?= (int) $r['id_aspirasi'] ?></b></td>
                        <td><?= e($r['ket_kategori']) ?></td>
                        <td><?= badgeStatus($r['status']) ?></td>
                        <td><?= e($r['username'] ?? '-') ?></td>
                        <td class="td-note"><?= e($r['feedback'] ?? '-') ?></td>
                        <td>
                            <?php if ($r['status'] === 'Menunggu'): ?>
                                <form method="post" action="../../CONTROLLER/c_aspirasi.php"
                                      onsubmit="return confirm('Hapus aspirasi ini?');">
                                    <input type="hidden" name="id_aspirasi" value="<?= (int) $r['id_aspirasi'] ?>">
                                    <button class="btn btn-danger btn-sm" type="submit" name="hapus_aspirasi">Hapus</button>
                                </form>
                            <?php else: ?>
                                <a class="btn btn-light btn-sm" href="DetailAspirasi.php?id=<?= (int) $r['id_aspirasi'] ?>">Detail</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php renderFoot(); ?>
