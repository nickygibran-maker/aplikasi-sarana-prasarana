<?php
session_start();
require_once __DIR__.'/../MODEL/m_admin.php';
require_once __DIR__.'/../MODEL/m_siswa.php';

if(isset($_GET['logout'])){ session_unset(); session_destroy(); header('Location: ../index.php'); exit; }
if($_SERVER['REQUEST_METHOD']!=='POST') return;

if(isset($_POST['login_admin'])){
    $a=(new Admin())->login(trim($_POST['username']??''),$_POST['password']??'');
    if($a){ $_SESSION['admin']=true; $_SESSION['id_admin']=(int)$a['id_admin']; $_SESSION['username']=$a['username']; header('Location: ../VIEW/ADMIN/v_dasbord_admin.php'); exit; }
    $_SESSION['error']='Username atau password salah!'; header('Location: ../VIEW/auth/v_login.php?type=admin'); exit;
}
if(isset($_POST['login_siswa'])){
    $nis=(int)($_POST['nis']??0); $s=(new Siswa())->login($nis);
    if($s){ $_SESSION['siswa']=true; $_SESSION['nis']=(int)$s['nis']; $_SESSION['kelas']=$s['kelas']; header('Location: ../VIEW/SISWA/dasbord_siswa.php'); exit; }
    $_SESSION['error']='NIS tidak ditemukan!'; header('Location: ../VIEW/auth/v_login.php?type=siswa'); exit;
}
