-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 05:10 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE `group_details` (
  `id` int(11) NOT NULL,
  `detail_key` varchar(100) NOT NULL,
  `detail_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_details`
--

INSERT INTO `group_details` (`id`, `detail_key`, `detail_value`) VALUES
(1, 'group_name', 'TechTide'),
(2, 'tutorial_day', 'Every Thursday (Except for Mid-term Break)'),
(3, 'tutorial_time', '12:30 p.m to 14:30 p.m'),
(4, 'tutorial_location', 'Room BA513, Floor 5 at BA Building'),
(5, 'group_number', 'G05'),
(6, 'scenario', 'An environmental organisation strengthening its online presence to promote conservation projects, community campaigns, educational resources, volunteer opportunities and public donations.');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `image_src` text NOT NULL,
  `image_alt` text NOT NULL,
  `job_reference` char(6) NOT NULL,
  `job_title` text NOT NULL,
  `short_description` text NOT NULL,
  `salary` varchar(50) NOT NULL,
  `employment_type` enum('Full-time','Part-time','Casual','') NOT NULL,
  `reporting_line` text NOT NULL,
  `responsibilities` text NOT NULL,
  `essential_requirements` text NOT NULL,
  `preferable_requirements` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`image_src`, `image_alt`, `job_reference`, `job_title`, `short_description`, `salary`, `employment_type`, `reporting_line`, `responsibilities`, `essential_requirements`, `preferable_requirements`) VALUES
('images/project_officer.jpg', 'Environmental conservation project', 'GS102A', 'Environmental Project Officer', 'The Environmental Project Officer supports the planning, coordination and delivery of environmental conservation projects including tree planting, habitat restoration and community sustainability programs.', '$75,000 - $85,000 per year', 'Full-time', 'Environmental Programs Manager', 'Coordinate environmental conservation projects.\nOrganise tree planting and habitat restoration activities.\nWork with volunteers and community organisations.\nMonitor project progress and prepare reports.\nAssist with environmental education programs.', 'Relevant qualification or experience in environmental conservation.\nStrong communication and teamwork skills.\nGood organisational and time-management skills.\nAbility to work outdoors when required.\nCommitment to environmental sustainability.', 'Project management experience.\nExperience working with volunteers.\nKnowledge of local environmental issues.\nExperience working with community organisations.'),
('images/community_management.jpg', 'Community engagement event', 'GS204B', 'Community Engagement Coordinator', 'The Community Engagement Coordinator develops relationships with volunteers, schools, local councils and community groups to promote Greener Society\'s environmental programs.', '$65,000 - $75,000 per year', 'Full-time', 'Community Programs Manager', 'Recruit and coordinate environmental volunteers.\nOrganise community conservation events.\nDevelop relationships with schools and community groups.\nPromote Greener Society programs and campaigns.\nSupport community communication activities.', 'Excellent written and verbal communication skills.\nStrong interpersonal skills.\nGood event organisation skills.\nAbility to work effectively with diverse communities.\nInterest in environmental sustainability.', 'Previous community engagement experience.\nSocial media or digital communication experience.\nEvent coordination experience.\nExperience managing volunteers.'),
('images/educator.jpg', 'Environmental education workshop', 'GS305C', 'Environmental Education Officer', 'The Environmental Education Officer delivers educational activities and workshops that help schools and communities understand sustainability, conservation and protection of local ecosystems.', '$70,000 - $80,000 per year', 'Full-time', 'Environmental Education Manager', 'Develop and deliver environmental education workshops.\nConduct presentations for schools and community groups.\nPrepare educational resources and activities.\nSupport tree planting and conservation events.\nEvaluate the effectiveness of educational programs.', 'Relevant education, environmental or community qualification.\nExcellent presentation and communication skills.\nAbility to work with students and community members.\nStrong teamwork skills.\nCommitment to environmental education.', 'Teaching or training experience.\nEnvironmental science knowledge.\nExperience developing educational resources.\nPublic speaking experience.');

-- --------------------------------------------------------

--
-- Table structure for table `member_contributions`
--

CREATE TABLE `member_contributions` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
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
(11, NULL, 1, 'CSS Style for each individual page'),
(12, NULL, 1, 'Suggesting ideas'),
(13, NULL, 1, 'Re-evaluation and finalisation'),
(17, 1, 2, 'Task 5: jobs.php with jobs table'),
(18, 1, 2, 'Task 6 (part 2): manage.php'),
(19, 1, 2, 'Presentation slides'),
(20, 2, 2, 'Task 1: Convert pages to PHP with header, nav and footer includes'),
(21, 2, 2, 'Task 2: settings.php database connection'),
(22, 2, 2, 'Task 6 (part 1): user table and login page'),
(23, 2, 2, 'Task 7: about page and about tables'),
(24, 2, 2, 'Presentation management'),
(25, 3, 2, 'Task 3: apply.php and eoi table'),
(26, 3, 2, 'Task 4: process_eoi.php'),
(27, 3, 2, 'Assignment Submission'),
(28, NULL, 2, 'Suggesting ideas'),
(29, NULL, 2, 'Re-evaluation and finalisation');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `student_id` varchar(30) NOT NULL,
  `responsibilities` text NOT NULL,
  `quote_original` text DEFAULT NULL,
  `quote_translation` text DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `quote_class` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `student_id`, `responsibilities`, `quote_original`, `quote_translation`, `flag`, `quote_class`) VALUES
(1, 'Tuan Dat Quach', '106424486', 'Main content for index.html and about.html; General CSS for pages', 'Sâu thẳm trong tim tôi là một niềm đam mê mãnh liệt với những con số, những quy luật và tính logic chặt chẽ.', 'Deep from my heart lies a profound passion for numbers, principles and coherent logics.', '🇻🇳', 'TDQ-Quote'),
(2, 'Ravindu Nethsara', '105998951', 'Main content for jobs.html', 'අද දවස හොඳම දවස කරගන්න.', 'Make today your best day.', '🇱🇰', 'RN-Quote'),
(3, 'Johnathan Mey', '105341872', 'Main content for apply.html; Assignment Submission', '塵も積もれば山となる. (Chiri mo tsumoreba yama to naru)', 'Even dust, when piled up, becomes a mountain.', '🇯🇵', 'JM-Quote');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$NVw3AyQfOlsmRHPfpIpYweTuyMn3N5OYl3W7h2ys0VQpzIoRZtETm', 'admin'),
(2, 'testuser', '$2y$10$I1BNlLnU4WPzCIPXpz.N9uk9uZDs5OQ0ozDuKTDv1OaJKdEOI8heC', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fun_facts`
--
ALTER TABLE `fun_facts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_details`
--
ALTER TABLE `group_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_key` (`detail_key`);

--
-- Indexes for table `member_contributions`
--
ALTER TABLE `member_contributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fun_facts`
--
ALTER TABLE `fun_facts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `group_details`
--
ALTER TABLE `group_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `member_contributions`
--
ALTER TABLE `member_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
