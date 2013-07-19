-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 07 月 19 日 12:36
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `nbnat`
--

-- --------------------------------------------------------

--
-- 表的结构 `answer`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `answer`
--

INSERT INTO `answer` (`id`, `answer`, `finish`, `spend`, `time`, `nodes_uuid`, `user_id`) VALUES
(8, '[{"topicId":"5","ans":["8"]},{"topicId":"6","ans":["5"]},{"topicId":"7","ans":["14"]},{"topicId":"8","ans":["+","-"]}]', 'true', 34, '2013-07-17 05:24:28', '0517faf415558e76af6359b462414c63', 2),
(9, '[{"topicId":"5","ans":["8"]},{"topicId":"6","ans":["-"]},{"topicId":"7","ans":["12","13","14"]},{"topicId":"8","ans":["+","+"]}]', 'true', 47, '2013-07-17 05:30:08', '0517faf415558e76af6359b462414c63', 2),
(10, '[{"topicId":"5","ans":["9"]},{"topicId":"6","ans":["5"]},{"topicId":"7","ans":["12","13","14"]},{"topicId":"8","ans":["+","+"]}]', 'true', 27, '2013-07-17 10:15:58', '0517faf415558e76af6359b462414c63', 2),
(11, '[{"topicId":"5","ans":["8"]},{"topicId":"6","ans":["3"]},{"topicId":"7","ans":["12","13","14"]},{"topicId":"8","ans":["+","+"]}]', 'true', 21, '2013-07-19 12:34:23', '0517faf415558e76af6359b462414c63', 2);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, '台中市');

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `grade` text NOT NULL,
  `name` text NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_school1_idx` (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `class`
--

INSERT INTO `class` (`id`, `type`, `grade`, `name`, `school_id`) VALUES
(1, '大學部', '一', '一', 1);

-- --------------------------------------------------------

--
-- 表的结构 `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nodes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nodes_id` (`nodes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `km`
--

CREATE TABLE IF NOT EXISTS `km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL DEFAULT '1',
  `subject_id` int(11) NOT NULL DEFAULT '1',
  `grade` int(11) NOT NULL,
  `visible` enum('true','false') NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `km`
--

INSERT INTO `km` (`id`, `t_id`, `subject_id`, `grade`, `visible`) VALUES
(2, 2, 1, 1, 'true'),
(3, 2, 2, 12, 'false'),
(4, 2, 1, 7, 'false'),
(5, 2, 2, 1, 'false');

-- --------------------------------------------------------

--
-- 表的结构 `links`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `links`
--

INSERT INTO `links` (`id`, `node_from`, `node_to`, `width`, `x`, `y`, `z`, `is_child`, `type`, `level`, `lid`, `km_id`) VALUES
(9, 4, 5, 150, 630, 320, 94.19418278839086, '1', 'chLine', 0, 0, 2),
(10, 6, 4, 167, 569, 463, 124.73862528276563, '1', 'chLine', 0, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `login_log`
--

CREATE TABLE IF NOT EXISTS `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`TIME`),
  KEY `fk_LoginLog_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `news`
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
-- 表的结构 `news_has_file`
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
-- 表的结构 `nodes`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `nodes`
--

INSERT INTO `nodes` (`id`, `uuid`, `name`, `x`, `y`, `lid`, `ch_lid`, `pid`, `type`, `level`, `km_id`, `rule`, `lock`, `open_answer`, `limit_time`, `media`) VALUES
(21, '0517faf415558e76af6359b462414c63', '加法與減法', 1021, 405, '', '', 3, 'point', 1, 2, NULL, 'unlock', 'open', 0, ''),
(22, '91b06c5c5817e692053a93adff641400', '一位數的減法', 692, 387, '', '0,1', 4, 'point', 0, 2, NULL, 'lock', 'close', 0, ''),
(23, '2ca7648c32e3c700988a41146110e342', '一位數的加法', 703, 237, '', '0', 5, 'point', 0, 2, NULL, 'lock', 'close', 0, ''),
(24, 'fc5d8ed42da4b67295243c22be492ae9', '二與三位數的減法', 597, 524, '', '1', 6, 'point', 0, 2, NULL, 'lock', 'close', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `nodes_old`
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
-- 转存表中的数据 `nodes_old`
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
-- 表的结构 `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text CHARACTER SET latin1 NOT NULL,
  `correct` enum('true','false') CHARACTER SET latin1 NOT NULL,
  `questions_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_id` (`questions_id`),
  KEY `questions_id_2` (`questions_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `options`
--

INSERT INTO `options` (`id`, `value`, `correct`, `questions_id`) VALUES
(7, '5', 'false', 5),
(8, '6', 'false', 5),
(9, '7', 'true', 5),
(10, '8', 'false', 5),
(11, '', 'true', 6),
(12, '1', 'true', 7),
(13, '2', 'true', 7),
(14, '3', 'true', 7),
(15, '4', 'false', 7),
(16, '', 'true', 8);

-- --------------------------------------------------------

--
-- 表的结构 `questions`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `questions`
--

INSERT INTO `questions` (`id`, `topic`, `type`, `media_url`, `tips`, `score`, `public`, `nodes_uuid`) VALUES
(5, '1+5+3-2=?', 'choose', '', '[]', 2500, 'true', '0517faf415558e76af6359b462414c63'),
(6, '<p>2+<label class=''stuffbox''>5</label>-4=3</p>', 'fill', '', '[]', 2500, 'true', '0517faf415558e76af6359b462414c63'),
(7, '5+8-?>10', 'multi_choose', '', '[]', 2500, 'true', '0517faf415558e76af6359b462414c63'),
(8, '<p>3<label class=''stuffbox''>+</label>3+2<label class=''stuffbox''>-</label>5=3</p>', 'fill', '', '[]', 2500, 'true', '0517faf415558e76af6359b462414c63');

-- --------------------------------------------------------

--
-- 表的结构 `school`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `school`
--

INSERT INTO `school` (`id`, `type`, `name`, `address`, `phone`, `city_id`) VALUES
(1, '國立大學', '國立臺中教育大學', '台中市西區民生路140號', '04-22183199 ', 1);

-- --------------------------------------------------------

--
-- 表的结构 `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `subject`
--

INSERT INTO `subject` (`id`, `subject`) VALUES
(1, '數學'),
(2, '微積分');

-- --------------------------------------------------------

--
-- 表的结构 `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `unit`
--

INSERT INTO `unit` (`id`, `name`) VALUES
(1, '註冊組');

-- --------------------------------------------------------

--
-- 表的结构 `user`
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
  `password_edited_time` datetime DEFAULT NULL,
  `unit_id` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_user_unit` (`unit_id`),
  KEY `fk_user_class1` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `sex`, `rank`, `birthday`, `ic_number`, `phone`, `tel`, `address`, `email`, `created_time`, `password_edited_time`, `unit_id`, `class_id`) VALUES
(2, 'admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', '管理員', '0', '0', '0000-00-00', '', '', '', '', NULL, '2013-07-16 02:23:45', NULL, 0, 1);

--
-- 限制导出的表
--

--
-- 限制表 `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`nodes_uuid`) REFERENCES `nodes` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `fk_class_school1` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `login_log`
--
ALTER TABLE `login_log`
  ADD CONSTRAINT `fk_LoginLog_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `news_has_file`
--
ALTER TABLE `news_has_file`
  ADD CONSTRAINT `fk_news_has_file_file1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_has_file_news1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`nodes_uuid`) REFERENCES `nodes` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `fk_school_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
