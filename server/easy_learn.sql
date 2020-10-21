-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 21, 2020 at 06:11 PM
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
-- Table structure for table `elements`
--

CREATE TABLE `elements` (
  `id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`id`, `exercise_id`, `value`, `createdAt`) VALUES
(42, 52, 'A', '2020-10-21 17:11:34'),
(43, 52, 'B', '2020-10-21 17:11:43'),
(44, 52, 'C', '2020-10-21 17:11:49'),
(45, 52, 'D', '2020-10-21 17:11:52'),
(46, 52, 'E', '2020-10-21 17:11:59'),
(47, 52, 'F', '2020-10-21 17:12:04'),
(48, 52, 'G', '2020-10-21 17:12:10'),
(49, 52, 'H', '2020-10-21 17:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL DEFAULT 'Click start to begin exercise',
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`id`, `type_id`, `title`, `description`, `createdAt`) VALUES
(52, 1, 'Letter training', 'Identify letters', '2020-10-21 16:40:55'),
(53, 2, 'Word training', '\'Click start to begin exercise\'', '2020-10-21 16:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_type`
--

CREATE TABLE `exercise_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercise_type`
--

INSERT INTO `exercise_type` (`id`, `title`, `description`, `createdAt`) VALUES
(1, 'Letter Identification', '', '2020-10-21 09:09:30'),
(2, 'Words identification', '', '2020-10-21 09:09:30'),
(3, 'Oral comprehension', '', '2020-10-21 09:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `screen_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question_answers`
--

CREATE TABLE `question_answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercise_type`
--
ALTER TABLE `exercise_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_answers`
--
ALTER TABLE `question_answers`
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
-- AUTO_INCREMENT for table `elements`
--
ALTER TABLE `elements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `exercise_type`
--
ALTER TABLE `exercise_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_answers`
--
ALTER TABLE `question_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
