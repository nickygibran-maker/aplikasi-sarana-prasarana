<?php include 'views/layout_top.php'; ?>
<div class="main-wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Daftar Masuk Pengaduan Siswa</h2>
        <table>
            <thead>
                <tr>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($allData)): ?>
                    <tr><td colspan="5" style="text-align:center;">Tidak ada pengaduan masuk.</td></tr>
                <?php else: ?>
                    <?php foreach($allData as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['kategori']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                        <td><span class="status-badge"><?= htmlspecialchars($row['status']); ?></span></td>
                        <td><a href="index.php?page=admin-detail&id=<?= $row['id_aspirasi']; ?>">Tanggapi</a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'views/layout_bottom.php'; ?>
