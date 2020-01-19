-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 30, 2019 at 05:24 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kikiclub`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatar`
--

CREATE TABLE `avatar` (
  `id` int(3) NOT NULL,
  `name` varchar(32) NOT NULL,
  `media_path` varchar(32) NOT NULL,
  `media_type` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `avatar`
--

INSERT INTO `avatar` (`id`, `name`, `media_path`, `media_type`) VALUES
(1, 'boy1', './images/avatar/robot (1).png', 'png'),
(2, 'boy2', './images/avatar/robot (2).png', 'png'),
(3, 'boy3', './images/avatar/robot (3).png', 'png'),
(4, 'boy3', './images/avatar/robot (4).png', 'png'),
(5, 'boy4', './images/avatar/robot (5).png', 'png'),
(6, 'boy5', './images/avatar/robot (6).png', 'png'),
(10, 'girl1', './images/avatar/robot (7).png', 'png'),
(11, 'girl2', './images/avatar/robot (8).png', 'png'),
(12, 'girl3', './images/avatar/robot (9).png', 'png'),
(13, 'girl4', './images/avatar/robot (10).png', 'png'),
(14, 'girl5', './images/avatar/robot (11).png', 'png'),
(15, 'girl6', './images/avatar/robot (12).png', 'png'),
(16, 'girl7', './images/avatar/robot (13).png', 'png'),
(17, 'horse', './images/avatar/robot (14).png', 'png'),
(18, 'mom', './images/avatar/robot (15).png', 'png'),
(19, 'round', './images/avatar/robot (16).png', 'png'),
(20, 'twin', './images/avatar/robot (17).png', 'png');

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `value_needed` int(10) DEFAULT NULL,
  `id_badge_type` int(11) DEFAULT NULL,
  `media_path` varchar(64) DEFAULT NULL,
  `media_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `badge_type`
--

CREATE TABLE `badge_type` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `badge_type`
--

INSERT INTO `badge_type` (`id`, `name`) VALUES
(1, 'pts');

-- --------------------------------------------------------

--
-- Table structure for table `connect_token`
--

CREATE TABLE `connect_token` (
  `id_user` int(11) NOT NULL,
  `token` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `difficulty`
--

CREATE TABLE `difficulty` (
  `id` int(1) NOT NULL,
  `name_en` varchar(16) NOT NULL,
  `name_fr` varchar(16) NOT NULL,
  `value` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `difficulty`
--

INSERT INTO `difficulty` (`id`, `name_en`, `name_fr`, `value`) VALUES
(1, 'Easy', 'Facile', 1),
(2, 'Intermediate', 'Intérmédiaire', 2),
(3, 'Hard', 'Difficile', 3),
(4, 'Expert', 'Expert', 4);

-- --------------------------------------------------------

--
-- Table structure for table `filter_type`
--

CREATE TABLE `filter_type` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `filter_type`
--

INSERT INTO `filter_type` (`id`, `name`) VALUES
(1, 'difficulty'),
(2, 'grade'),
(3, 'robot');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(1) NOT NULL,
  `name_fr` varchar(16) NOT NULL,
  `name_en` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `name_fr`, `name_en`) VALUES
(1, 'Garcon', 'Guy'),
(2, 'Fille', 'Girl'),
(3, 'Ne pas préciser', 'Do not say');

-- --------------------------------------------------------

--
-- Table structure for table `login_type`
--

CREATE TABLE `login_type` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_type`
--

INSERT INTO `login_type` (`id`, `name`) VALUES
(1, 'Wix'),
(2, 'Kikiclub');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `birthday` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int(10) NOT NULL DEFAULT '0',
  `id_avatar` int(3) DEFAULT '1',
  `id_gender` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member_badges`
--

CREATE TABLE `member_badges` (
  `id_user` int(11) NOT NULL,
  `id_badge` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `won_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member_workshops`
--

CREATE TABLE `member_workshops` (
  `id_member` int(11) NOT NULL,
  `id_workshop` int(11) NOT NULL,
  `id_statut` int(1) NOT NULL,
  `last_modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `referral`
--

CREATE TABLE `referral` (
  `referrer` int(11) NOT NULL,
  `referree` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `robot`
--

CREATE TABLE `robot` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `id_grade` int(2) NOT NULL,
  `media_path` varchar(256) NOT NULL,
  `media_type` varchar(10) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scholar_level`
--

CREATE TABLE `scholar_level` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(16) NOT NULL,
  `name_en` varchar(16) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scholar_level`
--

INSERT INTO `scholar_level` (`id`, `name_fr`, `name_en`, `age`) VALUES
(3, 'Maternelle', 'Kindergarden', 5),
(4, '1ere', '1rst', 6),
(5, '2e', '2nd', 7),
(6, '3e', '3rd', 8),
(7, '4e', '4th', 9),
(8, '5e', '5th', 10),
(9, '6e', '6th', 11),
(10, 'Sec1', 'Sec1', 12),
(11, 'Sec2', 'Sec2', 13),
(12, 'Sec3', 'Sec3', 14),
(13, 'Sec4', 'Sec4', 15),
(14, 'Sec5', 'Sec5', 16),
(15, 'Adulte', 'Adult', 17);

-- --------------------------------------------------------

--
-- Table structure for table `shared_posts`
--

CREATE TABLE `shared_posts` (
  `id` int(50) NOT NULL,
  `id_user` int(10) NOT NULL,
  `title` varchar(32) NOT NULL,
  `content` text,
  `media_path` varchar(256) DEFAULT NULL,
  `media_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(40) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `visibility` int(1) NOT NULL,
  `token` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_connexion`
--

CREATE TABLE `users_connexion` (
  `id` int(11) NOT NULL,
  `id_user` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_login`
--

CREATE TABLE `users_login` (
  `id` int(16) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_login_type` int(1) NOT NULL,
  `password` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `media_path` varchar(256) NOT NULL,
  `media_type` varchar(16) NOT NULL,
  `deployed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workshop_filters`
--

CREATE TABLE `workshop_filters` (
  `id` int(11) NOT NULL,
  `id_workshop` int(11) NOT NULL,
  `id_filter` int(11) NOT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workshop_materials`
--

CREATE TABLE `workshop_materials` (
  `id_workshop` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `nb` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workshop_score`
--

CREATE TABLE `workshop_score` (
  `id_robot` int(11) NOT NULL,
  `id_difficulty` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workshop_statut`
--

CREATE TABLE `workshop_statut` (
  `id` int(11) NOT NULL,
  `name_en` varchar(64) NOT NULL,
  `name_fr` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workshop_statut`
--

INSERT INTO `workshop_statut` (`id`, `name_en`, `name_fr`) VALUES
(1, '< My new challenges >', '< Mes nouveaux défis >'),
(2, '# I didn\'t had enough time...!', '# J\'ai pas eu le temps de terminer!'),
(3, '== Yeah! I finished those workshops!', '== Yeah! J\'ai réussi ces ateliers!');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_BADGE_TYPE` (`id_badge_type`);

--
-- Indexes for table `badge_type`
--
ALTER TABLE `badge_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `connect_token`
--
ALTER TABLE `connect_token`
  ADD UNIQUE KEY `token_2` (`token`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `difficulty`
--
ALTER TABLE `difficulty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `filter_type`
--
ALTER TABLE `filter_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_type`
--
ALTER TABLE `login_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_name_unique` (`name`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_avatar` (`id_avatar`),
  ADD KEY `gender_id` (`id_gender`);

--
-- Indexes for table `member_badges`
--
ALTER TABLE `member_badges`
  ADD PRIMARY KEY (`id_user`,`id_badge`,`id_member`) USING BTREE,
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_badge` (`id_badge`),
  ADD KEY `id_member` (`id_member`) USING BTREE;

--
-- Indexes for table `member_workshops`
--
ALTER TABLE `member_workshops`
  ADD UNIQUE KEY `Both` (`id_member`,`id_workshop`) USING BTREE,
  ADD KEY `ID_WORKSHOP` (`id_workshop`),
  ADD KEY `ID_MEMBER` (`id_member`),
  ADD KEY `ID_STATUT` (`id_statut`) USING BTREE;

--
-- Indexes for table `referral`
--
ALTER TABLE `referral`
  ADD UNIQUE KEY `referrance_unique` (`referrer`,`referree`) USING BTREE,
  ADD KEY `referree` (`referree`);

--
-- Indexes for table `robot`
--
ALTER TABLE `robot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_GRADE` (`id_grade`);

--
-- Indexes for table `scholar_level`
--
ALTER TABLE `scholar_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shared_posts`
--
ALTER TABLE `shared_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_USER` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `EMAIL` (`email`),
  ADD KEY `FIRSTNAME` (`firstname`),
  ADD KEY `LASTNAME` (`lastname`);

--
-- Indexes for table `users_connexion`
--
ALTER TABLE `users_connexion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_login_type` (`id_login_type`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workshop_filters`
--
ALTER TABLE `workshop_filters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index_all_filter_infos` (`id_workshop`,`id_filter`,`id_type`) USING BTREE,
  ADD KEY `index_workshop_id` (`id_workshop`) USING BTREE,
  ADD KEY `index_filter_id` (`id_filter`) USING BTREE,
  ADD KEY `index_fitler_type_id` (`id_type`) USING BTREE;

--
-- Indexes for table `workshop_materials`
--
ALTER TABLE `workshop_materials`
  ADD PRIMARY KEY (`id_workshop`,`id_material`);

--
-- Indexes for table `workshop_score`
--
ALTER TABLE `workshop_score`
  ADD PRIMARY KEY (`id_robot`,`id_difficulty`),
  ADD KEY `ID_DIFFICULTY` (`id_difficulty`),
  ADD KEY `ID_ROBOT` (`id_robot`) USING BTREE;

--
-- Indexes for table `workshop_statut`
--
ALTER TABLE `workshop_statut`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `badge_type`
--
ALTER TABLE `badge_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `difficulty`
--
ALTER TABLE `difficulty`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `filter_type`
--
ALTER TABLE `filter_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `login_type`
--
ALTER TABLE `login_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=522;
--
-- AUTO_INCREMENT for table `robot`
--
ALTER TABLE `robot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scholar_level`
--
ALTER TABLE `scholar_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `shared_posts`
--
ALTER TABLE `shared_posts`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users_connexion`
--
ALTER TABLE `users_connexion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_login`
--
ALTER TABLE `users_login`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workshop_filters`
--
ALTER TABLE `workshop_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workshop_statut`
--
ALTER TABLE `workshop_statut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `badges`
--
ALTER TABLE `badges`
  ADD CONSTRAINT `badges_ibfk_1` FOREIGN KEY (`id_badge_type`) REFERENCES `badge_type` (`id`);

--
-- Constraints for table `connect_token`
--
ALTER TABLE `connect_token`
  ADD CONSTRAINT `connect_token_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`id_avatar`) REFERENCES `avatar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_3` FOREIGN KEY (`id_gender`) REFERENCES `gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_badges`
--
ALTER TABLE `member_badges`
  ADD CONSTRAINT `member_badges_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_badges_ibfk_2` FOREIGN KEY (`id_badge`) REFERENCES `badges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_badges_ibfk_3` FOREIGN KEY (`id_member`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_workshops`
--
ALTER TABLE `member_workshops`
  ADD CONSTRAINT `member_workshops_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_workshops_ibfk_2` FOREIGN KEY (`id_workshop`) REFERENCES `workshops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_workshops_ibfk_3` FOREIGN KEY (`id_statut`) REFERENCES `workshop_statut` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `referral`
--
ALTER TABLE `referral`
  ADD CONSTRAINT `referral_ibfk_1` FOREIGN KEY (`referrer`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_ibfk_2` FOREIGN KEY (`referree`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `robot`
--
ALTER TABLE `robot`
  ADD CONSTRAINT `robot_ibfk_1` FOREIGN KEY (`id_grade`) REFERENCES `scholar_level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shared_posts`
--
ALTER TABLE `shared_posts`
  ADD CONSTRAINT `shared_posts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_login`
--
ALTER TABLE `users_login`
  ADD CONSTRAINT `users_login_ibfk_1` FOREIGN KEY (`id_login_type`) REFERENCES `login_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_login_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workshop_score`
--
ALTER TABLE `workshop_score`
  ADD CONSTRAINT `workshop_score_ibfk_1` FOREIGN KEY (`id_difficulty`) REFERENCES `difficulty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workshop_score_ibfk_2` FOREIGN KEY (`id_robot`) REFERENCES `robot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
