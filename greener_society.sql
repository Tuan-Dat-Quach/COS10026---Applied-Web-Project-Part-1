-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2026 at 04:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `user_id` int(11) DEFAULT NULL,
  `eoi_number` int(11) NOT NULL,
  `job_reference` char(6) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Rather Not Say') NOT NULL,
  `street_address` varchar(40) NOT NULL,
  `suburb` varchar(40) NOT NULL,
  `state` enum('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
  `postcode` char(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `other_skills` text DEFAULT NULL,
  `status` enum('NEW','CURRENT','FINAL') NOT NULL DEFAULT 'NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eoi_skills`
--

CREATE TABLE `eoi_skills` (
  `eoi_number` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `group_name` varchar(50) NOT NULL,
  `tutorial_day` varchar(100) NOT NULL,
  `tutorial_time` varchar(50) NOT NULL,
  `tutorial_location` varchar(100) NOT NULL,
  `group_number` varchar(10) NOT NULL,
  `scenario` text NOT NULL,
  `group_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_details`
--

INSERT INTO `group_details` (`id`, `group_name`, `tutorial_day`, `tutorial_time`, `tutorial_location`, `group_number`, `scenario`, `group_photo`) VALUES
(1, 'TechTide', 'Every Thursday (Except for Mid-term Break)', '12:30 p.m to 14:30 p.m', 'Room BA513, Floor 5 at BA Building', 'G05', 'An environmental organisation strengthening its online presence to promote conservation projects, community campaigns, educational resources, volunteer opportunities and public donations.', 'Images/official-group-photo.jpg');

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
  `employment_type` enum('Full-time','Part-time','Casual') NOT NULL,
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
(3, 2, 1, 'Main content for jobs.html'),
(4, 3, 1, 'Main content for apply.html'),
(5, 3, 1, 'Assignment Submission'),
(6, 1, 2, 'Task 5: jobs.php with jobs table, additional page search_result.php'),
(7, 1, 2, 'Task 6 (Part 2): manager.php, user.php and eoi_details.php'),
(8, 1, 2, 'signup.php'),
(9, 1, 2, 'CSS for the above pages and also login.php'),
(10, 2, 2, 'Task 1: Convert pages to PHP, header.inc, nav.inc, footer.inc'),
(11, 2, 2, 'Task 2: settings.php'),
(12, 2, 2, 'Task 6 (Part 1): login.php with users table, and logout.php'),
(13, 2, 2, 'Task 7: about.php with related tables'),
(14, 2, 2, 'Presentation management'),
(15, 3, 2, 'Task 3: apply.php and eoi table, additional eoi_skills and skills tables'),
(16, 3, 2, 'Task 4: process_eoi.php'),
(17, 3, 2, 'Presentation slides'),
(18, 3, 2, 'Group assignment submission');

-- --------------------------------------------------------

--
-- Table structure for table `shared_tasks`
--

CREATE TABLE `shared_tasks` (
  `id` int(11) NOT NULL,
  `project` tinyint(4) NOT NULL,
  `task` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shared_tasks`
--

INSERT INTO `shared_tasks` (`id`, `project`, `task`) VALUES
(1, 1, 'CSS Style for each individual page'),
(2, 1, 'Suggesting ideas'),
(3, 1, 'Re-evaluation and finalisation'),
(4, 2, 'Suggesting ideas'),
(5, 2, 'Re-evaluation and finalisation');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `skill_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill_name`) VALUES
(9, 'Communication'),
(4, 'Hard Working'),
(8, 'Leadership'),
(1, 'Loves the Environment'),
(2, 'Organization'),
(7, 'Passionate'),
(3, 'Punctuality'),
(5, 'Resilience'),
(6, 'Team Player');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `student_id` varchar(30) NOT NULL,
  `quote_original` text NOT NULL,
  `quote_translation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `student_id`, `quote_original`, `quote_translation`) VALUES
(1, 'Tuan Dat Quach', '106424486', 'Sâu thẳm trong tim tôi là một niềm đam mê mãnh liệt với những con số, những quy luật và tính logic chặt chẽ.', 'Deep from my heart lies a profound passion for numbers, principles and coherent logics.'),
(2, 'Ravindu Nethsara', '105998951', 'අද දවස හොඳම දවස කරගන්න.', 'Make today your best day.'),
(3, 'Johnathan Mey', '105341872', '塵も積もれば山となる. (Chiri mo tsumoreba yama to naru)', 'Even dust, when piled up, becomes a mountain.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('User','Manager') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$ml0bsr9YS.bFV6/Bb8pxSeg8Ke1hM8vyEQRqpJdMe4d7kLQy62bOW', 'Manager'),
(2, 'TechTide', '$2y$10$NJBTEO2lwVvqsyyQzYuZCO2NO/Jk3VxVgAi/3iFNhkBzBFWA/u7cu', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`eoi_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_reference` (`job_reference`);

--
-- Indexes for table `eoi_skills`
--
ALTER TABLE `eoi_skills`
  ADD PRIMARY KEY (`eoi_number`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `fun_facts`
--
ALTER TABLE `fun_facts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_id` (`member_id`,`row_num`);

--
-- Indexes for table `group_details`
--
ALTER TABLE `group_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_reference`);

--
-- Indexes for table `member_contributions`
--
ALTER TABLE `member_contributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `shared_tasks`
--
ALTER TABLE `shared_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD UNIQUE KEY `skill_name` (`skill_name`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

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
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `eoi_number` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fun_facts`
--
ALTER TABLE `fun_facts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `group_details`
--
ALTER TABLE `group_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `member_contributions`
--
ALTER TABLE `member_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `shared_tasks`
--
ALTER TABLE `shared_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eoi`
--
ALTER TABLE `eoi`
  ADD CONSTRAINT `eoi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `eoi_ibfk_2` FOREIGN KEY (`job_reference`) REFERENCES `jobs` (`job_reference`);

--
-- Constraints for table `eoi_skills`
--
ALTER TABLE `eoi_skills`
  ADD CONSTRAINT `eoi_skills_ibfk_1` FOREIGN KEY (`eoi_number`) REFERENCES `eoi` (`eoi_number`) ON DELETE CASCADE,
  ADD CONSTRAINT `eoi_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`);

--
-- Constraints for table `fun_facts`
--
ALTER TABLE `fun_facts`
  ADD CONSTRAINT `fun_facts_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_contributions`
--
ALTER TABLE `member_contributions`
  ADD CONSTRAINT `member_contributions_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
