-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2025 at 11:46 PM
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
-- Database: `moora_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatives`
--

CREATE TABLE `alternatives` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alternatives`
--

INSERT INTO `alternatives` (`id`, `name`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'A3'),
(4, 'A4'),
(5, 'A5'),
(6, 'A6'),
(7, 'A7'),
(8, 'A8'),
(9, 'A9'),
(10, 'A10'),
(11, 'A11'),
(12, 'A12'),
(13, 'A13'),
(14, 'A14'),
(15, 'A15');

-- --------------------------------------------------------

--
-- Table structure for table `alternative_values`
--

CREATE TABLE `alternative_values` (
  `id` int NOT NULL,
  `alternative_id` int NOT NULL,
  `criterion_id` int NOT NULL,
  `value` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alternative_values`
--

INSERT INTO `alternative_values` (`id`, `alternative_id`, `criterion_id`, `value`) VALUES
(13, 3, 1, '5.00'),
(14, 3, 2, '5.00'),
(15, 3, 3, '5.00'),
(16, 3, 4, '5.00'),
(17, 3, 5, '5.00'),
(18, 3, 6, '5.00'),
(19, 4, 1, '3.00'),
(20, 4, 2, '4.00'),
(21, 4, 3, '2.00'),
(22, 4, 4, '3.00'),
(23, 4, 5, '1.00'),
(24, 4, 6, '3.00'),
(25, 5, 1, '3.00'),
(26, 5, 2, '5.00'),
(27, 5, 3, '4.00'),
(28, 5, 4, '4.00'),
(29, 5, 5, '4.00'),
(30, 5, 6, '3.00'),
(31, 6, 1, '1.00'),
(32, 6, 2, '4.00'),
(33, 6, 3, '3.00'),
(34, 6, 4, '4.00'),
(35, 6, 5, '3.00'),
(36, 6, 6, '5.00'),
(37, 7, 1, '5.00'),
(38, 7, 2, '5.00'),
(39, 7, 3, '5.00'),
(40, 7, 4, '5.00'),
(41, 7, 5, '4.00'),
(42, 7, 6, '2.00'),
(43, 8, 1, '2.00'),
(44, 8, 2, '4.00'),
(45, 8, 3, '4.00'),
(46, 8, 4, '3.00'),
(47, 8, 5, '1.00'),
(48, 8, 6, '4.00'),
(49, 9, 1, '4.00'),
(50, 9, 2, '5.00'),
(51, 9, 3, '4.00'),
(52, 9, 4, '4.00'),
(53, 9, 5, '4.00'),
(54, 9, 6, '3.00'),
(55, 10, 1, '1.00'),
(56, 10, 2, '4.00'),
(57, 10, 3, '3.00'),
(58, 10, 4, '3.00'),
(59, 10, 5, '1.00'),
(60, 10, 6, '2.00'),
(61, 11, 1, '4.00'),
(62, 11, 2, '5.00'),
(63, 11, 3, '4.00'),
(64, 11, 4, '4.00'),
(65, 11, 5, '5.00'),
(66, 11, 6, '1.00'),
(67, 12, 1, '5.00'),
(68, 12, 2, '5.00'),
(69, 12, 3, '5.00'),
(70, 12, 4, '5.00'),
(71, 12, 5, '3.00'),
(72, 12, 6, '2.00'),
(73, 13, 1, '3.00'),
(74, 13, 2, '5.00'),
(75, 13, 3, '2.00'),
(76, 13, 4, '4.00'),
(77, 13, 5, '4.00'),
(78, 13, 6, '3.00'),
(79, 14, 1, '1.00'),
(80, 14, 2, '4.00'),
(81, 14, 3, '3.00'),
(82, 14, 4, '4.00'),
(83, 14, 5, '4.00'),
(84, 14, 6, '1.00'),
(85, 15, 1, '3.00'),
(86, 15, 2, '5.00'),
(87, 15, 3, '4.00'),
(88, 15, 4, '5.00'),
(89, 15, 5, '5.00'),
(90, 15, 6, '2.00'),
(116, 1, 1, '4.00'),
(117, 1, 2, '4.00'),
(118, 1, 3, '4.00'),
(119, 1, 4, '4.00'),
(120, 1, 5, '4.00'),
(121, 1, 6, '4.00'),
(123, 2, 1, '2.00'),
(124, 2, 2, '4.00'),
(125, 2, 3, '3.00'),
(126, 2, 4, '4.00'),
(127, 2, 5, '4.00'),
(128, 2, 6, '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `type` enum('Cost','Benefit') NOT NULL,
  `weight` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `code`, `name`, `description`, `type`, `weight`) VALUES
(1, 'C1', 'Jumlah Usaha Sejenis', 'Jumlah usaha yang sejenis di sekitar lokasi', 'Cost', '0.20'),
(2, 'C2', 'Luas Tanah', 'Luas tanah yang tersedia untuk usaha', 'Benefit', '0.15'),
(3, 'C3', 'Keamanan', 'Tingkat keamanan di lokasi usaha', 'Benefit', '0.25'),
(4, 'C4', 'Internetan', 'Ketersediaan akses internet', 'Benefit', '0.10'),
(5, 'C5', 'Pusat Keramaian', 'Kedekatan dengan pusat keramaian', 'Benefit', '0.20'),
(6, 'C6', 'Harga Sewa', 'Harga sewa lokasi usaha', 'Cost', '0.10');

-- --------------------------------------------------------

--
-- Table structure for table `subcriteria`
--

CREATE TABLE `subcriteria` (
  `id` int NOT NULL,
  `criterion_id` int NOT NULL,
  `description` text,
  `score` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subcriteria`
--

INSERT INTO `subcriteria` (`id`, `criterion_id`, `description`, `score`) VALUES
(1, 1, 'Tidak ada usaha sejenis', 5),
(2, 1, 'Sedikit usaha sejenis', 4),
(3, 1, 'Beberapa usaha sejenis', 3),
(4, 1, 'Cukup banyak usaha sejenis', 2),
(5, 1, 'Banyak usaha sejenis', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pimpinan','staff') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `role`, `created_at`) VALUES
(1, 'admin1', 'Ridho', '$2a$12$hfhQ.qz1QbWGB2oyFt81dOIpS0hCmx.6ZcAqeC7UJJoMoul5F2HVC', 'pimpinan', '2025-01-13 21:54:11'),
(2, 'asepp', 'Asep', '$2y$10$uaLQZTyKLC0swhoUEJzSgecu/dsDbjKmDMTb2LIUKRrI.ofYFcbTG', 'staff', '2025-01-13 22:05:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatives`
--
ALTER TABLE `alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alternative_values`
--
ALTER TABLE `alternative_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alternative_id` (`alternative_id`),
  ADD KEY `criterion_id` (`criterion_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcriteria`
--
ALTER TABLE `subcriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criterion_id` (`criterion_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `alternative_values`
--
ALTER TABLE `alternative_values`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subcriteria`
--
ALTER TABLE `subcriteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternative_values`
--
ALTER TABLE `alternative_values`
  ADD CONSTRAINT `alternative_values_ibfk_1` FOREIGN KEY (`alternative_id`) REFERENCES `alternatives` (`id`),
  ADD CONSTRAINT `alternative_values_ibfk_2` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`id`);

--
-- Constraints for table `subcriteria`
--
ALTER TABLE `subcriteria`
  ADD CONSTRAINT `subcriteria_ibfk_1` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
