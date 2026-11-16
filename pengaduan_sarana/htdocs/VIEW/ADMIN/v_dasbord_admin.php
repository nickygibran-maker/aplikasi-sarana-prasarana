<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_aspirasi.php';
require_once __DIR__ . '/../../template/layout.php';

$st = (new Aspirasi())->statistik();

renderHead('Dashboard Admin');
renderNavbar('admin', 'dashboard');
?>
<main>
    <div class="page-head">
        <div>
            <span class="eyebrow">Ringkasan</span>
            <h1>Dashboard Admin</h1>
            <p>Pantau aspirasi sarana dan prasarana sekolah.</p>
        </div>
    </div>

    <?php flashMessages(); ?>

    <?php renderStats([
        ['📊', 'Total Aspirasi', $st['total']],
        ['⏳', 'Menunggu',       $st['menunggu']],
        ['🔄', 'Proses',         $st['proses']],
        ['✅', 'Selesai',        $st['selesai']],
    ]); ?>
</main>
<?php renderFoot(); ?>
