-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2026 at 05:40 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_skm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '$2a$14$TLFQ1d6xrilNNqHy49nN7ezkA6AGb8jUYuCoiG5OzFNAvSED/MrXC', 'Admin Utama');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_skm`
--

CREATE TABLE `laporan_skm` (
  `id` int NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `file_pdf` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan_skm`
--

INSERT INTO `laporan_skm` (`id`, `tahun`, `judul`, `deskripsi`, `file_pdf`, `created_at`) VALUES
(7, '2027', 'Dinas Arpus', 'Laporan Survei Kepuasan Masyarakat Dinas Arpus di Tahun 2027', '1784252919_data_responden_skm_20260707_110440.pdf', '2026-07-17 01:48:39'),
(8, '2028', 'Dinas Arpus', 'kleas king', '1785225396_01__FORM_PENGAJUAN_PKL_MAGANG.pdf', '2026-07-28 07:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `responden`
--

CREATE TABLE `responden` (
  `id` int NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `usia` varchar(20) NOT NULL,
  `wa` varchar(20) NOT NULL,
  `pendidikan` varchar(50) NOT NULL,
  `pekerjaan` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `layanan` varchar(100) NOT NULL,
  `q1` tinyint NOT NULL,
  `q2` tinyint NOT NULL,
  `q3` tinyint NOT NULL,
  `q4` tinyint NOT NULL,
  `q5` tinyint NOT NULL,
  `q6` tinyint NOT NULL,
  `q7` tinyint NOT NULL,
  `q8` tinyint NOT NULL,
  `q9` tinyint NOT NULL,
  `saran` text,
  `tahun` smallint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `responden`
--

INSERT INTO `responden` (`id`, `nama`, `jk`, `usia`, `wa`, `pendidikan`, `pekerjaan`, `kecamatan`, `layanan`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `saran`, `tahun`, `created_at`) VALUES
(1, 'tewst', 'L', '40 - 49', '0867567876', 'SD/Sederajat', 'Seniman', 'Paninggaran', 'Fasilitas Kearsipan', 50, 75, 50, 75, 50, 50, 50, 100, 25, 'kelas kak', 2026, '2026-07-13 04:20:19'),
(2, 'kalas', 'L', '< 20', '0867567876', 'SMP', 'Seniman', 'Karanganyar', 'Layanan Umum Perpustakaan', 100, 100, 100, 100, 100, 100, 100, 75, 100, 'semua bagus', 2026, '2026-07-13 06:44:24'),
(3, 'tesT', 'L', '< 20', '0867567876', 'SMP', 'Dokter', 'Paninggaran', 'Peminjaman Arsip', 75, 50, 75, 25, 100, 100, 75, 50, 75, 'kelas king', 2026, '2026-07-17 02:16:30'),
(4, 'Maria', 'P', '40 - 49', '081234567', 'SD/Sederajat', 'Perawat', 'Siwalan', 'Informasi Arsip', 100, 75, 50, 100, 25, 50, 75, 75, 50, 'mantap', 2026, '2026-07-28 01:16:21'),
(5, 'TEST', 'L', '< 20', '0867567876', 'SMA/SMK/Sederajat', 'Ustadz/Ustadzah', 'Karanganyar', 'Informasi Arsip', 100, 100, 75, 75, 75, 50, 75, 25, 50, 'MnTO', 2026, '2026-07-28 03:50:37'),
(6, 'CLSJ', 'P', '20 - 29', '987654322', 'S1', 'Dokter', 'Karangdadap', 'Layanan Umum Perpustakaan', 75, 75, 75, 75, 50, 75, 50, 100, 75, 'KEREN', 2026, '2026-07-28 04:09:20'),
(7, 'cvv', 'L', '30 - 39', '0867567876', 'SMP', 'Dokter', 'Kandangserang', 'Konsultasi Kearsipan', 100, 75, 75, 50, 75, 100, 75, 100, 25, 'kls', 2026, '2026-07-28 04:22:47'),
(8, 'asd', 'P', '20 - 29', '0867567876', 'SMP', 'Ibu Rumah Tangga', 'Buaran', 'Informasi Arsip', 25, 75, 50, 75, 50, 75, 25, 50, 50, 'AYHTF', 2026, '2026-07-28 04:26:58'),
(9, 'tardtya', 'L', '< 20', '987654322', 'SD/Sederajat', 'Apoteker', 'Doro', 'Peminjaman Arsip', 50, 25, 75, 75, 100, 50, 75, 50, 25, 'kls brp?', 2026, '2026-07-28 04:53:34'),
(10, 'as', 'P', '20 - 29', '0867567876', 'SMP', 'Bidan', 'Lebakbarang', 'Peminjaman Arsip', 75, 75, 50, 25, 25, 25, 50, 100, 50, 'asdfg', 2026, '2026-07-28 06:39:08'),
(11, 'asd', 'P', '< 20', '0867567876', 'SMP', 'Dokter', 'Talun', 'Peminjaman Arsip', 25, 50, 75, 50, 75, 25, 50, 25, 50, 'kls nga', 2026, '2026-07-28 06:43:08'),
(12, 'aserg', 'L', '< 20', '987654322', 'SMA/SMK/Sederajat', 'Pelajar/Mahasiswa', 'Tirto', 'Fasilitas Kearsipan', 75, 100, 75, 100, 50, 25, 75, 50, 75, 'kls', 2026, '2026-07-28 06:51:54'),
(13, 'wet3', 'P', '20 - 29', '0867567876', 'SMP', 'Karyawan Swasta', 'Karangdadap', 'Konsultasi Kearsipan', 75, 50, 75, 25, 50, 75, 75, 75, 75, 'wdfa', 2026, '2026-07-28 06:53:33'),
(14, 'sdfgh', 'P', '30 - 39', '123458766', 'SMA/SMK/Sederajat', 'Nelayan', 'Wiradesa', 'Bidang Perpustakaan', 75, 50, 75, 50, 25, 50, 75, 75, 75, 'jgf', 2026, '2026-07-28 16:24:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `laporan_skm`
--
ALTER TABLE `laporan_skm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responden`
--
ALTER TABLE `responden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tahun` (`tahun`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laporan_skm`
--
ALTER TABLE `laporan_skm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `responden`
--
ALTER TABLE `responden`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
