-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 15, 2026 at 04:10 AM
-- Server version: 12.2.2-MariaDB
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
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '$2y$10$2HYM9e6VV6p.dSrGTWqrc.Nv8niXFPguchuFkdTIWsVpV85fN6lLC', 'Administrator Web');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_skm`
--

CREATE TABLE `laporan_skm` (
  `id` int(11) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_pdf` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `laporan_skm`
--

INSERT INTO `laporan_skm` (`id`, `tahun`, `judul`, `deskripsi`, `file_pdf`, `created_at`) VALUES
(2, '2025', 'Laporan dinas Arpus Tahun 2025', 'unutku hlbshjgpsyuirgjsdbluaegi;f', '1786499768_LAPORAN_SKM_2025_Dinas_Arpus.pdf', '2026-08-12 01:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `responden`
--

CREATE TABLE `responden` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `usia` varchar(20) NOT NULL,
  `wa` varchar(20) NOT NULL,
  `pendidikan` varchar(50) NOT NULL,
  `pekerjaan` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `layanan` varchar(100) NOT NULL,
  `q1` tinyint(4) NOT NULL,
  `q2` tinyint(4) NOT NULL,
  `q3` tinyint(4) NOT NULL,
  `q4` tinyint(4) NOT NULL,
  `q5` tinyint(4) NOT NULL,
  `q6` tinyint(4) NOT NULL,
  `q7` tinyint(4) NOT NULL,
  `q8` tinyint(4) NOT NULL,
  `q9` tinyint(4) NOT NULL,
  `saran` text DEFAULT NULL,
  `tahun` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `responden`
--

INSERT INTO `responden` (`id`, `nama`, `jk`, `usia`, `wa`, `pendidikan`, `pekerjaan`, `kecamatan`, `layanan`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `saran`, `tahun`, `created_at`) VALUES
(2, 'maria', 'P', '20 - 29', '0857778234', 'SD/Sederajat', 'Ibu Rumah Tangga', 'Wonokerto', 'Layanan Umum Perpustakaan', 75, 100, 75, 75, 75, 75, 75, 100, 75, 'mantap kak', 2026, '2026-08-03 02:21:27');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laporan_skm`
--
ALTER TABLE `laporan_skm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `responden`
--
ALTER TABLE `responden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
