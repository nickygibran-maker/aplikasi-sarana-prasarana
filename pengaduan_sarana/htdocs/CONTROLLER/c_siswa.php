<?php

session_start();
require_once __DIR__ . '/../MODEL/m_siswa.php';

const HALAMAN_DAFTAR = '../VIEW/ADMIN/v_DaftarSiswa.php';

function kembali(string $lokasi, string $jenis, string $pesan): void
{
    $_SESSION[$jenis] = $pesan;
    header('Location: ' . $lokasi);
    exit;
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../VIEW/auth/v_login.php?type=admin');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . HALAMAN_DAFTAR);
    exit;
}

$m = new Siswa();

$action = $_POST['action'] ?? '';
$nis = (int) ($_POST['nis'] ?? 0);
$kelas = trim($_POST['kelas'] ?? '');
$password = (string) ($_POST['password'] ?? '');

if (in_array($action, ['tambah', 'ubah'], true)) {
    $formUrl = $action === 'ubah'
        ? '../VIEW/ADMIN/FormEditSiswa.php?nis=' . $nis
        : '../VIEW/ADMIN/FormTambahSiswa.php';

    if ($nis <= 0 || $kelas === '') {
        kembali($formUrl, 'error', 'NIS dan kelas wajib diisi.');
    }

    if (strlen($kelas) > 10) {
        kembali($formUrl, 'error', 'Nama kelas maksimal 10 karakter.');
    }

    // Tambah siswa: password wajib. Ubah siswa: password boleh dikosongkan (tidak diganti).
    $wajibPassword = $action === 'tambah';
    if (($wajibPassword || $password !== '') && strlen($password) < 6) {
        kembali($formUrl, 'error', 'Password minimal 6 karakter.');
    }
}

if ($action === 'tambah') {
    $ok = $m->tambah($nis, $kelas, $password);
    kembali(
        HALAMAN_DAFTAR,
        $ok ? 'success' : 'error',
        $ok ? 'Data siswa berhasil ditambahkan.' : 'NIS sudah terdaftar atau data gagal disimpan.'
    );
}

if ($action === 'ubah') {
    $ok = $m->ubah($nis, $kelas, $password !== '' ? $password : null);
    kembali(
        HALAMAN_DAFTAR,
        $ok ? 'success' : 'error',
        $ok ? 'Data siswa berhasil diperbarui.' : 'Data siswa gagal diperbarui.'
    );
}

if ($action === 'hapus') {
    if ($nis <= 0) {
        kembali(HALAMAN_DAFTAR, 'error', 'NIS tidak valid.');
    }

    // Aspirasi milik siswa ikut terhapus otomatis (ON DELETE CASCADE di database).
    $ok = $m->hapus($nis);
    kembali(
        HALAMAN_DAFTAR,
        $ok ? 'success' : 'error',
        $ok ? 'Data siswa berhasil dihapus.' : 'Data siswa gagal dihapus.'
    );
}

header('Location: ' . HALAMAN_DAFTAR);
exit;
