-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2013 年 07 月 15 日 11:31
-- 伺服器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `nbnat`
--

-- --------------------------------------------------------

--
-- 表的結構 `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` text NOT NULL,
  `finish` enum('true','false') NOT NULL DEFAULT 'true',
  `spend` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nodes_uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nodes_id` (`nodes_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, ''),
(2, '');

-- --------------------------------------------------------

--
-- 表的結構 `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `grade` text NOT NULL,
  `name` text NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_school1_idx` (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `class`
--

INSERT INTO `class` (`id`, `type`, `grade`, `name`, `school_id`) VALUES
(1, '', '', '', 1),
(2, '', '', '', 2);

-- --------------------------------------------------------

--
-- 表的結構 `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nodes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nodes_id` (`nodes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `km`
--

CREATE TABLE IF NOT EXISTS `km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL DEFAULT '1',
  `subject_id` int(11) NOT NULL DEFAULT '1',
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的結構 `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_from` int(11) DEFAULT NULL,
  `node_to` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `is_child` varchar(11) DEFAULT '0',
  `type` text,
  `level` int(11) NOT NULL,
  `lid` int(11) DEFAULT NULL,
  `km_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `node_from` (`node_from`),
  KEY `node_to` (`node_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=124 ;

-- --------------------------------------------------------

--
-- 表的結構 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `edit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` text NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_News_Category_idx` (`category_id`),
  KEY `fk_News_Member_idx` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `news_has_file`
--

CREATE TABLE IF NOT EXISTS `news_has_file` (
  `news_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`file_id`),
  KEY `fk_news_has_file_file1_idx` (`file_id`),
  KEY `fk_news_has_file_news1_idx` (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `lid` text,
  `ch_lid` text,
  `pid` int(11) NOT NULL,
  `type` text NOT NULL,
  `level` int(11) NOT NULL,
  `km_id` int(11) NOT NULL DEFAULT '1',
  `rule` varchar(255) DEFAULT NULL,
  `lock` enum('lock','unlock') NOT NULL DEFAULT 'lock',
  `open_answer` enum('close','open') NOT NULL DEFAULT 'close',
  `limit_time` int(11) NOT NULL DEFAULT '0',
  `media` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=285 ;

-- --------------------------------------------------------

--
-- 表的結構 `nodes_old`
--

CREATE TABLE IF NOT EXISTS `nodes_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `deep` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_node` int(11) DEFAULT NULL,
  `first_child` int(1) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL,
  `km_id` int(11) NOT NULL DEFAULT '1',
  `rule` varchar(255) DEFAULT NULL,
  `lock` enum('lock','unlock') NOT NULL DEFAULT 'lock',
  `open_answer` enum('close','open') NOT NULL DEFAULT 'close',
  `limit_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_node` (`parent_node`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=144 ;

--
-- 轉存資料表中的資料 `nodes_old`
--

INSERT INTO `nodes_old` (`id`, `uuid`, `deep`, `name`, `parent_node`, `first_child`, `level`, `km_id`, `rule`, `lock`, `open_answer`, `limit_time`) VALUES
(133, 'f73d0700a6ecbe18cf5e9be36e0d57de', 0, '加法', NULL, 0, 1, 1, NULL, 'lock', 'open', 0),
(134, '8ca958a9fc0951aae438b398efc0a15e', 0, '個位數', 133, 1, 2, 1, NULL, 'unlock', 'open', 0),
(135, '6e7660edf22e800fa1db09d4a08e7c2d', 0, '減法', NULL, 0, 1, 1, NULL, 'lock', 'close', 0),
(136, '74ebabcc78c63cd49cc35ca468318458', 0, '減法', 135, 1, 2, 1, NULL, 'lock', 'close', 0),
(137, '3db15e629615820f7cca5de85707552c', 0, '十位數', 133, 0, 2, 1, NULL, 'unlock', 'open', 0),
(138, '25da68ab7d75a7a54c218ca43df0ce69', 0, '百位數', 133, 0, 2, 1, NULL, 'lock', 'close', 1800),
(139, '0ab06e4f34d8a1c2ae2d2ee5daed0e01', 0, '888', NULL, 0, 1, 1, NULL, 'lock', 'close', 0),
(140, '79c8bcdf3760659befe0d3e6b4cc530a', 0, '888', 139, 1, 2, 1, NULL, 'unlock', 'close', 0),
(141, 'd64955d56ed8b05a1ffa00eb1fb670d5', 0, '777', 139, 0, 2, 1, NULL, 'lock', 'close', 0),
(142, '396b4f0a0f69ecea97da66764fa17ded', 0, '555', 139, 0, 2, 1, NULL, 'lock', 'close', 0),
(143, '6d71e8832591eecd7c17be05477d8b59', 0, '666', 139, 0, 2, 1, NULL, 'lock', 'close', 0);

-- --------------------------------------------------------

--
-- 表的結構 `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text CHARACTER SET latin1 NOT NULL,
  `correct` enum('true','false') CHARACTER SET latin1 NOT NULL,
  `questions_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_id` (`questions_id`),
  KEY `questions_id_2` (`questions_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=163 ;

-- --------------------------------------------------------

--
-- 表的結構 `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text NOT NULL,
  `type` enum('choose','multi_choose','fill') NOT NULL,
  `media_url` text CHARACTER SET latin1 NOT NULL,
  `tips` text,
  `score` int(11) NOT NULL,
  `public` enum('true','false') CHARACTER SET latin1 NOT NULL,
  `nodes_uuid` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`nodes_uuid`),
  KEY `exam_id_2` (`nodes_uuid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- 表的結構 `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `city_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_school_city1_idx` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `school`
--

INSERT INTO `school` (`id`, `type`, `name`, `address`, `phone`, `city_id`) VALUES
(1, '', '', '', '', 1),
(2, '', '', '', '', 2);

-- --------------------------------------------------------

--
-- 表的結構 `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的結構 `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `sex` text,
  `rank` text NOT NULL,
  `birthday` date DEFAULT NULL,
  `ic_number` text NOT NULL,
  `phone` text,
  `tel` text,
  `address` text,
  `email` text,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password_edited_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `unit_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_unit` (`unit_id`),
  KEY `fk_user_class1` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 匯出資料表的 Constraints
--

--
-- 資料表的 Constraints `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`nodes_uuid`) REFERENCES `nodes` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `fk_class_school1` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `news_has_file`
--
ALTER TABLE `news_has_file`
  ADD CONSTRAINT `fk_news_has_file_file1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_has_file_news1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`nodes_uuid`) REFERENCES `nodes` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `fk_school_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_class1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
