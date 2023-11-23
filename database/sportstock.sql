-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 10:45 AM
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
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowing`
--

INSERT INTO `borrowing` (`id`, `equipment_id`, `user_id`, `quantity`, `status`, `borrow_date`, `return_date`) VALUES
(1, 8, '20-10134', 2, 'Borrowing', '2023-10-27', '2023-10-31'),
(2, 1, '21-10109', 2, 'Borrowing', '2023-10-27', '2023-10-31'),
(3, 1, '21-10109', 2, 'Borrowing', '2023-11-08', '2023-11-11'),
(4, 8, '21-10109', 2, 'Borrowing', '2023-11-08', '2023-11-09'),
(5, 9, '21-10109', 1, 'Borrowing', '2023-11-08', '2023-11-10'),
(6, 1, '20-10134', 1, 'Borrowing', '2023-11-08', '2023-11-11'),
(7, 1, '20-10134', 1, 'Borrowing', '2023-11-08', '2023-11-11'),
(8, 8, '20-10134', 1, 'Borrowing', '2023-11-08', '2023-11-11'),
(9, 9, '20-10134', 1, 'Borrowing', '2023-11-08', '2023-11-11'),
(10, 1, '20-10134', 1, 'Borrowing', '2023-11-08', '2023-11-10'),
(11, 1, '21-10109', 1, 'Borrowing', '2023-11-09', '2023-11-16'),
(12, 1, '21-10109', 1, 'Borrowing', '2023-11-09', '2023-11-11');

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
(1, 'Table Tennis Rackets', 'Table Tennis', 3, 'Good', '2023-10-19'),
(8, 'Badminton Rackets', 'Badminton', 2, 'Good', '2023-10-31'),
(9, 'Basketball Ball', 'Basketball', 1, 'Good', NULL);

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
(1, 'Christian Jay C. Varquez', '20-10134', 'Chan-chan05', '12345', 'BSIT - 3rd Year', 'user'),
(2, 'John Loyd Bonghanoy', '21-10109', 'John_Loyd', '12345', 'BSIT - 3rd Year', 'user'),
(4, 'Percival Velos', '', 'Perci_Jackson', '12345', 'BSIT - 3rd Year', 'user'),
(8, 'Libra Amplayo', '21-10101', 'LA', '21-10101', 'BSIT 3rd Year', 'user'),
(9, 'Percival', '21-10167', 'percival11', '12345', 'BSIT-301', 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
