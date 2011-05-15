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

/*Table structure for table `duans` */

DROP TABLE IF EXISTS `duans`;

CREATE TABLE `duans` (
  `id` bigint(20) NOT NULL auto_increment,
  `tenduan` varchar(255) character set utf8 default NULL,
  `alias` varchar(255) character set utf8 default NULL,
  `linhvuc_id` varchar(100) character set utf8 default NULL,
  `duan_email` varchar(100) character set utf8 default NULL,
  `duan_sodienthoai` varchar(100) character set utf8 default NULL,
  `tinh_id` bigint(20) default NULL,
  `ngayketthuc` datetime default NULL,
  `costmin` bigint(20) default NULL,
  `costmax` bigint(20) default NULL,
  `thongtinchitiet` text character set utf8,
  `file_id` bigint(20) default NULL,
  `ngaypost` datetime default NULL,
  `account_id` bigint(20) default NULL,
  `timeupdate` datetime default NULL,
  `prior` int(11) default NULL,
  `views` int(11) default NULL,
  `bidcount` int(11) default NULL,
  `averagecost` bigint(20) default NULL,
  `lastbid_nhathau` bigint(20) default NULL,
  `hosothau_id` bigint(20) default NULL,
  `nhathau_id` bigint(20) default NULL,
  `data_id` bigint(20) default NULL,
  `isnew` tinyint(1) default '1',
  `isbid` tinyint(1) default NULL,
  `editcode` varchar(50) default NULL,
  `active` int(11) default NULL,
  `approve` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `FK_duans_accounts` (`account_id`),
  KEY `FK_duans_files` (`file_id`),
  CONSTRAINT `FK_duans_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_duans_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

/*Table structure for table `raovatcomments` */

DROP TABLE IF EXISTS `raovatcomments`;

CREATE TABLE `raovatcomments` (
  `id` bigint(20) NOT NULL auto_increment,
  `raovat_id` bigint(20) default NULL,
  `ten` varchar(100) character set utf8 default NULL,
  `url` varchar(255) character set utf8 default NULL,
  `noidung` text character set utf8,
  `ngaypost` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_comments_articles` (`raovat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
  `isvip` tinyint(4) default NULL,
  `expirevip` date default NULL,
  `account_id` bigint(20) default NULL,
  `status` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_raovats_account` (`account_id`),
  CONSTRAINT `FK_raovats_account` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
