-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-07-25 17:24:51
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

create database if not exists bs;
use bs;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- 表的结构 `bs_kt_sel`
--

CREATE TABLE IF NOT EXISTS `bs_kt_sel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `k` text,
  `v` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `bs_kt_sel`
--



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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `sys_time`
--

CREATE TABLE IF NOT EXISTS `sys_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `k` text,
  `v` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

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
('telanx', '900150983cd24fb0d6963f7d28e17f72', b'1', '2015-07-25 21:52:39', '2015-07-05 10:20:07', '127.0.0.1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_student_pwd`
--

CREATE TABLE IF NOT EXISTS `user_student_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `pwd` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

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
  PRIMARY KEY (`user`(7))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_teacher_pwd`
--

CREATE TABLE IF NOT EXISTS `user_teacher_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `pwd` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
