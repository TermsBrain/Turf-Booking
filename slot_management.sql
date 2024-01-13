-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 13, 2024 at 11:59 AM
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
(1, 'slot-1', '12:30 PM', '1:00 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:54:25'),
(2, 'slot-2', '1:00 PM', '1:30 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:54:53'),
(3, 'slot-3', '1:30 PM', '2:00 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:55:01'),
(4, 'slot-4', '2:00 PM', '2:30 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:55:36'),
(5, 'slot-5', '2:30 PM', '3:00 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:55:44'),
(6, 'slot-6', '3:00 PM', '3:30 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:55:55'),
(7, 'slot-7', '3:30 PM', '4:00 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:56:02'),
(8, 'slot-8', '4:00 PM', '4:30 PM', 1, '2024-01-13 08:05:26', '2024-01-13 16:56:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `slot_management`
--
ALTER TABLE `slot_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `slot_management`
--
ALTER TABLE `slot_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
