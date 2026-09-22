<?php
require_once __DIR__.'/m_koneksi.php';
class Siswa {
    private mysqli $db;
    public function __construct(){ $this->db=(new Koneksi())->koneksi; }
    public function login(int $nis): ?array { $s=$this->db->prepare('SELECT nis,kelas FROM siswa WHERE nis=? LIMIT 1'); $s->bind_param('i',$nis); $s->execute(); return $s->get_result()->fetch_assoc() ?: null; }
    public function getAll(): array { $r=$this->db->query('SELECT nis,kelas FROM siswa ORDER BY nis'); return $r?$r->fetch_all(MYSQLI_ASSOC):[]; }
    public function getByNis(int $nis): ?array { $s=$this->db->prepare('SELECT nis,kelas FROM siswa WHERE nis=? LIMIT 1'); $s->bind_param('i',$nis); $s->execute(); return $s->get_result()->fetch_assoc() ?: null; }
    public function tambah(int $nis,string $kelas): bool { $s=$this->db->prepare('INSERT INTO siswa (nis,kelas) VALUES (?,?)'); $s->bind_param('is',$nis,$kelas); return $s->execute(); }
    public function ubah(int $nis,string $kelas): bool { $s=$this->db->prepare('UPDATE siswa SET kelas=? WHERE nis=?'); $s->bind_param('si',$kelas,$nis); return $s->execute(); }
    public function hapus(int $nis): bool { $s=$this->db->prepare('DELETE FROM siswa WHERE nis=?'); $s->bind_param('i',$nis); return $s->execute(); }
}
