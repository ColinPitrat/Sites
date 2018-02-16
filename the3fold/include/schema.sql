--
-- Base de données: `the3fold`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `question` varchar(255) collate latin1_general_ci NOT NULL default '',
  `answer` varchar(20) collate latin1_general_ci NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=39 ;


CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `subject` varchar(80) collate latin1_general_ci NOT NULL default '',
  `name` varchar(80) collate latin1_general_ci NOT NULL default '',
  `date` varchar(20) collate latin1_general_ci NOT NULL default '',
  `texte` longtext collate latin1_general_ci NOT NULL,
  `captcha` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=25 ;


CREATE TABLE IF NOT EXISTS `forummessages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `auteur` varchar(20) collate latin1_general_ci NOT NULL default '',
  `message` text collate latin1_general_ci NOT NULL,
  `thread` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=153 ;


CREATE TABLE IF NOT EXISTS `forumsalons` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `nom` varchar(255) collate latin1_general_ci NOT NULL default '',
  `img` varchar(255) collate latin1_general_ci NOT NULL default './images/t3f.png',
  `date` varchar(20) collate latin1_general_ci NOT NULL default '',
  `lvl` tinyint(4) NOT NULL default '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=28 ;


CREATE TABLE IF NOT EXISTS `forumthreads` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nom` varchar(255) collate latin1_general_ci NOT NULL default '',
  `auteur` varchar(20) collate latin1_general_ci NOT NULL default '',
  `date` varchar(20) collate latin1_general_ci NOT NULL default '',
  `salon` smallint(5) unsigned NOT NULL default '0',
  `epingle` tinyint(3) unsigned NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=52 ;


CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `titre` varchar(255) collate latin1_general_ci NOT NULL default '',
  `auteur` varchar(20) collate latin1_general_ci NOT NULL default '',
  `texte` text collate latin1_general_ci NOT NULL,
  `datedebut` varchar(10) collate latin1_general_ci NOT NULL default '',
  `datefin` varchar(10) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=15 ;


CREATE TABLE IF NOT EXISTS `users` (
  `nick` varchar(20) collate latin1_general_ci default NULL,
  `password` varchar(32) collate latin1_general_ci default NULL,
  `skin` varchar(80) collate latin1_general_ci default NULL,
  `level` tinyint(4) default '1',
  UNIQUE KEY `nick` (`nick`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

