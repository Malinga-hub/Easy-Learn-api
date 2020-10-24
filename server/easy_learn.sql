-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2020 at 03:51 PM
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
  `value` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`id`, `exercise_id`, `value`, `createdAt`) VALUES
(42, 52, 'A', '2020-10-21 17:11:34'),
(43, 52, 'b', '2020-10-21 17:11:43'),
(44, 52, 'C', '2020-10-21 17:11:49'),
(45, 52, 'D', '2020-10-21 17:11:52'),
(46, 52, 'E', '2020-10-21 17:11:59'),
(47, 52, 'F', '2020-10-21 17:12:04'),
(48, 52, 'G', '2020-10-21 17:12:10'),
(51, 52, 'H', '2020-10-21 19:30:05'),
(53, 52, 'z', '2020-10-21 19:44:35'),
(54, 52, 'x', '2020-10-21 19:44:40'),
(55, 52, 'b', '2020-10-21 19:45:40'),
(56, 52, 'm', '2020-10-21 19:45:46'),
(57, 52, 'q', '2020-10-21 19:45:53'),
(58, 52, 'i', '2020-10-21 19:46:02'),
(59, 52, 'q', '2020-10-21 19:46:08'),
(60, 56, 'ball', '2020-10-21 19:52:13'),
(61, 56, 'apple', '2020-10-21 19:52:20'),
(62, 56, 'cat', '2020-10-21 19:52:32'),
(63, 56, 'dog', '2020-10-21 19:52:39'),
(64, 56, 'egg', '2020-10-21 19:52:45'),
(65, 56, 'frog', '2020-10-21 19:52:52'),
(66, 56, 'pineapples', '2020-10-24 14:08:49'),
(67, 56, 'water melon', '2020-10-24 14:17:15'),
(68, 57, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2020-10-24 14:19:04'),
(69, 56, 'Education', '2020-10-24 14:23:15'),
(70, 56, 'Enviroment', '2020-10-24 14:36:33'),
(71, 52, 'X', '2020-10-24 14:38:32'),
(72, 52, 'Z', '2020-10-24 14:38:36'),
(74, 52, 'f', '2020-10-24 14:40:24'),
(75, 56, 'water', '2020-10-24 14:42:42'),
(76, 56, 'food', '2020-10-24 14:42:46'),
(77, 56, 'running', '2020-10-24 14:42:55');

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
(52, 1, 'Letter Identification', 'Identify as many letters as possible', '2020-10-21 16:40:55'),
(56, 2, 'word reading', 'identify as many words as possible', '2020-10-21 19:49:55'),
(57, 3, 'oral ', 'Click start to begin exercise', '2020-10-24 14:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_type`
--

CREATE TABLE `exercise_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `isQuestions` tinyint(2) NOT NULL DEFAULT 0,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercise_type`
--

INSERT INTO `exercise_type` (`id`, `title`, `description`, `isQuestions`, `createdAt`) VALUES
(1, 'Letter Identification', '', 0, '2020-10-21 09:09:30'),
(2, 'Words identification', '', 0, '2020-10-21 09:09:30'),
(3, 'Oral comprehension', '', 0, '2020-10-21 09:09:48'),
(4, 'Voice identification', '', 1, '2020-10-22 09:44:41'),
(5, 'test updated 2', '', 1, '2020-10-22 09:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `exercise_type`
--
ALTER TABLE `exercise_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
