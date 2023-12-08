-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 08:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportstock`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowing`
--

CREATE TABLE `borrowing` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `date_returned` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowing`
--

INSERT INTO `borrowing` (`id`, `equipment_id`, `user_id`, `quantity`, `status`, `borrow_date`, `return_date`, `date_returned`) VALUES
(1, 8, '20-10134', 2, 'Returned', '2023-10-27', '2023-10-31', '2023-12-04'),
(2, 1, '21-10109', 2, 'Returned', '2023-10-27', '2023-10-31', '2023-11-17'),
(3, 1, '21-10109', 2, 'Returned', '2023-11-08', '2023-11-11', '2023-12-05'),
(4, 8, '21-10109', 2, 'Returned', '2023-11-08', '2023-11-09', '2023-12-05'),
(5, 9, '21-10109', 1, 'Returned', '2023-11-08', '2023-11-10', '2023-12-05'),
(6, 1, '20-10134', 1, 'Returned', '2023-11-08', '2023-11-11', '2023-12-04'),
(7, 1, '20-10134', 1, 'Returned', '2023-11-08', '2023-11-11', '2023-12-04'),
(8, 8, '20-10134', 1, 'Returned', '2023-11-08', '2023-11-11', '2023-12-04'),
(9, 9, '20-10134', 1, 'Returned', '2023-11-08', '2023-11-11', '2023-11-10'),
(10, 1, '20-10134', 1, 'Returned', '2023-11-08', '2023-11-10', '2023-11-10'),
(11, 1, '21-10109', 1, 'Returned', '2023-11-09', '2023-11-16', '2023-12-05'),
(12, 1, '21-10109', 1, 'Returned', '2023-11-09', '2023-11-11', '2023-12-05'),
(13, 10, '21-10109', 5, 'Returned', '2023-11-16', '2023-11-30', '2023-12-05'),
(14, 9, '21-10167', 1, 'Returned', '2023-11-17', '2023-11-18', '2023-11-17'),
(15, 1, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(16, 1, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(17, 1, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(18, 9, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(19, 8, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(20, 1, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(21, 10, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(22, 27, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(23, 27, '21-10167', 1, 'Returned', '2023-11-24', '2023-11-25', '2023-11-24'),
(24, 1, '20-10134', 2, 'Returned', '2023-12-01', '2023-12-02', '2023-12-01'),
(25, 9, '20-10134', 1, 'Returned', '2023-12-04', '2023-12-05', '2023-12-04'),
(26, 8, '20-10134', 1, 'Returned', '2023-12-04', '2023-12-04', '2023-12-05'),
(27, 1, '20-10134', 1, 'Borrowing', '2023-12-05', '2023-12-06', NULL),
(28, 1, '20-10134', 1, 'Returned', '2023-12-07', '2023-12-11', '2023-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `eid` int(11) NOT NULL,
  `ename` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `quality` varchar(255) DEFAULT NULL,
  `last_maintenance_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`eid`, `ename`, `category`, `quantity`, `quality`, `last_maintenance_date`) VALUES
(1, 'TT-Rackets', 'Table Tennis', 11, 'Good', '2023-10-19'),
(8, 'B-Rackets', 'Badminton', 7, 'Good', '2023-10-31'),
(9, 'B-Ball', 'Basketball', 3, 'Good', '2023-11-15'),
(10, 'V-Ball', 'Volleyball', 8, 'Good', '2023-11-25'),
(27, 'B-Bat', 'Baseball', 10, 'Good', '2023-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `user_id`, `activity`, `timestamp`) VALUES
(82, 0, 'Logged In', '2023-11-17 08:55:56'),
(83, 0, 'Logged In', '2023-11-17 08:56:07'),
(84, 16, 'Logged In', '2023-11-17 08:56:12'),
(85, 16, 'Borrowed Equipment', '2023-11-17 08:55:49'),
(86, 16, 'Returned Equipment', '2023-11-17 08:54:30'),
(87, 16, 'Logged Out', '2023-11-17 08:58:54'),
(88, 0, 'Logged In', '2023-11-17 09:05:06'),
(89, 0, 'Deleted Equipment', '2023-11-17 09:46:42'),
(90, 0, 'Added Equipment', '2023-11-17 09:47:28'),
(91, 0, 'Deleted Equipment', '2023-11-17 09:47:43'),
(92, 0, 'Created User Account', '2023-11-17 09:49:07'),
(93, 0, 'Logged In', '2023-11-17 09:57:28'),
(94, 0, 'Logged In', '2023-11-22 14:06:46'),
(95, 0, 'Logged In', '2023-11-22 14:29:43'),
(96, 0, 'Logged In', '2023-11-23 10:48:25'),
(97, 0, 'Logged In', '2023-11-23 11:05:36'),
(98, 0, 'Created User Account', '2023-11-23 11:05:50'),
(99, 0, 'Deleted User', '2023-11-23 11:06:01'),
(100, 0, 'Deleted User', '2023-11-23 11:06:14'),
(101, 0, 'Deleted User', '2023-11-23 11:06:19'),
(102, 0, 'Deleted User', '2023-11-23 11:06:32'),
(103, 0, 'Deleted User', '2023-11-23 11:06:39'),
(104, 0, 'Logged In', '2023-11-23 13:08:47'),
(105, 0, 'Logged In', '2023-11-23 13:08:47'),
(106, 0, 'Logged In', '2023-11-24 03:19:52'),
(107, 16, 'Logged In', '2023-11-24 04:14:13'),
(108, 16, 'Borrowed Equipment', '2023-11-24 04:14:24'),
(109, 16, 'Borrowed Equipment', '2023-11-24 04:14:29'),
(110, 16, 'Borrowed Equipment', '2023-11-24 04:14:35'),
(111, 16, 'Borrowed Equipment', '2023-11-24 04:14:42'),
(112, 16, 'Borrowed Equipment', '2023-11-24 04:14:47'),
(113, 16, 'Borrowed Equipment', '2023-11-24 04:14:52'),
(114, 16, 'Borrowed Equipment', '2023-11-24 04:15:02'),
(115, 16, 'Borrowed Equipment', '2023-11-24 04:15:08'),
(116, 16, 'Borrowed Equipment', '2023-11-24 04:15:15'),
(117, 16, 'Returned Equipment', '2023-11-24 04:15:26'),
(118, 16, 'Returned Equipment', '2023-11-24 04:15:29'),
(119, 16, 'Returned Equipment', '2023-11-24 04:15:32'),
(120, 16, 'Returned Equipment', '2023-11-24 04:15:36'),
(121, 16, 'Returned Equipment', '2023-11-24 04:15:39'),
(122, 16, 'Returned Equipment', '2023-11-24 04:15:45'),
(123, 16, 'Returned Equipment', '2023-11-24 04:15:49'),
(124, 16, 'Returned Equipment', '2023-11-24 04:15:56'),
(125, 16, 'Returned Equipment', '2023-11-24 04:15:59'),
(126, 16, 'Logged Out', '2023-11-24 04:16:23'),
(127, 0, 'Logged In', '2023-11-24 04:16:30'),
(128, 0, 'Logged In', '2023-11-24 05:44:28'),
(129, 0, 'Logged In', '2023-11-24 06:07:43'),
(130, 1, 'Logged In', '2023-11-24 06:08:23'),
(131, 1, 'Logged Out', '2023-11-24 06:08:46'),
(132, 0, 'Logged In', '2023-11-24 06:08:54'),
(133, 1, 'Logged In', '2023-11-24 06:18:38'),
(134, 1, 'Logged Out', '2023-11-24 06:19:34'),
(135, 0, 'Logged In', '2023-11-24 06:19:41'),
(136, 0, 'Logged In', '2023-11-24 06:21:26'),
(137, 2, 'Logged In', '2023-11-24 06:32:14'),
(138, 2, 'Logged Out', '2023-11-24 06:45:24'),
(139, 0, 'Logged In', '2023-11-26 09:12:04'),
(140, 0, 'Logged In', '2023-11-26 09:28:23'),
(141, 0, 'Logged In', '2023-11-26 09:38:52'),
(142, 0, 'Logged In', '2023-11-26 09:45:11'),
(143, 0, 'Logged In', '2023-11-26 10:02:11'),
(144, 0, 'Logged In', '2023-11-26 11:43:58'),
(145, 0, 'Logged In', '2023-11-26 12:22:37'),
(146, 0, 'Logged In', '2023-11-26 12:25:32'),
(147, 0, 'Logged In', '2023-11-26 12:51:11'),
(148, 0, 'Logged In', '2023-11-27 07:01:39'),
(149, 0, 'Logged In', '2023-11-27 07:04:48'),
(150, 0, 'Logged In', '2023-11-30 02:32:23'),
(151, 1, 'Logged In', '2023-11-30 02:32:55'),
(152, 1, 'Logged In', '2023-11-30 08:07:57'),
(153, 1, 'Logged Out', '2023-11-30 08:08:02'),
(154, 0, 'Logged In', '2023-11-30 08:08:12'),
(155, 0, 'Logged In', '2023-11-30 08:24:05'),
(156, 1, 'Logged In', '2023-12-01 04:24:55'),
(157, 1, 'Logged Out', '2023-12-01 05:08:18'),
(158, 1, 'Logged In', '2023-12-01 05:10:07'),
(159, 0, 'Logged In', '2023-12-01 05:10:56'),
(160, 1, 'Logged In', '2023-12-01 06:07:14'),
(161, 1, 'Logged Out', '2023-12-01 06:12:46'),
(162, 1, 'Logged In', '2023-12-01 06:15:48'),
(163, 0, 'Logged In', '2023-12-01 06:44:39'),
(164, 1, 'Logged Out', '2023-12-01 06:44:57'),
(165, 0, 'Logged In', '2023-12-01 06:45:20'),
(166, 0, 'Logged In', '2023-12-01 06:53:20'),
(167, 1, 'Logged In', '2023-12-01 06:53:45'),
(168, 0, 'Deleted User', '2023-12-01 07:42:48'),
(169, 1, 'Logged Out', '2023-12-01 07:45:39'),
(170, 1, 'Logged In', '2023-12-01 07:46:38'),
(171, 1, 'Logged Out', '2023-12-01 07:46:41'),
(172, 1, 'Logged In', '2023-12-01 07:46:43'),
(173, 1, 'Logged Out', '2023-12-01 07:47:49'),
(174, 1, 'Logged In', '2023-12-01 07:48:04'),
(175, 1, 'Borrowed Equipment', '2023-12-01 07:48:47'),
(176, 1, 'Returned Equipment', '2023-12-01 07:49:22'),
(177, 1, 'Logged Out', '2023-12-01 07:49:38'),
(178, 0, 'Logged In', '2023-12-01 08:04:11'),
(179, 0, 'Logged In', '2023-12-02 09:25:32'),
(180, 0, 'Logged In', '2023-12-02 09:25:32'),
(181, 0, 'Logged In', '2023-12-02 10:24:14'),
(182, 0, 'Logged In', '2023-12-02 10:33:47'),
(183, 0, 'Logged In', '2023-12-02 10:33:47'),
(184, 0, 'Logged In', '2023-12-02 10:49:42'),
(185, 0, 'Logged In', '2023-12-02 10:49:42'),
(186, 0, 'Logged In', '2023-12-03 06:42:47'),
(187, 0, 'Logged In', '2023-12-03 06:42:47'),
(188, 0, 'Logged In', '2023-12-03 07:06:35'),
(189, 0, 'Logged In', '2023-12-03 07:06:35'),
(190, 0, 'Logged In', '2023-12-03 08:03:16'),
(191, 0, 'Logged In', '2023-12-03 08:03:16'),
(192, 0, 'Logged In', '2023-12-03 12:41:17'),
(193, 0, 'Logged In', '2023-12-03 12:41:17'),
(194, 0, 'Logged In', '2023-12-03 13:08:33'),
(195, 0, 'Logged In', '2023-12-03 13:08:33'),
(196, 0, 'Logged In', '2023-12-03 13:36:56'),
(197, 0, 'Logged In', '2023-12-03 13:36:56'),
(198, 1, 'Logged In', '2023-12-03 13:53:28'),
(199, 1, 'Logged In', '2023-12-03 13:53:28'),
(200, 0, 'Logged In', '2023-12-04 02:07:22'),
(201, 0, 'Logged In', '2023-12-04 02:07:22'),
(202, 1, 'Logged In', '2023-12-04 02:10:02'),
(203, 1, 'Logged In', '2023-12-04 02:10:02'),
(204, 1, 'Logged In', '2023-12-04 02:17:16'),
(205, 1, 'Logged In', '2023-12-04 02:17:16'),
(206, 1, 'Logged Out', '2023-12-04 02:17:27'),
(207, 0, 'Logged In', '2023-12-04 02:17:34'),
(208, 0, 'Logged In', '2023-12-04 02:17:34'),
(209, 1, 'Logged Out', '2023-12-04 02:20:10'),
(210, 0, 'Logged In', '2023-12-04 02:24:18'),
(211, 0, 'Logged In', '2023-12-04 02:24:18'),
(212, 1, 'Logged In', '2023-12-04 02:24:32'),
(213, 1, 'Logged In', '2023-12-04 02:24:32'),
(214, 1, 'Logged Out', '2023-12-04 02:24:42'),
(215, 0, 'Logged In', '2023-12-04 02:25:49'),
(216, 0, 'Logged In', '2023-12-04 02:25:49'),
(217, 1, 'Logged In', '2023-12-04 02:26:08'),
(218, 1, 'Logged In', '2023-12-04 02:26:08'),
(219, 1, 'Logged Out', '2023-12-04 03:15:17'),
(220, 0, 'Logged In', '2023-12-04 14:20:26'),
(221, 0, 'Logged In', '2023-12-04 14:20:26'),
(222, 1, 'Logged In', '2023-12-04 14:21:37'),
(223, 1, 'Logged In', '2023-12-04 14:21:37'),
(224, 1, 'Returned Equipment', '2023-12-04 14:21:56'),
(225, 1, 'Returned Equipment', '2023-12-04 14:22:06'),
(226, 1, 'Returned Equipment', '2023-12-04 14:22:14'),
(227, 1, 'Returned Equipment', '2023-12-04 14:22:28'),
(228, 0, 'Logged In', '2023-12-04 14:28:20'),
(229, 0, 'Logged In', '2023-12-04 14:28:20'),
(230, 1, 'Logged Out', '2023-12-04 14:36:46'),
(231, 1, 'Logged In', '2023-12-04 14:37:05'),
(232, 1, 'Logged In', '2023-12-04 14:37:05'),
(233, 1, 'Borrowed Equipment', '2023-12-04 15:42:26'),
(234, 1, 'Returned Equipment', '2023-12-04 15:42:44'),
(235, 1, 'Borrowed Equipment', '2023-12-04 15:46:32'),
(236, 1, 'Logged In', '2023-12-04 16:05:44'),
(237, 1, 'Logged In', '2023-12-04 16:05:44'),
(238, 1, 'Logged Out', '2023-12-04 16:19:14'),
(239, 1, 'Logged In', '2023-12-05 00:57:09'),
(240, 1, 'Logged In', '2023-12-05 00:57:09'),
(241, 1, 'Logged Out', '2023-12-05 01:27:47'),
(242, 0, 'Logged In', '2023-12-05 01:27:54'),
(243, 0, 'Logged In', '2023-12-05 01:27:54'),
(244, 0, 'Logged In', '2023-12-05 01:54:12'),
(245, 0, 'Logged In', '2023-12-05 01:54:13'),
(246, 0, 'Logged In', '2023-12-05 03:13:17'),
(247, 0, 'Logged In', '2023-12-05 03:13:17'),
(248, 1, 'Logged In', '2023-12-05 05:01:44'),
(249, 1, 'Logged In', '2023-12-05 05:01:44'),
(250, 1, 'Logged Out', '2023-12-05 05:28:03'),
(251, 0, 'Logged In', '2023-12-05 05:28:12'),
(252, 0, 'Logged In', '2023-12-05 05:28:12'),
(253, 0, 'Logged In', '2023-12-05 05:30:39'),
(254, 0, 'Logged In', '2023-12-05 05:30:39'),
(255, 1, 'Logged In', '2023-12-05 05:35:13'),
(256, 1, 'Logged In', '2023-12-05 05:35:13'),
(257, 0, 'Logged In', '2023-12-05 05:40:52'),
(258, 0, 'Logged In', '2023-12-05 05:40:52'),
(259, 0, 'Logged In', '2023-12-05 05:49:33'),
(260, 0, 'Logged In', '2023-12-05 05:49:34'),
(261, 0, 'Logged In', '2023-12-05 05:49:34'),
(262, 0, 'Logged In', '2023-12-05 05:49:41'),
(263, 0, 'Logged In', '2023-12-05 05:53:23'),
(264, 0, 'Logged In', '2023-12-05 05:53:23'),
(265, 0, 'Logged In', '2023-12-05 06:00:07'),
(266, 0, 'Logged In', '2023-12-05 06:00:07'),
(267, 0, 'Logged In', '2023-12-05 06:23:34'),
(268, 0, 'Logged In', '2023-12-05 06:23:34'),
(269, 0, 'Logged In', '2023-12-05 06:29:31'),
(270, 0, 'Logged In', '2023-12-05 06:29:31'),
(271, 1, 'Logged In', '2023-12-05 06:36:40'),
(272, 1, 'Logged In', '2023-12-05 06:36:40'),
(273, 1, 'Logged Out', '2023-12-05 06:38:26'),
(274, 1, 'Logged In', '2023-12-05 06:39:53'),
(275, 1, 'Logged In', '2023-12-05 06:39:53'),
(276, 1, 'Logged Out', '2023-12-05 06:46:52'),
(277, 0, 'Logged In', '2023-12-05 06:46:58'),
(278, 0, 'Logged In', '2023-12-05 06:46:58'),
(279, 1, 'Logged In', '2023-12-05 06:57:58'),
(280, 1, 'Logged In', '2023-12-05 06:57:58'),
(281, 1, 'Logged Out', '2023-12-05 06:58:18'),
(282, 0, 'Logged In', '2023-12-05 07:13:23'),
(283, 0, 'Logged In', '2023-12-05 07:13:23'),
(284, 1, 'Logged In', '2023-12-05 07:16:20'),
(285, 1, 'Logged In', '2023-12-05 07:16:20'),
(286, 1, 'Logged Out', '2023-12-05 07:20:15'),
(287, 0, 'Logged In', '2023-12-05 07:20:34'),
(288, 0, 'Logged In', '2023-12-05 07:20:34'),
(289, 0, 'Updated User', '2023-12-05 07:31:58'),
(290, 0, 'Updated User', '2023-12-05 07:38:00'),
(291, 0, 'Updated User', '2023-12-05 07:38:01'),
(292, 0, 'Updated User', '2023-12-05 07:38:02'),
(293, 0, 'Updated User', '2023-12-05 07:38:03'),
(294, 0, 'Updated User', '2023-12-05 07:38:03'),
(295, 0, 'Updated User', '2023-12-05 07:40:34'),
(296, 0, 'Updated User', '2023-12-05 07:40:35'),
(297, 0, 'Updated User', '2023-12-05 07:40:35'),
(298, 0, 'Updated User', '2023-12-05 07:40:35'),
(299, 0, 'Updated User', '2023-12-05 07:40:36'),
(300, 0, 'Updated User', '2023-12-05 07:40:36'),
(301, 0, 'Updated User', '2023-12-05 07:40:36'),
(302, 0, 'Updated User', '2023-12-05 07:40:36'),
(303, 0, 'Updated User', '2023-12-05 07:40:36'),
(304, 0, 'Updated User', '2023-12-05 07:40:37'),
(305, 0, 'Updated User', '2023-12-05 07:40:37'),
(306, 0, 'Updated User', '2023-12-05 07:40:42'),
(307, 0, 'Updated User', '2023-12-05 07:40:42'),
(308, 0, 'Updated User', '2023-12-05 07:40:42'),
(309, 0, 'Updated User', '2023-12-05 07:44:15'),
(310, 0, 'Updated User', '2023-12-05 07:44:15'),
(311, 0, 'Updated User', '2023-12-05 07:44:16'),
(312, 0, 'Updated User', '2023-12-05 07:44:17'),
(313, 0, 'Updated User', '2023-12-05 07:45:39'),
(314, 0, 'Updated User', '2023-12-05 07:45:40'),
(315, 0, 'Updated User', '2023-12-05 07:45:40'),
(316, 0, 'Updated User', '2023-12-05 07:45:40'),
(317, 0, 'Updated User', '2023-12-05 07:49:32'),
(318, 0, 'Updated User', '2023-12-05 07:49:33'),
(319, 0, 'Updated User', '2023-12-05 07:49:34'),
(320, 0, 'Updated User', '2023-12-05 07:49:34'),
(321, 0, 'Updated User', '2023-12-05 07:49:34'),
(322, 0, 'Logged In', '2023-12-05 07:55:32'),
(323, 0, 'Logged In', '2023-12-05 07:55:32'),
(324, 0, 'Updated User', '2023-12-05 07:55:58'),
(325, 0, 'Updated User', '2023-12-05 07:55:58'),
(326, 0, 'Updated User', '2023-12-05 07:55:58'),
(327, 0, 'Updated User', '2023-12-05 07:56:17'),
(328, 0, 'Updated User', '2023-12-05 07:56:17'),
(329, 0, 'Updated User', '2023-12-05 07:56:18'),
(330, 0, 'Updated User', '2023-12-05 07:56:18'),
(331, 0, 'Updated User', '2023-12-05 07:56:18'),
(332, 0, 'Updated User', '2023-12-05 07:56:18'),
(333, 0, 'Updated User', '2023-12-05 07:59:26'),
(334, 0, 'Updated User', '2023-12-05 07:59:35'),
(335, 0, 'Logged In', '2023-12-05 07:59:48'),
(336, 0, 'Logged In', '2023-12-05 07:59:48'),
(337, 0, 'Updated User', '2023-12-05 08:01:33'),
(338, 0, 'Updated User', '2023-12-05 08:02:57'),
(339, 0, 'Updated User', '2023-12-05 08:03:06'),
(340, 0, 'Updated User', '2023-12-05 08:05:24'),
(341, 0, 'Logged In', '2023-12-05 08:08:08'),
(342, 0, 'Logged In', '2023-12-05 08:08:08'),
(343, 0, 'Updated User', '2023-12-05 08:09:06'),
(344, 0, 'Updated User', '2023-12-05 08:09:07'),
(345, 0, 'Updated User', '2023-12-05 08:09:08'),
(346, 0, 'Updated User', '2023-12-05 08:09:08'),
(347, 0, 'Updated User', '2023-12-05 08:09:12'),
(348, 0, 'Updated User', '2023-12-05 08:09:12'),
(349, 0, 'Updated User', '2023-12-05 08:09:13'),
(350, 0, 'Updated User', '2023-12-05 08:09:13'),
(351, 0, 'Updated User', '2023-12-05 08:09:13'),
(352, 0, 'Updated User', '2023-12-05 08:09:13'),
(353, 0, 'Updated User', '2023-12-05 08:10:51'),
(354, 0, 'Updated User', '2023-12-05 08:10:52'),
(355, 0, 'Updated User', '2023-12-05 08:10:52'),
(356, 0, 'Updated User', '2023-12-05 08:10:52'),
(357, 0, 'Updated User', '2023-12-05 08:10:53'),
(358, 0, 'Updated User', '2023-12-05 08:10:53'),
(359, 0, 'Updated User', '2023-12-05 08:10:53'),
(360, 0, 'Updated User', '2023-12-05 08:10:53'),
(361, 0, 'Updated User', '2023-12-05 08:10:53'),
(362, 0, 'Updated User', '2023-12-05 08:10:55'),
(363, 0, 'Updated User', '2023-12-05 08:10:55'),
(364, 0, 'Updated User', '2023-12-05 08:12:01'),
(365, 0, 'Updated User', '2023-12-05 08:12:02'),
(366, 0, 'Updated User', '2023-12-05 08:12:02'),
(367, 0, 'Updated User', '2023-12-05 08:12:02'),
(368, 0, 'Updated User', '2023-12-05 08:12:22'),
(369, 1, 'Logged In', '2023-12-05 08:17:03'),
(370, 1, 'Logged In', '2023-12-05 08:17:03'),
(371, 1, 'Logged Out', '2023-12-05 08:40:36'),
(372, 1, 'Logged In', '2023-12-05 08:41:00'),
(373, 1, 'Logged In', '2023-12-05 08:41:00'),
(374, 1, 'Logged Out', '2023-12-05 08:44:57'),
(375, 1, 'Logged In', '2023-12-05 08:45:22'),
(376, 1, 'Logged In', '2023-12-05 08:45:23'),
(377, 1, 'Logged Out', '2023-12-05 08:49:55'),
(378, 1, 'Logged In', '2023-12-05 08:50:03'),
(379, 1, 'Logged In', '2023-12-05 08:50:03'),
(380, 1, 'Logged Out', '2023-12-05 08:50:14'),
(381, 1, 'Logged In', '2023-12-05 08:54:34'),
(382, 1, 'Logged In', '2023-12-05 08:54:34'),
(383, 1, 'Logged Out', '2023-12-05 08:58:25'),
(384, 1, 'Logged In', '2023-12-05 08:58:57'),
(385, 1, 'Logged In', '2023-12-05 08:58:57'),
(386, 1, 'Logged Out', '2023-12-05 09:06:24'),
(387, 0, 'Logged In', '2023-12-05 09:06:30'),
(388, 0, 'Logged In', '2023-12-05 09:06:30'),
(389, 0, 'Logged In', '2023-12-05 13:22:23'),
(390, 0, 'Logged In', '2023-12-05 13:22:24'),
(391, 0, 'Logged In', '2023-12-05 13:35:40'),
(392, 0, 'Logged In', '2023-12-05 13:35:40'),
(393, 1, 'Logged In', '2023-12-05 13:35:58'),
(394, 1, 'Logged In', '2023-12-05 13:35:58'),
(395, 0, 'Updated User', '2023-12-05 14:14:27'),
(396, 0, 'Updated User', '2023-12-05 14:14:45'),
(397, 0, 'Updated User', '2023-12-05 14:17:29'),
(398, 0, 'Updated User', '2023-12-05 14:22:05'),
(399, 0, 'Updated User', '2023-12-05 14:22:09'),
(400, 0, 'Updated User', '2023-12-05 14:25:27'),
(401, 0, 'Updated User', '2023-12-05 14:26:00'),
(402, 0, 'Updated User', '2023-12-05 14:29:15'),
(403, 0, 'Logged In', '2023-12-05 14:29:59'),
(404, 0, 'Logged In', '2023-12-05 14:29:59'),
(405, 0, 'Updated User', '2023-12-05 14:30:20'),
(406, 0, 'Updated User', '2023-12-05 14:33:43'),
(407, 0, 'Updated User', '2023-12-05 14:34:16'),
(408, 1, 'Logged Out', '2023-12-05 14:46:46'),
(409, 1, 'Logged In', '2023-12-05 14:47:10'),
(410, 1, 'Logged In', '2023-12-05 14:47:10'),
(411, 1, 'Borrowed Equipment', '2023-12-05 14:59:22'),
(412, 1, 'Logged Out', '2023-12-05 15:03:43'),
(413, 1, 'Logged In', '2023-12-05 15:04:11'),
(414, 1, 'Logged In', '2023-12-05 15:04:11'),
(415, 1, 'Returned Equipment', '2023-12-05 15:11:36'),
(416, 1, 'Logged Out', '2023-12-05 15:14:17'),
(417, 2, 'Logged In', '2023-12-05 15:17:00'),
(418, 2, 'Logged In', '2023-12-05 15:17:00'),
(419, 2, 'Returned Equipment', '2023-12-05 15:17:45'),
(420, 2, 'Returned Equipment', '2023-12-05 15:17:48'),
(421, 2, 'Returned Equipment', '2023-12-05 15:17:50'),
(422, 2, 'Returned Equipment', '2023-12-05 15:17:57'),
(423, 2, 'Returned Equipment', '2023-12-05 15:18:04'),
(424, 2, 'Returned Equipment', '2023-12-05 15:18:17'),
(425, 2, 'Logged Out', '2023-12-05 15:18:34'),
(426, 0, 'Logged In', '2023-12-05 15:18:46'),
(427, 0, 'Logged In', '2023-12-05 15:18:46'),
(428, 0, 'Logged In', '2023-12-06 03:55:20'),
(429, 0, 'Logged In', '2023-12-06 03:55:20'),
(430, 1, 'Logged In', '2023-12-06 04:36:16'),
(431, 1, 'Logged In', '2023-12-06 04:36:16'),
(432, 1, 'Logged Out', '2023-12-06 04:39:50'),
(433, 0, 'Logged In', '2023-12-06 04:42:27'),
(434, 0, 'Logged In', '2023-12-06 04:42:27'),
(435, 1, 'Logged In', '2023-12-06 05:03:14'),
(436, 1, 'Logged In', '2023-12-06 05:03:14'),
(437, 0, 'Logged In', '2023-12-06 05:15:41'),
(438, 0, 'Logged In', '2023-12-06 05:15:41'),
(439, 0, 'Logged In', '2023-12-06 06:13:46'),
(440, 0, 'Logged In', '2023-12-06 06:13:46'),
(441, 0, 'Logged In', '2023-12-06 06:21:18'),
(442, 0, 'Logged In', '2023-12-06 06:21:18'),
(443, 0, 'Logged In', '2023-12-06 12:46:21'),
(444, 0, 'Logged In', '2023-12-06 12:46:21'),
(445, 0, 'Logged In', '2023-12-06 23:37:15'),
(446, 0, 'Logged In', '2023-12-06 23:37:15'),
(447, 1, 'Logged In', '2023-12-06 23:40:34'),
(448, 1, 'Logged In', '2023-12-06 23:40:34'),
(449, 1, 'Logged Out', '2023-12-06 23:41:51'),
(450, 0, 'Logged In', '2023-12-07 04:53:39'),
(451, 0, 'Logged In', '2023-12-07 04:53:39'),
(452, 1, 'Logged In', '2023-12-07 04:55:17'),
(453, 1, 'Logged In', '2023-12-07 04:55:17'),
(454, 0, 'Logged In', '2023-12-07 05:25:54'),
(455, 0, 'Logged In', '2023-12-07 05:25:54'),
(456, 0, 'Logged In', '2023-12-07 05:54:58'),
(457, 0, 'Logged In', '2023-12-07 05:54:58'),
(458, 0, 'Created User Account', '2023-12-07 05:57:01'),
(459, 0, 'Added Equipment', '2023-12-07 05:58:38'),
(460, 1, 'Borrowed Equipment', '2023-12-07 05:59:34'),
(461, 1, 'Returned Equipment', '2023-12-07 06:00:05'),
(462, 0, 'Logged In', '2023-12-07 08:36:02'),
(463, 0, 'Logged In', '2023-12-07 08:36:02'),
(464, 0, 'Updated User', '2023-12-07 08:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `pending_registrations`
--

CREATE TABLE `pending_registrations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_return_request`
--

CREATE TABLE `pending_return_request` (
  `id` int(11) NOT NULL,
  `bid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_id`, `username`, `password`, `course`, `role`) VALUES
(0, 'Administrator', '', 'Administrator', 'admin123', NULL, 'admin'),
(1, 'Christian Jay C. Varquez', '20-10134', 'Chan-chan05', '12345', 'BSIT 3rd Year', 'user'),
(2, 'John Loyd Bonghanoy', '21-10109', 'John_Loyd', '12345', 'BSIT 3rd Year', 'user'),
(16, 'Percival Velos', '21-10167', 'Perci', '12345', 'BSIT 3rd Year', 'user'),
(23, 'Kristel', '213445', 'kris', 'kris123', 'BSIT301', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_return_request`
--
ALTER TABLE `pending_return_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465;

--
-- AUTO_INCREMENT for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pending_return_request`
--
ALTER TABLE `pending_return_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
