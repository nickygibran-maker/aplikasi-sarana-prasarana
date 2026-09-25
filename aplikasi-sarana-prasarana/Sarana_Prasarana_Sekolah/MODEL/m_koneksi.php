<?php
class Koneksi {
    private string $host = 'localhost';
    private string $username = 'root';
    private string $password = '';
    private string $db = 'sarpras';
    public mysqli $koneksi;
    public function __construct() {
        $this->koneksi = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->koneksi->connect_errno) die('Koneksi database gagal: '.$this->koneksi->connect_error);
        $this->koneksi->set_charset('utf8mb4');
    }
}
