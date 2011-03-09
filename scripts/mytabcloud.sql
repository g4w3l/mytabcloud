-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 09 Mars 2011 à 19:20
-- Version du serveur: 5.1.53
-- Version de PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `mytabcloud`
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
  `tab_content` longtext NOT NULL,
  `tab_user` int(11) NOT NULL,
  PRIMARY KEY (`tab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login` (`usr_login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `mtc_user`
--

INSERT INTO `mtc_user` (`usr_id`, `usr_login`, `usr_mail`, `usr_password`, `usr_name`, `usr_created`) VALUES
(6, 'gawel', 'gawel.net@gmail.com', '61b52106cccc0ec9c8c1681a8db0fbb8', 'Gawel', '2011-03-07 00:00:00'),
(7, 'monin', 'test@test.fr', '05a671c66aefea124cc08b76ea6d30bb', 'Test', '2011-03-08 13:31:53');
