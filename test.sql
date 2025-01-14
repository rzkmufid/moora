-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for moora_test
CREATE DATABASE IF NOT EXISTS `moora_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `moora_test`;

-- Dumping structure for table moora_test.alternatives
CREATE TABLE IF NOT EXISTS `alternatives` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table moora_test.alternatives: ~15 rows (approximately)
REPLACE INTO `alternatives` (`id`, `name`) VALUES
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

-- Dumping structure for table moora_test.alternative_values
CREATE TABLE IF NOT EXISTS `alternative_values` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alternative_id` int NOT NULL,
  `criterion_id` int NOT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alternative_id` (`alternative_id`),
  KEY `criterion_id` (`criterion_id`),
  CONSTRAINT `alternative_values_ibfk_1` FOREIGN KEY (`alternative_id`) REFERENCES `alternatives` (`id`),
  CONSTRAINT `alternative_values_ibfk_2` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table moora_test.alternative_values: ~90 rows (approximately)
REPLACE INTO `alternative_values` (`id`, `alternative_id`, `criterion_id`, `value`) VALUES
	(1, 1, 1, 4.00),
	(2, 1, 2, 4.00),
	(3, 1, 3, 4.00),
	(4, 1, 4, 4.00),
	(5, 1, 5, 4.00),
	(6, 1, 6, 4.00),
	(7, 2, 1, 2.00),
	(8, 2, 2, 4.00),
	(9, 2, 3, 3.00),
	(10, 2, 4, 4.00),
	(11, 2, 5, 4.00),
	(12, 2, 6, 2.00),
	(13, 3, 1, 5.00),
	(14, 3, 2, 5.00),
	(15, 3, 3, 5.00),
	(16, 3, 4, 5.00),
	(17, 3, 5, 5.00),
	(18, 3, 6, 5.00),
	(19, 4, 1, 3.00),
	(20, 4, 2, 4.00),
	(21, 4, 3, 2.00),
	(22, 4, 4, 3.00),
	(23, 4, 5, 1.00),
	(24, 4, 6, 3.00),
	(25, 5, 1, 3.00),
	(26, 5, 2, 5.00),
	(27, 5, 3, 4.00),
	(28, 5, 4, 4.00),
	(29, 5, 5, 4.00),
	(30, 5, 6, 3.00),
	(31, 6, 1, 1.00),
	(32, 6, 2, 4.00),
	(33, 6, 3, 3.00),
	(34, 6, 4, 4.00),
	(35, 6, 5, 3.00),
	(36, 6, 6, 5.00),
	(37, 7, 1, 5.00),
	(38, 7, 2, 5.00),
	(39, 7, 3, 5.00),
	(40, 7, 4, 5.00),
	(41, 7, 5, 4.00),
	(42, 7, 6, 2.00),
	(43, 8, 1, 2.00),
	(44, 8, 2, 4.00),
	(45, 8, 3, 4.00),
	(46, 8, 4, 3.00),
	(47, 8, 5, 1.00),
	(48, 8, 6, 4.00),
	(49, 9, 1, 4.00),
	(50, 9, 2, 5.00),
	(51, 9, 3, 4.00),
	(52, 9, 4, 4.00),
	(53, 9, 5, 4.00),
	(54, 9, 6, 3.00),
	(55, 10, 1, 1.00),
	(56, 10, 2, 4.00),
	(57, 10, 3, 3.00),
	(58, 10, 4, 3.00),
	(59, 10, 5, 1.00),
	(60, 10, 6, 2.00),
	(61, 11, 1, 4.00),
	(62, 11, 2, 5.00),
	(63, 11, 3, 4.00),
	(64, 11, 4, 4.00),
	(65, 11, 5, 5.00),
	(66, 11, 6, 1.00),
	(67, 12, 1, 5.00),
	(68, 12, 2, 5.00),
	(69, 12, 3, 5.00),
	(70, 12, 4, 5.00),
	(71, 12, 5, 3.00),
	(72, 12, 6, 2.00),
	(73, 13, 1, 3.00),
	(74, 13, 2, 5.00),
	(75, 13, 3, 2.00),
	(76, 13, 4, 4.00),
	(77, 13, 5, 4.00),
	(78, 13, 6, 3.00),
	(79, 14, 1, 1.00),
	(80, 14, 2, 4.00),
	(81, 14, 3, 3.00),
	(82, 14, 4, 4.00),
	(83, 14, 5, 4.00),
	(84, 14, 6, 1.00),
	(85, 15, 1, 3.00),
	(86, 15, 2, 5.00),
	(87, 15, 3, 4.00),
	(88, 15, 4, 5.00),
	(89, 15, 5, 5.00),
	(90, 15, 6, 2.00);

-- Dumping structure for table moora_test.criteria
CREATE TABLE IF NOT EXISTS `criteria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `type` enum('Cost','Benefit') NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table moora_test.criteria: ~6 rows (approximately)
REPLACE INTO `criteria` (`id`, `code`, `name`, `description`, `type`, `weight`) VALUES
	(1, 'C1', 'Jumlah Usaha Sejenis', 'Jumlah usaha yang sejenis di sekitar lokasi', 'Cost', 0.20),
	(2, 'C2', 'Luas Tanah', 'Luas tanah yang tersedia untuk usaha', 'Benefit', 0.15),
	(3, 'C3', 'Keamanan', 'Tingkat keamanan di lokasi usaha', 'Benefit', 0.25),
	(4, 'C4', 'Internetan', 'Ketersediaan akses internet', 'Benefit', 0.10),
	(5, 'C5', 'Pusat Keramaian', 'Kedekatan dengan pusat keramaian', 'Benefit', 0.20),
	(6, 'C6', 'Harga Sewa', 'Harga sewa lokasi usaha', 'Cost', 0.10);

-- Dumping structure for table moora_test.subcriteria
CREATE TABLE IF NOT EXISTS `subcriteria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `criterion_id` int NOT NULL,
  `description` text,
  `score` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `criterion_id` (`criterion_id`),
  CONSTRAINT `subcriteria_ibfk_1` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table moora_test.subcriteria: ~5 rows (approximately)
REPLACE INTO `subcriteria` (`id`, `criterion_id`, `description`, `score`) VALUES
	(1, 1, 'Tidak ada usaha sejenis', 5),
	(2, 1, 'Sedikit usaha sejenis', 4),
	(3, 1, 'Beberapa usaha sejenis', 3),
	(4, 1, 'Cukup banyak usaha sejenis', 2),
	(5, 1, 'Banyak usaha sejenis', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
