-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2023 at 07:50 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pages`
--
CREATE DATABASE IF NOT EXISTS `pages` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pages`;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `pid` varchar(250) NOT NULL,
  `pic` varchar(250) NOT NULL,
  `about` varchar(80) NOT NULL,
  `page_name` varchar(250) NOT NULL,
  `creator_username` varchar(250) NOT NULL,
  `creator_uid` varchar(250) NOT NULL,
  `creation_date` varchar(250) NOT NULL,
  `followers` int(20) NOT NULL DEFAULT 0,
  `posts_count` int(100) NOT NULL DEFAULT 0,
  `email` varchar(35) NOT NULL,
  `social` varchar(95) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`pid`);
ALTER TABLE `info` ADD FULLTEXT KEY `search` (`page_name`);
--
-- Database: `people`
--
CREATE DATABASE IF NOT EXISTS `people` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `people`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `lid` varchar(250) NOT NULL,
  `uid` varchar(250) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `username` varchar(18) NOT NULL,
  `email` varchar(250) NOT NULL,
  `pic` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `socialmedia` varchar(1000) NOT NULL DEFAULT '{"facebook":"-", "instagram":"-", "twitter":"-"}',
  `friend_count` int(50) NOT NULL DEFAULT 0,
  `pages_following_count` int(50) NOT NULL DEFAULT 0,
  `interests` longtext DEFAULT NULL,
  `bio` varchar(250) DEFAULT NULL,
  `gender` varchar(20) NOT NULL,
  `birthday` varchar(250) NOT NULL,
  `last_activity` varchar(250) DEFAULT current_timestamp(),
  `darkmode_toggle` int(5) NOT NULL DEFAULT 0,
  `chatid` varchar(200) DEFAULT NULL,
  `sessid` varchar(50) DEFAULT NULL,
  `eslot2` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;
ALTER TABLE `users` ADD FULLTEXT KEY `search_user` (`username`,`fullname`);
--
-- Database: `posts`
--
CREATE DATABASE IF NOT EXISTS `posts` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `posts`;

-- --------------------------------------------------------

--
-- Table structure for table `meme`
--

CREATE TABLE `meme` (
  `mid` varchar(120) NOT NULL,
  `date` varchar(20) NOT NULL,
  `page_name` varchar(120) NOT NULL,
  `pid` varchar(120) NOT NULL,
  `tags` longtext NOT NULL,
  `image_link` varchar(250) NOT NULL,
  `like_count` int(20) NOT NULL,
  `dislike_count` int(20) NOT NULL,
  `caption` varchar(250) DEFAULT NULL,
  `pagedp` varchar(250) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meme`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meme`
--
ALTER TABLE `meme`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `date` (`date`),
  ADD KEY `pid` (`pid`);
ALTER TABLE `meme` ADD FULLTEXT KEY `page_fulltext` (`pid`);
ALTER TABLE `meme` ADD FULLTEXT KEY `tags_fulltext` (`tags`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
