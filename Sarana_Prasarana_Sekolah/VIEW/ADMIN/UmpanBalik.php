<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}
require_once '../../MODEL/m_umpanbalik.php';

$m = new UmpanBalik();
$data = $m->getAll();
$selectedId = (int)($_GET['id'] ?? 0);
$selected = $selectedId > 0 ? $m->getById($selectedId) : null;
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Umpan Balik • Sarpras</title>
<link rel="stylesheet" href="../../ASSETS/modern.css">
<link rel="icon" href="../../ASSETS/GAMBAR/logoapk.jpeg">
</head>
<body>
<nav class="navbar">
    <a class="nav-brand" href="v_dasbord_admin.php"><span class="brand-icon">🏫</span><span>Admin Panel</span></a>
    <ul class="nav-menu">
        <li><a href="v_dasbord_admin.php">⌂ Dashboard</a></li>
        <li><a href="v_DaftarSiswa.php">👨‍🎓 Data Siswa</a></li>
        <li><a href="v_DataAspirasi.php">📋 Data Aspirasi</a></li>
        <li><a class="active" href="UmpanBalik.php">💬 Umpan Balik</a></li>
    </ul>
    <div class="nav-user">👤 <?=htmlspecialchars($_SESSION['username'] ?? 'Admin')?> <a class="logout-link" href="../../CONTROLLER/c_auth.php?logout=1">Keluar</a></div>
</nav>

<main>
    <a class="back" href="v_dasbord_admin.php">← Kembali ke Dashboard</a>

    <div class="page-head">
        <div>
            <span class="eyebrow">KOMUNIKASI ADMIN</span>
            <h1>💬 Umpan Balik</h1>
            <p>Berikan tanggapan langsung pada laporan siswa.</p>
        </div>
        <a class="btn btn-light" href="v_DataAspirasi.php">📋 Kelola Aspirasi</a>
    </div>

    <?php if ($error): ?><div class="alert error">⚠️ <?=htmlspecialchars($error)?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert success">✓ <?=htmlspecialchars($success)?></div><?php endif; ?>

    <div class="feedback-layout">
        <section class="table-card">
            <div class="section-head">
                <div><h2>Daftar Laporan</h2><p>Pilih laporan untuk memberikan atau memperbarui feedback.</p></div>
                <span class="count-pill"><?=count($data)?> laporan</span>
            </div>
            <div class="feedback-list">
                <?php if (!$data): ?>
                    <div class="empty">Belum ada aspirasi yang masuk.</div>
                <?php endif; ?>
                <?php foreach ($data as $r): ?>
                    <a class="feedback-item <?=$selectedId === (int)$r['id_aspirasi'] ? 'selected' : ''?>" href="?id=<?=$r['id_aspirasi']?>">
                        <div class="feedback-top">
                            <strong>#<?=$r['id_aspirasi']?> · <?=htmlspecialchars($r['ket_kategori'])?></strong>
                            <span class="badge <?=strtolower($r['status'])==='proses'?'badge-proses':(strtolower($r['status'])==='selesai'?'badge-selesai':'badge-menunggu')?>"><?=htmlspecialchars($r['status'])?></span>
                        </div>
                        <div class="feedback-meta">NIS <?=htmlspecialchars($r['nis'])?> · <?=htmlspecialchars($r['kelas'])?></div>
                        <div class="feedback-preview"><?=htmlspecialchars($r['feedback'] ?: 'Belum ada umpan balik')?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="form-card feedback-form-card">
            <?php if ($selected): ?>
                <span class="eyebrow">LAPORAN #<?=$selected['id_aspirasi']?></span>
                <h2>Berikan Umpan Balik</h2>
                <p class="sub">Tanggapan ini akan tampil pada akun siswa.</p>

                <div class="report-summary">
                    <div><span>NIS</span><b><?=htmlspecialchars($selected['nis'])?></b></div>
                    <div><span>Kelas</span><b><?=htmlspecialchars($selected['kelas'])?></b></div>
                    <div><span>Kategori</span><b><?=htmlspecialchars($selected['ket_kategori'])?></b></div>
                    <div><span>Status</span><b><span class="badge <?=strtolower($selected['status'])==='proses'?'badge-proses':(strtolower($selected['status'])==='selesai'?'badge-selesai':'badge-menunggu')?>"><?=htmlspecialchars($selected['status'])?></span></b></div>
                </div>

                <form method="post" action="../../CONTROLLER/c_umpanbalik.php">
                    <input type="hidden" name="id_aspirasi" value="<?=$selected['id_aspirasi']?>">
                    <div class="form-group">
                        <label for="feedback">Umpan Balik</label>
                        <textarea id="feedback" name="feedback" rows="7" maxlength="255" placeholder="Tulis tanggapan untuk siswa..." required><?=htmlspecialchars($selected['feedback'] ?? '')?></textarea>
                        <small>Maksimal 255 karakter.</small>
                    </div>
                    <button class="btn btn-primary feedback-submit" name="simpan_feedback">💬 Simpan & Kirim Feedback</button>
                </form>
            <?php else: ?>
                <div class="feedback-empty">
                    <div class="empty-icon">💬</div>
                    <h2>Pilih laporan</h2>
                    <p>Pilih salah satu aspirasi di sebelah kiri untuk mulai memberikan umpan balik.</p>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>
</body>
</html>
