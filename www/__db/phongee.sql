-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 31, 2013 at 05:49 PM
-- Server version: 5.6.14
-- PHP Version: 5.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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
  `pgcreateuser_id` int(11) NOT NULL,
  `pgthietbi_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pgcode_2` (`pgcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pgchitietthietbi`
--

INSERT INTO `pgchitietthietbi` (`id`, `pgcreate`, `pgthietbi_id`, `pglong_name`, `pgcode`, `pgpic`, `pgshort_info`, `pglong_info`, `pgtech_info`, `pgprice`, `pgprice_old`, `pgdeleted`, `pgyear`, `pgcolor`, `pgcountry`, `pgcreateuser_id`, `pgthietbi_code`) VALUES
(1, '2013-12-26 21:58:11', 1, 'Iphone 4', 'ip41', '0ab6a7ce01267426b4c341e1bf78e5d5.jpg', '111', '<p>222</p>\n', '<p>333</p>\n', 12000000, 14, 0, 2010, 'đỏ', 'mỹ', 1, 'ip4'),
(2, '2013-12-27 11:11:20', 3, 'bulong', 'bl1', '', '', '', '', 0, 0, 0, 0, '', 'my', 1, NULL),
(3, '2013-12-27 11:13:09', 3, 'bulong', 'bl2', '', '', '', '', 0, 0, 0, 0, '', 'my', 1, NULL),
(4, '2013-12-27 11:13:14', 3, 'bulong', '12121212e3w', '', '', '', '', 0, 0, 0, 0, '', 'my', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pginout`
--

CREATE TABLE IF NOT EXISTS `pginout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pgdate` int(11) NOT NULL,
  `pgcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgtype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgfrom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgxuattype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgdeleted` int(11) NOT NULL,
  `pgstatus` int(11) NOT NULL,
  `pgcreateuser_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pgcode` (`pgcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pginout`
--

INSERT INTO `pginout` (`id`, `pgcreate`, `pgdate`, `pgcode`, `pgtype`, `pgfrom`, `pgto`, `pgxuattype`, `pgdeleted`, `pgstatus`, `pgcreateuser_id`) VALUES
(1, '2013-12-31 04:54:39', 1388455200, 'hd1', 'nhap', '8', '2', '', 0, 0, 1),
(2, '2013-12-31 04:55:45', 1388458800, 'xdh1', 'xuat', '2', '1', 'cuahang', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pginout_details`
--

CREATE TABLE IF NOT EXISTS `pginout_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pgdeleted` int(11) NOT NULL,
  `pginout_id` int(11) NOT NULL,
  `pgseries` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgthietbi_id` int(11) NOT NULL,
  `pgthietbi_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgprice` int(11) NOT NULL,
  `pgcount` int(11) NOT NULL,
  `pgcolor` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgyear` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pgcountry` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgstatus` int(11) NOT NULL,
  `pgfrom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgcreateuser_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pginout_details`
--

INSERT INTO `pginout_details` (`id`, `pgcreate`, `pgdeleted`, `pginout_id`, `pgseries`, `pgthietbi_id`, `pgthietbi_code`, `pgprice`, `pgcount`, `pgcolor`, `pgyear`, `pgcountry`, `pgstatus`, `pgfrom`, `pgto`, `pgcreateuser_id`) VALUES
(1, '2013-12-31 04:54:55', 0, 1, 'ip41', 1, 'ip4', 13000000, 1, 'đỏ', '2010', 'mỹ', 0, '7', '2', 1),
(5, '2013-12-31 05:16:32', 0, 2, 'ip41', 1, 'ip4', 12000002, 1, 'đỏ', '2010', 'mỹ', 0, '2', '2', 1),
(6, '2013-12-31 08:07:37', 0, 1, 'bl1', 2, '', 120000, 10, 'trang', '2013', 'my', 0, '7', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pgmoneytransfer`
--

CREATE TABLE IF NOT EXISTS `pgmoneytransfer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pgtype` varchar(20) NOT NULL DEFAULT '',
  `pgamount` int(11) NOT NULL,
  `pgcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pgdeleted` int(11) NOT NULL,
  `pgcreateuser_id` int(11) NOT NULL,
  `pginout_id` int(11) NOT NULL,
  `pgdate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pgmoneytransfer`
--

INSERT INTO `pgmoneytransfer` (`id`, `pgtype`, `pgamount`, `pgcreate`, `pgdeleted`, `pgcreateuser_id`, `pginout_id`, `pgdate`) VALUES
(2, 'xuat', 1000000, '2013-12-31 10:27:20', 0, 1, 2, 0),
(3, 'xuat', 2000000, '2013-12-31 10:30:22', 0, 1, 2, 0);

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
  `pgcreateuser_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pgnhomthietbi`
--

INSERT INTO `pgnhomthietbi` (`id`, `pglong_name`, `pgurl`, `pgcode`, `pgdeleted`, `pgorder`, `pgcreateuser_id`) VALUES
(1, 'Điện thoại', '', 'dt', 0, 12, 0),
(2, 'Laptop', '', 'lt', 0, 2, 0);

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
  `pgcreateuser_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pgcode` (`pgcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pgstore`
--

INSERT INTO `pgstore` (`id`, `pgcode`, `pglong_name`, `pgaddr`, `pgdeleted`, `pgorder`, `pgcreateuser_id`) VALUES
(1, 'q14', 'mac dinh chi4', 'mdc444', 0, 3, 0),
(2, 'tk', 'tong kho', '', 0, 1, 0);

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
  `pgyear` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pgcolor` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pgcountry` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pgtype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pgtype_pk` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pgcreateuser_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pgcode` (`pgcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pgthietbi`
--

INSERT INTO `pgthietbi` (`id`, `pgcreate`, `pgnhomthietbi_id`, `pglong_name`, `pgcode`, `pgpic`, `pgshort_info`, `pglong_info`, `pgtech_info`, `pgprice`, `pgprice_old`, `pgdeleted`, `pgyear`, `pgcolor`, `pgcountry`, `pgtype`, `pgtype_pk`, `pgcreateuser_id`) VALUES
(1, '2013-12-26 21:27:35', 1, 'Iphone 4', 'ip4', '0ab6a7ce01267426b4c341e1bf78e5d5.jpg', '111', '<p>222</p>\n', '<p>333</p>\n', 12000000, 14, 0, '2010,2011,2012,2013', 'đỏ, xám, trắng, đen, nau', 'mỹ, trung quốc , han', 'thietbi', '', 0),
(2, '2013-12-27 05:12:36', 1, 'tai nghe', 'tnip4', '', '', '', '', 200000, 300000, 0, '2013', 'trang', 'my', 'phukien', 'ban', 0),
(3, '2013-12-27 05:19:57', 1, 'bulong', 'bl', '', '', '', '', 0, 0, 0, '', '', 'my', 'phukien', 'suachua', 0);

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
  `pgrole` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'member',
  `pgdeleted` tinyint(4) NOT NULL,
  `pgedit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pgcreate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pgmobi` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pgemail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pgaddr` text COLLATE utf8_unicode_ci NOT NULL,
  `pgstore_id` int(11) NOT NULL DEFAULT '0',
  `pgcreateuser_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dausername` (`pgusername`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `pguser`
--

INSERT INTO `pguser` (`id`, `pgfname`, `pglname`, `pgusername`, `pgpassword`, `pgavatar`, `pgrole`, `pgdeleted`, `pgedit`, `pgcreate`, `pgmobi`, `pgemail`, `pgaddr`, `pgstore_id`, `pgcreateuser_id`) VALUES
(1, 'Quản Trị', 'Viên', 'root', '57f231b1ec41dc6641270cb09a56f897', '22beb1b8f43f74770f57fd80bd8167c7.png', 'admin', 0, '2013-12-27 19:55:46', '2013-12-26 19:06:41', '0123e', 'qưeqưeqư', 'eee', 1, 0),
(5, 'Kế Toán Trưởng', '', 'ketoantruong', '57f231b1ec41dc6641270cb09a56f897', '', 'ketoantruong', 0, '2013-12-28 02:45:01', '0000-00-00 00:00:00', '', '', '', 0, 0),
(6, 'Kế toán cửa hàng', '', 'ketoan', '57f231b1ec41dc6641270cb09a56f897', '', 'ketoan', 0, '2013-12-28 02:44:14', '0000-00-00 00:00:00', '', '', '', 1, 0),
(7, 'Nha cc A', '', 'cca', '', '', 'provider', 0, '2013-12-30 06:30:11', '0000-00-00 00:00:00', '', '', '', 0, 0),
(8, 'Nha cc B', '', 'ccb', '', '', 'provider', 0, '2013-12-30 06:30:01', '0000-00-00 00:00:00', '', '', '', 0, 0),
(9, 'Khach hang 1', '', 'kh1', '', '', 'custom', 0, '2013-12-31 03:16:41', '0000-00-00 00:00:00', '', '', '', 0, 1),
(10, 'Khach hang 2', '', 'kh2', '', '', 'custom', 0, '2013-12-31 03:16:49', '0000-00-00 00:00:00', '', '', '', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
