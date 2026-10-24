-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 08:28 AM
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
-- Table structure for table `fun_facts`
--

CREATE TABLE `fun_facts` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `row_num` tinyint(4) NOT NULL,
  `emoji` varchar(10) DEFAULT NULL,
  `fact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fun_facts`
--

INSERT INTO `fun_facts` (`id`, `member_id`, `row_num`, `emoji`, `fact`) VALUES
(1, 1, 1, '📚', 'His favourite subject is Maths, especially when it comes to Probability and Statistics'),
(2, 2, 1, '🎧', 'He is a big fan of listening to music'),
(3, 3, 1, '☕️', 'He works as a barista, but he doesn\'t like coffee'),
(4, 1, 2, '🧩', 'He likes solving puzzles or IQ games, including Minesweeper, Sudoku and match-3 games'),
(5, 2, 2, '🤖', 'He is interested in Artificial Intelligence (AI)'),
(6, 3, 2, '✈️', 'He has never gone overseas or interstate'),
(7, 1, 3, '🎼', 'He loves playing kalimba, as the only instrument that he\'s keen on'),
(8, 2, 3, '⏰', 'He can spend a surprisingly long time trying to fix one small coding error'),
(9, 3, 3, '🕹️', 'He loves games, whether it\'s video, board or card games');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fun_facts`
--
ALTER TABLE `fun_facts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_id` (`member_id`,`row_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fun_facts`
--
ALTER TABLE `fun_facts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fun_facts`
--
ALTER TABLE `fun_facts`
  ADD CONSTRAINT `fun_facts_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
