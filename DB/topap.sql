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
  `tipe_input` enum('id_server','id_only') DEFAULT 'id_server',
  `is_popular` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_topap.categories: ~5 rows (approximately)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `nama_game`, `slug`, `gambar_banner`, `tipe_input`, `is_popular`) VALUES
	(1, 'Mobile Legends', 'mobile-legends', 'ml.jpeg', 'id_server', 1),
	(2, 'Free Fire', 'free-fire', 'ff.jpeg', 'id_only', 1),
	(3, 'Genshin Impact', 'genshin-impact', 'genshin.jpeg', 'id_server', 1),
	(4, 'Valorant', 'valorant', 'valo.jpeg', 'id_only', 1),
	(5, 'Honor of Kings', 'honor-of-kings', 'hok.jpeg', 'id_server', 1),
	(6, 'PUBG Mobile', 'pubg-mobile', 'pubg.jpeg', 'id_only', 0),
	(7, 'Roblox', 'roblox', 'roblox.jpeg', 'id_only', 0),
	(8, 'Call of Duty Mobile', 'cod-mobile', 'codm.jpeg', 'id_only', 0),
	(9, 'League of Legends', 'lol-wild-rift', 'lol.jpeg', 'id_only', 0),
	(10, 'Steam Wallet', 'steam-wallet', 'steam.jpeg', 'id_only', 0),
	(11, 'Arena of Valor', 'aov', 'aov.jpeg', 'id_only', 0),
	(12, 'Sausage Man', 'sausage-man', 'sausage.jpeg', 'id_only', 0),
	(13, 'Point Blank', 'point-blank', 'pb.jpeg', 'id_only', 0),
	(14, 'Ragnarok Origin', 'ragnarok-origin', 'ragnarok.jpeg', 'id_server', 0),
	(15, 'FC Mobile', 'fc-mobile', 'fcmobile.jpeg', 'id_only', 0);

-- Dumping structure for table db_topap.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_topap.products: ~21 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `category_id`, `nama_produk`, `harga`) VALUES
	(1, 1, '86 Diamonds', 20000),
	(2, 1, '172 Diamonds', 40000),
	(3, 1, '257 Diamonds', 60000),
	(4, 1, '706 Diamonds', 155000),
	(5, 1, 'Weekly Diamond Pass', 28000),
	(6, 1, 'Twilight Pass', 145000),
	(7, 2, '50 Diamonds', 8000),
	(8, 2, '140 Diamonds', 20000),
	(9, 2, '355 Diamonds', 50000),
	(10, 2, '720 Diamonds', 100000),
	(11, 2, 'Member Mingguan', 30000),
	(12, 2, 'Member Bulanan', 150000),
	(13, 3, '60 Genesis Crystal', 15000),
	(14, 3, '300 Genesis Crystal', 65000),
	(15, 3, '980 Genesis Crystal', 200000),
	(16, 3, 'Welkin Moon', 79000),
	(17, 4, '125 Points', 15000),
	(18, 4, '420 Points', 50000),
	(19, 4, '700 Points', 80000),
	(20, 4, '1375 Points', 150000),
	(21, 4, '2400 Points', 250000),
	(22, 5, '17 Tokens', 3500),
	(23, 5, '88 Tokens', 15000),
	(24, 5, '257 Tokens', 45000),
	(25, 5, 'Weekly Card', 30000),
	(26, 6, '60 UC', 14000),
	(27, 6, '325 UC', 70000),
	(28, 6, '660 UC', 140000),
	(29, 6, 'Royale Pass', 155000),
	(30, 7, '80 Robux', 15000),
	(31, 7, '400 Robux', 70000),
	(32, 7, '800 Robux', 135000),
	(33, 7, '1700 Robux', 330000),
	(34, 8, '53 CP', 10000),
	(35, 8, '321 CP', 50000),
	(36, 8, '645 CP', 100000),
	(37, 9, '425 Wild Cores', 50000),
	(38, 9, '1000 Wild Cores', 100000),
	(39, 10, 'IDR 12.000', 15000),
	(40, 10, 'IDR 45.000', 50000),
	(41, 10, 'IDR 90.000', 100000),
	(42, 11, '40 Vouchers', 10000),
	(43, 11, '90 Vouchers', 20000),
	(44, 12, '60 Candy', 15000),
	(45, 12, '300 Candy', 70000),
	(46, 13, '1200 Cash', 12000),
	(47, 13, '2400 Cash', 24000),
	(48, 14, 'Nyan Berry x16', 5000),
	(49, 14, 'Nyan Berry x90', 25000),
	(50, 15, 'Silver', 15000),
	(51, 15, 'Gold', 50000);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
