<?php include 'views/layout_top.php'; ?>
<div class="main-wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Riwayat Pengaduan Anda</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($data)): ?>
                    <tr><td colspan="4" style="text-align:center;">Belum ada riwayat pengaduan.</td></tr>
                <?php else: ?>
                    <?php foreach($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                        <td><?= htmlspecialchars($row['kategori']); ?></td>
                        <td><span class="status-badge"><?= htmlspecialchars($row['status']); ?></span></td>
                        <td><a href="index.php?page=siswa-detail&id=<?= $row['id_aspirasi']; ?>">Lihat</a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'views/layout_bottom.php'; ?>
