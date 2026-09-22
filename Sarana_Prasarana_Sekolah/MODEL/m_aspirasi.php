<?php
require_once __DIR__.'/m_koneksi.php';
class Aspirasi {
    private mysqli $db;
    public function __construct(){ $this->db=(new Koneksi())->koneksi; }
    public function getAll(): array {
        $sql="SELECT a.id_aspirasi,a.nis,s.kelas,a.id_admin,ad.username,a.status,a.id_kategori,k.ket_kategori,a.feedback
              FROM aspirasi a JOIN siswa s ON a.nis=s.nis JOIN kategori k ON a.id_kategori=k.id_kategori
              LEFT JOIN admin ad ON a.id_admin=ad.id_admin ORDER BY a.id_aspirasi DESC";
        $r=$this->db->query($sql); return $r?$r->fetch_all(MYSQLI_ASSOC):[];
    }
    public function getById(int $id): ?array {
        $s=$this->db->prepare("SELECT a.id_aspirasi,a.nis,s.kelas,a.id_admin,ad.username,a.status,a.id_kategori,k.ket_kategori,a.feedback
            FROM aspirasi a JOIN siswa s ON a.nis=s.nis JOIN kategori k ON a.id_kategori=k.id_kategori
            LEFT JOIN admin ad ON a.id_admin=ad.id_admin WHERE a.id_aspirasi=?");
        $s->bind_param('i',$id); $s->execute(); return $s->get_result()->fetch_assoc() ?: null;
    }
    public function getByNis(int $nis): array {
        $s=$this->db->prepare("SELECT a.id_aspirasi,a.nis,a.id_admin,ad.username,a.status,a.id_kategori,k.ket_kategori,a.feedback
            FROM aspirasi a JOIN kategori k ON a.id_kategori=k.id_kategori LEFT JOIN admin ad ON a.id_admin=ad.id_admin
            WHERE a.nis=? ORDER BY a.id_aspirasi DESC");
        $s->bind_param('i',$nis); $s->execute(); return $s->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getKategori(): array { $r=$this->db->query('SELECT id_kategori,ket_kategori FROM kategori ORDER BY id_kategori'); return $r?$r->fetch_all(MYSQLI_ASSOC):[]; }
    public function tambah(int $nis,int $idKategori): int|false {
        $s=$this->db->prepare("INSERT INTO aspirasi (nis,id_kategori,status) VALUES (?,?,'Menunggu')");
        $s->bind_param('ii',$nis,$idKategori); if(!$s->execute()) return false; return $this->db->insert_id;
    }
    public function updateStatus(int $id,string $status,?int $idAdmin): bool {
        if(!in_array($status,['Menunggu','Proses','Selesai'],true)) return false;
        if($idAdmin===null){$s=$this->db->prepare('UPDATE aspirasi SET status=?,id_admin=NULL WHERE id_aspirasi=?');$s->bind_param('si',$status,$id);}
        else {$s=$this->db->prepare('UPDATE aspirasi SET status=?,id_admin=? WHERE id_aspirasi=?');$s->bind_param('sii',$status,$idAdmin,$id);}
        return $s->execute();
    }
    public function updateFeedback(int $id,?string $feedback): bool { $s=$this->db->prepare('UPDATE aspirasi SET feedback=? WHERE id_aspirasi=?'); $s->bind_param('si',$feedback,$id); return $s->execute(); }
    public function hapus(int $id,int $nis): bool { $s=$this->db->prepare('DELETE FROM aspirasi WHERE id_aspirasi=? AND nis=?'); $s->bind_param('ii',$id,$nis); return $s->execute(); }
    public function statistik(): array {
        $out=['total'=>0,'menunggu'=>0,'proses'=>0,'selesai'=>0];
        $r=$this->db->query("SELECT COUNT(*) total, SUM(status='Menunggu') menunggu, SUM(status='Proses') proses, SUM(status='Selesai') selesai FROM aspirasi");
        if($r) $out=array_merge($out,$r->fetch_assoc()); return $out;
    }
    public function statistikSiswa(int $nis): array {
        $s=$this->db->prepare("SELECT COUNT(*) total,SUM(status='Menunggu') menunggu,SUM(status='Proses') proses,SUM(status='Selesai') selesai FROM aspirasi WHERE nis=?"); $s->bind_param('i',$nis); $s->execute(); return $s->get_result()->fetch_assoc();
    }
}
