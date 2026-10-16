-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2026 at 11:43 AM
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
