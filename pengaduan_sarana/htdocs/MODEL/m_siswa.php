<?php

require_once __DIR__ . '/m_koneksi.php';

class Siswa
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = (new Koneksi())->koneksi;
    }

    /**
     * Login siswa memakai NIS + password.
     * Mengembalikan data siswa (nis, kelas) jika cocok, atau null jika tidak.
     */
    public function login(int $nis, string $password): ?array
    {
        $s = $this->db->prepare(
            'SELECT nis, kelas, password FROM siswa WHERE nis = ? LIMIT 1'
        );
        $s->bind_param('i', $nis);
        $s->execute();

        $row = $s->get_result()->fetch_assoc();

        if (!$row || $row['password'] === '' || !password_verify($password, $row['password'])) {
            return null;
        }

        unset($row['password']);

        return $row;
    }

    /**
     * Ganti password oleh siswa sendiri. Password lama harus cocok.
     */
    public function gantiPassword(int $nis, string $passwordLama, string $passwordBaru): bool
    {
        $s = $this->db->prepare('SELECT password FROM siswa WHERE nis = ? LIMIT 1');
        $s->bind_param('i', $nis);
        $s->execute();
        $row = $s->get_result()->fetch_assoc();

        if (!$row || $row['password'] === '' || !password_verify($passwordLama, $row['password'])) {
            return false;
        }

        $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);
        $u = $this->db->prepare('UPDATE siswa SET password = ? WHERE nis = ?');
        $u->bind_param('si', $hash, $nis);

        return $u->execute();
    }

    public function getAll(): array
    {
        $r = $this->db->query('SELECT nis, kelas FROM siswa ORDER BY nis');

        return $r ? $r->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getByNis(int $nis): ?array
    {
        $s = $this->db->prepare('SELECT nis, kelas FROM siswa WHERE nis = ? LIMIT 1');
        $s->bind_param('i', $nis);
        $s->execute();

        return $s->get_result()->fetch_assoc() ?: null;
    }

    public function tambah(int $nis, string $kelas, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $s = $this->db->prepare('INSERT INTO siswa (nis, kelas, password) VALUES (?, ?, ?)');
        $s->bind_param('iss', $nis, $kelas, $hash);

        return $s->execute();
    }

    /**
     * Ubah kelas siswa. Password hanya diganti jika $password tidak null/kosong.
     */
    public function ubah(int $nis, string $kelas, ?string $password = null): bool
    {
        if ($password === null || $password === '') {
            $s = $this->db->prepare('UPDATE siswa SET kelas = ? WHERE nis = ?');
            $s->bind_param('si', $kelas, $nis);
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $s = $this->db->prepare('UPDATE siswa SET kelas = ?, password = ? WHERE nis = ?');
            $s->bind_param('ssi', $kelas, $hash, $nis);
        }

        return $s->execute();
    }

    public function hapus(int $nis): bool
    {
        $s = $this->db->prepare('DELETE FROM siswa WHERE nis = ?');
        $s->bind_param('i', $nis);

        return $s->execute();
    }
}
