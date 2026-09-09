<?php
// index.php
session_start();
require_once 'config/koneksi.php';
require_once 'models/Auth.php';
require_once 'models/Aspirasi.php';

$authModel = new Auth($pdo);
$aspirasiModel = new Aspirasi($pdo);

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Handle Aksi Login & Logout
if ($page == 'proses-login-siswa') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $res = $authModel->loginSiswa($_POST['nisn'], $_POST['password']);
        if ($res) {
            $_SESSION['user'] = $res;
            $_SESSION['role'] = 'siswa';
            header('Location: index.php?page=siswa-dashboard');
        } else {
            header('Location: index.php?page=login-siswa&error=1');
        }
    }
    exit;
}

if ($page == 'proses-login-admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $res = $authModel->loginAdmin($_POST['username'], $_POST['password']);
        if ($res) {
            $_SESSION['user'] = $res;
            $_SESSION['role'] = 'admin';
            header('Location: index.php?page=admin-dashboard');
        } else {
            header('Location: index.php?page=login-admin&error=1');
        }
    }
    exit;
}

if ($page == 'logout') {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Router ke Views / Controllers
switch ($page) {
    case 'home':
        require 'views/home.php';
        break;
    case 'login-siswa':
        require 'views/login-siswa.php';
        break;
    case 'login-admin':
        require 'views/login-admin.php';
        break;
    
    // Core Router Siswa
    case 'siswa-dashboard':
        require_once 'controllers/SiswaController.php';
        (new SiswaController($aspirasiModel))->dashboard();
        break;
    case 'siswa-histori':
        require_once 'controllers/SiswaController.php';
        (new SiswaController($aspirasiModel))->histori();
        break;
    case 'siswa-detail':
    require_once 'controllers/SiswaController.php';
    if (isset($_GET['id'])) {
        (new SiswaController($aspirasiModel))->detail($_GET['id']);
    } else {
        header('Location: index.php?page=siswa-histori');
    }
    break;
    case 'siswa-kirim':
        require_once 'controllers/SiswaController.php';
        (new SiswaController($aspirasiModel))->kirimAspirasi();
        break;

    // Core Router Admin
    case 'admin-dashboard':
        require_once 'controllers/AdminController.php';
        (new AdminController($aspirasiModel))->dashboard();
        break;
    case 'admin-aspirasi':
        require_once 'controllers/AdminController.php';
        (new AdminController($aspirasiModel))->aspirasi();
        break;
    case 'admin-detail':
    require_once 'controllers/AdminController.php';
    if (isset($_GET['id'])) {
        (new AdminController($aspirasiModel))->detail($_GET['id']);
    } else {
        header('Location: index.php?page=admin-aspirasi');
    }
    break;
    case 'admin-tanggapi':
        require_once 'controllers/AdminController.php';
        (new AdminController($aspirasiModel))->tanggapi();
        break;
        
    default:
        echo "Halaman tidak ditemukan.";
        break;
}
?>
