<?php
session_start();
require_once __DIR__.'/../MODEL/m_umpanbalik.php';
require_once __DIR__.'/../MODEL/m_aspirasi.php';
require_once __DIR__.'/../MODEL/m_histori.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../VIEW/auth/v_login.php?type=admin');
    exit;
}

$m = new UmpanBalik();
$a = new Aspirasi();
$h = new Histori();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_feedback'])) {
    $id = (int)($_POST['id_aspirasi'] ?? 0);
    $feedback = trim($_POST['feedback'] ?? '');

    if ($id <= 0 || $feedback === '') {
        $_SESSION['error'] = 'Feedback tidak boleh kosong.';
        header('Location: ../VIEW/ADMIN/UmpanBalik.php');
        exit;
    }

    $data = $m->getById($id);
    if (!$data) {
        $_SESSION['error'] = 'Data aspirasi tidak ditemukan.';
        header('Location: ../VIEW/ADMIN/UmpanBalik.php');
        exit;
    }

    $adminId = (int)$_SESSION['id_admin'];
    if ($m->simpan($id, $adminId, $feedback)) {
        // Feedback juga dicatat sebagai histori agar siswa dapat melihat riwayatnya.
        $h->tambah($id, $data['status'], $feedback);
        $_SESSION['success'] = 'Umpan balik berhasil disimpan dan dikirim ke siswa.';
    } else {
        $_SESSION['error'] = 'Umpan balik gagal disimpan.';
    }

    header('Location: ../VIEW/ADMIN/UmpanBalik.php?id='.$id);
    exit;
}

header('Location: ../VIEW/ADMIN/UmpanBalik.php');
exit;
