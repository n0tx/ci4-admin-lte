-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 14, 2018 at 12:13 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36
 
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
 
 
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
 
--
-- Database: `listrindo`
--
 
-- --------------------------------------------------------
 
--
-- Table structure for table `kinerja_keuangan`
--
 
CREATE TABLE `kinerja_keuangan` (
  `id` int(11) NOT NULL,
  `penjualan_neto` decimal(5,1) NOT NULL,
  `laba_tahun_berjalan` decimal(5,1) NOT NULL,
  `total_aset` decimal(5,1) NOT NULL,
  `hasil_dividen` decimal(5,5) NOT NULL,
  `tahun` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
--
-- Dumping data for table `kinerja_keuangan`
--
 
INSERT INTO `kinerja_keuangan` (`id`, `penjualan_neto`, `laba_tahun_berjalan`, `total_aset`, `hasil_dividen`, `tahun`) VALUES
(1, 588.5, 113.5, 1324.8, 0.0071, '2019' ),
(2, 465.9, 74.8, 1342.9, 0.0047, '2020' ),
(3, 514.9, 90.4, 1358.9, 0.0057, '2021'),
(4, 550.5, 72.5, 1361.6, 0.0046, '2022' ),
(5, 546.1, 77.0, 1324.2, 0.0049, '2023');
 
--
-- Indexes for dumped tables
--
 
--
-- Indexes for table `kinerja_keuangan`
--
ALTER TABLE `kinerja_keuangan`
  ADD PRIMARY KEY (`id`);
 
--
-- AUTO_INCREMENT for dumped tables
--
 
--
-- AUTO_INCREMENT for table `kinerja_keuangan`
--
ALTER TABLE `kinerja_keuangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;