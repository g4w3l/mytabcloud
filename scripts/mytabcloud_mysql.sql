-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 14 Mars 2011 à 09:28
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mytabcloud`
--

-- --------------------------------------------------------

--
-- Structure de la table `mtc_action`
--

CREATE TABLE IF NOT EXISTS `mtc_action` (
  `act_id` int(11) NOT NULL,
  `act_user` int(11) NOT NULL,
  `act_action` varchar(20) NOT NULL,
  `act_type` varchar(20) NOT NULL,
  `act_resource` int(11) NOT NULL,
  `act_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `mtc_action`
--


-- --------------------------------------------------------

--
-- Structure de la table `mtc_note`
--

CREATE TABLE IF NOT EXISTS `mtc_note` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note_string` int(11) NOT NULL,
  `note_fret` int(11) NOT NULL,
  `note_beat` int(11) DEFAULT NULL,
  `note_tab` int(11) DEFAULT NULL,
  PRIMARY KEY (`note_id`),
  KEY `note_tab` (`note_tab`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `mtc_note`
--


-- --------------------------------------------------------

--
-- Structure de la table `mtc_tab`
--

CREATE TABLE IF NOT EXISTS `mtc_tab` (
  `tab_id` int(11) NOT NULL AUTO_INCREMENT,
  `tab_artist` varchar(100) DEFAULT NULL,
  `tab_title` varchar(100) DEFAULT NULL,
  `tab_nb_strings` int(11) NOT NULL DEFAULT '6',
  `tab_user` int(11) NOT NULL,
  `tab_created` datetime NOT NULL,
  PRIMARY KEY (`tab_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `mtc_tab`
--


-- --------------------------------------------------------

--
-- Structure de la table `mtc_user`
--

CREATE TABLE IF NOT EXISTS `mtc_user` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(50) NOT NULL,
  `usr_mail` varchar(100) NOT NULL,
  `usr_password` varchar(32) DEFAULT NULL,
  `usr_name` varchar(50) DEFAULT NULL,
  `usr_created` datetime DEFAULT NULL,
  `usr_role` varchar(50) NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login` (`usr_login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `mtc_user`
--

INSERT INTO `mtc_user` (`usr_id`, `usr_login`, `usr_mail`, `usr_password`, `usr_name`, `usr_created`, `usr_role`) VALUES
(7, 'gawel', 'gawel.net@gmail.com', '61b52106cccc0ec9c8c1681a8db0fbb8', 'Gawel', '2011-03-08 08:36:51', '');
