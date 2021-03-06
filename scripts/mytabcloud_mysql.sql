-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 14 Mars 2011 à 21:15
-- Version du serveur: 5.1.53
-- Version de PHP: 5.3.3
-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `mtc_action` (
  `act_id` int(11) NOT NULL AUTO_INCREMENT,
  `act_user` int(11) NOT NULL,
  `act_action` varchar(20) NOT NULL,
  `act_type` varchar(20) NOT NULL,
  `act_resource` int(11) NOT NULL,
  `act_timestamp` datetime NOT NULL,
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mtc_instrument` (
  `ins_id` int(11) NOT NULL AUTO_INCREMENT,
  `ins_name` varchar(50) NOT NULL,
  PRIMARY KEY (`ins_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mtc_note` (
  `note_string` int(11) NOT NULL,
  `note_fret` int(11) NOT NULL,
  `note_beat` int(11) NOT NULL DEFAULT '0',
  `note_tab` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_string`,`note_beat`,`note_tab`),
  KEY `note_tab` (`note_tab`),
  KEY `fk_note_tab` (`note_tab`),
  CONSTRAINT `fk_note_tab` FOREIGN KEY (`note_tab`) REFERENCES `mtc_tab` (`tab_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `mtc_tab` (
  `tab_id` int(11) NOT NULL AUTO_INCREMENT,
  `tab_artist` varchar(100) DEFAULT NULL,
  `tab_title` varchar(100) DEFAULT NULL,
  `tab_nb_strings` int(11) NOT NULL DEFAULT '6',
  `tab_capo` int(11) DEFAULT NULL,
  `tab_tuning` varchar(32) DEFAULT NULL,
  `tab_desc` text,
  `tab_instrument` int(11) DEFAULT NULL,
  `tab_user` int(11) NOT NULL,
  `tab_visibility` varchar(50) DEFAULT NULL,
  `tab_created` datetime NOT NULL,
  PRIMARY KEY (`tab_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mtc_tab_preset` (
  `pst_id` int(11) NOT NULL AUTO_INCREMENT,
  `pst_name` varchar(50) NOT NULL,
  `pst_nb_strings` int(11) NOT NULL,
  `pst_capo` int(11) NOT NULL,
  `pst_tuning` varchar(50) NOT NULL,
  PRIMARY KEY (`pst_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mtc_user` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(50) NOT NULL,
  `usr_mail` varchar(100) NOT NULL,
  `usr_password` varchar(32) DEFAULT NULL,
  `usr_name` varchar(50) DEFAULT NULL,
  `usr_location` varchar(100) DEFAULT NULL,
  `usr_created` datetime DEFAULT NULL,
  `usr_role` varchar(50) NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login` (`usr_login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mtc_friendship` (
  `fri_user_1` int(11) NOT NULL,
  `fri_user_2` int(11) NOT NULL,
  `fri_active` tinyint(1) NOT NULL,
  `fri_ask_date` datetime NOT NULL,
  PRIMARY KEY (`fri_user_2`,`fri_user_1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `mtc_group` (
  `gpe_id` INT NOT NULL AUTO_INCREMENT ,
  `gpe_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`gpe_id`) ,
  UNIQUE INDEX `gpe_name_UNIQUE` (`gpe_name` ASC)
);

CREATE TABLE IF NOT EXISTS `mtc_user_group` (
  `mug_user` INT NOT NULL ,
  `mug_group` INT NOT NULL ,
  PRIMARY KEY (`mug_user`, `mug_group`)
);

INSERT INTO `mtc_tab_preset` (`pst_id`, `pst_name`, `pst_nb_strings`, `pst_capo`, `pst_tuning`) VALUES
(1, 'Guitar Standard Tuning', 6, 0, 'E5|B4|G4|D4|A3|E3'),
(2, 'Ukulele C Tuning', 4, 0, 'A3|E3|C3|G3'),
(3, 'Bass Standard Tuning', 4, 0, 'G3|D3|A2|E2');

INSERT INTO `mtc_instrument` (`ins_id`, `ins_name`) VALUES
(1, 'Guitar'),
(2, 'Ukulele'),
(3, 'Bass');



