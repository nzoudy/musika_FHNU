-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 05, 2015 at 11:43 PM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `testminimvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE IF NOT EXISTS `song` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `artist` text NOT NULL,
  `track` text NOT NULL,
  `link` text
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`id`, `userid`, `artist`, `track`, `link`) VALUES
(11, 20, 'Test artist manager', 'Test track', 'upload/liquido - liquido - narcotic.mp3'),
(13, 20, 'Test artist manager', 'Michel Sardo - Je vole', 'upload/Michel_Sardou_-_Je_Vole.mp3'),
(14, 20, 'Test artist manager', 'Michel sardo - amour', 'upload/Michel_Sardou_-_La_Maladie_D_39_amour.mp3'),
(15, 20, 'Test artist manager', 'Michel sardo - Mari', 'upload/Michel_Sardou_-_Les_Vieux_Mari_s_.mp3'),
(16, 20, 'Test artist manager', 'Michel sardo - En chantant', 'upload/Michel_Sardou_-_En_chantant.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `fullname` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL DEFAULT '',
  `groupid` int(11) NOT NULL DEFAULT '6',
  `updated` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `email`, `groupid`, `updated`, `created`) VALUES
(20, 'test', 'bcc4a19de13afdf707a58e238b30658334ce824d', 'Test artist manager', 'testherm@gmail.com', 6, 1428265814, 1428163611),
(21, 'adminmusika', 'aa035512fb483b907001a49b6d9147e3f70c8c55', 'Administrator', 'adminmusika@musika.com', 1, 1428163695, 1428163695);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `song`
--
ALTER TABLE `song`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
