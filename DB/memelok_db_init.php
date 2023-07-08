-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2023 at 07:47 PM
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
-- Dumping data for table `info`
--

INSERT INTO `info` (`pid`, `pic`, `about`, `page_name`, `creator_username`, `creator_uid`, `creation_date`, `followers`, `posts_count`, `email`, `social`) VALUES
('1020115e4cdba456925569308591469', 'default.jpg', 'Ye saare milke hame pagal banarhe h madarchod ke bacche.', 'MilkePagal', 'myprakhar96', 'pr113385e21c8dc8132174606193127', '19:2:2020', 5, 1, 'milkepagal@gmail.com', '{\"facebook\":\"-\",\"twitter\":\"-\",\"instagram\":\"-\"}'),
('112211649ed2deb4869375077739477', '-', 'backbencher memes', 'newpagetest', 'myprakhar96', 'pr113385e21c8dc8132174606193127', '30:6:2023', 0, 2, 'myprakhar96q@gmail.com', '{\"facebook\":\"-\",\"instagram\":\"-\",\"twitter\":\"-\"}'),
('1325115e8aea862ef4b413650457782', 'default.jpg', 'lopslops', 'prakharkapage', 'testuser123', 'te113485e884df08798f47085699785', '6:4:2020', 1, 1, 'prakharraone020@gmail.com', '{\"facebook\":\"http:\\/\\/facebook.com\",\"instagram\":\"-\",\"twitter\":\"-\"}'),
('2021115e479fb3e31b5687814857176', '15535664a8184bb264d2.25157311.jpeg', 'You Will get the funniest memes here.', 'Prakhar\'s First Page', 'myprakhar96', 'pr113385e21c8dc8132174606193127', '15:2:2020', 6, 3, 'myprakhar96@gmail.com', '{\"facebook\":\"http://facbook.com\",\"twitter\":\"-\",\"instagram\":\"-\"}'),
('51885e9089d4b6a4c256697626164', 'default.jpg', 'helloooo', 'blipbloptheboy', 'testuser', 'te83485e220656d501891680966242', '10:4:2020', 1, 5, 'akarya98@gmail.com', '{\"facebook\":\"-\",\"twitter\":\"-\",\"instagram\":\"-\"}'),
('817125e7477a920daf466023016368', 'default.jpg', 'I am High.Don\'t fuck with me.', 'High.bro', 'vishusingh4u', 'vi12185e21eeb2792f289829730818', '20:3:2020', 4, 3, 'highbro@gmail.com', '{\"facebook\":\"-\",\"instagram\":\"-\",\"twitter\":\"-\"}');

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`lid`, `uid`, `fullname`, `username`, `email`, `pic`, `password`, `socialmedia`, `friend_count`, `pages_following_count`, `interests`, `bio`, `gender`, `birthday`, `last_activity`, `darkmode_toggle`, `chatid`, `sessid`, `eslot2`) VALUES
('db2e155aeba6ac84ca31f6b0c667dba2', 'ad734125e39aadeef3d885924310358', 'Aditya Singh', 'freak07', 'adityasingh272002@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 1, 2, 'random', '................', 'male', '2/7/2003', '2020-03-27 00:45:42', 0, 'J9BPK6_p6J9zZRqUAAAj', NULL, NULL),
('672f6b747ec271c8378cc9cc62814edb', 'me153485e9203b7c0e4607337458383', 'Metal Admiral', 'metal_admiral96', 'metaladmiral@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 1, 0, '[\"School Life\",\"College Life\",\"Indian Parents\",\"Technology\",\"Sports\",\"Childhood\",\"Bollywood\",\"Engineers\",\"Cartoons\",\"Sarcastic\",\"Teenage Life\",\"Humourous\",\"Nature\"]', 'King of Metals', 'male', '3/4/2004', '2022-07-16 02:25:04', 0, NULL, 'dcovp09khltringvcjsr2ftst8', NULL),
('b6489a36c39f4679e40057d94a8f3db9', 'nt1316649ee1191631785459345874', 'ntlGQCLFFO', 'prakharsinha1', 'tfzqv@ysh0.com1', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 1, 1, '[\"Sports\",\"Engineers\",\"Doctors\",\"10 Year Challenge\",\"Tik Tok\"]', 'XhyzrOLkPp', 'male', '8/9/2001', '2023-07-07 20:40:49', 0, 'sZHK5CA9QpVKrDOiAABF', '63nk5121dhk0s69lkcd33den67', NULL),
('7b3b1c0d8fa33f9640651bd9a7a28b3b', 'pr10145e2213184ef2833691112523', 'Pratham Garg', 'thepratham', 'prathamgarg2010@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 4, 3, 'random', 'blah blah blah', 'male', '8/3/2004', '2020-04-22 04:31:54', 0, 'aYqQVkN_21kjcC9lAAAZ', 'df948acc26347a4aea45a555de1838d3', NULL),
('08d61abca88e2b7cfa6e86c387a4be64', 'pr103385e84d5ff759a93914307939', 'Prakhar Sinha', 'prakhar123', 'prakharraone066@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 0, 0, 'random', 'Creta', 'male', '3/3/2001', '2023-06-27 17:25:24', 0, '1TL_gmNAF1hibC3pAAAb', 'g7a47o2up5m7gevktrcfjfsedu', NULL),
('bce6cce61f76f1eeb4c612556126b576', 'pr113385e21c8dc8132174606193127', 'Prakhar Sinha', 'myprakhar96', 'myprakhar96@gmail.com', '23735962d065e5d8e825.52573635.jpeg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"http://facebook.com\",\"twitter\":\"-\",\"instagram\":\"-\"}', 8, 1, 'random', 'I am a Human Being :)', 'male', '7/2/2010', '2023-07-08 15:26:33', 0, '79nuG8xxJVjkDFuiAAAB', 'gebe3bdjvt2e3a0quhc204o4rg', NULL),
('54c000e4320022cfcff18721078ff7fa', 'pr121864a02dda0a2cf23290395683', 'prakhar sinha', 'prakhararara', 'myprakhar92@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 0, 0, '[\"School Life\",\"College Life\",\"Sports\",\"Childhood\",\"Indian Politics\"]', '123121223q1', 'male', '3/4/2004', '2023-07-01 19:14:58', 0, NULL, NULL, NULL),
('bd6933f079464ed30c2669d46cc3c6b8', 'pr81864a02f0910f2011802555670', 'praarar@', 'prakarq1', 'prakharraone02021@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 0, 0, '[\"Indian Weddings\",\"10 Year Challenge\",\"Indian TV Ads\",\"Tik Tok\",\"Reactions\",\"Teenage Life\",\"Indian History\",\"Nature\"]', 'sdasdasda', 'male', '3/4/2004', '2023-07-01 19:20:01', 0, NULL, NULL, NULL),
('b152f5e9779546bdc6d4f70feacc487f', 'te103345e93579773b2375050498884', 'Test User', 'testuser96', 'testuser96@gmail.com', 'male_avatar.jpg', '81dc9bdb52d04dc20036dbd8313ed055', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 0, 0, '[\"School Life\",\"College Life\",\"Indian Parents\"]', 'ghghggj', 'male', '7/3/1987', '2020-04-12 23:31:59', 0, NULL, NULL, NULL),
('375d1cce1c36eacd490764c1de9156bd', 'te103385e9358d2c03de43686340378', 'Test User', 'testuser97', 'testuser97@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 1, 0, '[\"School Life\",\"College Life\",\"Indian Parents\"]', 'ghghggj', 'male', '7/3/1987', '2020-04-13 00:44:57', 0, NULL, 'ed68edf9ef47fb03ef1eb81f4a24ca09', NULL),
('0e003a8290d8a53ce75c0b04f1628eff', 'te113485e884df08798f47085699785', 'Test User', 'bhosad_pappu', 'testuser123@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 3, 3, '[\"School Life\",\"College Life\",\"Indian Politics\"]', 'Test User ki Bio nhi h ye.', 'male', '15/11/1994', '2020-04-16 11:47:38', 0, '074_nlfQ8oRqGlvrAAAe', 'a43da91a8fb96dcba8917997a0887024', NULL),
('8a21bde08bfdfe3cf38a8ed7f541e8a9', 'te14185e94a6946507682596290964', 'test user', 'testuserabc123', 'testuserabc123@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 0, 0, 'random', 'ghghgj', 'male', '1/1/2000', '2020-04-13 23:38:11', 0, NULL, 'ed68edf9ef47fb03ef1eb81f4a24ca09', NULL),
('764339cf059c2d0a4ea386e2f591049d', 'te83485e220656d501891680966242', 'Test User', 'testuser', 'testuser@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"http://facebook.com\",\"twitter\":\"-\",\"instagram\":\"-\"}', 4, 3, 'random', 'hi......', 'male', '24/10/2005', '2020-04-20 23:51:06', 0, 'pRGs17Y0p5OJkypZAAA7', 'fa177c9deb2c045bd2b7960851e66b5a', NULL),
('4b9e5dea406a16ad3d30fdabec017927', 'te93385e84d4e31a6ff07430682497', 'test user', 'testuser1', 'prakharraone020@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 0, 0, 'random', 'Prakhar', 'male', '18/11/2001', '2020-04-11 14:10:08', 0, 'x1GvXlFcc5TZyLgOAAAC', 'a9eed775d4287f72c9e7e68bf70b60ca', NULL),
('5b30b18dae83165037139f2e9bc63146', 'vi12185e21eeb2792f289829730818', 'Vishwajeet Singh', 'vishusingh4u', 'vishusingh4u@gmail.com', 'male_avatar.jpg', '00612d08e80508ef24212920bfd030d2', '{\"facebook\":\"-\", \"instagram\":\"-\", \"twitter\":\"-\"}', 3, 2, 'random', 'I am a Chootiya.yah', 'male', '1/2/2002', '2020-04-22 23:59:00', 0, 'tThKSutnGaPYxKAdAAAC', 'caf90025b27f10976e4702f2646471da', NULL);

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

INSERT INTO `meme` (`mid`, `date`, `page_name`, `pid`, `tags`, `image_link`, `like_count`, `dislike_count`, `caption`, `pagedp`) VALUES
('10204757735e8efd85924812.87880876', '2020-04-09 16:18:37', 'MilkePagal', '1020115e4cdba456925569308591469', '[\"Indian Politics\",\"Sarcastic\",\"Relationship\",\"Teenage Life\"]', '47526433435e8efd45be79b2.29654490.jpeg', 3, 0, NULL, '1342225e4cdb9d536e37.06285182.jpeg'),
('112211591664a81a6ecf6b86.09321235', '2023-07-07 19:30:14', 'newpagetest', '112211649ed2deb4869375077739477', 'random', '11521164a81a6c33bd30.25056795.png', 1, 0, NULL, '-'),
('11221468064a81aedaa3130.77634053', '2023-07-07 19:32:21', 'newpagetest', '112211649ed2deb4869375077739477', 'random', '14628264a81ae98e46f1.98026570.jpeg', 0, 1, NULL, '-'),
('132512415e8efc9feb23d3.31204286', '2020-04-09 16:14:47', 'prakharkapage', '1325115e8aea862ef4b413650457782', '[\"Technology\",\"Dailylife\"]', '12469992715e8efc91750077.24691589.jpeg', 2, 1, NULL, '1754005e8aea75252214.73758993.jpeg'),
('202114698664a81635acba42.08332101', '2023-07-07 19:12:13', 'Prakhar%27s%20First%20Page', '2021115e479fb3e31b5687814857176', 'random', '14617164a815c6eeb0a4.28535345.jpeg', 0, 0, NULL, '2742335e479f825b5b01.59316515.jpeg'),
('202116692564a81a262df0d0.69134668', '2023-07-07 19:29:02', 'Prakhar%27s%20First%20Page', '2021115e479fb3e31b5687814857176', 'random', '16643464a81a065e3891.53775587.jpeg', 0, 0, NULL, '15535664a8184bb264d2.25157311.jpeg'),
('20213554895e8efdbc414ef5.67587729', '2020-04-09 16:19:32', 'Prakhar%27s%20First%20Page', '2021115e479fb3e31b5687814857176', 'random', '3554937665e8efda86f6947.77618685.jpeg', 1, 1, NULL, '2742335e479f825b5b01.59316515.jpeg'),
('51882314125e908c326df868.34880879', '2020-04-10 20:39:38', 'blipbloptheboy', '51885e9089d4b6a4c256697626164', 'random', '23116443715e908c27ed8855.91045200.jpeg', 3, 0, 'first.......', '237205e9089a9a4e3d3.29941997.jpeg'),
('51882326555e908f0d3f4631.87530040', '2020-04-10 20:51:49', 'blipbloptheboy', '51885e9089d4b6a4c256697626164', 'random', '232154762215e908efea022f7.44763362.jpeg', 2, 0, 'ek baar hua mere saath......', '237205e9089a9a4e3d3.29941997.jpeg'),
('51882767325e908c70288d26.38786050', '2020-04-10 20:40:40', 'blipbloptheboy', '51885e9089d4b6a4c256697626164', 'random', '27605133845e908c6cd0c7a4.86258552.jpeg', 1, 0, 'oye....', '237205e9089a9a4e3d3.29941997.jpeg'),
('51882781105e908f4f328ad0.05486989', '2020-04-10 20:52:55', 'blipbloptheboy', '51885e9089d4b6a4c256697626164', 'random', '27813813295e908f24beb1c3.31602839.jpeg', 1, 1, 'har ladke ke kiya hoga nursery main....', '237205e9089a9a4e3d3.29941997.jpeg'),
('51882792925e908e508ec593.00355868', '2020-04-10 20:48:40', 'blipbloptheboy', '51885e9089d4b6a4c256697626164', 'random', '27990281105e908e46877f06.67951910.jpeg', 2, 1, 'sahi batttt', '237205e9089a9a4e3d3.29941997.jpeg'),
('8171304265e8efae49d03a9.64627689', '2020-04-09 16:07:24', 'High.bro', '817125e7477a920daf466023016368', '[\"Bollywood\"]', '30483141665e8efad8d53f85.76007477.jpeg', 1, 0, NULL, '1753825e74778e666b48.96442310.jpeg'),
('81713632385e8efbdc4ca0e4.62940281', '2020-04-09 16:11:32', 'High.bro', '817125e7477a920daf466023016368', '[\"School Life\",\"College Life\",\"Bollywood\",\"Engineers\"]', '36301733545e8efbd21abf32.06120169.jpeg', 0, 1, NULL, '1753825e74778e666b48.96442310.jpeg'),
('81713664645e8efbadcd3e05.32478436', '2020-04-09 16:10:45', 'High.bro', '817125e7477a920daf466023016368', '[\"College Life\",\"Bollywood\",\"Engineers\"]', '36643832035e8efba0cd8330.70397976.jpeg', 2, 0, NULL, '1753825e74778e666b48.96442310.jpeg');

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
