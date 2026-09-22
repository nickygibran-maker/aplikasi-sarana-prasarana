<?php
session_start();
require_once __DIR__.'/../MODEL/m_siswa.php';
if(!isset($_SESSION['admin'])){ header('Location: ../VIEW/auth/v_login.php?type=admin'); exit; }
$m=new Siswa();
if($_SERVER['REQUEST_METHOD']!=='POST'){ header('Location: ../VIEW/ADMIN/v_DaftarSiswa.php'); exit; }
$action=$_POST['action']??'';
$nis=(int)($_POST['nis']??0);
$kelas=trim($_POST['kelas']??'');
if(in_array($action,['tambah','ubah'],true) && ($nis<=0 || $kelas==='')){
    $_SESSION['error']='NIS dan kelas wajib diisi.';
    header('Location: ../VIEW/ADMIN/'.($action==='ubah'?'FormEditSiswa.php?nis='.$nis:'FormTambahSiswa.php')); exit;
}
if($action==='tambah'){
    $ok=$m->tambah($nis,$kelas); $_SESSION[$ok?'success':'error']=$ok?'Data siswa berhasil ditambahkan.':'NIS sudah terdaftar atau data gagal disimpan.';
    header('Location: ../VIEW/ADMIN/v_DaftarSiswa.php'); exit;
}
if($action==='ubah'){
    $ok=$m->ubah($nis,$kelas); $_SESSION[$ok?'success':'error']=$ok?'Data siswa berhasil diperbarui.':'Data siswa gagal diperbarui.';
    header('Location: ../VIEW/ADMIN/v_DaftarSiswa.php'); exit;
}
if($action==='hapus'){
    if($nis<=0){$_SESSION['error']='NIS tidak valid.';}
    else { try { $ok=$m->hapus($nis); $_SESSION[$ok?'success':'error']=$ok?'Data siswa berhasil dihapus.':'Data siswa gagal dihapus.'; } catch(Throwable $e){$_SESSION['error']='Siswa tidak dapat dihapus karena masih memiliki data aspirasi.';} }
    header('Location: ../VIEW/ADMIN/v_DaftarSiswa.php'); exit;
}
header('Location: ../VIEW/ADMIN/v_DaftarSiswa.php'); exit;
