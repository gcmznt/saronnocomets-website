-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2012 at 10:47 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stbc`
--

-- --------------------------------------------------------

--
-- Table structure for table `tds`
--

CREATE TABLE `tds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team` varchar(50) NOT NULL,
  `tournament` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `invite` varchar(50) NOT NULL,
  `responsible` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `saturnday` int(11) NOT NULL,
  `sunday` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `confirm` varchar(50) NOT NULL,
  `request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invite` (`invite`,`confirm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
