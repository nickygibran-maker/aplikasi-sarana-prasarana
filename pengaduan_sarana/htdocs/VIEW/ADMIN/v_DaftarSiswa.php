<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_siswa.php';
require_once __DIR__ . '/../../template/layout.php';

$daftar = (new Siswa())->getAll();

renderHead('Data Siswa');
renderNavbar('admin', 'siswa');
?>
<main>
    <div class="page-head">
        <div>
            <span class="eyebrow">Manajemen Siswa</span>
            <h1>Data Siswa</h1>
            <p>Tambah, ubah, dan hapus data siswa beserta akun login-nya.</p>
        </div>
        <a class="btn btn-primary" href="FormTambahSiswa.php">＋ Tambah Siswa</a>
    </div>

    <?php flashMessages(); ?>

    <section class="table-card">
        <div class="section-head">
            <div>
                <h2>Daftar Siswa</h2>
                <p>Siswa login memakai NIS dan password.</p>
            </div>
            <span class="count-pill"><?= count($daftar) ?> siswa</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$daftar): ?>
                    <tr><td colspan="4" class="empty">Belum ada data siswa.</td></tr>
                <?php endif; ?>

                <?php foreach ($daftar as $no => $s): ?>
                    <?php $nis = (int) $s['nis']; ?>
                    <tr>
                        <td><?= $no + 1 ?></td>
                        <td><b><?= $nis ?></b></td>
                        <td><span class="badge badge-kelas"><?= e($s['kelas']) ?></span></td>
                        <td>
                            <div class="inline-form">
                                <a class="btn btn-light btn-sm" href="FormEditSiswa.php?nis=<?= $nis ?>">✏️ Edit</a>
                                <form method="post" action="../../CONTROLLER/c_siswa.php"
                                      onsubmit="return confirm('Hapus siswa NIS <?= $nis ?>? Aspirasi siswa ini juga ikut terhapus.');">
                                    <input type="hidden" name="action" value="hapus">
                                    <input type="hidden" name="nis" value="<?= $nis ?>">
                                    <button class="btn btn-danger btn-sm" type="submit">🗑 Hapus</button>
                                </form>
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
