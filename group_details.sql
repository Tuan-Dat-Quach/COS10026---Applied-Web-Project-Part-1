-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 12:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greener_society`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE `group_details` (
  `id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `tutorial_day` varchar(100) NOT NULL,
  `tutorial_time` varchar(50) NOT NULL,
  `tutorial_location` varchar(100) NOT NULL,
  `group_number` varchar(10) NOT NULL,
  `scenario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_details`
--

INSERT INTO `group_details` (`id`, `group_name`, `tutorial_day`, `tutorial_time`, `tutorial_location`, `group_number`, `scenario`) VALUES
(1, 'TechTide', 'Every Thursday (Except for Mid-term Break)', '12:30 p.m to 14:30 p.m', 'Room BA513, Floor 5 at BA Building', 'G05', 'An environmental organisation strengthening its online presence to promote conservation projects, community campaigns, educational resources, volunteer opportunities and public donations.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_details`
--
ALTER TABLE `group_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_details`
--
ALTER TABLE `group_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
