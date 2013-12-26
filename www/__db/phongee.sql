-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 27, 2013 at 05:34 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phongee`
--

-- --------------------------------------------------------

--
-- Table structure for table `pgchitietthietbi`
--

CREATE TABLE IF NOT EXISTS `pgchitietthietbi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pgthietbi_id` int(11) NOT NULL,
  `pglong_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgcode` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pgpic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgshort_info` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pglong_info` text COLLATE utf8_unicode_ci NOT NULL,
  `pgtech_info` text COLLATE utf8_unicode_ci NOT NULL,
  `pgprice` int(11) NOT NULL,
  `pgprice_old` int(11) NOT NULL,
  `pgdeleted` int(11) NOT NULL,
  `pgyear` int(11) NOT NULL,
  `pgcolor` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgcountry` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pgchitietthietbi`
--

INSERT INTO `pgchitietthietbi` (`id`, `pgcreate`, `pgthietbi_id`, `pglong_name`, `pgcode`, `pgpic`, `pgshort_info`, `pglong_info`, `pgtech_info`, `pgprice`, `pgprice_old`, `pgdeleted`, `pgyear`, `pgcolor`, `pgcountry`) VALUES
(1, '2013-12-27 04:58:11', 1, 'Iphone 4', '23423424234234', '0ab6a7ce01267426b4c341e1bf78e5d5.jpg', '111', '<p>222</p>\n', '<p>333</p>\n', 12000, 14, 0, 2009, 'do', 'my');

-- --------------------------------------------------------

--
-- Table structure for table `pgnhomthietbi`
--

CREATE TABLE IF NOT EXISTS `pgnhomthietbi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pglong_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pgurl` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pgcode` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pgdeleted` tinyint(4) NOT NULL,
  `pgorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pgnhomthietbi`
--

INSERT INTO `pgnhomthietbi` (`id`, `pglong_name`, `pgurl`, `pgcode`, `pgdeleted`, `pgorder`) VALUES
(1, 'Điện thoại', '', 'dt', 0, 12),
(2, 'Laptop', '', 'lt', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pgstore`
--

CREATE TABLE IF NOT EXISTS `pgstore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgcode` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pglong_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pgaddr` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pgdeleted` tinyint(4) NOT NULL,
  `pgorder` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pgcode` (`pgcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pgstore`
--

INSERT INTO `pgstore` (`id`, `pgcode`, `pglong_name`, `pgaddr`, `pgdeleted`, `pgorder`) VALUES
(1, 'q14', 'mac dinh chi4', 'mdc444', 0, 14);

-- --------------------------------------------------------

--
-- Table structure for table `pgthietbi`
--

CREATE TABLE IF NOT EXISTS `pgthietbi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pgnhomthietbi_id` int(11) NOT NULL,
  `pglong_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgpic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgshort_info` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pglong_info` text COLLATE utf8_unicode_ci NOT NULL,
  `pgtech_info` text COLLATE utf8_unicode_ci NOT NULL,
  `pgprice` int(11) NOT NULL,
  `pgprice_old` int(11) NOT NULL,
  `pgdeleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pgthietbi`
--

INSERT INTO `pgthietbi` (`id`, `pgcreate`, `pgnhomthietbi_id`, `pglong_name`, `pgcode`, `pgpic`, `pgshort_info`, `pglong_info`, `pgtech_info`, `pgprice`, `pgprice_old`, `pgdeleted`) VALUES
(1, '2013-12-27 04:27:35', 1, 'Iphone 4', 'ip4', '0ab6a7ce01267426b4c341e1bf78e5d5.jpg', '111', '222', '333', 12, 14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pguser`
--

CREATE TABLE IF NOT EXISTS `pguser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgfname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pglname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgusername` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgpassword` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgavatar` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgrole` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'member',
  `pgdeleted` tinyint(4) NOT NULL,
  `pgedit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pgcreate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pgmobi` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgemail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgaddr` text COLLATE utf8_unicode_ci NOT NULL,
  `pgstore_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dausername` (`pgusername`),
  UNIQUE KEY `daemail` (`pgemail`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pguser`
--

INSERT INTO `pguser` (`id`, `pgfname`, `pglname`, `pgusername`, `pgpassword`, `pgavatar`, `pgrole`, `pgdeleted`, `pgedit`, `pgcreate`, `pgmobi`, `pgemail`, `pgaddr`, `pgstore_id`) VALUES
(1, 'Quản Trị', 'Viên', 'root', '57f231b1ec41dc6641270cb09a56f897', '556e4e92769fd1a03e416dd399390de3.jpg', 'admin', 0, '2013-12-27 03:22:21', '2013-12-27 02:06:41', '0123e', 'qưeqưeqư', 'eee', 0);
