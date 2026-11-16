-- =====================================================================
-- SARPRAS SEKOLAH - DATABASE FINAL (satu file untuk semua kondisi)
--
-- Cara pakai di phpMyAdmin:
--   1. Pilih database hosting kamu (mis. if0_43250414_sarpras).
--   2. Tab SQL > paste isi file ini > Go.
--
-- PERHATIAN: file ini MENGHAPUS dan MEMBUAT ULANG tabel admin, kategori,
-- siswa, aspirasi, dan histori. Semua data di tabel tersebut akan diganti
-- dengan data contoh. Jangan jalankan jika database sudah berisi data asli.
--
-- Akun contoh:
--   Admin : admin01 / admin123   (wajib diganti setelah login)
--   Siswa : NIS 2026101 / siswa123 (siswa bisa ganti di menu Profil)
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `histori`;
DROP TABLE IF EXISTS `aspirasi`;
DROP TABLE IF EXISTS `siswa`;
DROP TABLE IF EXISTS `kategori`;
DROP TABLE IF EXISTS `admin`;
SET FOREIGN_KEY_CHECKS = 1;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2026 at 03:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sarpras`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin01', 'admin123'),
(2, 'admin02', 'admin123'),
(3, 'admin03', 'admin123'),
(4, 'admin04', 'admin123'),
(5, 'admin05', 'admin123'),
(6, 'admin06', 'admin123'),
(7, 'admin07', 'admin123'),
(8, 'admin08', 'admin123'),
(9, 'admin09', 'admin123'),
(10, 'admin10', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int(5) NOT NULL,
  `nis` int(10) NOT NULL,
  `id_admin` int(5) DEFAULT NULL,
  `status` enum('Menunggu','Proses','Selesai') NOT NULL DEFAULT 'Menunggu',
  `id_kategori` int(5) NOT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `nis`, `id_admin`, `status`, `id_kategori`, `feedback`) VALUES
(1, 2026101, 1, 'Selesai', 1, 'Kipas angin sudah diperbaiki'),
(2, 2026102, 2, 'Proses', 2, 'Keran sedang menunggu penggantian'),
(3, 2026103, 3, 'Proses', 3, 'Komputer sedang diperiksa teknisi'),
(4, 2026104, 4, 'Selesai', 4, 'Lampu sudah diganti'),
(5, 2026105, 5, 'Menunggu', 5, NULL),
(6, 2026106, 6, 'Selesai', 6, 'Tempat sampah sudah ditambahkan'),
(7, 2026107, 7, 'Proses', 7, 'Jaringan sedang diperbaiki'),
(8, 2026108, 8, 'Selesai', 8, 'Kelas sudah dibersihkan'),
(9, 2026109, 9, 'Menunggu', 9, NULL),
(10, 2026110, 10, 'Proses', 10, 'Kursi sedang dalam proses perbaikan');

-- --------------------------------------------------------

--
-- Table structure for table `histori`
--

CREATE TABLE `histori` (
  `id_histori` int(5) NOT NULL,
  `id_aspirasi` int(5) NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') NOT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `histori`
--

INSERT INTO `histori` (`id_histori`, `id_aspirasi`, `status`, `feedback`, `tanggal`) VALUES
(1, 1, 'Menunggu', 'Laporan telah diterima', '2026-08-20 08:00:00'),
(2, 2, 'Proses', 'Keran sedang diperiksa', '2026-08-20 09:15:00'),
(3, 3, 'Proses', 'Komputer sedang diperiksa teknisi', '2026-08-21 10:00:00'),
(4, 4, 'Selesai', 'Lampu sudah diganti', '2026-08-21 11:30:00'),
(5, 5, 'Menunggu', 'Laporan sedang menunggu tindakan', '2026-08-22 08:30:00'),
(6, 6, 'Selesai', 'Tempat sampah sudah ditambahkan', '2026-08-22 13:00:00'),
(7, 7, 'Proses', 'Jaringan sedang diperbaiki', '2026-08-23 09:00:00'),
(8, 8, 'Selesai', 'Kelas sudah dibersihkan', '2026-08-23 10:30:00'),
(9, 9, 'Menunggu', 'Laporan telah diterima admin', '2026-08-24 08:45:00'),
(10, 10, 'Proses', 'Kursi sedang dalam proses perbaikan', '2026-08-24 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `ket_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`) VALUES
(1, 'Ruang Kelas'),
(2, 'Toilet'),
(3, 'Laboratorium'),
(4, 'Perpustakaan'),
(5, 'Lapangan'),
(6, 'Kantin'),
(7, 'Fasilitas IT'),
(8, 'Kebersihan'),
(9, 'Keamanan'),
(10, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int(10) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `kelas`, `password`) VALUES
(2026101, 'X RPL 1', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026102, 'X RPL 2', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026103, 'X PM 1', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026104, 'XI RPL 2', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026105, 'XI RPL 1', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026106, 'XI RPL 2', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026107, 'XI BR 1', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026108, 'XII RPL 2', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026109, 'XII RPL 1', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG'),
(2026110, 'XII BR 2', '$2y$10$B42G7dUcrIfWohe/NzGZPuP1b6Vomt/G4kwuwcKXQFssLIoW8l6aG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `nis` (`nis`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `histori`
--
ALTER TABLE `histori`
  ADD PRIMARY KEY (`id_histori`),
  ADD KEY `id_aspirasi` (`id_aspirasi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `histori`
--
ALTER TABLE `histori`
  MODIFY `id_histori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aspirasi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aspirasi_ibfk_3` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `histori`
--
ALTER TABLE `histori`
  ADD CONSTRAINT `histori_ibfk_1` FOREIGN KEY (`id_aspirasi`) REFERENCES `aspirasi` (`id_aspirasi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET FOREIGN_KEY_CHECKS = 1;
