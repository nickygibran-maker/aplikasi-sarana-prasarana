<?php include 'views/layout_top.php'; ?>
<div class="main-wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Proses Validasi & Tanggapan Pengaduan</h2>
        
        <?php if (empty($detail) || $detail === false): ?>
            <div class="error" style="background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin-bottom: 15px;">
                <strong>Sistem Informasi:</strong> Data pengaduan tidak ditemukan di database.
                <br><br>
                <small style="color: #555;">Catatan debug parameter URL saat ini: ID = <?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'Kosong/Tidak terkirim'; ?></small>
            </div>
            <a href="index.php?page=admin-aspirasi" class="btn">Kembali ke Daftar Laporan</a>
        <?php else: ?>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="width: 150px; font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Nama Pelapor</td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($detail['nama']) ? htmlspecialchars($detail['nama']) : 'Siswa (Tidak Diketahui)'; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Kategori Sarpras</td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($detail['kategori']) ? htmlspecialchars($detail['kategori']) : '-'; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Tanggal Masuk</td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($detail['tanggal']) ? htmlspecialchars($detail['tanggal']) : '-'; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Deskripsi Laporan</td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($detail['deskripsi']) ? nl2br(htmlspecialchars($detail['deskripsi'])) : '-'; ?></td>
                </tr>
            </table>

            <p><strong>Foto Keadaan Fasilitas:</strong><br>
                <?php if (!empty($detail['foto']) && file_exists("assets/img/" . $detail['foto'])): ?>
                    <img src="assets/img/<?= htmlspecialchars($detail['foto']); ?>" width="350" alt="Bukti Kerusakan" style="border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 5px;">
                <?php else: ?>
                    <span style="color: #6c757d; font-style: italic;">Foto tidak tersedia atau file gambar hilang</span>
                <?php endif; ?>
            </p>
            
            <hr style="border: 0; border-top: 1px solid #ddd; margin: 25px 0;">
            
            <form action="index.php?page=admin-tanggapi" method="POST" style="background: #f8f9fa; padding: 20px; border-radius: 6px; border: 1px solid #e3e6f0;">
                <input type="hidden" name="id_aspirasi" value="<?= isset($detail['id_aspirasi']) ? $detail['id_aspirasi'] : ''; ?>">
                
                <label for="status" style="display: block; font-weight: bold; margin-bottom: 5px;">Ubah Status Tindakan</label>
                <select name="status" id="status" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;" required>
                    <option value="Pending" <?= (isset($detail['status']) && $detail['status'] == 'Pending') ? 'selected' : ''; ?>>Pending (Belum Diperiksa)</option>
                    <option value="Proses" <?= (isset($detail['status']) && $detail['status'] == 'Proses') ? 'selected' : ''; ?>>Proses (Dalam Perbaikan)</option>
                    <option value="Selesai" <?= (isset($detail['status']) && $detail['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai (Sudah Ditangani)</option>
                </select>
                
                <label for="tanggapan" style="display: block; font-weight: bold; margin-top: 15px; margin-bottom: 5px;">Isi Umpan Balik / Tanggapan Resmi</label>
                <textarea name="tanggapan" id="tanggapan" rows="5" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; resize: vertical;" placeholder="Tuliskan tindakan yang diambil sekolah disini..." required><?= isset($detail['tanggapan']) ? htmlspecialchars($detail['tanggapan']) : ''; ?></textarea>
                
                <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-top: 15px;">Simpan Perubahan Tanggapan</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php include 'views/layout_bottom.php'; ?>
