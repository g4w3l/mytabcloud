-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 14 Mars 2011 à 21:15
-- Version du serveur: 5.1.53
-- Version de PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `mytabcloud`
--

-- --------------------------------------------------------

--
-- Structure de la table `mtc_action`
--

CREATE TABLE IF NOT EXISTS `mtc_action` (
  `act_id` int(11) NOT NULL AUTO_INCREMENT,
  `act_user` int(11) NOT NULL,
  `act_action` varchar(20) NOT NULL,
  `act_type` varchar(20) NOT NULL,
  `act_resource` int(11) NOT NULL,
  `act_timestamp` datetime NOT NULL,
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

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

