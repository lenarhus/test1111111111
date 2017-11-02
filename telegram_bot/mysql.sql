-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `sel_category`;
CREATE TABLE `sel_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `time` int(11) NOT NULL,
  `mesto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sel_keys`;
CREATE TABLE `sel_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` mediumtext,
  `id_cat` tinyint(4) NOT NULL,
  `id_subcat` tinyint(4) NOT NULL,
  `time` int(11) NOT NULL,
  `sale` tinyint(4) NOT NULL,
  `block` tinyint(4) NOT NULL,
  `block_user` int(11) NOT NULL,
  `block_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sel_orders`;
CREATE TABLE `sel_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_key` int(11) NOT NULL,
  `code` text,
  `chat` text,
  `id_subcat` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sel_qiwi`;
CREATE TABLE `sel_qiwi` (
  `iID` text,
  `sDate` text,
  `sTime` text,
  `dAmount` text,
  `iOpponentPhone` text,
  `sComment` text,
  `sStatus` text,
  `chat` text,
  `iAccount` text,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sel_set_bot`;
CREATE TABLE `sel_set_bot` (
  `token` text,
  `verification` int(11) NOT NULL,
  `block` int(11) NOT NULL,
  `proxy` text NOT NULL,
  `proxy_login` text NOT NULL,
  `proxy_pass` text NOT NULL,
  `url` text NOT NULL,
  `limits` int(11) NOT NULL,
  `on_off` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sel_set_bot` (`token`, `verification`, `block`, `proxy`, `proxy_login`, `proxy_pass`, `url`, `limits`, `on_off`) VALUES
('token',	60,	90,	'80.78.251.31:3129',	'',	'',	'http://site.ru',	2000,	'on');

DROP TABLE IF EXISTS `sel_set_qiwi`;
CREATE TABLE `sel_set_qiwi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `sel_set_qiwi` (`id`, `number`, `password`, `active`) VALUES
(1,	'777777',	'777',	1),
(2,	'777777',	'777',	0),
(3,	'777777',	'777',	0),
(4,	'777777',	'777',	0),
(5,	'777777',	'777',	0);

DROP TABLE IF EXISTS `sel_subcategory`;
CREATE TABLE `sel_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `amount` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `mesto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sel_users`;
CREATE TABLE `sel_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` text,
  `first_name` text,
  `last_name` text,
  `chat` text,
  `time` int(11) NOT NULL,
  `id_key` int(11) NOT NULL,
  `verification` int(11) NOT NULL,
  `pay_number` varchar(55) NOT NULL,
  `balans` int(11) NOT NULL,
  `ban` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2016-03-25 18:04:42
