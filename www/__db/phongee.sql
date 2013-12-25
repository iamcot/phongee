-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 26, 2013 at 01:43 AM
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
-- Table structure for table `pgnhomthietbi`
--

CREATE TABLE IF NOT EXISTS `pgnhomthietbi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgtitle` varchar(50) NOT NULL,
  `pgurl` varchar(50) NOT NULL,
  `pgcode` varchar(20) NOT NULL,
  `pgdelete` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pgnhomthietbi`
--


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
  PRIMARY KEY (`id`),
  UNIQUE KEY `dausername` (`pgusername`),
  UNIQUE KEY `daemail` (`pgemail`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pguser`
--

INSERT INTO `pguser` (`id`, `pgfname`, `pglname`, `pgusername`, `pgpassword`, `pgavatar`, `pgrole`, `pgdeleted`, `pgedit`, `pgcreate`, `pgmobi`, `pgemail`, `pgaddr`) VALUES
(1, 'root', '', 'root', '57f231b1ec41dc6641270cb09a56f897', '', 'admin', 0, '2013-12-26 01:25:56', '0000-00-00 00:00:00', '', '', '');
