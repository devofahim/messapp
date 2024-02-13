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


-- Dumping database structure for mess
CREATE DATABASE IF NOT EXISTS `mess` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mess`;

-- Dumping structure for table mess.meal
CREATE TABLE IF NOT EXISTS `meal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `mess_id` int DEFAULT NULL,
  `meal_count` int DEFAULT NULL,
  `datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `mess_id` (`mess_id`),
  CONSTRAINT `meal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `meal_ibfk_2` FOREIGN KEY (`mess_id`) REFERENCES `mess_members` (`mess_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table mess.meal: ~11 rows (approximately)
DELETE FROM `meal`;
INSERT INTO `meal` (`id`, `user_id`, `mess_id`, `meal_count`, `datetime`) VALUES
	(3, 1, 14, 2, '2024-02-12 17:10:58'),
	(4, 2, 14, 1, '2024-02-12 17:14:55'),
	(5, 2, 14, 5, '2024-02-12 17:22:57'),
	(6, 2, 14, 32, '2024-02-12 17:26:45'),
	(7, 1, 14, 76, '2024-02-12 17:26:53'),
	(8, 1, 14, 9, '2024-02-12 17:26:58'),
	(9, 1, 14, 4, '2024-02-12 17:27:06'),
	(10, 1, 14, 1, '2024-02-12 17:27:14'),
	(11, 1, 14, 1, '2024-02-12 17:27:22'),
	(12, 1, 14, 54, '2024-02-12 17:27:28'),
	(13, 2, 14, 4, '2024-02-12 17:27:35');

-- Dumping structure for table mess.mess
CREATE TABLE IF NOT EXISTS `mess` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `mess_name` varchar(100) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_user_id` (`user_id`),
  CONSTRAINT `mess_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table mess.mess: ~2 rows (approximately)
DELETE FROM `mess`;
INSERT INTO `mess` (`id`, `user_id`, `mess_name`, `created_date`) VALUES
	(13, 1, 'sdfsdfsfsdfsdf', '2024-02-11 18:03:25'),
	(14, 2, 'Galib Bhai er mess', '2024-02-11 18:28:51');

-- Dumping structure for table mess.mess_members
CREATE TABLE IF NOT EXISTS `mess_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `mess_id` int DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `mess_id` (`mess_id`),
  CONSTRAINT `mess_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `mess_members_ibfk_2` FOREIGN KEY (`mess_id`) REFERENCES `mess` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table mess.mess_members: ~2 rows (approximately)
DELETE FROM `mess_members`;
INSERT INTO `mess_members` (`id`, `user_id`, `mess_id`, `job_title`) VALUES
	(6, 2, 14, 'manager'),
	(8, 1, 14, 'member');

-- Dumping structure for table mess.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table mess.users: ~3 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `password`) VALUES
	(1, 'fahim', '$2y$10$3M7ZZqcWNduil0Vkp1Y.3unClbXVziu20JlcjXEgYcAgRbSjC5d1K'),
	(2, 'mushfiq', '$2y$10$fOcvLVnCw./s.xPhbE5HH.ryjetqhhOB/HZnQVQ9ziZFdcnYAtmM6'),
	(3, 'omg', '$2y$10$zuYi5YMhIgPFNLbAMKJ7.exLlU/TkLcImghDI7Ck4VLuqgmPa56LK');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
