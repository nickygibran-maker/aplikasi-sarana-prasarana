<?php

session_start();
if (!isset($_SESSION['siswa'])) {
    header('Location: ../auth/v_login.php?type=siswa');
    exit;
}

require_once __DIR__ . '/../../template/layout.php';

renderHead('Profil Siswa');
renderNavbar('siswa', 'profil');
?>
<main>
    <section class="form-card">
        <span class="eyebrow">Akun</span>
        <h1>👤 Profil Siswa</h1>
        <p class="sub">Informasi akun yang sedang kamu gunakan.</p>

        <?php flashMessages(); ?>

        <div class="form-group">
            <label for="nis">NIS</label>
            <input id="nis" value="<?= e($_SESSION['nis']) ?>" readonly>
        </div>

        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input id="kelas" value="<?= e($_SESSION['kelas']) ?>" readonly>
        </div>
    </section>

    <section class="form-card">
        <span class="eyebrow">Keamanan</span>
        <h2>🔒 Ganti Password</h2>
        <p class="sub">Gunakan password yang mudah kamu ingat tetapi sulit ditebak orang lain.</p>

        <form method="post" action="../../CONTROLLER/c_profil.php" autocomplete="off">
            <div class="form-group">
                <label for="password_lama">Password lama</label>
                <input id="password_lama" type="password" name="password_lama" autocomplete="current-password" required>
            </div>

            <div class="form-group">
                <label for="password_baru">Password baru</label>
                <input id="password_baru" type="password" name="password_baru" minlength="6"
                       placeholder="Minimal 6 karakter" autocomplete="new-password" required>
            </div>

            <div class="form-group">
                <label for="konfirmasi_password">Ulangi password baru</label>
                <input id="konfirmasi_password" type="password" name="konfirmasi_password" minlength="6"
                       autocomplete="new-password" required>
            </div>

            <button class="btn btn-primary btn-block" type="submit" name="ganti_password">Simpan Password Baru</button>
        </form>
    </section>
</main>
<?php renderFoot(); ?>
