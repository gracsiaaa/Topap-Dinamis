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


-- Dumping database structure for db_topap
CREATE DATABASE IF NOT EXISTS `db_topap` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_topap`;

-- Dumping structure for table db_topap.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_game` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `gambar_banner` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_topap.categories: ~5 rows (approximately)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `nama_game`, `slug`, `gambar_banner`) VALUES
	(1, 'Mobile Legends', 'mobile-legends', 'ml.jpeg'),
	(2, 'Roblox', 'roblox', 'roblox.jpeg'),
	(3, 'Valorant', 'valorant', 'valo.jpeg'),
	(4, 'Free Fire', 'free-fire', 'ff.jpeg'),
	(5, 'Honor of Kings', 'honor-of-kings', 'hok.jpeg');

-- Dumping structure for table db_topap.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_topap.products: ~21 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `category_id`, `nama_produk`, `harga`) VALUES
	(1, 1, '86 Diamonds', 20000),
	(2, 1, '172 Diamonds', 40000),
	(3, 1, '257 Diamonds', 60000),
	(4, 1, '706 Diamonds', 155000),
	(5, 2, '100 Robux', 15000),
	(6, 2, '400 Robux', 60000),
	(7, 2, '800 Robux', 120000),
	(8, 2, '1700 Robux', 250000),
	(9, 3, '625 Points', 65000),
	(10, 3, '1125 Points', 120000),
	(11, 3, '1650 Points', 170000),
	(12, 3, '2850 Points', 290000),
	(13, 4, '50 Diamonds', 8000),
	(14, 4, '140 Diamonds', 20000),
	(15, 4, '355 Diamonds', 50000),
	(16, 4, '720 Diamonds', 100000),
	(17, 5, '17 Tokens', 4000),
	(18, 5, '88 Tokens', 15000),
	(19, 5, '257 Tokens', 45000),
	(20, 5, '432 Tokens', 75000),
	(21, 5, '895 Tokens', 150000);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
