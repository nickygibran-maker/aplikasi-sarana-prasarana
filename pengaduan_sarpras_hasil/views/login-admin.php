<?php include 'layout_top.php'; ?>
<div class="container" style="background: linear-gradient(135deg, #1d2671 0%, #c33764 100%); min-height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: 9999; display: flex; align-items: center; justify-content: center;">
    
    <div class="login-card">
        <h2>Login Administrator</h2>
        <p class="subtitle">Panel Kontrol Validasi & Tanggapan Sarpras</p>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="error-alert">
                <strong>Akses Ditolak!</strong><br>Username atau Password salah atau akun Anda tidak memiliki hak akses admin.
            </div>
        <?php endif; ?>
        
        <form action="index.php?page=proses-login-admin" method="POST">
            <div class="form-group">
                <label for="username">Nama Pengguna (Username)</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username admin" autocomplete="off" required>
            </div>
            
            <div class="form-group">
                <label for="password">Kata Sandi (Password)</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            
            <button type="submit" class="btn-admin-theme">Otorisasi Masuk</button>
        </form>
        
        <a href="index.php" class="back-link">&larr; Kembali ke Beranda Utama</a>
    </div>

</div>
<?php include 'layout_bottom.php'; ?>
