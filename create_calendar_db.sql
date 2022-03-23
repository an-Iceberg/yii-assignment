-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for calendar_db
CREATE DATABASE IF NOT EXISTS `calendar_db` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `calendar_db`;

-- Dumping structure for table calendar_db.backend_users
CREATE TABLE IF NOT EXISTS `backend_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashed_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table calendar_db.backend_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `backend_users` DISABLE KEYS */;
INSERT INTO `backend_users` (`id`, `username`, `hashed_password`) VALUES
	(1, 'test', 'TZPdHXGvjK6_8mzVGc=fa5J$e?*Y8leNbq|Y@dD=');
/*!40000 ALTER TABLE `backend_users` ENABLE KEYS */;

-- Dumping structure for table calendar_db.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `duration` smallint(6) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `treatment_id` json DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `patient_salutation` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_firstName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_lastName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_birthdate` date DEFAULT NULL,
  `patient_street` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_zipCode` int(10) unsigned DEFAULT NULL,
  `patient_city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_phoneNumber` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_email` varchar(254) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_comment` text COLLATE utf8_unicode_ci,
  `newPatient` bit(1) DEFAULT NULL,
  `callback` bit(1) DEFAULT NULL,
  `send_confirmation` bit(1) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table calendar_db.bookings: ~15 rows (approximately)
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` (`id`, `duration`, `role_id`, `treatment_id`, `date`, `time`, `patient_salutation`, `patient_firstName`, `patient_lastName`, `patient_birthdate`, `patient_street`, `patient_zipCode`, `patient_city`, `patient_phoneNumber`, `patient_email`, `patient_comment`, `newPatient`, `callback`, `send_confirmation`, `status`) VALUES
	(1, 45, 2, '["2"]', '2022-02-03', '14:30:00', 'mrs', 'Ariadne', 'Bojack', '2022-01-01', 'Laravel Str. 69ab', 64123, 'Anor Londo', '696 969 69 69', 'astolfo@website.domain', 'Hello World, how are you doing tonight?', b'1', b'0', b'1', 1),
	(2, 60, 2, '{"1": 3}', '2022-03-09', '14:15:00', 'mrs', 'Astolfo', 'Michelangelo', '1988-05-12', 'Laravel Str. 69ab', 64123, 'Anor Londo', '6969696969', 'astolfo@website.domain', '', b'1', b'0', b'1', 1),
	(3, 45, 3, '{"1": 14}', '2022-02-10', '08:00:00', 'mr', 'A', 'B', '2021-11-03', 'laragon str. 123aba', 54367, 'St. Petersburg', '684 468 68 68', 'something@somewhere.snow', '', b'1', b'0', b'1', 1),
	(4, 30, 3, '{"1": 4, "2": 5, "3": 7}', '2022-02-15', '12:00:00', 'mystery', 'first', 'last', '2021-04-02', 'laravel str. 79285a', 648, 'asdf', '684 468 68 68', 'something@somewhere.snow', '', b'0', b'1', b'1', 1),
	(5, 15, 3, '{"1": 12}', '2022-02-28', '08:00:00', 'mr', 'Role', 'Doctor', '2022-02-03', 'Laravel Str. 69ab', 54367, 'St. Petersburg', '486 468 48 48', 'astolfo@website.domain', '', b'1', b'0', b'1', 2),
	(6, 180, 3, '{"1": 6, "2": 9, "3": 10, "4": 13}', '2022-03-09', '12:00:00', 'other', 'Hello', 'World', '2021-09-01', 'laravel 234a', 468, 'St. Petersburg', '486 468 48 48', 'astolfo@website.domain', '', b'1', b'0', b'0', 0),
	(7, 30, 3, '{"1": 7, "2": 12}', '2022-04-27', '09:00:00', 'mrs', 'Ariadne', 'name', '1977-06-23', 'lj', 854, 'hgf', '684', 'test@test.test', 'Lorem ipsum dolor sit amet.', b'1', b'1', b'1', 1),
	(8, 60, 4, '{"1": 16, "2": 17}', '2022-05-26', '10:00:00', 'mr', 'A', 'B', '2022-02-04', 'sadfa', 35, 'asdfsad', '69', 'test@test.test', 'Some comment for the patient.', b'1', b'1', b'1', 1),
	(9, 15, 8, '{"1": 30, "2": 31}', '2022-02-28', '08:30:00', 'mr', 'a', 's', '2022-02-02', 's', 684, 'hgf', '66', 'test@test.test', '', b'1', b'0', b'1', 1),
	(10, 15, 3, '{"1": 4}', '2022-04-01', '08:00:00', 'mr', 'A', 'B', '2022-03-03', 'lj', 1435, 'hgf', '66', 'test@test.test', 'Comment', b'1', b'1', b'1', 1),
	(11, 30, 3, '{"1": 4, "2": 5}', '2022-04-01', '09:00:00', 'mr', 'gfagd', 'vdfa', '2022-03-01', 'lj', 1243, 'hgf', '684', 'test@test.test', '', b'1', b'1', b'1', 1),
	(12, 90, 3, '{"1": 7, "2": 12}', '2022-04-01', '11:00:00', 'mr', 'Ariadne', 'Domnhall', '0001-01-01', 'lj', 654, 'hgf', '66', 'test@test.test', '', b'0', b'1', b'1', 1),
	(13, 90, 3, '{"1": 7, "2": 12}', '2022-04-29', '11:00:00', 'mrs', 'Tester', 'Test', '1970-08-13', 'test street 420', 42069, 'Testville', '+444204206969', 'test@test.test', 'Lorem ipsum dolor sit amet.', b'1', b'1', b'1', 1),
	(14, 180, 3, '["7", "10", "11", "13"]', '2022-03-31', '09:30:00', 'mr', 'Tester', 'Test', '1956-04-27', 'test street 420', 42069, 'Testville', '+444204206969', 'test@test.test', '', b'0', b'0', b'1', 1),
	(15, 135, 3, '{"1": 5, "2": 6, "3": 7}', '2022-03-30', '10:00:00', 'other', 'Tester', 'Test', '1977-05-20', 'test street 420', 42069, 'Testville', '+444204206969', 'test@test.test', '', b'0', b'0', b'1', 1),
	(16, 90, 3, '["13", "14"]', '2022-03-29', '11:30:00', 'other', 'Tester', 'Test', '1986-09-25', 'test street 420', 42069, 'Testville', '+444204206969', 'test@test.test', '', b'1', b'1', b'0', 1);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;

-- Dumping structure for table calendar_db.holidays
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `beginning_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table calendar_db.holidays: ~4 rows (approximately)
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` (`id`, `holiday_name`, `date`, `beginning_time`, `end_time`) VALUES
	(1, 'Another name s', '2022-02-25', '11:00:00', '20:00:00'),
	(2, 'Some Name', '2022-02-16', '08:00:00', '20:00:00'),
	(3, 'New Holiday', '2022-05-20', '08:00:00', '20:00:00'),
	(4, 'Another different name', '2022-06-25', '08:00:00', '15:00:00'),
	(5, 'Holiday during work day', '2022-05-18', '10:00:00', '17:00:00');
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;

-- Dumping structure for table calendar_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `sort_order` smallint(6) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `status` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table calendar_db.roles: ~4 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `role_name`, `email`, `description`, `sort_order`, `duration`, `status`) VALUES
	(2, 'Dental Hygiene', 'dental_hygiene@calendar.test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 5, 60, b'1'),
	(3, 'Dentist', 'dentist@calendar.test', '', -3, 45, b'1'),
	(8, 'Test1', 'test@test.test', '', 96, 30, b'0');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table calendar_db.treatments
CREATE TABLE IF NOT EXISTS `treatments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `treatment_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table calendar_db.treatments: ~18 rows (approximately)
/*!40000 ALTER TABLE `treatments` DISABLE KEYS */;
INSERT INTO `treatments` (`id`, `role_id`, `treatment_name`, `sort_order`) VALUES
	(1, 2, 'Bleaching', 1),
	(2, 2, 'General Dental Examination', 2),
	(3, 2, 'Professional Tooth Cleaning', 3),
	(4, 3, 'Bleaching', 1),
	(5, 3, 'Dentures', 3),
	(6, 3, 'Fillings', 2),
	(7, 3, 'General Dental Examination', 8),
	(8, 3, 'Gum Desease', 7),
	(9, 3, 'Implants', 5),
	(10, 3, 'Inlays', 6),
	(11, 3, 'Oral Surgery', 4),
	(12, 3, 'Professional Tooth Cleaning', 9),
	(13, 3, 'Root Canal Treatment', 11),
	(14, 3, 'Toothache', 10),
	(29, 8, 'Testing', 0),
	(30, 8, 'Testing 2', 0),
	(31, 8, 'Testing 3', 0);
/*!40000 ALTER TABLE `treatments` ENABLE KEYS */;

-- Dumping structure for table calendar_db.who_has_holidays
CREATE TABLE IF NOT EXISTS `who_has_holidays` (
  `role_id` int(11) NOT NULL,
  `holiday_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`holiday_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table calendar_db.who_has_holidays: ~9 rows (approximately)
/*!40000 ALTER TABLE `who_has_holidays` DISABLE KEYS */;
INSERT INTO `who_has_holidays` (`role_id`, `holiday_id`) VALUES
	(2, 1),
	(2, 2),
	(2, 3),
	(2, 4),
	(3, 1),
	(3, 2),
	(3, 3),
	(3, 4),
	(3, 5),
	(8, 3),
	(8, 4);
/*!40000 ALTER TABLE `who_has_holidays` ENABLE KEYS */;

-- Dumping structure for table calendar_db.work_times
CREATE TABLE IF NOT EXISTS `work_times` (
  `role_id` int(11) NOT NULL DEFAULT '0',
  `weekday` tinyint(4) NOT NULL,
  `from` time DEFAULT NULL,
  `until` time DEFAULT NULL,
  `has_free` bit(1) DEFAULT NULL,
  PRIMARY KEY (`role_id`,`weekday`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table calendar_db.work_times: ~21 rows (approximately)
/*!40000 ALTER TABLE `work_times` DISABLE KEYS */;
INSERT INTO `work_times` (`role_id`, `weekday`, `from`, `until`, `has_free`) VALUES
	(2, 0, '08:00:00', '19:30:00', b'0'),
	(2, 1, '08:00:00', '19:30:00', b'0'),
	(2, 2, '08:00:00', '19:30:00', b'0'),
	(2, 3, '08:00:00', '19:30:00', b'0'),
	(2, 4, '08:00:00', '19:30:00', b'0'),
	(2, 5, '09:00:00', '13:00:00', b'0'),
	(2, 6, '00:00:00', '00:00:00', b'1'),
	(3, 0, '08:00:00', '19:30:00', b'0'),
	(3, 1, '08:00:00', '19:30:00', b'0'),
	(3, 2, '08:00:00', '19:30:00', b'0'),
	(3, 3, '08:00:00', '19:30:00', b'0'),
	(3, 4, '08:00:00', '19:30:00', b'0'),
	(3, 5, '09:00:00', '14:00:00', b'0'),
	(3, 6, '00:00:00', '00:00:00', b'1'),
	(8, 0, '08:00:00', '17:00:00', b'0'),
	(8, 1, '08:00:00', '17:00:00', b'0'),
	(8, 2, '08:00:00', '17:00:00', b'0'),
	(8, 3, '08:00:00', '17:00:00', b'0'),
	(8, 4, '08:00:00', '17:00:00', b'0'),
	(8, 5, '00:00:00', '00:00:00', b'1'),
	(8, 6, '00:00:00', '00:00:00', b'1');
/*!40000 ALTER TABLE `work_times` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
