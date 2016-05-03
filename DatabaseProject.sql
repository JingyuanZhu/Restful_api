-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: May 01, 2016 at 11:48 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DatabaseProject`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `PostId` char(20) NOT NULL,
  `Author` varchar(20) NOT NULL,
  `Recipient` varchar(20) NOT NULL,
  `Content` varchar(200) NOT NULL,
  `Sendtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`PostId`, `Author`, `Recipient`, `Content`, `Sendtime`) VALUES
('P00000', '00001', '00002', 'How do u feel now?', '2016-04-01 10:24:38'),
('P00001', 'Jeff0002', 'Jeff0003', 'Happy Birthday!', '2016-04-03 16:06:28'),
('P00001', 'Linxin Li', 'Yujia Zhai', 'hello!', '2016-04-03 15:58:57');

-- --------------------------------------------------------

--
-- Table structure for table `Location`
--

CREATE TABLE `Location` (
  `LocationId` varchar(20) NOT NULL DEFAULT '',
  `Longtitude` varchar(20) DEFAULT NULL,
  `Latitude` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Location`
--

INSERT INTO `Location` (`LocationId`, `Longtitude`, `Latitude`) VALUES
('00001', '73249729', '624816894'),
('00002', '73497239', '514517'),
('NYU', '3319', '2213');

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE `News` (
  `PostId` char(20) NOT NULL,
  `UserId` varchar(20) NOT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Video` varchar(100) DEFAULT NULL,
  `Entry` varchar(255) DEFAULT NULL,
  `Posttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LocationId` char(20) NOT NULL,
  `Setting` varchar(10) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `Ilikeit` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `News`
--

INSERT INTO `News` (`PostId`, `UserId`, `Image`, `Video`, `Entry`, `Posttime`, `LocationId`, `Setting`, `Ilikeit`) VALUES
('P00000', 'Jeff0003', NULL, NULL, 'I like NY', '2016-05-01 20:23:18', 'Tandon School NYU', 'Private', 0),
('P00001', 'Jeff0004', NULL, NULL, 'I like Ny too', '2016-05-01 16:48:36', '', 'Public', 0),
('P00002', 'Jeff0009', NULL, NULL, 'I love Dc.', '2016-05-01 16:48:55', 'L00003', 'Public', 0),
('P00003', 'Jeff0008', NULL, NULL, 'I love DC too', '2016-05-01 16:49:07', '', 'Private', 0),
('P00004', 'Jeff0005', NULL, NULL, 'I like basketball', '2016-05-01 16:49:22', 'L00000', 'Public', 0),
('P00005', 'Jeff0013', NULL, NULL, 'I like swimming', '2016-05-01 16:49:35', 'L00002', 'Public', 0),
('P00006', 'Jeff0004', NULL, NULL, 'hello', '2016-05-01 16:49:44', 'L00001', 'Public', 0),
('P00007', 'Jeff0009', NULL, NULL, 'nice to meet you', '2016-05-01 16:50:02', 'L00002', 'Public', 0),
('P00111', 'Jingyuan Zhu', NULL, NULL, 'I feel good', '2016-05-01 16:48:23', 'L00002', 'Private', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Relationship`
--

CREATE TABLE `Relationship` (
  `UserId` varchar(20) NOT NULL,
  `Friend` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Relationship`
--

INSERT INTO `Relationship` (`UserId`, `Friend`) VALUES
('Jeff0002', 'Jeff0001'),
('Jeff0002', 'Jeff0003'),
('Jeff0002', 'Jeff0004'),
('Jeff0002', 'Jeff0005'),
('Jeff0002', 'Jeff0008'),
('Jeff0002', 'Jeff0009'),
('Jeff0003', 'Jeff0008'),
('Jeff0003', 'Jeff0009'),
('Jeff0003', 'Jeff0010'),
('Jeff0003', 'Jeff0011'),
('Jeff0004', 'Jeff0006'),
('Jeff0004', 'Jeff0007'),
('Jeff0012', 'Jeff0015');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserId` varchar(20) NOT NULL,
  `Age` int(2) NOT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Zipcode` int(5) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Starttime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `Age`, `Image`, `Zipcode`, `Email`, `Password`, `Starttime`) VALUES
('Jeff0001', 21, '', 11201, 'linxinli@wozuishuai.com', '123456', '2016-03-01'),
('jeff0002', 30, '12', 11200, 'llx0008@gmail.com', '12345', '2016-04-06'),
('Jeff0003', 30, '12', 11200, 'llx0008@gmail.com', '12345', '2016-04-06'),
('Jeff0004', 23, '', 11201, 'llx0002@gmail.com', '123456', '2016-04-03'),
('Jeff0005', 23, '', 11201, 'llx0002@gmail.com', '123456', '2016-04-03'),
('Jeff0006', 21, '', 11228, 'zhujingyuan@gmail.com', '001389', '2016-03-22'),
('Jeff0007', 22, '', 11228, 'Tongli@gmail.com', '5438', '2015-12-18'),
('Jeff0008', 21, '', 11215, 'ywl@gmail.com', '131313', '2015-08-10'),
('Jeff0009', 21, '', 11218, 'yogazh@gmail.com', '121212', '2015-05-08'),
('Jeff0010', 26, '', 11228, 'jy26@gmail.com', '876907', '2015-07-13'),
('Jeff0011', 21, '', 11228, 'peishengdu@gmail.com', '26878549', '2015-07-13'),
('Jeff0012', 25, '', 12300, 'jg92@gmail.com', 'jg1992', '2015-03-09'),
('Jeff0013', 21, '', 11201, 'hchao@gmail.com', 'hongchao1992', '2014-04-07'),
('Jeff0014', 22, '', 11213, 'diji@gmail.com', 'diji1992', '2014-11-12'),
('Jeff0015', 21, '', 11226, 'tl1993@gmail.com', 'tianlan93', '2016-03-27'),
('jingyuan Zhu', 50, '1212', 11200, 'llx0002@gmail.com', '123456', '2016-04-30'),
('Yujia Zhai', 150, '123', 11200, 'llx0002@gmail.com', '123456', '2016-04-30'),
('Yuwei Liu', 15, '', 11207, 'llx0002@gmail.com', '123456', '2016-04-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`Author`,`Sendtime`);

--
-- Indexes for table `Location`
--
ALTER TABLE `Location`
  ADD PRIMARY KEY (`LocationId`);

--
-- Indexes for table `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`PostId`);

--
-- Indexes for table `Relationship`
--
ALTER TABLE `Relationship`
  ADD PRIMARY KEY (`UserId`,`Friend`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `UseId` (`UserId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
