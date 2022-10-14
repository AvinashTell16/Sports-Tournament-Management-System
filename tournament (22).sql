-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2022 at 02:04 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tournament`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `match_id` int(10) NOT NULL,
  `tid` int(10) NOT NULL,
  `pid1` int(10) NOT NULL,
  `pid2` int(10) NOT NULL,
  `winner_id` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`match_id`, `tid`, `pid1`, `pid2`, `winner_id`) VALUES
(2, 2, 1, 3, 0),
(3, 2, 2, 1, 0),
(4, 2, 2, 3, 0),
(5, 2, 3, 1, 0),
(6, 2, 3, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `pid` int(10) NOT NULL,
  `pname` varchar(30) NOT NULL,
  `age` varchar(3) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `address` varchar(200) NOT NULL,
  `bloodgroup` varchar(5) DEFAULT NULL,
  `teamid` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`pid`, `pname`, `age`, `email`, `password`, `address`, `bloodgroup`, `teamid`) VALUES
(1, 'admin1111', '22', 'admin11@gmail.com', '$2y$10$TMoNW.7YHhQfK4CpR.e.0eEDP3Z/6k4tHKow/JjzK94/BVcc36zyq', 'asdf', 'O+', 1),
(2, 'avinashttellakula', '20', 'avinashtellakula16@gmail.com', '$2y$10$fbOsEBZgp.c06Xn8b3qwwOQtDGSzIa.rYUe0FVQ.umGLzAMvMaLmS', 'qwer', 'A+', 1),
(3, 'rakesh8', '24', 'rakesh8@gmail.com', '$2y$10$3F7D2KdQiB.ho676rQZTeukShHBG9A0GyX4qDzHWVR4EDa3eQWuFG', 'zxcv', 'AB-', 2),
(4, 'yaswanth', '25', 'yaswanth@gmail.com', '$2y$10$uy7Iz5eJnI8jNixYu8qYs.c/DetEI/QMr.83RkcvabPaDCX7.WhNG', 'zxcv', 'AB+', 2),
(5, 'kalyan9876', '23', 'kalyan@gmail.com', '$2y$10$opEqCXdQboUeA.Q0DtziyuO5wPUgvf2emBtQ5hN2GEmEo5ckIRyGe', 'hjkl', 'B+', 2),
(7, 'badrish', '20', 'badri@gmail.com', '$2y$10$bDwIoZtO3W9HAEPMSc1M7.4Bz/.woss.u48pinG/4yMnrCei6Iz7O', 'asdf', 'A+', 4),
(8, 'balu8461', '22', 'balu@gmail.com', '$2y$10$7KBvavsTLA6HnAIs9hf4Vu0UEZKOs.nT2mp4L4je/Lws5BCe2Ci8K', 'ghjk', 'AB+', 3),
(10, 'avinash111', '22', '198w1a05c0@vrsiddhartha.ac.in', '$2y$10$3mNoXbG2S7RalnOYs4yh/OXi7s1YGhTyFTwIBkE0hk5R.63pE7W/O', 'ghjk', 'A+', 1),
(11, 'avinash16', '28', 'avinash16tellakula@gmail.com', '$2y$10$E/MSDPbQ8V7fbZ.VFSEcW.TqXi82ZlXwkqx4F.ZHWOjX2JL06SAEK', 'uiop', 'A-', 5),
(13, 'lokesh18', '23', 'lokesh@gmail.com', '$2y$10$zpa75ZD2hUh2CoMDMf1Yu.jhkgijNAJQBupEriTa11Zb8f9XjGDi6', '1234dfgh', 'B-', 3),
(14, 'sumanth21', '21', 'sumanth@gmail.com', '$2y$10$8JCff9UpqEHyU82Rv0O4heDHIJp82OUa6iA579G3BfmmCo2./oI4C', 'zxcv', 'O-', 3),
(15, 'koushik65', '25', 'koushik@gmail.com', '$2y$10$c0AhhqTZFuhEde.SZD0fQ.Zv.mwJeafb8XH.lZrukfDfEWjwPNsJa', 'tyui', 'A+', 5),
(16, 'junaid88', '23', 'junaid@gmail.com', '$2y$10$ORPnAZYLXizJ9F43WinecOzDYRevUEUlu0b4PCsyTM9xBX7iKIl42', 'cvbn', 'B-', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `teamid` int(10) NOT NULL,
  `teamname` varchar(30) NOT NULL,
  `count` varchar(10) DEFAULT NULL,
  `captain` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`teamid`, `teamname`, `count`, `captain`) VALUES
(1, 'Blue Badgers', '3', '2'),
(2, 'Black Tigers', '4', '4'),
(3, 'Chennai chasers', '3', '8'),
(4, 'Mumbai Indians', '1', '7'),
(5, 'Delhi Capitals', '2', '11');

-- --------------------------------------------------------

--
-- Table structure for table `tourall`
--

CREATE TABLE `tourall` (
  `tid` int(10) NOT NULL,
  `id` int(10) NOT NULL,
  `disqualify` varchar(2) DEFAULT NULL,
  `wins` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tourall`
--

INSERT INTO `tourall` (`tid`, `id`, `disqualify`, `wins`) VALUES
(1, 1, '1', 0),
(1, 5, '1', 0),
(1, 7, '1', 0),
(1, 8, '1', 0),
(1, 10, '0', 0),
(1, 13, '0', 0),
(1, 14, '0', 0),
(2, 1, '0', 0),
(2, 2, '0', 0),
(2, 3, '0', 0),
(3, 2, '0', 0),
(3, 3, '0', 0),
(3, 4, '0', 0),
(4, 2, '0', 0),
(4, 4, '0', 0),
(4, 5, '0', 0),
(4, 7, '0', 0),
(4, 11, '0', 0),
(10, 1, '0', 0),
(10, 3, '0', 0),
(10, 5, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tourevents`
--

CREATE TABLE `tourevents` (
  `tid` int(10) NOT NULL,
  `tname` varchar(30) NOT NULL,
  `type` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `minteams` varchar(10) NOT NULL,
  `pperteam` varchar(10) NOT NULL,
  `time` time NOT NULL,
  `tourend_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tourevents`
--

INSERT INTO `tourevents` (`tid`, `tname`, `type`, `start_date`, `end_date`, `status`, `minteams`, `pperteam`, `time`, `tourend_date`) VALUES
(1, 'Hand Cricket', 'single', '2022-07-06', '2022-08-30', 'Active', '4', '1', '10:00:00', '2022-09-05'),
(2, 'Cricket', 'team', '2022-07-14', '2022-08-21', 'Active', '3', '3', '13:30:00', '2022-08-26'),
(3, 'Football', 'team', '2022-07-11', '2022-07-30', 'InActive', '4', '3', '16:45:00', '2022-08-02'),
(4, 'Chess', 'single', '2022-07-22', '2022-08-15', 'Active', '3', '1', '18:30:00', '2022-08-18'),
(10, 'Kabaddi', 'team', '2022-07-26', '2022-08-03', 'Active', '4', '3', '19:30:00', '2022-08-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `matches_ibfk_1` (`tid`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`teamid`);

--
-- Indexes for table `tourall`
--
ALTER TABLE `tourall`
  ADD PRIMARY KEY (`tid`,`id`);

--
-- Indexes for table `tourevents`
--
ALTER TABLE `tourevents`
  ADD PRIMARY KEY (`tid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `teamid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tourevents`
--
ALTER TABLE `tourevents`
  MODIFY `tid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `tourevents` (`tid`);

--
-- Constraints for table `tourall`
--
ALTER TABLE `tourall`
  ADD CONSTRAINT `tourall_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `tourevents` (`tid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
