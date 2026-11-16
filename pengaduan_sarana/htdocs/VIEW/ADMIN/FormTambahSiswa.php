<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

require_once __DIR__ . '/../../template/layout.php';

renderHead('Tambah Siswa');
renderNavbar('admin', 'siswa');
?>
<main>
    <section class="form-card">
        <a class="back" href="v_DaftarSiswa.php">← Kembali ke Data Siswa</a>

        <span class="eyebrow">Data Siswa</span>
        <h1>➕ Tambah Siswa</h1>
        <p class="sub">Isi NIS, kelas, dan password awal untuk login siswa.</p>

        <?php flashMessages(); ?>

        <form method="post" action="../../CONTROLLER/c_siswa.php" autocomplete="off">
            <input type="hidden" name="action" value="tambah">

            <div class="form-group">
                <label for="nis">NIS</label>
                <input id="nis" name="nis" inputmode="numeric" pattern="[0-9]{1,10}" maxlength="10"
                       placeholder="Contoh: 2026111" required>
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input id="kelas" name="kelas" maxlength="10" placeholder="Contoh: XII RPL 1" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" minlength="6"
                       placeholder="Minimal 6 karakter" autocomplete="new-password" required>
                <small class="hint">Berikan password ini kepada siswa untuk login pertama kali.</small>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">Simpan Siswa</button>
                <a class="btn btn-light" href="v_DaftarSiswa.php">Batal</a>
            </div>
        </form>
    </section>
</main>
<?php renderFoot(); ?>
