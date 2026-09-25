<?php
require_once __DIR__.'/m_koneksi.php';

class UmpanBalik {
    private mysqli $db;

    public function __construct(){
        $this->db = (new Koneksi())->koneksi;
    }

    public function getAll(): array {
        $sql = "SELECT a.id_aspirasi, a.nis, s.kelas, a.status, k.ket_kategori,
                       a.feedback, a.id_admin, ad.username
                FROM aspirasi a
                JOIN siswa s ON a.nis = s.nis
                JOIN kategori k ON a.id_kategori = k.id_kategori
                LEFT JOIN admin ad ON a.id_admin = ad.id_admin
                ORDER BY a.id_aspirasi DESC";
        $r = $this->db->query($sql);
        return $r ? $r->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getById(int $id): ?array {
        $s = $this->db->prepare("SELECT a.id_aspirasi, a.nis, s.kelas, a.status,
                                        k.ket_kategori, a.feedback, a.id_admin, ad.username
                                 FROM aspirasi a
                                 JOIN siswa s ON a.nis = s.nis
                                 JOIN kategori k ON a.id_kategori = k.id_kategori
                                 LEFT JOIN admin ad ON a.id_admin = ad.id_admin
                                 WHERE a.id_aspirasi = ? LIMIT 1");
        $s->bind_param('i', $id);
        $s->execute();
        return $s->get_result()->fetch_assoc() ?: null;
    }

    public function simpan(int $idAspirasi, int $idAdmin, string $feedback): bool {
        $feedback = trim($feedback);
        if ($feedback === '') return false;

        $s = $this->db->prepare("UPDATE aspirasi
                                 SET feedback = ?, id_admin = ?
                                 WHERE id_aspirasi = ?");
        $s->bind_param('sii', $feedback, $idAdmin, $idAspirasi);
        return $s->execute();
    }
}
