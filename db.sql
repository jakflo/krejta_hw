-- Adminer 5.2.1 MySQL 8.0.31 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `krejta` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `krejta`;

CREATE TABLE `subsribed_email` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


-- 2025-08-31 18:01:32 UTC
