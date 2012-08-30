-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: 62.149.150.66
-- Generato il: Ago 30, 2012 alle 21:52
-- Versione del server: 5.0.92
-- Versione PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Sql125733_3`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `tds`
--

CREATE TABLE IF NOT EXISTS `tds` (
  `id` int(11) NOT NULL auto_increment,
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
  `request` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `invite` (`invite`,`confirm`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
