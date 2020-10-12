-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 12, 2020 at 10:34 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easy_learn`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_elements`
--

CREATE TABLE `data_elements` (
  `id` int(11) NOT NULL,
  `reading_screen_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_elements`
--

INSERT INTO `data_elements` (`id`, `reading_screen_id`, `value`, `createdAt`) VALUES
(1, 13, 'A', '2020-10-11 14:18:12'),
(2, 13, 'B', '2020-10-11 14:18:12'),
(3, 13, 'C', '2020-10-11 14:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `reading_screen`
--

CREATE TABLE `reading_screen` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reading_screen`
--

INSERT INTO `reading_screen` (`id`, `title`, `createdAt`) VALUES
(13, 'aplhabet', '2020-10-11 13:07:49'),
(18, 'test2 updated 2', '2020-10-11 13:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `createdAt`) VALUES
(6, 'test', 'test@gmail.com', '$2y$10$7qOqjF2GRf9a3qXuw4JrreLJdv2HJujy1zZWaKTgR3e0sRZfwdtE.', '2020-10-09 22:27:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_elements`
--
ALTER TABLE `data_elements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading_screen`
--
ALTER TABLE `reading_screen`
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
-- AUTO_INCREMENT for table `data_elements`
--
ALTER TABLE `data_elements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reading_screen`
--
ALTER TABLE `reading_screen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
