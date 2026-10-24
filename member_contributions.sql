-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 08:30 AM
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
-- Table structure for table `member_contributions`
--

CREATE TABLE `member_contributions` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `project` tinyint(4) NOT NULL,
  `task` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_contributions`
--

INSERT INTO `member_contributions` (`id`, `member_id`, `project`, `task`) VALUES
(1, 1, 1, 'Main content for index.html and about.html'),
(2, 1, 1, 'General CSS for pages'),
(5, 2, 1, 'Main content for jobs.html'),
(7, 3, 1, 'Main content for apply.html'),
(8, 3, 1, 'Assignment Submission'),
(30, 1, 2, 'Task 5: jobs.php with jobs table, additional page search_result.php'),
(31, 1, 2, 'Task 6 (Part 2): manager.php, user.php and eoi_details.php'),
(32, 1, 2, 'signup.php'),
(33, 1, 2, 'CSS for the above pages and also login.php'),
(34, 2, 2, 'Task 1: Convert pages to PHP, header.inc, nav.inc, footer.inc'),
(35, 2, 2, 'Task 2: settings.php'),
(36, 2, 2, 'Task 6 (Part 1): login.php with users table, and logout.php'),
(37, 2, 2, 'Task 7: about.php with related tables'),
(38, 2, 2, 'Presentation management'),
(39, 3, 2, 'Task 3: apply.php and eoi table, additional eoi_skills and skills tables'),
(40, 3, 2, 'Task 4: process_eoi.php'),
(41, 3, 2, 'Presentation slides'),
(42, 3, 2, 'Group assignment submission');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member_contributions`
--
ALTER TABLE `member_contributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member_contributions`
--
ALTER TABLE `member_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `member_contributions`
--
ALTER TABLE `member_contributions`
  ADD CONSTRAINT `member_contributions_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
