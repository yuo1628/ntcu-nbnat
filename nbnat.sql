-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2013 年 07 月 12 日 09:35
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

--
-- 轉存資料表中的資料 `answer`
--

INSERT INTO `answer` (`id`, `answer`, `finish`, `spend`, `time`, `nodes_uuid`, `user_id`) VALUES
(59, '[{"topicId":"107","ans":["116"]},{"topicId":"108","ans":["120","122"]},{"topicId":"109","ans":["124"]}]', 'true', 14, '2013-07-03 04:33:49', '7994a3e994c38939eadd5941ec0ee8a6', 1),
(60, '[{"topicId":"110","ans":["128"]},{"topicId":"111","ans":["133"]}]', 'true', 10, '2013-07-03 04:50:57', 'bffddf84b653ecc600c1695efb8a5939', 3),
(61, '[{"topicId":"107","ans":["117"]},{"topicId":"108","ans":["119","120"]},{"topicId":"109","ans":["125"]}]', 'true', 23, '2013-07-03 04:51:06', '7994a3e994c38939eadd5941ec0ee8a6', 2),
(62, '[{"topicId":"107","ans":["116"]},{"topicId":"108","ans":["119","120"]},{"topicId":"109","ans":["124"]}]', 'true', 10, '2013-07-03 04:51:09', '7994a3e994c38939eadd5941ec0ee8a6', 1),
(63, '[{"topicId":"107","ans":["116"]},{"topicId":"108","ans":["120","122"]},{"topicId":"109","ans":["124"]},{"topicId":"113","ans":["137"]}]', 'true', 13, '2013-07-03 04:51:11', '7994a3e994c38939eadd5941ec0ee8a6', 1),
(65, '[{"topicId":"110","ans":["128"]},{"topicId":"111","ans":["133"]}]', 'true', 6, '2013-07-03 04:51:18', 'bffddf84b653ecc600c1695efb8a5939', 2),
(66, '[{"topicId":"110","ans":["128"]},{"topicId":"111","ans":["133"]}]', 'true', 6, '2013-07-03 04:51:20', 'bffddf84b653ecc600c1695efb8a5939', 2),
(67, '[{"topicId":"110","ans":["128"]},{"topicId":"111","ans":["133"]}]', 'true', 4, '2013-07-03 04:51:22', 'bffddf84b653ecc600c1695efb8a5939', 1),
(68, '[{"topicId":"107","ans":["116"]},{"topicId":"108","ans":["120","122"]},{"topicId":"109","ans":["124"]},{"topicId":"113","ans":["137"]}]', 'true', 31, '2013-07-03 04:51:25', '7994a3e994c38939eadd5941ec0ee8a6', 1),
(69, '[{"topicId":"107","ans":[]},{"topicId":"108","ans":[]},{"topicId":"109","ans":[]},{"topicId":"113","ans":[]},{"topicId":"118","ans":[]},{"topicId":"119","ans":[]},{"topicId":"120","ans":[]}]', 'true', 3, '2013-07-03 04:51:27', '7994a3e994c38939eadd5941ec0ee8a6', 2),
(70, '[{"topicId":"107","ans":[]},{"topicId":"108","ans":[]},{"topicId":"109","ans":[]},{"topicId":"113","ans":[]},{"topicId":"121","ans":[]},{"topicId":"122","ans":[]},{"topicId":"123","ans":[]}]', 'true', 55, '2013-07-03 04:51:29', '7994a3e994c38939eadd5941ec0ee8a6', 3),
(71, '[{"topicId":"107","ans":["116"]},{"topicId":"108","ans":["120","122"]},{"topicId":"109","ans":["124"]},{"topicId":"113","ans":["137"]},{"topicId":"121","ans":["154"]},{"topicId":"122","ans":["157"]},{"topicId":"123","ans":["159"]}]', 'true', 20, '2013-07-03 05:00:33', '7994a3e994c38939eadd5941ec0ee8a6', 5),
(72, '[{"topicId":"107","ans":["116"]},{"topicId":"108","ans":["120","122"]},{"topicId":"109","ans":["126"]},{"topicId":"113","ans":["139"]},{"topicId":"121","ans":["154"]},{"topicId":"122","ans":[]},{"topicId":"123","ans":[]}]', 'true', 12, '2013-07-12 07:43:22', '7994a3e994c38939eadd5941ec0ee8a6', 1),
(74, '[{"topicId":"125","ans":["+"]},{"topicId":"126","ans":["+","+"]}]', 'true', 11, '2013-07-12 09:30:33', 'c624a7ea37b73a7ad1d413d8a8a0fa6a', 1),
(75, '[{"topicId":"107","ans":["116"]},{"topicId":"108","ans":[]}]', 'false', 3, '2013-07-12 08:15:48', '7994a3e994c38939eadd5941ec0ee8a6', 1);

-- --------------------------------------------------------

--
-- 表的結構 `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, '台中市');

-- --------------------------------------------------------

--
-- 表的結構 `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `grade` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_school1` (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `class`
--

INSERT INTO `class` (`id`, `type`, `grade`, `name`, `school_id`) VALUES
(1, '大學', '一', '1', 1);

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
-- 表的結構 `km`
--

CREATE TABLE IF NOT EXISTS `km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL DEFAULT '1',
  `subject_id` int(11) NOT NULL DEFAULT '1',
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 轉存資料表中的資料 `km`
--

INSERT INTO `km` (`id`, `t_id`, `subject_id`, `grade`) VALUES
(1, 3, 1, 5),
(3, 3, 2, 12),
(4, 3, 1, 1),
(5, 3, 2, 11),
(6, 1, 2, 1);

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

--
-- 轉存資料表中的資料 `links`
--

INSERT INTO `links` (`id`, `node_from`, `node_to`, `width`, `x`, `y`, `z`, `is_child`, `type`, `level`, `lid`, `km_id`) VALUES
(109, 1, 2, 199, 916, 429, 8.942753948409715, '1', 'chLine', 0, 1, 1),
(110, 2, 3, 162, 785, 350, 51.505626645683684, '1', 'chLine', 0, 2, 1),
(111, 3, 4, 247, 786, 206, 139.09728360520828, '1', 'chLine', 0, 3, 1),
(112, 4, 5, 396, 608, 146, -6.228441969363445, '0', 'line', 0, 4, 1),
(113, 6, 5, 427, 247, 322, 133.86182299251183, '0', 'line', 0, 5, 1),
(114, 7, 6, 170, 236, 560, 84.59166784252466, '1', 'chLine', 0, 6, 1),
(115, 8, 6, 209, 140, 555, 130.92818610569236, '1', 'chLine', 0, 7, 1),
(116, 9, 5, 302, 506, 311, 71.26507601477408, '1', 'chLine', 0, 8, 1),
(117, 10, 9, 250, 469, 511, 152.92339295633496, '1', 'chLine', 0, 9, 1),
(118, 9, 11, 254, 516, 564, -60.31098975264578, '1', 'chLine', 0, 10, 1),
(119, 9, 12, 238, 600, 572, -96.26057746711756, '1', 'chLine', 0, 11, 1),
(120, 9, 13, 272, 670, 546, -137.23117460803127, '1', 'chLine', 0, 12, 1),
(123, 16, 15, 412, 270, 378, 150.01372954649273, '0', 'line', 1, 14, 1);

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

--
-- 轉存資料表中的資料 `nodes`
--

INSERT INTO `nodes` (`id`, `uuid`, `name`, `x`, `y`, `lid`, `ch_lid`, `pid`, `type`, `level`, `km_id`, `rule`, `lock`, `open_answer`, `limit_time`, `media`) VALUES
(265, '7994a3e994c38939eadd5941ec0ee8a6', '加法', 1048, 238, '', '0', 0, 'point', 0, 1, NULL, 'unlock', 'open', 0, 'NEdyRGXyYpk'),
(266, 'bffddf84b653ecc600c1695efb8a5939', '減法', 1089, 420, '', '0,1', 1, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(267, 'c624a7ea37b73a7ad1d413d8a8a0fa6a', '乘法', 892, 389, '', '1,2', 2, 'point', 0, 1, NULL, 'unlock', 'open', 0, ''),
(268, '531024b1286a8acac5d35c289140b2c1', '除法', 791, 262, '', '2,3', 3, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(269, '912a2246dc92d18365e6b6fdfcb8531c', '四則運算', 978, 100, '4', '3', 4, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(270, 'b320e3f07f21b80cc6f874a7e55621bc', '分數運算', 584, 143, '4,5,14', '8', 5, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(271, 'f7bcdfd20cc06f0b57524364f89f2f99', '微積分', 288, 451, '5', '6,7', 6, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(272, '9cdc58eae84942876336eb0b5352d809', '微分', 304, 620, '', '6', 7, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(273, 'ab12c382837cb66fb6ef9d948c4540fa', '積分', 151, 609, '', '7', 8, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(274, '3e4314ff9d89bd5f26717002f14b7ad9', '帶分數與假分數的轉換', 681, 429, '', '8,9,10,11,12', 9, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(275, 'c812aa132587aaed4ae940f6e4bcb7c0', '帶分數乘法', 458, 543, '', '9', 10, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(276, 'b237764bb402ea1c3071a5a711d6d3e5', '比較假分數和帶分數', 555, 650, '', '10', 11, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(277, '8b2a01592deb816ab74bf65809606ee9', '帶分數的加法與減法', 707, 666, '', '11', 12, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(278, 'a0a2172e536bf7b22547f5abb3c4e847', '數線上的分數', 881, 614, '', '12', 13, 'point', 0, 1, NULL, 'lock', 'close', 0, ''),
(283, '2392d9ffda6e89f215381098d637c5c2', '分數', 611, 230, '14', '', 15, 'point', 1, 1, NULL, 'lock', 'close', 0, ''),
(284, '158780cd3517a6d11c530f8985b4a9ea', '微積分', 253, 436, '14', '', 16, 'point', 1, 1, NULL, 'unlock', 'close', 0, '');

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

--
-- 轉存資料表中的資料 `options`
--

INSERT INTO `options` (`id`, `value`, `correct`, `questions_id`) VALUES
(116, '2', 'true', 107),
(117, '3', 'false', 107),
(118, '11', 'false', 107),
(119, '5', 'false', 108),
(120, '15', 'true', 108),
(121, '10', 'false', 108),
(122, '15', 'true', 108),
(123, '13', 'false', 109),
(124, '12', 'true', 109),
(125, '11', 'false', 109),
(126, '10', 'false', 109),
(127, '1', 'false', 110),
(128, '2', 'true', 110),
(129, '3', 'false', 110),
(130, '5', 'false', 111),
(133, '8', 'true', 111),
(134, '7', 'false', 112),
(135, '8', 'true', 112),
(136, '9', 'false', 112),
(137, '10', 'true', 113),
(138, '11', 'false', 113),
(139, '12', 'false', 113),
(141, '6', 'false', 111),
(154, '2121', 'true', 121),
(155, '121', 'false', 121),
(156, '<p><iframe src="http://www.youtube.com/embed/BqKCPszx6mY" width="425" height="350"></iframe></p>', 'false', 121),
(157, '123', 'true', 122),
(158, '<p><iframe src="http://www.youtube.com/embed/MpEPRqV9SSQ" width="425" height="350"></iframe></p>', 'true', 123),
(159, '<p><img src="http://likecool.com/Gear/Pic/One%20Trippy%20Profile%20Pic/One-Trippy-Profile-Pic.jpg" alt="" /></p>', 'false', 123);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=127 ;

--
-- 轉存資料表中的資料 `questions`
--

INSERT INTO `questions` (`id`, `topic`, `type`, `media_url`, `tips`, `score`, `public`, `nodes_uuid`) VALUES
(107, '1 + 1 = ?	', 'choose', 'http://www.youtube.com/watch?v=8OS2tXpZ7cA', '["步驟1"]', 2000, 'true', '7994a3e994c38939eadd5941ec0ee8a6'),
(108, '10+5=?		', 'multi_choose', '', '["超過兩位數","低於20"]', 2000, 'true', '7994a3e994c38939eadd5941ec0ee8a6'),
(109, '5+7', 'choose', '', '[]', 2000, 'true', '7994a3e994c38939eadd5941ec0ee8a6'),
(110, '9-7', 'choose', '', '[]', 500, 'true', 'bffddf84b653ecc600c1695efb8a5939'),
(111, '13-5', 'choose', '', '[]', 500, 'true', 'bffddf84b653ecc600c1695efb8a5939'),
(112, '1*2*4', 'choose', '', '[]', 3000, 'false', 'c624a7ea37b73a7ad1d413d8a8a0fa6a'),
(113, '1+9', 'choose', '', '[]', 2000, 'true', '7994a3e994c38939eadd5941ec0ee8a6'),
(121, '<p><span style="font-size: 24pt;"><strong>gdfgdfgg</strong></span></p>\n<p><span style="font-size: 24pt;"><strong><iframe src="http://www.youtube.com/embed/BqKCPszx6mY" width="425" height="350"></iframe></strong></span></p>', 'choose', 'http://www.youtube.com/watch?v=BqKCPszx6mY', '["123","2121","<p>231</p>\\n<p><iframe src=\\"http://www.youtube.com/embed/BqKCPszx6mY\\" width=\\"425\\" height=\\"350\\"></iframe></p>"]', 2000, 'true', '7994a3e994c38939eadd5941ec0ee8a6'),
(122, '<p><iframe src="http://www.youtube.com/embed/MpEPRqV9SSQ" width="425" height="350"></iframe></p>', 'choose', '', '["<p><img src=\\"http://likecool.com/Gear/Pic/One%20Trippy%20Profile%20Pic/One-Trippy-Profile-Pic.jpg\\" alt=\\"\\" width=\\"384\\" height=\\"399\\" /></p>"]', 0, 'true', '7994a3e994c38939eadd5941ec0ee8a6'),
(123, '', 'choose', '', '[]', 0, 'true', '7994a3e994c38939eadd5941ec0ee8a6'),
(125, '<p>1<label class=''stuffbox''>X</label>1=1</p>', 'fill', '', '[]', 3000, 'true', 'c624a7ea37b73a7ad1d413d8a8a0fa6a'),
(126, '<p>1<label class=''stuffbox''>+</label>4<label class=''stuffbox''>+</label>3=8</p>', 'fill', '', '[]', 3000, 'true', 'c624a7ea37b73a7ad1d413d8a8a0fa6a');

-- --------------------------------------------------------

--
-- 表的結構 `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_school_city1` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `school`
--

INSERT INTO `school` (`id`, `type`, `name`, `address`, `phone`, `city_id`) VALUES
(1, '國立大學', '國立臺中教育大學', '', '', 1);

-- --------------------------------------------------------

--
-- 表的結構 `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `subject`
--

INSERT INTO `subject` (`id`, `subject`) VALUES
(1, '數學'),
(2, '微積分');

-- --------------------------------------------------------

--
-- 表的結構 `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `rank` varchar(45) NOT NULL,
  `birthday` date DEFAULT NULL,
  `ic_number` varchar(10) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `unit_id` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `usercol_UNIQUE` (`ic_number`),
  KEY `fk_user_unit` (`unit_id`),
  KEY `fk_user_class1` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 轉存資料表中的資料 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `sex`, `rank`, `birthday`, `ic_number`, `phone`, `tel`, `address`, `email`, `unit_id`, `class_id`) VALUES
(1, 'admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', '管理員', '0', '0', '0000-00-00', '', '', '', '', '', 0, 0),
(2, 's', '*16863C23B2E91537AEAEDDE9D1B40DA2A975C5DC', '我是學生', '0', '3', '1999-01-01', 'A123456789', '0912345678', '04-2226666', 'somewhere', 'aaa@aaa.com', 0, 1),
(3, 't', '*2D8EF61A814C7AEC5FE0446292E7AA6CC39B868D', '我是老師', '0', '2', '1985-01-01', 'B945678125', '0934567890', '04-3334444', 'aaa', 'bbb@yam.com', 0, 1),
(5, 'tt', '*8A4C0190D23732FF96AA783D5D7B1AD95A0FA6DE', '我是老師2', '0', '2', '0000-00-00', '11', '11', '11', '11', '11', 0, 1);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
