<?php

session_start();
require_once __DIR__ . '/../../template/layout.php';

$type = ($_GET['type'] ?? 'siswa') === 'admin' ? 'admin' : 'siswa';

renderHead('Login', 'login-page');
?>
<section class="login-card">
    <img class="login-logo" src="<?= e(appRoot()) ?>/ASSETS/GAMBAR/logoapk.jpeg" alt="Logo sekolah">
    <h1>Sarpras Sekolah</h1>
    <p class="muted">Sistem aspirasi sarana dan prasarana sekolah</p>

    <?php flashMessages(); ?>

    <div class="tabs">
        <a class="<?= $type === 'siswa' ? 'active' : '' ?>" href="?type=siswa">👨‍🎓 Login Siswa</a>
        <a class="<?= $type === 'admin' ? 'active' : '' ?>" href="?type=admin">🛡️ Login Admin</a>
    </div>

    <?php if ($type === 'admin'): ?>
        <form method="post" action="../../CONTROLLER/c_auth.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" placeholder="Masukkan username" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password-admin">Password</label>
                <input id="password-admin" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
            </div>
            <button class="btn btn-primary" type="submit" name="login_admin">Masuk sebagai Admin</button>
        </form>
    <?php else: ?>
        <form method="post" action="../../CONTROLLER/c_auth.php">
            <div class="form-group">
                <label for="nis">NIS</label>
                <input id="nis" name="nis" inputmode="numeric" pattern="[0-9]{1,10}" placeholder="Masukkan NIS" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password-siswa">Password</label>
                <input id="password-siswa" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
            </div>
            <button class="btn btn-primary" type="submit" name="login_siswa">Masuk sebagai Siswa</button>
        </form>
        <small>Gunakan NIS dan password yang diberikan oleh admin sekolah.</small>
    <?php endif; ?>
</section>
<?php renderFoot(); ?>
