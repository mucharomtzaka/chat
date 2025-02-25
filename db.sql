-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for chat
DROP DATABASE IF EXISTS `chat`;
CREATE DATABASE IF NOT EXISTS `chat` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `chat`;

-- Dumping structure for table chat.chat_messages
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table chat.chat_messages: ~20 rows (approximately)
DELETE FROM `chat_messages`;
INSERT INTO `chat_messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`, `is_read`) VALUES
	(1, 3, 1, 'test', '2025-02-25 05:33:40', 1),
	(2, 3, 1, 'halo', '2025-02-25 05:33:52', 1),
	(3, 1, 3, 'test', '2025-02-25 05:37:49', 1),
	(4, 3, 1, 'testa', '2025-02-25 05:38:15', 1),
	(5, 3, 1, 'halo mas baru', '2025-02-25 05:38:36', 1),
	(6, 1, 3, 'dbsh', '2025-02-25 05:40:23', 1),
	(7, 3, 1, 'test', '2025-02-25 05:47:16', 1),
	(8, 1, 3, 'halo', '2025-02-25 05:47:58', 1),
	(9, 3, 1, 'halo abangku', '2025-02-25 06:16:07', 1),
	(10, 1, 3, 'oke', '2025-02-25 06:17:19', 1),
	(11, 1, 3, 'gshhh', '2025-02-25 06:23:14', 1),
	(12, 3, 1, 'dgg', '2025-02-25 06:23:32', 1),
	(13, 1, 3, 'dfgsgggg', '2025-02-25 06:28:40', 1),
	(14, 3, 1, 'addag', '2025-02-25 06:33:13', 1),
	(15, 1, 3, 'sgsh', '2025-02-25 06:33:40', 1),
	(16, 1, 3, 'fwgwgwg', '2025-02-25 06:35:53', 1),
	(17, 1, 3, 'sfaag', '2025-02-25 06:48:14', 1),
	(18, 1, 3, 'gggggag', '2025-02-25 06:49:45', 1),
	(19, 3, 1, 'gsdgsgg', '2025-02-25 06:50:02', 1),
	(20, 1, 3, 'ggwggg', '2025-02-25 06:55:15', 1);

-- Dumping structure for table chat.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table chat.users: ~3 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
	(1, 'Mucharom', 'mucharomtzaka@gmail.com', '$2y$10$gxBpF0MuXFP00u3o4jhat.GbkDH3jZnwjVFI0rLwBLoAXdSSJTSsm', '2025-02-25 04:45:48'),
	(2, 'Agus', 'agus@yahoo.com', '$2y$10$x2QewBkrm4MmIqg7G332hO/3WVQn1IkgR76HwKwBIsip5irKaScK.', '2025-02-25 04:50:08'),
	(3, 'Admin', 'admin@test.com', '$2y$10$ppjWu5ZCUhAkFmDz0iFSL.Pm2FvNcZAuXjdlT1irrDN02/znRS16O', '2025-02-25 04:51:45');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
