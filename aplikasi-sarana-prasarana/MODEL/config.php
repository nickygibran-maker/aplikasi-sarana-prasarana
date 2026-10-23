<?php
/**
 * Konfigurasi database aplikasi Sarana dan Prasarana.
 *
 * Hosting: isi nilai di bawah dari menu MySQL Databases pada panel hosting.
 * Jangan membagikan file ini karena berisi kredensial database.
 */
return [
    // Lokal XAMPP: localhost | Hosting: hostname MySQL dari panel hosting
    'host' => 'localhost',
    // Lokal XAMPP umumnya root | Hosting: username database dari panel hosting
    'username' => 'root',
    // Lokal XAMPP umumnya kosong | Hosting: password database yang dibuat
    'password' => '',
    // Nama database lokal: sarpras | Hosting: nama lengkap database dari panel hosting
    'database' => 'sarpras',
    'charset' => 'utf8mb4',
];
