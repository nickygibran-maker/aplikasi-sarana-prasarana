<?php
require_once __DIR__.'/../MODEL/m_admin.php';
require_once __DIR__.'/../MODEL/m_siswa.php';
require_once __DIR__.'/../MODEL/m_aspirasi.php';
require_once __DIR__.'/../MODEL/m_histori.php';
class AdminController {
    public function dashboard(){ $a=new Aspirasi(); return ['stat'=>$a->statistik()]; }
    public function aspirasi(){ return (new Aspirasi())->getAll(); }
    public function siswa(){ return (new Siswa())->getAll(); }
    public function histori(){ return (new Histori())->getAll(); }
}
