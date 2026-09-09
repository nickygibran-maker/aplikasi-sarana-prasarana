<?php include 'views/layout_top.php'; ?>
<div class="main-wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Formulir Pengaduan Sarpras</h2>
        <p>Halo, <strong><?= htmlspecialchars($_SESSION['user']['nama']); ?></strong>. Laporkan fasilitas sekolah di sini.</p>
        
        <form action="index.php?page=siswa-kirim" method="POST" enctype="multipart/form-data">
            <label>Kategori Fasilitas</label>
            <select name="kategori" required>
                <option value="Ruang Kelas">Ruang Kelas</option>
                <option value="Laboratorium">Laboratorium</option>
                <option value="Toilet">Toilet</option>
                <option value="Olahraga">Fasilitas Olahraga</option>
            </select>
            
            <label>Deskripsi Kerusakan</label>
            <textarea name="deskripsi" rows="5" required></textarea>
            
            <label>Foto Bukti</label>
            <input type="file" name="foto" required>
            
            <button type="submit">Kirim Laporan</button>
        </form>
    </div>
</div>
<?php include 'views/layout_bottom.php'; ?>
