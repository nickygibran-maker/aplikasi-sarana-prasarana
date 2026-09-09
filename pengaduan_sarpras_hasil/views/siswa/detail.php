<?php include 'views/layout_top.php'; ?>
<div class="main-wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Detail Laporan Pengaduan Saya</h2>
        
        <?php if (empty($detail) || $detail === false): ?>
            <div class="error" style="background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin-bottom: 15px;">
                <strong>Sistem Informasi:</strong> Data laporan pengaduan tidak ditemukan.
                <br><br>
                <small style="color: #555;">Catatan debug parameter URL saat ini: ID = <?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'Kosong/Tidak terkirim'; ?></small>
            </div>
            <a href="index.php?page=siswa-histori" class="btn">Kembali ke Riwayat</a>
        <?php else: ?>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="width: 150px; font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Kategori Sarpras</td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($detail['kategori']) ? htmlspecialchars($detail['kategori']) : '-'; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Tanggal Lapor</td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($detail['tanggal']) ? htmlspecialchars($detail['tanggal']) : '-'; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Status Tindakan</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <span class="status-badge" style="background: <?= (isset($detail['status']) && $detail['status'] == 'Selesai') ? '#28a745' : ((isset($detail['status']) && $detail['status'] == 'Proses') ? '#17a2b8' : '#ffc107'); ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 13px;">
                            <?= isset($detail['status']) ? htmlspecialchars($detail['status']) : 'Pending'; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">Deskripsi Kerusakan</td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($detail['deskripsi']) ? nl2br(htmlspecialchars($detail['deskripsi'])) : '-'; ?></td>
                </tr>
            </table>

            <p><strong>Foto Bukti Kerusakan:</strong><br>
                <?php if (!empty($detail['foto']) && file_exists("assets/img/" . $detail['foto'])): ?>
                    <img src="assets/img/<?= htmlspecialchars($detail['foto']); ?>" width="350" alt="Bukti Fasilitas" style="border-radius: 5px; margin-top: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <?php else: ?>
                    <span style="color: #6c757d; font-style: italic;">Foto tidak tersedia atau file gambar hilang di server</span>
                <?php endif; ?>
            </p>
            
            <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 6px; border: 1px solid #e3e6f0;">
                <h3 style="margin-top: 0; color: #4e73df;">Tanggapan Resmi Admin / Sekolah</h3>
                <div style="background: white; padding: 15px; border-radius: 4px; border: 1px solid #dddfeb; min-height: 60px;">
                    <?= (!empty($detail['tanggapan'])) ? nl2br(htmlspecialchars($detail['tanggapan'])) : '<em style="color: #858796;">Belum ada tanggapan atau tindakan lanjut dari pihak sarpras sekolah terkait laporan ini.</em>'; ?>
                </div>
            </div>
            
            <br>
            <a href="index.php?page=siswa-histori" style="display: inline-block; text-decoration: none; color: #4e73df; font-weight: bold;">&larr; Kembali ke Riwayat Pengaduan</a>
        <?php endif; ?>
    </div>
</div>
<?php include 'views/layout_bottom.php'; ?>
