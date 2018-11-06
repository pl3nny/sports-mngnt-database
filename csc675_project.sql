-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2018 at 01:45 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csc675_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `cid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `cname` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`cid`, `tid`, `cname`) VALUES
(15, 1001, 'Bruce Bochy'),
(31, 1002, 'Hensley Meulens'),
(33, 1003, 'Alonzo Powell'),
(39, 1004, 'Rick Schu'),
(43, 1005, 'Curt Young');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `eid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `item` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`eid`, `tid`, `item`) VALUES
(1923123, 1001, 'Bat'),
(2323321, 1002, 'Bat'),
(2343242, 1003, 'Bat'),
(3009383, 1004, 'Bat'),
(3423662, 1005, 'Bat'),
(3787423, 1001, 'Glove'),
(7763621, 1002, 'Glove'),
(8837271, 1003, 'Glove'),
(8883723, 1004, 'Glove'),
(9478344, 1005, 'Glove');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `pid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `pname` char(30) NOT NULL,
  `page` int(11) NOT NULL,
  `pnumber` int(11) NOT NULL,
  `pposition` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`pid`, `tid`, `pname`, `page`, `pnumber`, `pposition`) VALUES
(1, 1001, 'Tyler Beede', 32, 38, 'Pitcher'),
(2, 1002, 'Ty Blach', 28, 50, 'Pitcher'),
(3, 1003, 'Hunter Strickland', 26, 60, 'Pitcher'),
(4, 1004, 'Tony Watson', 32, 56, 'Pitcher'),
(5, 1005, 'Aramis Garcia', 25, 74, 'Catcher'),
(6, 1001, 'Nick Hundley', 35, 5, 'Catcher'),
(7, 1002, 'Buster Posey', 31, 28, 'Catcher'),
(8, 1003, 'Brandon Belt', 30, 9, 'Infield'),
(9, 1004, 'Brandon Crawford', 32, 35, 'Infield'),
(10, 1005, 'Miguel Gomez', 26, 52, 'Infield'),
(11, 1001, 'Gregor Blanco', 35, 1, 'Outfield'),
(12, 1002, 'Gorkys Hernandez', 31, 7, 'Outfield'),
(13, 1003, 'Austin Jackson', 31, 16, 'Outfield');

-- --------------------------------------------------------

--
-- Stand-in structure for view `q1_view`
--
CREATE TABLE `q1_view` (
`pname` char(30)
);

-- --------------------------------------------------------

--
-- Table structure for table `stadiums`
--

CREATE TABLE `stadiums` (
  `sid` int(11) NOT NULL,
  `s_name` char(255) NOT NULL,
  `location` char(30) NOT NULL,
  `num_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stadiums`
--

INSERT INTO `stadiums` (`sid`, `s_name`, `location`, `num_seats`) VALUES
(10451, 'Bronx Stadium', 'Bronx, NY', 54251),
(20003, 'Washignton Stadium', 'Washington, DC', 41313),
(22155, 'Boston Stadium', 'Boston, MA', 37731),
(60613, 'Chicago Stadium', 'Chicago, IL', 43649),
(94107, 'AT&T Park', 'San Francisco, CA', 41915);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `tid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `tname` char(30) NOT NULL,
  `num_players` int(11) NOT NULL,
  `mascot` char(30) NOT NULL,
  `color` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`tid`, `sid`, `tname`, `num_players`, `mascot`, `color`) VALUES
(1001, 22155, 'Boston Red Sox', 25, 'Lou Seal', 'Black/Orange'),
(1002, 10451, 'Bronx baseball team', 25, 'Rally Monkey', 'White/Red/NavyBlue'),
(1003, 20003, 'Washington Nationals', 25, 'BJ Birdy', 'White/Red/NavyBlue'),
(1004, 60613, 'Chicago Red Sox', 25, 'Screech', 'White/Red/NavyBlue'),
(1005, 94107, 'SF Giants', 25, 'Swinging Friar', 'White/Red/NavyBlue');

-- --------------------------------------------------------

--
-- Structure for view `q1_view`
--
DROP TABLE IF EXISTS `q1_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `q1_view`  AS  select `p`.`pname` AS `pname` from `players` `p` group by `p`.`tid` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `tid` (`tid`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `tid` (`tid`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `tid` (`tid`),
  ADD KEY `idx_pname` (`pname`),
  ADD KEY `idx_pid` (`pid`,`tid`);

--
-- Indexes for table `stadiums`
--
ALTER TABLE `stadiums`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `sid` (`sid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coaches`
--
ALTER TABLE `coaches`
  ADD CONSTRAINT `coaches_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `teams` (`tid`);

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `teams` (`tid`);

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `teams` (`tid`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `stadiums` (`sid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
