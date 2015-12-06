-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-12-06 08:50:59
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bs`
--

-- --------------------------------------------------------

--
-- 表的结构 `bs_kt`
--

CREATE TABLE IF NOT EXISTS `bs_kt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` tinytext NOT NULL,
  `way` tinytext NOT NULL,
  `origin` text NOT NULL,
  `require` text NOT NULL,
  `content` text NOT NULL,
  `goal` text NOT NULL,
  `snum` tinyint(4) NOT NULL,
  `bsnum` tinyint(4) DEFAULT NULL,
  `fee` float DEFAULT NULL,
  `env` text NOT NULL,
  `reference` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `teacher` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `bs_kt`
--

INSERT INTO `bs_kt` (`id`, `name`, `type`, `way`, `origin`, `require`, `content`, `goal`, `snum`, `bsnum`, `fee`, `env`, `reference`, `status`, `teacher`) VALUES
(1, '基于Web的毕业设计管理系统', '自选', '结合科研', '来源于实际情况', '基于Web的毕业设计管理系统', 'PHP,ThinkPHP', '符合实际要求即可', 1, 1, 0, '无', '无', 3, '2011367'),
(2, 'LOL模型建立', '科研', '测试类型3', '英雄联盟修改', '无修改修改', '我修改', '无修改', 1, 12, 12, '12', '12', 3, '2011367'),
(3, '测试课题', '我类个去', '自选课题', '无', '无', '无', '无', 1, 1, 121, '1', '1', 0, '2011367');

-- --------------------------------------------------------

--
-- 表的结构 `bs_kt_old`
--

CREATE TABLE IF NOT EXISTS `bs_kt_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` tinytext NOT NULL,
  `way` tinytext NOT NULL,
  `origin` text NOT NULL,
  `require` text NOT NULL,
  `content` text NOT NULL,
  `goal` text NOT NULL,
  `snum` tinyint(4) NOT NULL,
  `bsnum` tinyint(4) DEFAULT NULL,
  `fee` float DEFAULT NULL,
  `env` text NOT NULL,
  `reference` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `teacher` tinytext NOT NULL,
  `year` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `bs_kt_sel`
--

CREATE TABLE IF NOT EXISTS `bs_kt_sel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `k` text,
  `v` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `bs_kt_sel`
--

INSERT INTO `bs_kt_sel` (`id`, `k`, `v`) VALUES
(1, 'class', '["\\u8ba1\\u79d1\\u4e00\\u73ed","\\u8ba1\\u79d1\\u4e8c\\u73ed"]'),
(2, 'dep', '["\\u8ba1\\u7b97\\u6240","\\u5e76\\u884c\\u6240"]'),
(3, 'bstype', '["\\u81ea\\u9009","\\u79d1\\u7814","\\u6211\\u7c7b\\u4e2a\\u53bb"]'),
(4, 'bsway', '["\\u7ed3\\u5408\\u79d1\\u7814","\\u81ea\\u9009\\u8bfe\\u9898","\\u6d4b\\u8bd5\\u7c7b\\u578b3"]');

-- --------------------------------------------------------

--
-- 表的结构 `bs_student_log`
--

CREATE TABLE IF NOT EXISTS `bs_student_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `bs_student_log`
--

INSERT INTO `bs_student_log` (`id`, `user`, `content`) VALUES
(1, 'U201114175', '[]');

-- --------------------------------------------------------

--
-- 表的结构 `bs_student_log_old`
--

CREATE TABLE IF NOT EXISTS `bs_student_log_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `content` text,
  `year` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `bs_xt`
--

CREATE TABLE IF NOT EXISTS `bs_xt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `sid` char(255) NOT NULL,
  `time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sid` (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `bs_xt`
--

INSERT INTO `bs_xt` (`id`, `bid`, `sid`, `time`) VALUES
(2, 1, 'U201114175', '2015-12-06 02:45:43');

-- --------------------------------------------------------

--
-- 表的结构 `bs_xt_old`
--

CREATE TABLE IF NOT EXISTS `bs_xt_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `sid` text NOT NULL,
  `time` datetime DEFAULT NULL,
  `year` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `home_doc`
--

CREATE TABLE IF NOT EXISTS `home_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `publishtime` datetime DEFAULT NULL,
  `fileurl` text,
  `type` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `home_doc`
--

INSERT INTO `home_doc` (`id`, `title`, `publishtime`, `fileurl`, `type`) VALUES
(1, 'Python%E5%9F%BA%E7%A1%80%E6%95%99%E7%A8%8B.py', '2015-12-03 00:00:00', 'upload/doc/20151203_b3b372b36f11e3b61261cea88bf17bad.py', 'py'),
(2, '%E7%A4%BA%E4%BE%8B%E6%96%87%E4%BB%B6', '2015-12-03 00:00:00', 'upload/doc/20151203_4a73f6ecb55b7515c13de9ecb41a1a8f.txt', 'txt');

-- --------------------------------------------------------

--
-- 表的结构 `home_link`
--

CREATE TABLE IF NOT EXISTS `home_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `linkurl` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `home_link`
--

INSERT INTO `home_link` (`id`, `title`, `linkurl`) VALUES
(1, '百度', 'http://www.baidu.com');

-- --------------------------------------------------------

--
-- 表的结构 `home_news`
--

CREATE TABLE IF NOT EXISTS `home_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `author` tinytext NOT NULL,
  `publishtime` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `home_news`
--

INSERT INTO `home_news` (`id`, `title`, `author`, `publishtime`, `content`) VALUES
(1, '选题时间更改通知', 'telanx', '2015-12-03 18:44:15', '毕业设计选题时间更新了！选题开始时间为2015/12/18 00:00，截止时间为2015/12/25 18:44。选题日期截止后将无法进行选题或退选！'),
(2, '选题时间更改通知', 'telanx', '2015-12-05 21:41:47', '毕业设计选题时间更新了！课题填报时间为2015-12-25 18:44:00~2015-12-04 21:41:00。选题开始时间为2015-12-18 00:00:00，截止时间为2015-12-01 21:41:00。选题日期截止后将无法进行选题或退选！'),
(3, '选题时间更改通知', 'telanx', '2015-12-05 21:44:22', '毕业设计选题时间更新了！课题填报时间为2015/12/01 21:44~2015-12-04 21:41:00。选题开始时间为2015-12-18 00:00:00，截止时间为2015-12-25 18:44:00。选题日期截止后将无法进行选题或退选！');

-- --------------------------------------------------------

--
-- 表的结构 `home_pic`
--

CREATE TABLE IF NOT EXISTS `home_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picurl` text NOT NULL,
  `linkurl` text,
  `des` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `home_plan`
--

CREATE TABLE IF NOT EXISTS `home_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ttime` text,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `home_plan`
--

INSERT INTO `home_plan` (`id`, `ttime`, `content`) VALUES
(1, '11-11', '天猫双十一'),
(2, '12-1', '选题'),
(3, '6-1', '课题答辩');

-- --------------------------------------------------------

--
-- 表的结构 `sys_time`
--

CREATE TABLE IF NOT EXISTS `sys_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `k` text,
  `v` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sys_time`
--

INSERT INTO `sys_time` (`id`, `k`, `v`) VALUES
(1, 'xt_start', '2015-12-03 02:45:00'),
(2, 'xt_end', '2015-12-16 02:45:00'),
(3, 'kt_start', '2015-12-03 22:26:00'),
(4, 'kt_end', '2015-12-04 22:26:00');

-- --------------------------------------------------------

--
-- 表的结构 `user_admin`
--

CREATE TABLE IF NOT EXISTS `user_admin` (
  `user` tinytext NOT NULL,
  `pwd` text,
  `status` bit(1) DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `createtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` text,
  PRIMARY KEY (`user`(6))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_admin`
--

INSERT INTO `user_admin` (`user`, `pwd`, `status`, `lastlogin`, `createtime`, `ip`) VALUES
('telanx', '900150983cd24fb0d6963f7d28e17f72', b'1', '2015-12-06 14:55:53', '2015-07-05 10:20:07', '::1');

-- --------------------------------------------------------

--
-- 表的结构 `user_student`
--

CREATE TABLE IF NOT EXISTS `user_student` (
  `user` text NOT NULL,
  `name` text,
  `class` text,
  `status` bit(1) DEFAULT NULL,
  `qq` text,
  `email` text,
  `cellphone` text,
  `pic` text,
  PRIMARY KEY (`user`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_student`
--

INSERT INTO `user_student` (`user`, `name`, `class`, `status`, `qq`, `email`, `cellphone`, `pic`) VALUES
('U201114113', '翟冬冬', '计科一班', b'1', NULL, NULL, NULL, NULL),
('U201114175', '叶明灵', '计科一班', b'1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user_student_old`
--

CREATE TABLE IF NOT EXISTS `user_student_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `name` text,
  `class` text,
  `status` bit(1) DEFAULT NULL,
  `qq` text,
  `email` text,
  `cellphone` text,
  `pic` text,
  `year` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_student_pwd`
--

CREATE TABLE IF NOT EXISTS `user_student_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `pwd` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user_student_pwd`
--

INSERT INTO `user_student_pwd` (`id`, `user`, `pwd`) VALUES
(1, 'U201114113', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'U201114175', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- 表的结构 `user_teacher`
--

CREATE TABLE IF NOT EXISTS `user_teacher` (
  `user` tinytext NOT NULL,
  `name` text,
  `dep` tinytext,
  `status` bit(1) DEFAULT NULL,
  `pic` text,
  `email` text,
  `qq` text,
  `cellphone` text,
  `officephone` text,
  `bsnum` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user`(7))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_teacher`
--

INSERT INTO `user_teacher` (`user`, `name`, `dep`, `status`, `pic`, `email`, `qq`, `cellphone`, `officephone`, `bsnum`, `type`) VALUES
('2011367', '王多强', '计算所', b'1', NULL, '123132123', '12132', '', '', 0, 3),
('2015001', '吴淞', '计算所', b'1', NULL, NULL, NULL, NULL, NULL, NULL, 1),
('2015002', '金海', '并行所', b'1', NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_teacher_old`
--

CREATE TABLE IF NOT EXISTS `user_teacher_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` tinytext NOT NULL,
  `name` text,
  `dep` tinytext,
  `status` bit(1) DEFAULT NULL,
  `pic` text,
  `email` text,
  `qq` text,
  `cellphone` text,
  `officephone` text,
  `bsnum` int(11) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_teacher_pwd`
--

CREATE TABLE IF NOT EXISTS `user_teacher_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `pwd` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user_teacher_pwd`
--

INSERT INTO `user_teacher_pwd` (`id`, `user`, `pwd`) VALUES
(1, '2011367', 'e10adc3949ba59abbe56e057f20f883e');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
