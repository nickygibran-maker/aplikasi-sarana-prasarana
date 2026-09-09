<?php include 'layout_top.php'; ?>
<!-- Mengubah tema latar belakang khusus halaman login siswa via class body jikalau memungkinkan, atau menggunakan pembungkus full-screen -->
<div class="container" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); min-height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: 9999; display: flex; align-items: center; justify-content: center;">
    
    <div class="login-card">
        <h2>Login Siswa</h2>
        <p class="subtitle">Sistem Pengaduan Sarana & Prasarana Sekolah</p>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="error-alert">
                <strong>Gagal Masuk!</strong><br>Kombinasi NISN atau Password salah. Silakan periksa kembali data Anda.
            </div>
        <?php endif; ?>
        
        <form action="index.php?page=proses-login-siswa" method="POST">
            <div class="form-group">
                <label for="nisn">Nomor Induk Siswa Nasional (NISN)</label>
                <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN Anda" autocomplete="off" required>
            </div>
            
            <div class="form-group">
                <label for="password">Kata Sandi (Password)</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            
            <button type="submit">Masuk ke Dashboard</button>
        </form>
        
        <a href="index.php" class="back-link">&larr; Kembali ke Beranda Utama</a>
    </div>

</div>
<?php include 'layout_bottom.php'; ?>
