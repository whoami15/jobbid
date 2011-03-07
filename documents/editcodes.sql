/*
SQLyog Enterprise - MySQL GUI v6.13
MySQL - 5.1.33-community : Database - cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `cms`;

USE `cms`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `editcodes` */

DROP TABLE IF EXISTS `editcodes`;

CREATE TABLE `editcodes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `duan_id` bigint(20) DEFAULT NULL,
  `editcode` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_editcodes_duans` (`duan_id`),
  CONSTRAINT `FK_editcodes_duans` FOREIGN KEY (`duan_id`) REFERENCES `duans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `editcodes` */

insert  into `editcodes`(`id`,`duan_id`,`editcode`) values (2,41,'hlvq9r7g965dfnk'),(3,42,'lx3kgmu10vlslco');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
