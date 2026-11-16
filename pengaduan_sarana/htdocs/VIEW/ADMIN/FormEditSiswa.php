<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_siswa.php';
require_once __DIR__ . '/../../template/layout.php';

$nis = (int) ($_GET['nis'] ?? 0);
$siswa = $nis > 0 ? (new Siswa())->getByNis($nis) : null;

if (!$siswa) {
    $_SESSION['error'] = 'Data siswa tidak ditemukan.';
    header('Location: v_DaftarSiswa.php');
    exit;
}

renderHead('Edit Siswa');
renderNavbar('admin', 'siswa');
?>
<main>
    <section class="form-card">
        <a class="back" href="v_DaftarSiswa.php">← Kembali ke Data Siswa</a>

        <span class="eyebrow">Data Siswa</span>
        <h1>✏️ Edit Siswa</h1>
        <p class="sub">Perbarui kelas atau password siswa.</p>

        <?php flashMessages(); ?>

        <form method="post" action="../../CONTROLLER/c_siswa.php" autocomplete="off">
            <input type="hidden" name="action" value="ubah">
            <input type="hidden" name="nis" value="<?= (int) $siswa['nis'] ?>">

            <div class="form-group">
                <label for="nis">NIS</label>
                <input id="nis" value="<?= (int) $siswa['nis'] ?>" readonly>
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input id="kelas" name="kelas" maxlength="10" value="<?= e($siswa['kelas']) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password baru</label>
                <input id="password" type="password" name="password" minlength="6"
                       placeholder="Kosongkan jika tidak ingin mengubah" autocomplete="new-password">
                <small class="hint">Password tersimpan terenkripsi, sehingga tidak bisa ditampilkan lagi. Isi hanya jika ingin menggantinya.</small>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                <a class="btn btn-light" href="v_DaftarSiswa.php">Batal</a>
            </div>
        </form>
    </section>
</main>
<?php renderFoot(); ?>
