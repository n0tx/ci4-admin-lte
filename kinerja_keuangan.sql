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
-- Database: `ci4_template`
--
 
-- --------------------------------------------------------

--
-- Dumping data for table `kinerja_keuangan`
--
 
INSERT INTO `financial_performance` (`id`, `penjualan_neto`, `laba_tahun_berjalan`, `total_aset`, `hasil_dividen`, `tahun`) VALUES
(1, 588.5, 113.5, 1324.8, 0.0071, '2019' ),
(2, 465.9, 74.8, 1342.9, 0.0047, '2020' ),
(3, 514.9, 90.4, 1358.9, 0.0057, '2021'),
(4, 550.5, 72.5, 1361.6, 0.0046, '2022' ),
(5, 546.1, 77.0, 1324.2, 0.0049, '2023');

 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;