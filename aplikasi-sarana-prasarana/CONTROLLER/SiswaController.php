<?php
require_once __DIR__.'/../MODEL/m_siswa.php';
require_once __DIR__.'/../MODEL/m_aspirasi.php';
require_once __DIR__.'/../MODEL/m_histori.php';
class SiswaController {
    public function dashboard(int $nis){ $a=new Aspirasi(); return ['siswa'=>(new Siswa())->getByNis($nis),'stat'=>$a->statistikSiswa($nis),'aspirasi'=>$a->getByNis($nis)]; }
    public function aspirasi(int $nis){ return (new Aspirasi())->getByNis($nis); }
    public function histori(int $nis){ return (new Histori())->getBySiswa($nis); }
}
