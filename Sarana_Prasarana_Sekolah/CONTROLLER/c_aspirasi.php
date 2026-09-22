<?php
session_start();
require_once __DIR__.'/../MODEL/m_aspirasi.php';
require_once __DIR__.'/../MODEL/m_histori.php';

if(!isset($_SESSION['siswa']) && !isset($_SESSION['admin'])){ header('Location: ../index.php'); exit; }
$m=new Aspirasi(); $h=new Histori();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['tambah_aspirasi']) && isset($_SESSION['siswa'])){
        $id=$m->tambah((int)$_SESSION['nis'],(int)$_POST['id_kategori']);
        if($id){ $h->tambah($id,'Menunggu','Laporan telah diterima'); $_SESSION['success']='Aspirasi berhasil dikirim.'; }
        else $_SESSION['error']='Aspirasi gagal dikirim.';
        header('Location: ../VIEW/SISWA/v_form_aspirasi.php'); exit;
    }
    if(isset($_POST['ubah_status']) && isset($_SESSION['admin'])){
        $id=(int)$_POST['id_aspirasi']; $status=$_POST['status']??'Menunggu';
        $ok=$m->updateStatus($id,$status,(int)$_SESSION['id_admin']);
        if($ok){ $h->tambah($id,$status,trim($_POST['feedback']??'')?:null); $m->updateFeedback($id,trim($_POST['feedback']??'')?:null); $_SESSION['success']='Status aspirasi berhasil diperbarui.'; }
        else $_SESSION['error']='Gagal memperbarui status.';
        header('Location: ../VIEW/ADMIN/v_DataAspirasi.php'); exit;
    }
    if(isset($_POST['hapus_aspirasi']) && isset($_SESSION['siswa'])){
        $m->hapus((int)$_POST['id_aspirasi'],(int)$_SESSION['nis']); header('Location: ../VIEW/SISWA/daftar_laporan.php'); exit;
    }
}
