-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2024 at 05:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mzfault`
--

-- --------------------------------------------------------

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
  `fault_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `fault_description` varchar(500) NOT NULL,
  `fault_location` varchar(100) NOT NULL,
  `fault_status` varchar(20) DEFAULT 'pending',
  `latitude` varchar(30) DEFAULT NULL,
  `longtitude` varchar(30) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_cleared` date DEFAULT NULL,
  `date_reported` date DEFAULT sysdate()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`fault_id`, `category`, `fault_description`, `fault_location`, `fault_status`, `latitude`, `longtitude`, `user_id`, `date_cleared`, `date_reported`) VALUES
(1, 'Broken Street Lights', 'Broken Street Light on Luwinga', 'kanengo', 'pending', '', '', 7, NULL, '2024-03-05'),
(2, 'Broken Street Lights', 'jkfw', 'Nchesi', 'pending', '', '', 7, NULL, '2024-03-05'),
(3, 'Garbage Collection', 'You have not collected garbage here at the university in days.', 'Luwinga', 'cleared', '', '', 14, '2024-03-05', '2024-03-05'),
(4, 'Garbage Collection', 'jpj', 'kh', 'pending', '', '', 3, NULL, '2024-03-05'),
(5, 'Garbage Collection', 'Clean up on area 1b', 'Luwinga', 'pending', '', '', 3, NULL, '2024-03-05'),
(6, 'Garbage Collection', 'fhwqhfwqifh', 'jkhdf', 'pending', '-11.420205565262341', '33.996140529723434', 7, NULL, '2024-03-05'),
(7, 'Garbage Collection', 'garbage', 'mzuzu', 'pending', '', '', 7, NULL, '2024-03-05'),
(8, 'Garbage Collection', 'There is a broken pit latrine at the point of the road.', 'Luwinga', 'pending', '-11.4585', '33.9944', 3, NULL, '2024-03-05'),
(9, 'Garbage Collection', 'Garbage not collected.', 'Luwinga', 'pending', '', '', 14, NULL, '2024-03-05'),
(10, 'Land  Matters', 'Mzuzu', 'Luwinga', 'pending', '-11.4201818443326', '33.99607536754802', 12, NULL, '2024-03-05'),
(12, 'Garbage Collection', 'Near the University garbage not picked.', 'Luwinga', 'pending', '-11.420408338093667', '33.99605356556226', 3, NULL, '2024-03-05'),
(88, 'Land  Matters', 'Akulimbilana malo kuno.', 'Area 24', 'pending', '', '', 48, NULL, '2024-03-05');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_articles`
--

CREATE TABLE `knowledge_articles` (
  `ID` int(11) NOT NULL,
  `articleTitle` varchar(200) NOT NULL,
  `articleBody` varchar(5000) NOT NULL,
  `publishedOn` date DEFAULT sysdate(),
  `readsNum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_articles`
--

INSERT INTO `knowledge_articles` (`ID`, `articleTitle`, `articleBody`, `publishedOn`, `readsNum`) VALUES
(1, 'Plot Demarcation Resolutions.', '<div>Mzuzu City Council is committed to solving any complaints you may have about plot demarcation this is why we have introduced a team specific for that the team is available all year round to help.</div>\n<div style=\"text-align: center;\"><p><span style=\"font-weight: bold;\">How to get help.</span></p><ul style=\"text-align: left;\"><li>Report via the Mzuzu City Council fault reporting system.</li><li>Our team will contact you.</li><li>We visit you and check the demarcations.<br /></li></ul></div>', '2024-03-02', 13),
(2, 'HANDLING ESCOM ISSUES', '<p>Mzuzu City is not responsible for handling electrictity issues for any issues regarding power at residences or businesses contact escom</p>\r\n<p style=\"text-align: center;\"><span style=\"font-weight: bold;\">ESCOM CONTACTS</span></p>\r\n<p style=\"text-align: center;\"><span style=\"font-weight: bold;\">0994922342<br /></span></p>', '2024-03-05', 4);

-- --------------------------------------------------------

--
-- Table structure for table `response_teams`
--

CREATE TABLE `response_teams` (
  `ID` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `team_category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `response_teams`
--

INSERT INTO `response_teams` (`ID`, `team_name`, `team_category`) VALUES
(1, 'Team GC', 'Garbage Collection'),
(2, 'Land Issues', 'Land  Matters'),
(3, 'Street Lights', 'Street Lights');

-- --------------------------------------------------------

--
-- Table structure for table `teammembers`
--

CREATE TABLE `teammembers` (
  `ID` int(11) NOT NULL,
  `teamid` int(11) NOT NULL,
  `memberid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teammembers`
--

INSERT INTO `teammembers` (`ID`, `teamid`, `memberid`) VALUES
(1, 1, 5),
(3, 2, 9),
(4, 2, 8),
(6, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `phone_number`, `password`, `type`) VALUES
(1, 'Daniel', 'Mandevu', '0884054197', 'daniel1', 2),
(3, 'Khalani', 'Simu', '088124585', 'daniel1', 0),
(4, 'Maya', 'Kango', '0993214567', 'daniel1', 1),
(5, 'Songa', 'Zitha', '0888834567', 'daniel1', 1),
(7, 'Lowa', 'Tabwera', '09999345678', 'daniel1', 0),
(8, 'Ed', 'Mango', '0881234567', 'daniel1', 1),
(9, 'Mike', 'Chokapp', '0889123456', 'daniel1', 1),
(12, 'Kani', 'Zatha', '0993213425', 'daniel1', 0),
(14, 'Mango', 'Zgambo', '0992314657', 'daniel1', 0),
(17, 'Mande ', 'Banda', '0888234567', 'daniel1', 2),
(48, 'Sothini', 'Zoya', '0999454444', 'daniel1', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faults`
--
ALTER TABLE `faults`
  ADD PRIMARY KEY (`fault_id`),
  ADD KEY `id` (`user_id`);

--
-- Indexes for table `knowledge_articles`
--
ALTER TABLE `knowledge_articles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `response_teams`
--
ALTER TABLE `response_teams`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `team_name` (`team_name`),
  ADD UNIQUE KEY `team_category` (`team_category`);

--
-- Indexes for table `teammembers`
--
ALTER TABLE `teammembers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `teamid` (`teamid`),
  ADD KEY `memberid` (`memberid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faults`
--
ALTER TABLE `faults`
  MODIFY `fault_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `knowledge_articles`
--
ALTER TABLE `knowledge_articles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `response_teams`
--
ALTER TABLE `response_teams`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teammembers`
--
ALTER TABLE `teammembers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
