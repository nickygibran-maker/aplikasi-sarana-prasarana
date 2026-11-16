<?php

require_once __DIR__ . '/m_koneksi.php';

class Histori
{
    private mysqli $db;


    public function __construct()
    {
        $this->db = (new Koneksi())->koneksi;
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA HISTORI - ADMIN
    |--------------------------------------------------------------------------
    */

    public function getAll(): array
    {
        $sql = "SELECT
                    h.id_histori,
                    h.id_aspirasi,

                    a.nis,
                    s.kelas,

                    a.id_kategori,
                    k.ket_kategori,

                    a.foto,
                    a.keterangan,

                    h.status,
                    h.feedback,
                    h.tanggal

                FROM histori h

                JOIN aspirasi a
                    ON h.id_aspirasi = a.id_aspirasi

                JOIN siswa s
                    ON a.nis = s.nis

                JOIN kategori k
                    ON a.id_kategori = k.id_kategori

                ORDER BY
                    h.tanggal DESC,
                    h.id_histori DESC";


        $r = $this->db->query($sql);


        return $r
            ? $r->fetch_all(MYSQLI_ASSOC)
            : [];
    }


    /*
    |--------------------------------------------------------------------------
    | HISTORI BERDASARKAN ASPIRASI
    |--------------------------------------------------------------------------
    */

    public function getByAspirasi(int $id): array
    {
        $sql = "SELECT
                    h.*,

                    a.nis,
                    a.foto,
                    a.keterangan,

                    k.ket_kategori

                FROM histori h

                JOIN aspirasi a
                    ON h.id_aspirasi = a.id_aspirasi

                JOIN kategori k
                    ON a.id_kategori = k.id_kategori

                WHERE h.id_aspirasi = ?

                ORDER BY
                    h.tanggal DESC,
                    h.id_histori DESC";


        $s = $this->db->prepare($sql);

        $s->bind_param('i', $id);

        $s->execute();


        return $s
            ->get_result()
            ->fetch_all(MYSQLI_ASSOC);
    }


    /*
    |--------------------------------------------------------------------------
    | HISTORI SISWA
    |--------------------------------------------------------------------------
    */

    public function getBySiswa(int $nis): array
    {
        $sql = "SELECT
                    h.*,

                    a.nis,
                    a.foto,
                    a.keterangan,

                    k.ket_kategori

                FROM histori h

                JOIN aspirasi a
                    ON h.id_aspirasi = a.id_aspirasi

                JOIN kategori k
                    ON a.id_kategori = k.id_kategori

                WHERE a.nis = ?

                ORDER BY
                    h.tanggal DESC,
                    h.id_histori DESC";


        $s = $this->db->prepare($sql);

        $s->bind_param('i', $nis);

        $s->execute();


        return $s
            ->get_result()
            ->fetch_all(MYSQLI_ASSOC);
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH HISTORI
    |--------------------------------------------------------------------------
    */

    public function tambah(
        int $id,
        string $status,
        ?string $feedback
    ): bool {

        $sql = "INSERT INTO histori
                    (
                        id_aspirasi,
                        status,
                        feedback,
                        tanggal
                    )

                VALUES
                    (?, ?, ?, NOW())";


        $s = $this->db->prepare($sql);


        $s->bind_param(
            'iss',
            $id,
            $status,
            $feedback
        );


        return $s->execute();
    }
}