/*
SQLyog Enterprise - MySQL GUI v6.13
MySQL - 5.0.51b-community-nt : Database - cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `cms`;

USE `cms`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `raovats` */

DROP TABLE IF EXISTS `raovats`;

CREATE TABLE `raovats` (
  `id` bigint(20) NOT NULL auto_increment,
  `tieude` varchar(255) character set utf8 default NULL,
  `alias` varchar(255) character set utf8 default NULL,
  `noidung` text character set utf8,
  `raovat_email` varchar(70) default NULL,
  `raovat_sodienthoai` varchar(20) default NULL,
  `ngaypost` datetime default NULL,
  `ngayupdate` datetime default NULL,
  `views` int(11) default NULL,
  `account_id` bigint(20) default NULL,
  `status` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_raovats_account` (`account_id`),
  CONSTRAINT `FK_raovats_account` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `raovats` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
