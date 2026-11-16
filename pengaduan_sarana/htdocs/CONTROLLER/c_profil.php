<?php

session_start();
require_once __DIR__ . '/../MODEL/m_siswa.php';

const HALAMAN_PROFIL = '../VIEW/SISWA/profil_siswa.php';

if (!isset($_SESSION['siswa'])) {
    header('Location: ../VIEW/auth/v_login.php?type=siswa');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['ganti_password'])) {
    header('Location: ' . HALAMAN_PROFIL);
    exit;
}

$lama = (string) ($_POST['password_lama'] ?? '');
$baru = (string) ($_POST['password_baru'] ?? '');
$konfirmasi = (string) ($_POST['konfirmasi_password'] ?? '');

if ($lama === '' || $baru === '' || $konfirmasi === '') {
    $_SESSION['error'] = 'Semua kolom password wajib diisi.';
} elseif (strlen($baru) < 6) {
    $_SESSION['error'] = 'Password baru minimal 6 karakter.';
} elseif ($baru !== $konfirmasi) {
    $_SESSION['error'] = 'Konfirmasi password tidak sama.';
} elseif ($baru === $lama) {
    $_SESSION['error'] = 'Password baru harus berbeda dari password lama.';
} elseif ((new Siswa())->gantiPassword((int) $_SESSION['nis'], $lama, $baru)) {
    $_SESSION['success'] = 'Password berhasil diganti.';
} else {
    $_SESSION['error'] = 'Password lama tidak sesuai.';
}

header('Location: ' . HALAMAN_PROFIL);
exit;
