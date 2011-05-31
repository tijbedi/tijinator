/*
SQLyog Community- MySQL GUI v8.22 
MySQL - 5.0.51a-3ubuntu5.4 : Database - zuova
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `debate` */

DROP TABLE IF EXISTS `debate`;

CREATE TABLE `debate` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `question` varchar(255) NOT NULL,
  `creator` int(11) NOT NULL default '1',
  `opendate` date NOT NULL,
  `total_against` int(11) unsigned zerofill NOT NULL default '00000000000',
  `total_for` int(11) unsigned zerofill NOT NULL default '00000000000',
  `total_undecided` int(11) unsigned zerofill NOT NULL default '00000000000',
  `date_updated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL default '1',
  `date_created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '1',
  `urlkey` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `response` */

DROP TABLE IF EXISTS `response`;

CREATE TABLE `response` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `message` varchar(200) character set utf8 NOT NULL,
  `debate` int(11) NOT NULL,
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `user` int(10) NOT NULL,
  `flagged` tinyint(1) NOT NULL default '0',
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=latin1;

/*Table structure for table `response_type` */

DROP TABLE IF EXISTS `response_type`;

CREATE TABLE `response_type` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `firstname` varchar(50) default NULL,
  `middlename` varchar(10) default NULL,
  `lastname` varchar(50) default NULL,
  `Nickname` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `password` varchar(16) default NULL,
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `disabled` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `user_debate` */

DROP TABLE IF EXISTS `user_debate`;

CREATE TABLE `user_debate` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `user` bigint(20) NOT NULL,
  `debate` bigint(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL default NULL,
  `disabled` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
