<?php

session_start();
if (!isset($_SESSION['siswa'])) {
    header('Location: ../auth/v_login.php?type=siswa');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_aspirasi.php';
require_once __DIR__ . '/../../template/layout.php';

$st = (new Aspirasi())->statistikSiswa((int) $_SESSION['nis']);

renderHead('Dashboard Siswa');
renderNavbar('siswa', 'dashboard');
?>
<main>
    <div class="page-head">
        <div>
            <span class="eyebrow">Selamat datang</span>
            <h1>Halo, Siswa! 👋</h1>
            <p>Pantau aspirasi sarana dan prasarana kamu di sini.</p>
        </div>
    </div>

    <?php flashMessages(); ?>

    <?php renderStats([
        ['📊', 'Total',    $st['total']],
        ['⏳', 'Menunggu', $st['menunggu']],
        ['🔄', 'Proses',   $st['proses']],
        ['✅', 'Selesai',  $st['selesai']],
    ]); ?>
</main>
<?php renderFoot(); ?>
