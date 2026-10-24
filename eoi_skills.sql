-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 09:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `eoi_skills`
--

CREATE TABLE `eoi_skills` (
  `eoi_number` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi_skills`
--
ALTER TABLE `eoi_skills`
  ADD PRIMARY KEY (`eoi_number`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eoi_skills`
--
ALTER TABLE `eoi_skills`
  ADD CONSTRAINT `eoi_skills_ibfk_1` FOREIGN KEY (`eoi_number`) REFERENCES `eoi` (`eoi_number`) ON DELETE CASCADE,
  ADD CONSTRAINT `eoi_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
