<?php
// models/Aspirasi.php
class Aspirasi {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT a.*, s.nama FROM aspirasi a JOIN siswa s ON a.nisn = s.nisn ORDER BY a.id_aspirasi DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
    // Menggunakan LEFT JOIN agar data pengaduan tetap keluar meskipun ada kendala relasi
    $stmt = $this->db->prepare("SELECT a.*, s.nama FROM aspirasi a LEFT JOIN siswa s ON a.nisn = s.nisn WHERE a.id_aspirasi = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}


    public function getByNisn($nisn) {
        $stmt = $this->db->prepare("SELECT * FROM aspirasi WHERE nisn = :nisn ORDER BY id_aspirasi DESC");
        $stmt->execute(['nisn' => $nisn]);
        return $stmt->fetchAll();
    }

    public function create($nisn, $kategori, $deskripsi, $foto) {
        $stmt = $this->db->prepare("INSERT INTO aspirasi (nisn, kategori, deskripsi, foto, status, tanggal) VALUES (:nisn, :kategori, :deskripsi, :foto, 'Pending', NOW())");
        return $stmt->execute([
            'nisn' => $nisn,
            'kategori' => $kategori,
            'deskripsi' => $deskripsi,
            'foto' => $foto
        ]);
    }

    public function updateStatus($id, $status, $tanggapan) {
        $stmt = $this->db->prepare("UPDATE aspirasi SET status = :status, tanggapan = :tanggapan WHERE id_aspirasi = :id");
        return $stmt->execute([
            'status' => $status,
            'tanggapan' => $tanggapan,
            'id' => $id
        ]);
    }
}
?>
