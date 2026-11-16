<?php
/**
 * Kerangka bersama untuk semua halaman: <head>, navbar, notifikasi, dan kartu statistik.
 * Semua halaman admin, siswa, dan login memakai file ini supaya menu dan tampilannya selalu sama.
 */

/** Escape HTML singkat. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Path akar aplikasi, misalnya "/aplikasi-sarana-prasarana" (atau "" jika di root).
 * Dihitung dari halaman yang sedang dibuka, jadi link tetap benar di XAMPP maupun hosting.
 */
function appRoot(): string
{
    return rtrim(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
}

/** Daftar menu navigasi per peran. Kunci dipakai untuk menandai menu yang aktif. */
function menuNavigasi(string $role): array
{
    $view = appRoot() . '/VIEW';

    if ($role === 'admin') {
        return [
            'dashboard' => ['🏠 Dashboard',     $view . '/ADMIN/v_dasbord_admin.php'],
            'siswa'     => ['👨‍🎓 Data Siswa',   $view . '/ADMIN/v_DaftarSiswa.php'],
            'aspirasi'  => ['📋 Data Aspirasi', $view . '/ADMIN/v_DataAspirasi.php'],
            'umpan'     => ['💬 Umpan Balik',   $view . '/ADMIN/UmpanBalik.php'],
            'histori'   => ['🕘 Histori',       $view . '/SISWA/v_HistoryAspirasiSiswa.php'],
        ];
    }

    return [
        'dashboard' => ['🏠 Dashboard',      $view . '/SISWA/dasbord_siswa.php'],
        'kirim'     => ['➕ Kirim Aspirasi', $view . '/SISWA/v_form_aspirasi.php'],
        'laporan'   => ['📋 Aspirasi Saya',  $view . '/SISWA/daftar_laporan.php'],
        'histori'   => ['🕘 Histori',        $view . '/SISWA/v_HistoryAspirasiSiswa.php'],
        'profil'    => ['👤 Profil',         $view . '/SISWA/profil_siswa.php'],
    ];
}

/** Bagian <head> dan pembuka <body>. */
function renderHead(string $judul, string $kelasBody = ''): void
{
    $app = appRoot();
    ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul) ?> • Sarpras Sekolah</title>
    <link rel="icon" href="<?= e($app) ?>/ASSETS/GAMBAR/logoapk.jpeg">
    <link rel="stylesheet" href="<?= e($app) ?>/ASSETS/modern.css">
</head>
<body<?= $kelasBody !== '' ? ' class="' . e($kelasBody) . '"' : '' ?>>
<?php
}

/** Navbar atas. $aktif = kunci menu yang sedang dibuka. */
function renderNavbar(string $role, string $aktif): void
{
    $menu = menuNavigasi($role);
    $brand = $role === 'admin' ? 'Admin Panel' : 'Siswa Panel';
    $beranda = $menu['dashboard'][1];
    $logout = appRoot() . '/CONTROLLER/c_auth.php?logout=1';

    if ($role === 'admin') {
        $info = '👤 ' . ($_SESSION['username'] ?? 'Admin');
    } else {
        $info = '🎓 NIS ' . ($_SESSION['nis'] ?? '-') . ' · ' . ($_SESSION['kelas'] ?? '-');
    }
    ?>
<header class="navbar">
    <a class="nav-brand" href="<?= e($beranda) ?>">
        <span class="brand-icon">🏫</span>
        <span><?= e($brand) ?></span>
    </a>

    <nav>
        <ul class="nav-menu">
            <?php foreach ($menu as $kunci => [$label, $url]): ?>
                <li>
                    <a href="<?= e($url) ?>" class="<?= $kunci === $aktif ? 'active' : '' ?>"><?= e($label) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <div class="nav-user">
        <span><?= e($info) ?></span>
        <a class="logout-link" href="<?= e($logout) ?>">Keluar</a>
    </div>
</header>
    <?php
}

/** Penutup halaman. */
function renderFoot(): void
{
    echo "</body>\n</html>\n";
}

/** Tampilkan dan hapus pesan sukses/error dari session. */
function flashMessages(): void
{
    foreach (['success', 'error'] as $jenis) {
        if (!empty($_SESSION[$jenis])) {
            echo '<div class="alert ' . $jenis . '" role="alert">' . e($_SESSION[$jenis]) . '</div>';
            unset($_SESSION[$jenis]);
        }
    }
}

/** Baris kartu statistik. $items = [[ikon, label, nilai], ...] */
function renderStats(array $items): void
{
    echo '<section class="cards">';
    foreach ($items as [$ikon, $label, $nilai]) {
        echo '<div class="stat">'
            . '<span class="stat-label">' . e($ikon . ' ' . $label) . '</span>'
            . '<strong class="stat-value">' . (int) $nilai . '</strong>'
            . '</div>';
    }
    echo '</section>';
}

/** Label status aspirasi berwarna. */
function badgeStatus(string $status): string
{
    $kelas = match (strtolower($status)) {
        'proses'  => 'badge-proses',
        'selesai' => 'badge-selesai',
        default   => 'badge-menunggu',
    };

    return '<span class="badge ' . $kelas . '">' . e($status) . '</span>';
}
