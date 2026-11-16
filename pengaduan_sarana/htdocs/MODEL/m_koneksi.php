<?php

class Koneksi
{
    public mysqli $koneksi;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_OFF);
        $config = require __DIR__ . '/config.php';

        $host = (string) ($config['host'] ?? 'localhost');
        $username = (string) ($config['username'] ?? 'root');
        $password = (string) ($config['password'] ?? '');
        $database = (string) ($config['database'] ?? 'sarpras');
        $port = isset($config['port']) ? (int) $config['port'] : 3306;

        $db = @new mysqli($host, $username, $password, $database, $port);
        if ($db->connect_errno) {
            // Jangan tampilkan username/password atau detail server ke pengunjung umum.
            error_log('Koneksi database Sarpras gagal: ' . $db->connect_error);
            http_response_code(500);
            exit('Database belum terhubung. Periksa pengaturan MODEL/config.php dan pastikan database sudah diimpor.');
        }

        $charset = (string) ($config['charset'] ?? 'utf8mb4');
        if (!$db->set_charset($charset)) {
            error_log('Gagal mengatur charset database Sarpras.');
        }

        $this->koneksi = $db;
    }
}
