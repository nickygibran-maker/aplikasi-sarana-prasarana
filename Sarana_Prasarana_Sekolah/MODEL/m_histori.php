<?php
require_once __DIR__.'/m_koneksi.php';
class Histori {
    private mysqli $db;
    public function __construct(){ $this->db=(new Koneksi())->koneksi; }
    public function getAll(): array {
        $sql="SELECT h.id_histori,h.id_aspirasi,a.nis,s.kelas,h.status,h.feedback,h.tanggal
              FROM histori h JOIN aspirasi a ON h.id_aspirasi=a.id_aspirasi JOIN siswa s ON a.nis=s.nis ORDER BY h.tanggal DESC,h.id_histori DESC";
        $r=$this->db->query($sql); return $r?$r->fetch_all(MYSQLI_ASSOC):[];
    }
    public function getByAspirasi(int $id): array { $s=$this->db->prepare('SELECT * FROM histori WHERE id_aspirasi=? ORDER BY tanggal DESC,id_histori DESC');$s->bind_param('i',$id);$s->execute();return $s->get_result()->fetch_all(MYSQLI_ASSOC); }
    public function getBySiswa(int $nis): array { $s=$this->db->prepare('SELECT h.*,a.nis FROM histori h JOIN aspirasi a ON h.id_aspirasi=a.id_aspirasi WHERE a.nis=? ORDER BY h.tanggal DESC,h.id_histori DESC');$s->bind_param('i',$nis);$s->execute();return $s->get_result()->fetch_all(MYSQLI_ASSOC); }
    public function tambah(int $id,string $status,?string $feedback): bool { $s=$this->db->prepare('INSERT INTO histori (id_aspirasi,status,feedback,tanggal) VALUES (?,?,?,NOW())');$s->bind_param('iss',$id,$status,$feedback);return $s->execute(); }
}
