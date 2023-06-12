-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2023 at 04:47 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bisnew3`
--

-- --------------------------------------------------------

--
-- Table structure for table `cavity`
--

DROP TABLE IF EXISTS `cavity`;
CREATE TABLE IF NOT EXISTS `cavity` (
  `cavity_id` int NOT NULL,
  `cavity_name` varchar(50) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `availability_date` datetime DEFAULT NULL,
  PRIMARY KEY (`cavity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cavity`
--

INSERT INTO `cavity` (`cavity_id`, `cavity_name`, `is_available`, `availability_date`) VALUES
(34, 'A3-CV4', 1, NULL),
(33, 'A3-CV3', 1, NULL),
(32, 'A3-CV2', 1, NULL),
(31, 'A3-CV1', 1, NULL),
(30, 'B6-CV4', 1, NULL),
(29, 'B6-CV3', 1, NULL),
(28, 'B6-CV2', 1, NULL),
(27, 'B6-CV1', 1, NULL),
(26, 'B5-CV4', 1, NULL),
(25, 'B5-CV3', 1, NULL),
(24, 'B5-CV2', 1, NULL),
(23, 'B5-CV1', 1, NULL),
(22, 'B4-CV4', 1, NULL),
(21, 'B4-CV3', 1, NULL),
(20, 'B4-CV2', 1, NULL),
(19, 'B4-CV1', 1, NULL),
(18, 'B3-CV4', 1, NULL),
(17, 'B3-CV3', 1, NULL),
(16, 'B3-CV2', 1, NULL),
(15, 'B3-CV1', 1, NULL),
(14, 'B2-CV4', 1, NULL),
(13, 'B2-CV3', 0, '2023-06-28 17:25:33'),
(12, 'B2-CV2', 0, '2023-06-25 13:25:33'),
(11, 'B2-CV1', 0, '2023-06-14 08:45:33'),
(10, 'B1-CV4', 0, '2023-06-26 14:05:33'),
(9, 'B1-CV3', 0, '2023-06-15 21:25:33'),
(8, 'B1-CV2', 0, '2023-06-16 12:45:33'),
(7, 'B1-CV1', 0, '2023-06-16 17:05:33'),
(6, 'F6-CV1', 1, NULL),
(5, 'F5-CV1', 1, NULL),
(4, 'F4-CV1', 1, NULL),
(3, 'F3-CV1', 1, NULL),
(2, 'F2-CV1', 0, '2023-06-26 23:45:33'),
(1, 'F1-CV1', 0, '2023-06-17 09:43:49');

-- --------------------------------------------------------

--
-- Table structure for table `mold`
--

DROP TABLE IF EXISTS `mold`;
CREATE TABLE IF NOT EXISTS `mold` (
  `mold_id` int NOT NULL AUTO_INCREMENT,
  `mold_name` varchar(50) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `availability_date` datetime DEFAULT NULL,
  PRIMARY KEY (`mold_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mold`
--

INSERT INTO `mold` (`mold_id`, `mold_name`, `is_available`, `availability_date`) VALUES
(13, 'M13', 1, NULL),
(12, 'M12', 1, NULL),
(11, 'M11', 1, NULL),
(10, 'M10', 0, '2023-06-16 12:45:33'),
(9, 'M9', 0, '2023-06-16 17:05:33'),
(8, 'M8', 1, NULL),
(7, 'M7', 0, '2023-06-28 17:25:33'),
(6, 'M6', 0, '2023-06-25 13:25:33'),
(5, 'M5', 0, '2023-06-14 08:45:33'),
(4, 'M4', 0, '2023-06-26 14:05:33'),
(3, 'M3', 0, '2023-06-15 21:25:33'),
(2, 'M2', 0, '2023-06-26 23:45:33'),
(1, 'M1', 0, '2023-06-17 09:43:49');

-- --------------------------------------------------------

--
-- Table structure for table `mold_press`
--

DROP TABLE IF EXISTS `mold_press`;
CREATE TABLE IF NOT EXISTS `mold_press` (
  `mold_id` int NOT NULL,
  `press_id` int NOT NULL,
  PRIMARY KEY (`mold_id`,`press_id`),
  KEY `press_id` (`press_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mold_press`
--

INSERT INTO `mold_press` (`mold_id`, `press_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(4, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(5, 11),
(5, 12),
(5, 13),
(6, 7),
(6, 8),
(6, 9),
(6, 10),
(6, 11),
(6, 12),
(6, 13),
(7, 7),
(7, 8),
(7, 9),
(7, 10),
(7, 11),
(7, 12),
(7, 13),
(8, 7),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 12),
(8, 13),
(9, 7),
(9, 8),
(9, 9),
(9, 10),
(9, 11),
(9, 12),
(9, 13),
(10, 7),
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(10, 13),
(11, 7),
(11, 8),
(11, 9),
(11, 10),
(11, 11),
(11, 12),
(11, 13),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(13, 7),
(13, 8),
(13, 9),
(13, 10),
(13, 11),
(13, 12),
(13, 13);

-- --------------------------------------------------------

--
-- Table structure for table `press`
--

DROP TABLE IF EXISTS `press`;
CREATE TABLE IF NOT EXISTS `press` (
  `press_id` int NOT NULL AUTO_INCREMENT,
  `press_name` varchar(50) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `availability_date` datetime DEFAULT NULL,
  PRIMARY KEY (`press_id`)
) ENGINE=MyISAM AUTO_INCREMENT=276 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `press`
--

INSERT INTO `press` (`press_id`, `press_name`, `is_available`, `availability_date`) VALUES
(275, NULL, 1, NULL),
(274, NULL, 1, NULL),
(273, NULL, 1, NULL),
(272, NULL, 1, NULL),
(271, NULL, 1, NULL),
(270, NULL, 1, NULL),
(269, NULL, 1, NULL),
(268, NULL, 1, NULL),
(267, NULL, 1, NULL),
(266, NULL, 1, NULL),
(265, NULL, 1, NULL),
(264, NULL, 1, NULL),
(263, NULL, 1, NULL),
(262, NULL, 1, NULL),
(261, NULL, 1, NULL),
(260, NULL, 1, NULL),
(259, NULL, 1, NULL),
(258, NULL, 1, NULL),
(257, NULL, 1, NULL),
(256, NULL, 1, NULL),
(255, NULL, 1, NULL),
(254, NULL, 1, NULL),
(253, NULL, 1, NULL),
(252, NULL, 1, NULL),
(251, NULL, 1, NULL),
(250, NULL, 1, NULL),
(249, NULL, 1, NULL),
(248, NULL, 1, NULL),
(247, NULL, 1, NULL),
(246, NULL, 1, NULL),
(245, NULL, 1, NULL),
(244, NULL, 1, NULL),
(243, NULL, 1, NULL),
(242, NULL, 1, NULL),
(241, NULL, 1, NULL),
(240, NULL, 1, NULL),
(239, NULL, 1, NULL),
(238, NULL, 1, NULL),
(237, NULL, 1, NULL),
(236, NULL, 1, NULL),
(235, NULL, 1, NULL),
(234, NULL, 1, NULL),
(233, NULL, 1, NULL),
(232, NULL, 1, NULL),
(231, NULL, 1, NULL),
(230, NULL, 1, NULL),
(229, NULL, 1, NULL),
(228, NULL, 1, NULL),
(227, NULL, 1, NULL),
(226, NULL, 1, NULL),
(225, NULL, 1, NULL),
(224, NULL, 1, NULL),
(223, NULL, 1, NULL),
(222, NULL, 1, NULL),
(221, NULL, 1, NULL),
(220, NULL, 1, NULL),
(219, NULL, 1, NULL),
(218, NULL, 1, NULL),
(217, NULL, 1, NULL),
(216, NULL, 1, NULL),
(215, NULL, 1, NULL),
(214, NULL, 1, NULL),
(213, NULL, 1, NULL),
(212, NULL, 1, NULL),
(211, NULL, 1, NULL),
(210, NULL, 1, NULL),
(209, NULL, 1, NULL),
(208, NULL, 1, NULL),
(207, NULL, 1, NULL),
(206, NULL, 1, NULL),
(205, NULL, 1, NULL),
(204, NULL, 1, NULL),
(203, NULL, 1, NULL),
(202, NULL, 1, NULL),
(201, NULL, 1, NULL),
(200, NULL, 1, NULL),
(199, NULL, 1, NULL),
(198, NULL, 1, NULL),
(197, NULL, 1, NULL),
(196, NULL, 1, NULL),
(195, NULL, 1, NULL),
(194, NULL, 1, NULL),
(193, NULL, 1, NULL),
(192, NULL, 1, NULL),
(191, NULL, 1, NULL),
(190, NULL, 1, NULL),
(189, NULL, 1, NULL),
(188, NULL, 1, NULL),
(187, NULL, 1, NULL),
(186, NULL, 1, NULL),
(185, NULL, 1, NULL),
(184, NULL, 1, NULL),
(183, NULL, 1, NULL),
(182, NULL, 1, NULL),
(181, NULL, 1, NULL),
(180, NULL, 1, NULL),
(179, NULL, 1, NULL),
(178, NULL, 1, NULL),
(177, NULL, 1, NULL),
(176, NULL, 1, NULL),
(175, NULL, 1, NULL),
(174, NULL, 1, NULL),
(173, NULL, 1, NULL),
(172, NULL, 1, NULL),
(171, NULL, 1, NULL),
(170, NULL, 1, NULL),
(169, NULL, 1, NULL),
(168, NULL, 1, NULL),
(167, NULL, 1, NULL),
(166, NULL, 1, NULL),
(165, NULL, 1, NULL),
(164, NULL, 1, NULL),
(163, NULL, 1, NULL),
(162, NULL, 1, NULL),
(161, NULL, 1, NULL),
(160, NULL, 1, NULL),
(159, NULL, 1, NULL),
(158, NULL, 1, NULL),
(157, NULL, 1, NULL),
(156, NULL, 1, NULL),
(155, NULL, 1, NULL),
(154, NULL, 1, NULL),
(153, NULL, 1, NULL),
(152, NULL, 1, NULL),
(151, NULL, 1, NULL),
(150, NULL, 1, NULL),
(149, NULL, 1, NULL),
(148, NULL, 1, NULL),
(147, NULL, 1, NULL),
(146, NULL, 1, NULL),
(145, NULL, 1, NULL),
(144, NULL, 1, NULL),
(143, NULL, 1, NULL),
(142, NULL, 1, NULL),
(141, NULL, 1, NULL),
(140, NULL, 1, NULL),
(139, NULL, 1, NULL),
(138, NULL, 1, NULL),
(137, NULL, 1, NULL),
(136, NULL, 1, NULL),
(135, NULL, 1, NULL),
(134, NULL, 1, NULL),
(133, NULL, 1, NULL),
(132, NULL, 1, NULL),
(131, NULL, 1, NULL),
(130, NULL, 1, NULL),
(129, NULL, 1, NULL),
(128, NULL, 1, NULL),
(127, NULL, 1, NULL),
(126, NULL, 1, NULL),
(125, NULL, 1, NULL),
(124, NULL, 1, NULL),
(123, NULL, 1, NULL),
(122, NULL, 1, NULL),
(121, NULL, 1, NULL),
(120, NULL, 1, NULL),
(119, NULL, 1, NULL),
(118, NULL, 1, NULL),
(117, NULL, 1, NULL),
(116, NULL, 1, NULL),
(115, NULL, 1, NULL),
(114, NULL, 1, NULL),
(113, NULL, 1, NULL),
(112, NULL, 1, NULL),
(111, NULL, 1, NULL),
(110, NULL, 1, NULL),
(109, NULL, 1, NULL),
(108, NULL, 1, NULL),
(107, NULL, 1, NULL),
(106, NULL, 1, NULL),
(105, NULL, 1, NULL),
(104, NULL, 1, NULL),
(103, NULL, 1, NULL),
(102, NULL, 1, NULL),
(101, NULL, 1, NULL),
(100, NULL, 1, NULL),
(99, NULL, 1, NULL),
(98, NULL, 1, NULL),
(97, NULL, 1, NULL),
(96, NULL, 1, NULL),
(95, NULL, 1, NULL),
(94, NULL, 1, NULL),
(93, NULL, 1, NULL),
(92, NULL, 1, NULL),
(91, NULL, 1, NULL),
(90, NULL, 1, NULL),
(89, NULL, 1, NULL),
(88, NULL, 1, NULL),
(87, NULL, 1, NULL),
(86, NULL, 1, NULL),
(85, NULL, 1, NULL),
(84, NULL, 1, NULL),
(83, NULL, 1, NULL),
(82, NULL, 1, NULL),
(81, NULL, 1, NULL),
(80, NULL, 1, NULL),
(79, NULL, 1, NULL),
(78, NULL, 1, NULL),
(77, NULL, 1, NULL),
(76, NULL, 1, NULL),
(75, NULL, 1, NULL),
(74, NULL, 1, NULL),
(73, NULL, 1, NULL),
(72, NULL, 1, NULL),
(71, NULL, 1, NULL),
(70, NULL, 1, NULL),
(69, NULL, 1, NULL),
(68, NULL, 1, NULL),
(67, NULL, 1, NULL),
(66, NULL, 1, NULL),
(65, NULL, 1, NULL),
(64, NULL, 1, NULL),
(63, NULL, 1, NULL),
(62, NULL, 1, NULL),
(61, NULL, 1, NULL),
(60, NULL, 1, NULL),
(59, NULL, 1, NULL),
(58, NULL, 1, NULL),
(57, NULL, 1, NULL),
(56, NULL, 1, NULL),
(55, NULL, 1, NULL),
(54, NULL, 1, NULL),
(53, NULL, 1, NULL),
(52, NULL, 1, NULL),
(51, NULL, 1, NULL),
(50, NULL, 1, NULL),
(49, NULL, 1, NULL),
(48, NULL, 1, NULL),
(47, NULL, 1, NULL),
(13, 'A3', 0, '2023-06-28 17:25:33'),
(12, 'B6', 0, '2023-06-25 13:25:33'),
(11, 'B5', 0, '2023-06-14 08:45:33'),
(10, 'B4', 0, '2023-06-26 14:05:33'),
(9, 'B3', 0, '2023-06-15 21:25:33'),
(8, 'B2', 0, '2023-06-16 12:45:33'),
(7, 'B1', 0, '2023-06-16 17:05:33'),
(6, 'F6', 1, NULL),
(5, 'F5', 1, NULL),
(4, 'F4', 1, NULL),
(3, 'F3', 1, NULL),
(2, 'F2', 0, '2023-06-26 23:45:33'),
(1, 'F1', 0, '2023-06-17 09:43:49');

-- --------------------------------------------------------

--
-- Table structure for table `press_cavity`
--

DROP TABLE IF EXISTS `press_cavity`;
CREATE TABLE IF NOT EXISTS `press_cavity` (
  `press_id` int NOT NULL,
  `mold_id` int NOT NULL,
  `cavity_id` int NOT NULL,
  PRIMARY KEY (`press_id`,`mold_id`,`cavity_id`),
  KEY `mold_id` (`mold_id`),
  KEY `cavity_id` (`cavity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `press_cavity`
--

INSERT INTO `press_cavity` (`press_id`, `mold_id`, `cavity_id`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 12, 1),
(2, 1, 2),
(2, 2, 2),
(2, 12, 2),
(3, 1, 3),
(3, 2, 3),
(3, 12, 3),
(4, 1, 4),
(4, 2, 4),
(4, 12, 4),
(5, 1, 5),
(5, 2, 5),
(5, 12, 5),
(6, 1, 6),
(6, 2, 6),
(6, 12, 6),
(7, 3, 7),
(7, 4, 7),
(7, 5, 7),
(7, 6, 7),
(7, 7, 7),
(7, 8, 7),
(7, 9, 7),
(7, 10, 7),
(7, 11, 7),
(7, 13, 7),
(8, 3, 8),
(8, 4, 8),
(8, 5, 8),
(8, 6, 8),
(8, 7, 8),
(8, 8, 8),
(8, 9, 8),
(8, 10, 8),
(8, 11, 8),
(8, 13, 8),
(9, 3, 9),
(9, 4, 9),
(9, 5, 9),
(9, 6, 9),
(9, 7, 9),
(9, 8, 9),
(9, 9, 9),
(9, 10, 9),
(9, 11, 9),
(9, 13, 9),
(10, 3, 10),
(10, 4, 10),
(10, 5, 10),
(10, 6, 10),
(10, 7, 10),
(10, 8, 10),
(10, 9, 10),
(10, 10, 10),
(10, 11, 10),
(10, 13, 10),
(11, 3, 11),
(11, 4, 11),
(11, 5, 11),
(11, 6, 11),
(11, 7, 11),
(11, 8, 11),
(11, 9, 11),
(11, 10, 11),
(11, 11, 11),
(11, 13, 11),
(12, 3, 12),
(12, 4, 12),
(12, 5, 12),
(12, 6, 12),
(12, 7, 12),
(12, 8, 12),
(12, 9, 12),
(12, 10, 12),
(12, 11, 12),
(12, 13, 12),
(13, 3, 13),
(13, 4, 13),
(13, 5, 13),
(13, 6, 13),
(13, 7, 13),
(13, 8, 13),
(13, 9, 13),
(13, 10, 13),
(13, 11, 13),
(13, 13, 13);

-- --------------------------------------------------------

--
-- Table structure for table `production_plan`
--

DROP TABLE IF EXISTS `production_plan`;
CREATE TABLE IF NOT EXISTS `production_plan` (
  `production_plan_id` int NOT NULL AUTO_INCREMENT,
  `work_order_id` int DEFAULT NULL,
  `tire_id` int DEFAULT NULL,
  `press_id` int DEFAULT NULL,
  `press_name` varchar(50) DEFAULT NULL,
  `mold_id` int DEFAULT NULL,
  `mold_name` varchar(50) DEFAULT NULL,
  `cavity_id` int DEFAULT NULL,
  `cavity_name` varchar(50) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`production_plan_id`),
  KEY `work_order_id` (`work_order_id`),
  KEY `tire_id` (`tire_id`),
  KEY `press_id` (`press_id`),
  KEY `mold_id` (`mold_id`),
  KEY `cavity_id` (`cavity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `production_plan`
--

INSERT INTO `production_plan` (`production_plan_id`, `work_order_id`, `tire_id`, `press_id`, `press_name`, `mold_id`, `mold_name`, `cavity_id`, `cavity_name`, `start_date`, `end_date`) VALUES
(8, 2, 125042, 8, 'B2', 10, 'M10', 8, 'B1-CV2', '2023-06-12 04:45:33', '2023-06-16 12:45:33'),
(7, 2, 125041, 7, 'B1', 9, 'M9', 7, 'B1-CV1', '2023-06-12 04:45:33', '2023-06-16 17:05:33'),
(6, 1, 155011, 1, 'F1', 1, 'M1', 1, 'F1-CV1', '2023-06-12 04:43:49', '2023-06-17 09:43:49'),
(9, 2, 125013, 9, 'B3', 3, 'M3', 9, 'B1-CV3', '2023-06-12 04:45:33', '2023-06-15 21:25:33'),
(10, 2, 125014, 10, 'B4', 4, 'M4', 10, 'B1-CV4', '2023-06-12 04:45:33', '2023-06-26 14:05:33'),
(11, 2, 125011, 11, 'B5', 5, 'M5', 11, 'B2-CV1', '2023-06-12 04:45:33', '2023-06-14 08:45:33'),
(12, 2, 125012, 12, 'B6', 6, 'M6', 12, 'B2-CV2', '2023-06-12 04:45:33', '2023-06-25 13:25:33'),
(13, 2, 125003, 13, 'A3', 7, 'M7', 13, 'B2-CV3', '2023-06-12 04:45:33', '2023-06-28 17:25:33'),
(14, 2, 155051, 2, 'F2', 2, 'M2', 2, 'F2-CV1', '2023-06-12 04:45:33', '2023-06-26 23:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `tire`
--

DROP TABLE IF EXISTS `tire`;
CREATE TABLE IF NOT EXISTS `tire` (
  `tire_id` int NOT NULL AUTO_INCREMENT,
  `time_taken` int DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `availability_date` datetime DEFAULT NULL,
  PRIMARY KEY (`tire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=158012 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tire`
--

INSERT INTO `tire` (`tire_id`, `time_taken`, `is_available`, `availability_date`) VALUES
(120043, 280, 1, NULL),
(120044, 280, 1, NULL),
(120041, 260, 1, NULL),
(120042, 260, 1, NULL),
(153112, 300, 1, NULL),
(153001, 300, 1, NULL),
(152011, 300, 1, NULL),
(152001, 300, 1, NULL),
(125045, 280, 1, NULL),
(125046, 280, 1, NULL),
(125043, 280, 1, NULL),
(125044, 280, 1, NULL),
(125041, 260, 1, NULL),
(125042, 260, 1, NULL),
(125013, 280, 1, NULL),
(125014, 280, 1, NULL),
(125011, 260, 1, NULL),
(125012, 260, 1, NULL),
(125003, 280, 1, NULL),
(125004, 280, 1, NULL),
(125001, 260, 1, NULL),
(125002, 260, 1, NULL),
(155053, 320, 1, NULL),
(155054, 320, 1, NULL),
(155051, 300, 1, NULL),
(155052, 300, 1, NULL),
(155011, 300, 1, NULL),
(155012, 300, 1, NULL),
(155003, 320, 1, NULL),
(155004, 320, 1, NULL),
(155001, 300, 1, NULL),
(155002, 300, 1, NULL),
(158001, 300, 1, NULL),
(158011, 300, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tire_mold`
--

DROP TABLE IF EXISTS `tire_mold`;
CREATE TABLE IF NOT EXISTS `tire_mold` (
  `tire_id` int NOT NULL,
  `mold_id` int NOT NULL,
  PRIMARY KEY (`tire_id`,`mold_id`),
  KEY `mold_id` (`mold_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tire_mold`
--

INSERT INTO `tire_mold` (`tire_id`, `mold_id`) VALUES
(120041, 13),
(120042, 13),
(120043, 13),
(120044, 13),
(125001, 3),
(125001, 4),
(125001, 5),
(125001, 6),
(125001, 7),
(125001, 8),
(125002, 3),
(125002, 4),
(125002, 5),
(125002, 6),
(125003, 3),
(125003, 4),
(125003, 5),
(125003, 6),
(125003, 7),
(125003, 8),
(125004, 3),
(125004, 4),
(125004, 5),
(125004, 6),
(125004, 7),
(125004, 8),
(125011, 3),
(125011, 4),
(125011, 5),
(125011, 6),
(125011, 7),
(125011, 8),
(125012, 3),
(125012, 4),
(125012, 5),
(125012, 6),
(125012, 7),
(125012, 8),
(125013, 3),
(125013, 4),
(125013, 5),
(125013, 6),
(125013, 7),
(125013, 8),
(125014, 3),
(125014, 4),
(125014, 5),
(125014, 6),
(125014, 7),
(125014, 8),
(125041, 9),
(125041, 10),
(125041, 11),
(125042, 9),
(125042, 10),
(125042, 11),
(125043, 9),
(125043, 10),
(125043, 11),
(125044, 9),
(125044, 10),
(125044, 11),
(125045, 9),
(125045, 10),
(125045, 11),
(125046, 9),
(125046, 10),
(125046, 11),
(152001, 12),
(152011, 12),
(153001, 12),
(153112, 12),
(155001, 1),
(155002, 1),
(155003, 1),
(155004, 1),
(155011, 1),
(155012, 1),
(155051, 2),
(155052, 2),
(155053, 2),
(155054, 2),
(158001, 1),
(158011, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_order`
--

DROP TABLE IF EXISTS `work_order`;
CREATE TABLE IF NOT EXISTS `work_order` (
  `work_order_id` int NOT NULL AUTO_INCREMENT,
  `work_order_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`work_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `work_order`
--

INSERT INTO `work_order` (`work_order_id`, `work_order_name`) VALUES
(3, 'USA'),
(2, 'DUBAI'),
(1, 'AUS');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_tire`
--

DROP TABLE IF EXISTS `work_order_tire`;
CREATE TABLE IF NOT EXISTS `work_order_tire` (
  `work_order_tire_id` int NOT NULL AUTO_INCREMENT,
  `work_order_id` int DEFAULT NULL,
  `tire_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`work_order_tire_id`),
  KEY `work_order_id` (`work_order_id`),
  KEY `tire_id` (`tire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `work_order_tire`
--

INSERT INTO `work_order_tire` (`work_order_tire_id`, `work_order_id`, `tire_id`, `quantity`) VALUES
(26, 3, 120044, 85),
(25, 3, 120041, 25),
(24, 3, 120042, 27),
(23, 3, 153112, 23),
(22, 3, 153001, 21),
(21, 3, 152011, 29),
(20, 3, 125044, 24),
(19, 2, 125041, 25),
(18, 2, 125042, 24),
(17, 2, 125013, 19),
(16, 2, 125014, 74),
(15, 2, 125011, 12),
(14, 2, 125012, 74),
(13, 2, 125003, 85),
(12, 2, 125004, 14),
(11, 2, 155051, 71),
(10, 2, 155052, 56),
(9, 1, 155011, 25),
(8, 1, 155012, 74),
(7, 1, 155003, 89),
(6, 1, 155004, 45),
(5, 1, 155001, 78),
(4, 1, 155002, 98),
(3, 1, 158001, 80),
(2, 1, 158011, 50),
(1, 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
