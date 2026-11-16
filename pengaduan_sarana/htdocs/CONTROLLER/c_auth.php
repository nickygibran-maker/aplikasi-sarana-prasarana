<?php

session_start();
require_once __DIR__ . '/../MODEL/m_admin.php';
require_once __DIR__ . '/../MODEL/m_siswa.php';

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
}

if (isset($_POST['login_admin'])) {
    $admin = (new Admin())->login(trim($_POST['username'] ?? ''), (string) ($_POST['password'] ?? ''));

    if ($admin) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        $_SESSION['id_admin'] = (int) $admin['id_admin'];
        $_SESSION['username'] = $admin['username'];
        header('Location: ../VIEW/ADMIN/v_dasbord_admin.php');
        exit;
    }

    $_SESSION['error'] = 'Username atau password salah!';
    header('Location: ../VIEW/auth/v_login.php?type=admin');
    exit;
}

if (isset($_POST['login_siswa'])) {
    $nis = (int) ($_POST['nis'] ?? 0);
    $password = (string) ($_POST['password'] ?? '');

    $siswa = $nis > 0 ? (new Siswa())->login($nis, $password) : null;

    if ($siswa) {
        session_regenerate_id(true);
        $_SESSION['siswa'] = true;
        $_SESSION['nis'] = (int) $siswa['nis'];
        $_SESSION['kelas'] = $siswa['kelas'];
        header('Location: ../VIEW/SISWA/dasbord_siswa.php');
        exit;
    }

    $_SESSION['error'] = 'NIS atau password salah!';
    header('Location: ../VIEW/auth/v_login.php?type=siswa');
    exit;
}
