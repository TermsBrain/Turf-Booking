-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2024 at 03:27 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tb_turf`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '12345', 'admin', 1, '2024-01-14 12:36:51', '2024-01-15 20:26:27'),
(2, 'Rafi', 'manager@gmail.com', '12345', 'manager', 1, '2024-01-14 12:36:51', '2024-01-14 18:36:51');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `start_slot_id` int(11) DEFAULT NULL,
  `end_slot_id` int(11) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slot_live`
--

CREATE TABLE `slot_live` (
  `id` int(11) NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slot_management`
--

CREATE TABLE `slot_management` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slot_management`
--

INSERT INTO `slot_management` (`id`, `name`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 'slot-1', '12:00 PM', '12:30 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15'),
(2, 'slot-2', '12:30 PM', '1:00 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15'),
(3, 'slot-3', '1:00 PM', '1:30 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15'),
(4, 'slot-4', '1:30 PM', '2:00 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15'),
(5, 'slot-5', '2:00 PM', '2:30 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15'),
(6, 'slot-6', '2:30 PM', '3:00 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15'),
(7, 'slot-7', '3:00 PM', '3:30 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15'),
(8, 'slot-7', '3:30 PM', '4:00 PM', 1, '2024-01-14 12:39:15', '2024-01-14 18:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advance` int(11) DEFAULT NULL,
  `due` int(11) DEFAULT NULL,
  `cash` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `start_slot_id` (`start_slot_id`),
  ADD KEY `end_slot_id` (`end_slot_id`),
  ADD KEY `reference_id` (`reference_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slot_live`
--
ALTER TABLE `slot_live`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `slot_management`
--
ALTER TABLE `slot_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authentication`
--
ALTER TABLE `authentication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slot_live`
--
ALTER TABLE `slot_live`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slot_management`
--
ALTER TABLE `slot_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`start_slot_id`) REFERENCES `slot_management` (`id`),
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`end_slot_id`) REFERENCES `slot_management` (`id`),
  ADD CONSTRAINT `booking_ibfk_5` FOREIGN KEY (`reference_id`) REFERENCES `authentication` (`id`);

--
-- Constraints for table `slot_live`
--
ALTER TABLE `slot_live`
  ADD CONSTRAINT `slot_live_ibfk_1` FOREIGN KEY (`slot_id`) REFERENCES `slot_management` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
