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

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `sodienthoai` varchar(20) default NULL,
  `lastlogin` datetime default NULL,
  `timeonline` bigint(20) default NULL,
  `role` int(11) default NULL,
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `accounts` */

insert  into `accounts`(`id`,`username`,`password`,`sodienthoai`,`lastlogin`,`timeonline`,`role`,`active`) values (1,'admin@jobbid.com','e10adc3949ba59abbe56e057f20f883e','123456789','2010-12-28 21:33:11',NULL,1,1),(2,'nclong@jobbid.com','e10adc3949ba59abbe56e057f20f883e',NULL,'2010-11-18 22:32:58',NULL,1,1),(10,'nclong87@jobbid.com','c33367701511b4f6020ec61ded352059','123456','2010-12-24 14:25:12',NULL,2,1),(11,'nclong88@jobbid.com','e10adc3949ba59abbe56e057f20f883e','12343','2010-11-23 16:19:03',NULL,2,1),(15,'levana@yahoo.com','e10adc3949ba59abbe56e057f20f883e','0834321285','2010-12-28 20:16:29',NULL,2,1),(16,'mytrang@gmail.com','e10adc3949ba59abbe56e057f20f883e','0979932151','2010-12-27 13:16:16',NULL,2,1),(17,'tranvanc@yahoo.com','e10adc3949ba59abbe56e057f20f883e','988213312','2010-12-13 21:23:20',NULL,2,1),(18,'tuanngoc@yahoo.com','03e4c83055481daef02e63b77047c826','098733121','2010-12-28 11:47:55',NULL,2,1),(19,'tuanngoc2@gmail.com','e10adc3949ba59abbe56e057f20f883e','78831300','2010-12-19 00:18:20',NULL,2,-1),(20,'tuanhung@gmail.com','e10adc3949ba59abbe56e057f20f883e','0987621211','2010-12-07 23:22:25',NULL,2,-1),(21,'test@yahoo.com','e10adc3949ba59abbe56e057f20f883e','45312121','2010-12-22 15:20:53',0,2,0),(22,'test3@yahoo.com','e10adc3949ba59abbe56e057f20f883e','4553313','2010-12-22 15:08:56',0,2,0),(23,'test4@gmail.com','e10adc3949ba59abbe56e057f20f883e','5465323','2010-12-21 15:26:06',0,2,1),(24,'test5@gm.com','e10adc3949ba59abbe56e057f20f883e','3313131','2010-12-24 14:24:46',0,2,0),(25,'111@1.com','e10adc3949ba59abbe56e057f20f883e','43121','2010-12-21 16:42:13',0,2,0),(30,'nclong87@gmail.com','e10adc3949ba59abbe56e057f20f883e','8754322','2010-12-28 20:38:19',0,2,0),(31,'mytrang@yahoo.com','e10adc3949ba59abbe56e057f20f883e','0987654321',NULL,0,2,0),(32,'mytrang6789@yahoo.com','e10adc3949ba59abbe56e057f20f883e','0987654321','2010-12-26 23:47:03',0,2,1);

/*Table structure for table `activecodes` */

DROP TABLE IF EXISTS `activecodes`;

CREATE TABLE `activecodes` (
  `id` bigint(20) NOT NULL auto_increment,
  `account_id` bigint(20) default NULL,
  `active_code` varchar(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_activecodes_accounts` (`account_id`),
  CONSTRAINT `FK_activecodes_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `activecodes` */

insert  into `activecodes`(`id`,`account_id`,`active_code`) values (1,21,'97fv6p932d'),(2,22,'hatwyrchu4'),(7,25,'abcde'),(8,24,'12345'),(14,30,'pvqcw0to48'),(15,31,'qut883awqx');

/*Table structure for table `datas` */

DROP TABLE IF EXISTS `datas`;

CREATE TABLE `datas` (
  `id` bigint(20) NOT NULL auto_increment,
  `data` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `data` (`data`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `datas` */

insert  into `datas`(`id`,`data`) values (0,'a'),(34,'che ban dien tu che ban dien tu'),(35,'thiet ke mach dien cho cong ty a thiet ke mach dien cho cong ty a'),(33,'xay dung nha o xay dung nha o'),(12,'Dự án test web2 Dự án test websiteCần 500 ngườiChi tiết vui lòng liên hệ số : 0973862100Thanks! du an test web2 du an test websitecan 500 nguoichi tiet vui long lien he so : 0973862100thanks!'),(30,'do hoa may tinh day them do hoa may tinh, gia hap dan'),(32,'du an xay dung duong bo ok, xay dung tuyen duong xyz'),(31,'phan mem ke toan xay dung phan mem ke toan cho cong ty abc'),(36,'xay nha dan dung xin chao tat ca moi nguoi, toi dang tim kiem mot doi tac hay doi tac cua tai nang. silhouetting kiem soat trong photoshop (voi clip con duong, mat na, lop ...). neu ban la mot vi vua cua thats chinh sua va hieu chinh mau sac tot hon. ban phai tuong doi co san, nhu cong viec trong tuong lai khong the du bao truoc va phai duoc thuc hien nhanh chong. toi thuc su exigeant. xin vui long them cac vi du ve nang luc cua ban!'),(37,'thiet ke banner flash helo'),(38,'thiet ke banner b dep, bat mat'),(39,'thiet ke banner a chung toi dang tim kiem mot nha thiet ke tai nang cho thiet ke lai mot trang web (khong phai tong so tu dau chi de thay doi no), chung ta can cac trang truoc va thiet ke lai trang ben trong. chung ta can ket qua theo dinh dang psd trong lop. co 3 du an khac nhau de lam gi sau khi lan dau tien mot'),(40,'du an kien truc b xay nha la mot chuyen lon cua doi nguoi,  co nhieu viec phai lam de co mot cong trinh nha o nhu y, lam sao de ban  thiet ke kien truc va ngoi nha cua ban dat day du cac tinh chat: tien  dung, tham my, kinh te va ben vung. voi goi y cua ahdesign giup cac ban  bot di cac kho khan ban dau.'),(41,'du an kien truc a xay nha la mot chuyen lon cua doi nguoi,  co nhieu viec phai lam de co mot cong trinh nha o nhu y, lam sao de ban  thiet ke kien truc va ngoi nha cua ban dat day du cac tinh chat: tien  dung, tham my, kinh te va ben vung. voi goi y cua ahdesign giup cac ban  bot di cac kho khan ban dau.'),(21,'Dự án cơ khí B Đây là các  dự án đã được Hội đồng Chính phủ thẩm tra phê duyệt đầu tư bằng nguồn  vốn vay ưu đãi đặc biệt. Tuy nhiên, cho đến nay dự án nầy hầu hết vẫn  đang án binh bất động.\nSau khi lựa chọn, Ban dự án cơ khí  trọng điểm đã quyết định đưa 24 dự án vào danh mục những Dự án cơ khí  trọng điểm. Theo đó, những dự án này được hưởng ưu đãi đặc biệt của Nhà  nước theo Quyết định 186/TTgcủa Thủ tướng Chính phủ và được vay thông  qua nguồn vốn từ Quỹ Hỗ trợ Phát triển (HTPT) với lãi suất 3%/năm trong  vòng 12 năm (hai năm đầu không phải trả lãi, trả nợ gốc bắt đầu từ năm  thứ 5). Có thể nói, sau gần 1 năm thực hiện một số dự án đầu tiên được  phê duyệt, 5 dự án được hoàn thiện để xin cơ chế ưu đãi. Tuy nhiên, cho  đến nay tất cả các dự án này đều bị ách tắc có nguy cơ phá sản do bị  vướng từ Nghị định 106/2004/CPngày 1/4/2004 cuả Chính phủ về tín dụng  đầu tư phát triển của nhà nước. du an co khi b day la cac  du an da duoc hoi dong chinh phu tham tra phe duyet dau tu bang nguon  von vay uu dai dac biet. tuy nhien, cho den nay du an nay hau het van  dang an binh bat dong.\nsau khi lua chon, ban du an co khi  trong diem da quyet dinh dua 24 du an vao danh muc nhung du an co khi  trong diem. theo do, nhung du an nay duoc huong uu dai dac biet cua nha  nuoc theo quyet dinh 186/ttgcua thu tuong chinh phu va duoc vay thong  qua nguon von tu quy ho tro phat trien (htpt) voi lai suat 3%/nam trong  vong 12 nam (hai nam dau khong phai tra lai, tra no goc bat dau tu nam  thu 5). co the noi, sau gan 1 nam thuc hien mot so du an dau tien duoc  phe duyet, 5 du an duoc hoan thien de xin co che uu dai. tuy nhien, cho  den nay tat ca cac du an nay deu bi ach tac co nguy co pha san do bi  vuong tu nghi dinh 106/2004/cpngay 1/4/2004 cua chinh phu ve tin dung  dau tu phat trien cua nha nuoc.'),(42,'du an co khi a day la cac  du an da duoc hoi dong chinh phu tham tra phe duyet dau tu bang nguon  von vay uu dai dac biet. tuy nhien, cho den nay du an nay hau het van  dang an binh bat dong.\nsau khi lua chon, ban du an co khi  trong diem da quyet dinh dua 24 du an vao danh muc nhung du an co khi  trong diem. theo do, nhung du an nay duoc huong uu dai dac biet cua nha  nuoc theo quyet dinh 186/ttgcua thu tuong chinh phu va duoc vay thong  qua nguon von tu quy ho tro phat trien (htpt) voi lai suat 3%/nam trong  vong 12 nam (hai nam dau khong phai tra lai, tra no goc bat dau tu nam  thu 5). co the noi, sau gan 1 nam thuc hien mot so du an dau tien duoc  phe duyet, 5 du an duoc hoan thien de xin co che uu dai. tuy nhien, cho  den nay tat ca cac du an nay deu bi ach tac co nguy co pha san do bi  vuong tu nghi dinh 106/2004/cpngay 1/4/2004 cua chinh phu ve tin dung  dau tu phat trien cua nha nuoc.'),(43,'du an website test ok lii'),(44,'thiet ke website mua ban kinh nghiem 3 nam thiet ke web'),(45,'du an long ca nha van can thiet cho mot du an. ban se duoc thanh toan theo chieu dai cua bai viet. ngoai ra, ban nen co the giao tiep it nhat 2 gio moi ngay. (thu hai-thu bay). xin vui long pm cho biet them chi tiet.'),(26,'Dự án Vietnam Idol Trước giờ công bố kết quả, 3 cô gái trẻ đã được trở về nhà, về trường cũ\r\n và được mọi người đón tiếp rất nồng hậu. \"Đàn chị\" Uyên Linh trở về \r\ntrường PTTH Lê Hồng Phong, TPHCM đã được các đàn em chào đón như cô đã \r\nlà thần tượng âm nhạc. Lều Phương Anh, Mai Hương bay ra Hà Nội&nbsp;gặp lại \r\ngia đình, thầy cô, bạn bè... du an vietnam idol truoc gio cong bo ket qua, 3 co gai tre da duoc tro ve nha, ve truong cu\r\n va duoc moi nguoi don tiep rat nong hau. \"dan chi\" uyen linh tro ve \r\ntruong ptth le hong phong, tphcm da duoc cac dan em chao don nhu co da \r\nla than tuong am nhac. leu phuong anh, mai huong bay ra ha noi&nbsp;gap lai \r\ngia dinh, thay co, ban be...'),(46,'ggg tet'),(47,'ddd dddd'),(48,'test555 test'),(49,'test555 test'),(50,'test555 test'),(51,'thue muon yhte');

/*Table structure for table `duanmarks` */

DROP TABLE IF EXISTS `duanmarks`;

CREATE TABLE `duanmarks` (
  `id` bigint(20) NOT NULL auto_increment,
  `account_id` bigint(20) default NULL,
  `duan_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_duanmarks_accounts` (`account_id`),
  KEY `FK_duanmarks_duans` (`duan_id`),
  CONSTRAINT `FK_duanmarks_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_duanmarks_duans` FOREIGN KEY (`duan_id`) REFERENCES `duans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Data for the table `duanmarks` */

insert  into `duanmarks`(`id`,`account_id`,`duan_id`) values (3,1,12),(5,16,18),(8,1,13),(9,1,9),(13,15,5),(17,16,13),(19,16,17),(20,16,16),(22,18,17),(23,19,13),(24,1,18),(25,10,18),(27,18,7),(28,18,6),(29,17,21),(30,17,5),(31,15,15),(32,18,10),(33,15,21),(34,1,16);

/*Table structure for table `duans` */

DROP TABLE IF EXISTS `duans`;

CREATE TABLE `duans` (
  `id` bigint(20) NOT NULL auto_increment,
  `tenduan` varchar(255) character set utf8 default NULL,
  `alias` varchar(255) character set utf8 default NULL,
  `linhvuc_id` varchar(100) character set utf8 default NULL,
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
  `isbid` tinyint(1) default '1',
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_duans_accounts` (`account_id`),
  KEY `FK_duans_files` (`file_id`),
  CONSTRAINT `FK_duans_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_duans_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `duans` */

insert  into `duans`(`id`,`tenduan`,`alias`,`linhvuc_id`,`tinh_id`,`ngayketthuc`,`costmin`,`costmax`,`thongtinchitiet`,`file_id`,`ngaypost`,`account_id`,`timeupdate`,`prior`,`views`,`bidcount`,`averagecost`,`lastbid_nhathau`,`hosothau_id`,`nhathau_id`,`data_id`,`isnew`,`isbid`,`active`) values (1,'dự án long ca','du-an-long-ca','seo',1,'2010-12-29 00:00:00',1500000,3000000,'<p><span id=\"result_box\" class=\"\" lang=\"vi\"><span title=\"Click for alternate translations\" class=\"hps\">Nhà văn</span> <span title=\"Click for alternate translations\" class=\"hps\">cần thiết</span> <span title=\"Click for alternate translations\" class=\"hps\">cho</span> <span title=\"Click for alternate translations\" class=\"hps\">một dự án</span><span title=\"Click for alternate translations\">.</span> <span title=\"Click for alternate translations\" class=\"hps\">Bạn</span> <span title=\"Click for alternate translations\" class=\"hps\">sẽ</span> <span title=\"Click for alternate translations\" class=\"hps\">được</span> <span title=\"Click for alternate translations\" class=\"hps\">thanh toán</span> <span title=\"Click for alternate translations\" class=\"hps\">theo</span> <span title=\"Click for alternate translations\" class=\"hps\">chiều dài</span> <span title=\"Click for alternate translations\" class=\"hps\">của bài viết</span><span title=\"Click for alternate translations\">.</span> <span title=\"Click for alternate translations\" class=\"hps\">Ngoài ra, bạn</span> <span title=\"Click for alternate translations\" class=\"hps\">nên</span> <span title=\"Click for alternate translations\" class=\"hps\">có thể</span> <span title=\"Click for alternate translations\" class=\"hps\">giao tiếp</span> <span title=\"Click for alternate translations\" class=\"hps\">ít nhất 2</span> <span title=\"Click for alternate translations\" class=\"hps\">giờ</span> <span title=\"Click for alternate translations\" class=\"hps\">mỗi ngày</span><span title=\"Click for alternate translations\">.</span> <span title=\"Click for alternate translations\" class=\"hps atn\">(</span><span title=\"Click for alternate translations\">Thứ hai</span><span title=\"Click for alternate translations\" class=\"atn\">-</span><span title=\"Click for alternate translations\">thứ bảy</span><span title=\"Click for alternate translations\">)</span><span title=\"Click for alternate translations\">.</span> <span title=\"Click for alternate translations\" class=\"hps\">Xin vui lòng</span> <span title=\"Click for alternate translations\" class=\"hps\">PM</span> <span title=\"Click for alternate translations\" class=\"hps\">cho</span> <span title=\"Click for alternate translations\" class=\"hps\">biết thêm chi tiết</span><span class=\"\" title=\"Click for alternate translations\">.</span></span></p>',19,'2010-11-16 00:01:39',1,'2010-12-26 23:37:08',4,2,0,0,NULL,NULL,NULL,45,0,1,1),(2,'Thiết kế website mua bán','thiet-ke-website-mua-ban','cntt',1,'2010-12-31 00:00:00',5000000,10000000,'<p>Kinh nghiệm 3 năm thiết kế web</p>',63,'2010-11-16 21:01:29',1,'2010-12-25 14:41:18',3,89,0,0,NULL,NULL,NULL,44,0,1,1),(5,'Dự án website','du-an-website','cntt',1,'2010-12-28 00:00:00',3000000,5000000,'<p>test ok lii</p>',65,'2010-11-26 23:17:51',1,'2010-12-25 14:41:07',4,33,0,0,NULL,NULL,NULL,43,0,1,1),(6,'Dự án cơ khí A','du-an-co-khi-a','co_khi',1,'2010-12-29 00:00:00',3000000,5000000,'<p><span><span style=\"color: #0033cc; font-family: Arial; font-size: x-small;\"><strong>Đ&acirc;y l&agrave; c&aacute;c  dự &aacute;n đ&atilde; được Hội đồng Ch&iacute;nh phủ thẩm tra ph&ecirc; duyệt đầu tư bằng nguồn  vốn vay ưu đ&atilde;i đặc biệt. Tuy nhi&ecirc;n, cho đến nay dự &aacute;n nầy hầu hết vẫn  đang &aacute;n binh bất động.</strong></span></span></p>\n<p><span><span style=\"font-family: Arial; font-size: x-small;\">Sau khi lựa chọn, Ban dự &aacute;n cơ kh&iacute;  trọng điểm đ&atilde; quyết định đưa 24 dự &aacute;n v&agrave;o danh mục những Dự &aacute;n cơ kh&iacute;  trọng điểm. Theo đ&oacute;, những dự &aacute;n n&agrave;y được hưởng ưu đ&atilde;i đặc biệt của Nh&agrave;  nước theo Quyết định 186/TTgcủa Thủ tướng Ch&iacute;nh phủ v&agrave; được vay th&ocirc;ng  qua nguồn vốn từ Quỹ Hỗ trợ Ph&aacute;t triển (HTPT) với l&atilde;i suất 3%/năm trong  v&ograve;ng 12 năm (hai năm đầu kh&ocirc;ng phải trả l&atilde;i, trả nợ gốc bắt đầu từ năm  thứ 5). C&oacute; thể n&oacute;i, sau gần 1 năm thực hiện một số dự &aacute;n đầu ti&ecirc;n được  ph&ecirc; duyệt, 5 dự &aacute;n được ho&agrave;n thiện để xin cơ chế ưu đ&atilde;i. Tuy nhi&ecirc;n, cho  đến nay tất cả c&aacute;c dự &aacute;n n&agrave;y đều bị &aacute;ch tắc c&oacute; nguy cơ ph&aacute; sản do bị  vướng từ Nghị định 106/2004/CPng&agrave;y 1/4/2004 cuả Ch&iacute;nh phủ về t&iacute;n dụng  đầu tư ph&aacute;t triển của nh&agrave; nước.</span></span></p>',0,'2010-11-27 20:26:45',1,'2010-12-25 14:40:58',0,17,0,0,NULL,NULL,NULL,42,0,1,1),(7,'Dự án cơ khí B','du-an-co-khi-b','co_khi',2,'2010-12-23 00:00:00',1500000,3000000,'<p><big><big><span><span style=\"color: #0033cc; font-family: Arial; font-size: x-small;\"><strong>Đ&acirc;y l&agrave; c&aacute;c  dự &aacute;n đ&atilde; được Hội đồng Ch&iacute;nh phủ thẩm tra ph&ecirc; duyệt đầu tư bằng nguồn  vốn vay ưu đ&atilde;i đặc biệt. Tuy nhi&ecirc;n, cho đến nay dự &aacute;n nầy hầu hết vẫn  đang &aacute;n binh bất động.</strong></span></span></big></big></p>\n<p><big><big><span><span style=\"font-family: Arial; font-size: x-small;\">Sau khi lựa chọn, Ban dự &aacute;n cơ kh&iacute;  trọng điểm đ&atilde; quyết định đưa 24 dự &aacute;n v&agrave;o danh mục những Dự &aacute;n cơ kh&iacute;  trọng điểm. Theo đ&oacute;, những dự &aacute;n n&agrave;y được hưởng ưu đ&atilde;i đặc biệt của Nh&agrave;  nước theo Quyết định 186/TTgcủa Thủ tướng Ch&iacute;nh phủ v&agrave; được vay th&ocirc;ng  qua nguồn vốn từ Quỹ Hỗ trợ Ph&aacute;t triển (HTPT) với l&atilde;i suất 3%/năm trong  v&ograve;ng 12 năm (hai năm đầu kh&ocirc;ng phải trả l&atilde;i, trả nợ gốc bắt đầu từ năm  thứ 5). C&oacute; thể n&oacute;i, sau gần 1 năm thực hiện một số dự &aacute;n đầu ti&ecirc;n được  ph&ecirc; duyệt, 5 dự &aacute;n được ho&agrave;n thiện để xin cơ chế ưu đ&atilde;i. Tuy nhi&ecirc;n, cho  đến nay tất cả c&aacute;c dự &aacute;n n&agrave;y đều bị &aacute;ch tắc c&oacute; nguy cơ ph&aacute; sản do bị  vướng từ Nghị định 106/2004/CPng&agrave;y 1/4/2004 cuả Ch&iacute;nh phủ về t&iacute;n dụng  đầu tư ph&aacute;t triển của nh&agrave; nước.</span></span></big></big></p>',20,'2010-11-27 20:42:34',1,'2010-12-17 22:17:45',0,63,1,3500000,9,15,9,21,0,1,1),(8,'Dự án kiến trúc A','du-an-kien-truc-a','kien_truc',1,'2010-12-30 00:00:00',5000000,10000000,'<p><strong><span style=\"color: #003300;\">X&acirc;y nh&agrave; l&agrave; một chuyện lớn của đời người,  c&oacute; nhiều việc phải l&agrave;m để c&oacute; một c&ocirc;ng tr&igrave;nh nh&agrave; ở như &yacute;, l&agrave;m sao để bản  thiết kế kiến tr&uacute;c v&agrave; ng&ocirc;i nh&agrave; của bạn đạt đầy đủ c&aacute;c t&iacute;nh chất: tiện  dụng, thẩm mỹ, kinh tế v&agrave; bền vững. Với gợi &yacute; của AHDesign gi&uacute;p c&aacute;c bạn  bớt đi c&aacute;c kh&oacute; khăn ban đầu.</span></strong></p>',21,'2010-11-27 20:44:42',1,'2010-12-25 14:40:44',0,25,1,6000000,9,NULL,NULL,41,0,1,1),(9,'Dự án kiến trúc B','du-an-kien-truc-b','kien_truc',3,'2010-12-29 00:00:00',3000000,5000000,'<p><strong><span style=\"color: #003300;\">X&acirc;y nh&agrave; l&agrave; một chuyện lớn của đời người,  c&oacute; nhiều việc phải l&agrave;m để c&oacute; một c&ocirc;ng tr&igrave;nh nh&agrave; ở như &yacute;, l&agrave;m sao để bản  thiết kế kiến tr&uacute;c v&agrave; ng&ocirc;i nh&agrave; của bạn đạt đầy đủ c&aacute;c t&iacute;nh chất: tiện  dụng, thẩm mỹ, kinh tế v&agrave; bền vững. Với gợi &yacute; của AHDesign gi&uacute;p c&aacute;c bạn  bớt đi c&aacute;c kh&oacute; khăn ban đầu.</span></strong></p>',22,'2010-11-27 20:45:30',1,'2010-12-25 14:40:31',0,35,0,0,NULL,NULL,NULL,40,0,1,1),(10,'Thiết kế banner A','thiet-ke-banner-a','design',1,'2010-12-31 00:00:00',3000000,5000000,'<p><span id=\"result_box\" lang=\"vi\"><span class=\"hps\" title=\"Click for alternate translations\">Ch&uacute;ng t&ocirc;i</span> <span class=\"hps\" title=\"Click for alternate translations\">đang t&igrave;m kiếm</span> <span class=\"hps\" title=\"Click for alternate translations\">một</span> <span class=\"hps\" title=\"Click for alternate translations\">nh&agrave; thiết kế</span> <span class=\"hps\" title=\"Click for alternate translations\">t&agrave;i năng</span> <span class=\"hps\" title=\"Click for alternate translations\">cho</span> <span class=\"hps\" title=\"Click for alternate translations\">thiết kế lại</span> <span class=\"hps\" title=\"Click for alternate translations\">một</span> <span class=\"hps\" title=\"Click for alternate translations\">trang web</span> <span class=\"hps atn\" title=\"Click for alternate translations\">(</span><span title=\"Click for alternate translations\">kh&ocirc;ng phải</span> <span class=\"hps\" title=\"Click for alternate translations\">tổng số</span> <span class=\"hps\" title=\"Click for alternate translations\">từ</span> <span class=\"hps\" title=\"Click for alternate translations\">đầu</span> <span class=\"hps\" title=\"Click for alternate translations\">chỉ</span> <span class=\"hps\" title=\"Click for alternate translations\">để</span> <span class=\"hps\" title=\"Click for alternate translations\">thay đổi</span> <span class=\"hps\" title=\"Click for alternate translations\">n&oacute;</span><span title=\"Click for alternate translations\">)</span><span title=\"Click for alternate translations\">,</span> <span class=\"hps\" title=\"Click for alternate translations\">ch&uacute;ng ta cần</span> <span class=\"hps\" title=\"Click for alternate translations\">c&aacute;c</span> <span class=\"hps\" title=\"Click for alternate translations\">trang</span> <span class=\"hps\" title=\"Click for alternate translations\">trước</span> <span class=\"hps\" title=\"Click for alternate translations\">v&agrave;</span> <span class=\"hps\" title=\"Click for alternate translations\">thiết kế lại</span> <span class=\"hps\" title=\"Click for alternate translations\">trang</span> <span class=\"hps\" title=\"Click for alternate translations\">b&ecirc;n trong</span><span title=\"Click for alternate translations\">.</span><br /> <span class=\"hps\" title=\"Click for alternate translations\">Ch&uacute;ng ta</span> <span class=\"hps\" title=\"Click for alternate translations\">cần</span> <span class=\"hps\" title=\"Click for alternate translations\">kết quả</span> <span class=\"hps\" title=\"Click for alternate translations\">theo định dạng</span> <span class=\"hps\" title=\"Click for alternate translations\">psd</span> <span class=\"hps\" title=\"Click for alternate translations\">trong</span> <span class=\"hps\" title=\"Click for alternate translations\">lớp</span><span title=\"Click for alternate translations\">.</span><br /> <span class=\"hps\" title=\"Click for alternate translations\">C&oacute;</span> <span class=\"hps\" title=\"Click for alternate translations\">3</span> <span class=\"hps\" title=\"Click for alternate translations\">dự &aacute;n</span> <span class=\"hps\" title=\"Click for alternate translations\">kh&aacute;c nhau</span> <span class=\"hps\" title=\"Click for alternate translations\">để</span> <span class=\"hps\" title=\"Click for alternate translations\">l&agrave;m g&igrave;</span> <span class=\"hps\" title=\"Click for alternate translations\">sau khi</span> <span class=\"hps\" title=\"Click for alternate translations\">lần đầu ti&ecirc;n</span> <span class=\"hps\" title=\"Click for alternate translations\">một</span></span></p>',23,'2010-11-27 20:46:55',1,'2010-12-25 14:40:21',0,58,0,0,NULL,NULL,NULL,39,0,1,1),(11,'Thiết kế banner B','thiet-ke-banner-b','design',3,'2010-12-31 00:00:00',1500000,3000000,'<p>đẹp, bắt mắt</p>',24,'2010-11-27 20:47:08',1,'2010-12-25 14:40:11',0,32,0,0,NULL,NULL,NULL,38,0,1,1),(12,'Thiết kế banner Flash','thiet-ke-banner-flash','design',1,'2010-12-29 00:00:00',100000,500000,'<p>helo</p>',0,'2010-11-27 22:59:57',10,'2010-12-25 14:40:01',4,102,3,116333,9,NULL,NULL,37,0,1,1),(13,'Xây nhà dân dụng','xay-nha-dan-dung','kien_truc',1,'2010-12-31 00:00:00',5000000,10000000,'<p><span id=\"result_box\" lang=\"vi\"><span class=\"hps\" title=\"Click for alternate translations\">Xin ch&agrave;o</span> <span class=\"hps\" title=\"Click for alternate translations\">tất cả mọi người</span><span title=\"Click for alternate translations\">,</span><br /><br /> <span class=\"hps\" title=\"Click for alternate translations\">T&ocirc;i</span> <span class=\"hps\" title=\"Click for alternate translations\">đang</span> <span class=\"hps\" title=\"Click for alternate translations\">t&igrave;m kiếm</span> <span class=\"hps\" title=\"Click for alternate translations\">một</span> <span class=\"hps\" title=\"Click for alternate translations\">đối t&aacute;c</span> <span class=\"hps\" title=\"Click for alternate translations\">hay</span> <span class=\"hps\" title=\"Click for alternate translations\">đối t&aacute;c</span> <span class=\"hps\" title=\"Click for alternate translations\">của</span> <span class=\"hps\" title=\"Click for alternate translations\">t&agrave;i năng</span><span title=\"Click for alternate translations\">.</span><br /> <span class=\"hps\" title=\"Click for alternate translations\">Silhouetting</span> <span class=\"hps\" title=\"Click for alternate translations\">kiểm so&aacute;t</span> <span class=\"hps\" title=\"Click for alternate translations\">trong</span> <span class=\"hps\" title=\"Click for alternate translations\">photoshop</span> <span class=\"hps atn\" title=\"Click for alternate translations\">(</span><span title=\"Click for alternate translations\">với</span> <span class=\"hps\" title=\"Click for alternate translations\">clip</span> <span class=\"hps\" title=\"Click for alternate translations\">con đường</span><span title=\"Click for alternate translations\">, mặt nạ</span><span title=\"Click for alternate translations\">,</span> <span class=\"hps\" title=\"Click for alternate translations\">lớp</span> <span class=\"hps\" title=\"Click for alternate translations\">...).</span><br /> <span class=\"hps\" title=\"Click for alternate translations\">Nếu</span> <span class=\"hps\" title=\"Click for alternate translations\">bạn</span> <span class=\"hps\" title=\"Click for alternate translations\">l&agrave;</span> <span class=\"hps\" title=\"Click for alternate translations\">một</span> <span class=\"hps\" title=\"Click for alternate translations\">vị vua</span> <span class=\"hps\" title=\"Click for alternate translations\">của</span> <span class=\"hps\" title=\"Click for alternate translations\">thats</span> <span class=\"hps\" title=\"Click for alternate translations\">chỉnh sửa</span> <span class=\"hps\" title=\"Click for alternate translations\">v&agrave;</span> <span class=\"hps\" title=\"Click for alternate translations\">hiệu chỉnh m&agrave;u sắc</span> <span class=\"hps\" title=\"Click for alternate translations\">tốt hơn</span><span title=\"Click for alternate translations\">.</span><br /> <span class=\"hps\" title=\"Click for alternate translations\">Bạn phải</span> <span class=\"hps\" title=\"Click for alternate translations\">tương đối</span> <span class=\"hps\" title=\"Click for alternate translations\">c&oacute; sẵn</span><span title=\"Click for alternate translations\">,</span> <span class=\"hps\" title=\"Click for alternate translations\">như c&ocirc;ng việc</span> <span class=\"hps\" title=\"Click for alternate translations\">trong tương lai</span> <span class=\"hps\" title=\"Click for alternate translations\">kh&ocirc;ng</span> <span class=\"hps\" title=\"Click for alternate translations\">thể</span> <span class=\"hps\" title=\"Click for alternate translations\">dự b&aacute;o</span> <span class=\"hps\" title=\"Click for alternate translations\">trước</span> <span class=\"hps\" title=\"Click for alternate translations\">v&agrave;</span> <span class=\"hps\" title=\"Click for alternate translations\">phải được thực hiện</span> <span class=\"hps\" title=\"Click for alternate translations\">nhanh ch&oacute;ng</span><span title=\"Click for alternate translations\">.</span><br /><br /> <span class=\"hps\" title=\"Click for alternate translations\">T&ocirc;i</span> <span class=\"hps\" title=\"Click for alternate translations\">thực sự</span> <span class=\"hps\" title=\"Click for alternate translations\">exigeant</span><span title=\"Click for alternate translations\">.</span><br /> <span class=\"hps\" title=\"Click for alternate translations\">Xin vui l&ograve;ng</span> <span class=\"hps\" title=\"Click for alternate translations\">th&ecirc;m</span> <span class=\"hps\" title=\"Click for alternate translations\">c&aacute;c v&iacute; dụ</span> <span class=\"hps\" title=\"Click for alternate translations\">về</span> <span class=\"hps\" title=\"Click for alternate translations\">năng lực</span> <span class=\"hps\" title=\"Click for alternate translations\">của bạn</span><span title=\"Click for alternate translations\">!</span></span></p>',25,'2010-11-28 18:03:02',1,'2010-12-25 14:39:42',0,61,0,0,NULL,NULL,NULL,36,0,1,1),(14,'Thiết kế mạch điện cho công ty A','thiet-ke-mach-dien-cho-cong-ty-a','dien_tu',3,'2010-12-30 00:00:00',500000,1500000,'<p>Thiết kế mạch điện cho c&ocirc;ng ty A</p>',26,'2010-11-28 22:30:41',10,'2010-12-25 14:39:32',0,41,2,800000,12,NULL,NULL,35,0,1,1),(15,'Chế bản điện tử','che-ban-dien-tu','dien_tu',4,'2010-12-28 00:00:00',3000000,5000000,'<p>Chế bản điện tử</p>',27,'2010-11-28 22:31:59',10,'2010-12-25 14:39:23',0,94,2,3750000,9,NULL,NULL,34,0,1,1),(16,'Dự án test web2','du-an-test-web2','khac',2,'2010-12-28 00:00:00',1500000,3000000,'<p>Dự &aacute;n test website<br />Cần <span style=\"color: #ff0000; font-weight: bold;\">500</span> người<br />Chi tiết vui l&ograve;ng li&ecirc;n hệ số : <span style=\"color: #ff0000; font-weight: bold;\">0973862100</span><br />Thanks!</p>',59,'2010-11-28 23:55:04',15,'2010-12-15 00:27:14',0,121,1,2000000,15,NULL,NULL,12,0,1,1),(17,'Xây dựng nhà ở','xay-dung-nha-o','kien_truc',1,'2010-12-31 00:00:00',3000000,5000000,'<p>x&acirc;y dựng nh&agrave; ở</p>',42,'2010-12-01 21:32:14',10,'2010-12-25 14:39:13',0,82,0,0,NULL,NULL,NULL,33,0,1,1),(18,'Đồ họa máy tính','do-hoa-may-tinh','design',1,'2010-12-28 00:00:00',3000000,5000000,'<p>Dạy th&ecirc;m <strong><span style=\"color: #990000;\">đồ họa m&aacute;y t&iacute;nh</span></strong>, gi&aacute; <span style=\"color: #33ff33;\"><strong>hấp dẫn</strong></span></p>',46,'2010-12-02 00:14:50',16,'2010-12-27 09:45:32',0,137,2,300250,12,21,15,30,0,1,1),(19,'Dự án xây dựng đường bộ','du-an-xay-dung-duong-bo','co_khi',1,'2010-12-30 00:00:00',3000000,5000000,'<p>ok, x&acirc;y dựng tuyến đường XYZ</p>',66,'2010-12-05 08:02:34',15,'2010-12-25 14:39:04',0,10,1,600000,12,NULL,NULL,32,0,1,1),(21,'Phần mềm kế toán','phan-mem-ke-toan','cntt',1,'2010-12-30 00:00:00',5000000,10000000,'<p>X&acirc;y dưng phần mềm kế to&aacute;n cho c&ocirc;ng ty ABC</p>',70,'2010-12-11 20:24:00',10,'2010-12-25 14:36:17',0,458,1,500000,NULL,19,8,31,0,1,1),(22,'Dự án Vietnam Idol','du-an-vietnam-idol','cntt',1,'2010-12-23 00:00:00',100000,500000,'Trước giờ công bố kết quả, 3 cô gái trẻ đã được trở về nhà, về trường cũ\r\n và được mọi người đón tiếp rất nồng hậu. \"Đàn chị\" Uyên Linh trở về \r\ntrường PTTH Lê Hồng Phong, TPHCM đã được các đàn em chào đón như cô đã \r\nlà thần tượng âm nhạc. Lều Phương Anh, Mai Hương bay ra Hà Nội&nbsp;gặp lại \r\ngia đình, thầy cô, bạn bè...',0,'2010-12-15 00:39:21',1,'2010-12-17 23:38:34',0,56,4,550000,12,18,12,26,0,1,1),(23,'ggg','ggg','kien_truc',1,'2010-12-30 00:00:00',100000,500000,'tét',0,'2010-12-27 16:47:53',16,'2010-12-27 16:47:53',0,0,0,0,NULL,NULL,NULL,46,NULL,1,1),(24,'ddd','ddd','cntt',1,'2010-12-29 00:00:00',100000,500000,'dddd',0,'2010-12-27 17:16:27',16,'2010-12-27 17:16:27',0,1,0,0,NULL,NULL,NULL,47,NULL,1,1),(25,'test555','test555','cntt',1,'2010-12-30 00:00:00',100000,500000,'test',NULL,'2010-12-28 20:48:39',15,'2010-12-28 21:23:40',0,15,0,0,NULL,NULL,NULL,50,1,1,1),(26,'thue muon','thue-muon','co_khi',1,'2010-12-31 00:00:00',3000000,5000000,'yhte',NULL,'2010-12-28 21:26:18',1,'2010-12-28 21:26:18',0,3,0,0,NULL,NULL,NULL,51,1,0,1);

/*Table structure for table `duanskills` */

DROP TABLE IF EXISTS `duanskills`;

CREATE TABLE `duanskills` (
  `id` bigint(20) NOT NULL auto_increment,
  `duan_id` bigint(20) default NULL,
  `skill_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_duanskills_skills` (`skill_id`),
  KEY `FK_duanskills_duan` (`duan_id`),
  CONSTRAINT `FK_duanskills_duan` FOREIGN KEY (`duan_id`) REFERENCES `duans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_duanskills_skills` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

/*Data for the table `duanskills` */

insert  into `duanskills`(`id`,`duan_id`,`skill_id`) values (21,9,13),(26,12,9),(27,12,4),(29,14,12),(30,14,14),(33,18,9),(34,18,5),(51,11,4),(52,11,10),(53,11,15),(60,6,8),(61,6,16),(63,16,8),(71,5,1),(72,5,3),(73,5,17),(74,19,8),(75,2,6),(76,2,3),(77,15,12),(86,21,3),(87,21,6),(90,17,13),(91,8,13),(92,7,7),(93,7,8),(94,7,16),(97,22,3),(98,13,13),(101,10,4),(102,10,10),(103,1,18),(104,1,19),(105,23,3),(106,23,1),(107,23,17),(108,23,6),(109,23,7),(110,23,8),(111,23,16),(112,23,11),(113,23,12),(114,23,14),(115,24,1),(116,24,3),(119,25,3),(120,26,8);

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` bigint(20) NOT NULL auto_increment,
  `filename` varchar(255) character set utf8 default NULL,
  `fileurl` varchar(255) default NULL,
  `account_id` bigint(20) default NULL,
  `account_share` bigint(20) default NULL,
  `status` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

/*Data for the table `files` */

insert  into `files`(`id`,`filename`,`fileurl`,`account_id`,`account_share`,`status`) values (0,NULL,NULL,1,NULL,1),(5,'5.rar','http://localhost/mycms/upload/files/1290443700_5.rar',1,NULL,1),(6,'CV.doc','http://localhost/mycms/upload/files/1290519887_CV.doc',1,NULL,1),(7,'Don_xin_viec__en.doc','http://localhost/mycms/upload/files/1290526656_Don_xin_viec__en.doc',10,NULL,1),(8,'traset.rar','http://localhost/mycms/upload/files/1290784091_traset.rar',1,NULL,1),(9,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290786524_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',1,NULL,1),(10,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290786707_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',1,NULL,1),(11,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290787655_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(12,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290787804_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(13,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290787820_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(14,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290787882_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(15,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290787992_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(16,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290788088_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(17,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290788210_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(18,'CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf','http://localhost/mycms/upload/files/1290788271_CQ_Tieu_chuan_dang_ky_lam_KLTN_K2006_2007.pdf',NULL,NULL,1),(19,'DeXDPMHDT_05HCA.pdf','http://localhost/mycms/upload/files/1290864404_DeXDPMHDT_05HCA.pdf',NULL,NULL,1),(20,'association_class.doc','http://localhost/mycms/upload/files/1290865354_association_class.doc',NULL,NULL,1),(21,'Bao_cao.doc','http://localhost/mycms/upload/files/1290865482_Bao_cao.doc',NULL,NULL,1),(22,'CTDT_KhoaCNTT_2007vetruoc_29June2009.pdf','http://localhost/mycms/upload/files/1290865530_CTDT_KhoaCNTT_2007vetruoc_29June2009.pdf',NULL,NULL,1),(23,'KHHVu_CQ.pdf','http://localhost/mycms/upload/files/1290865615_KHHVu_CQ.pdf',NULL,NULL,1),(24,'KHHVu_CQ.pdf','http://localhost/mycms/upload/files/1290865628_KHHVu_CQ.pdf',NULL,NULL,1),(25,'QLHS_3.Form.doc','http://localhost/mycms/upload/files/1290942182_QLHS_3.Form.doc',NULL,NULL,1),(26,'QLHS_3.HocSinhControl.doc','http://localhost/mycms/upload/files/1290958241_QLHS_3.HocSinhControl.doc',NULL,NULL,1),(27,'QLHS_3.DataProvider.doc','http://localhost/mycms/upload/files/1290958319_QLHS_3.DataProvider.doc',NULL,NULL,1),(28,'3layers_Sample.zip','http://localhost/mycms/upload/files/1290961604_3layers_Sample.zip',1,NULL,1),(29,'QLHS_3.HocSinhDataAccess.doc','http://localhost/mycms/upload/files/1290961983_QLHS_3.HocSinhDataAccess.doc',15,NULL,1),(30,'QLHS_3.Form.doc','http://localhost/mycms/upload/files/1290963304_QLHS_3.Form.doc',NULL,NULL,1),(31,'QLHS_3.Form.doc','http://localhost/mycms/upload/files/1290963347_QLHS_3.Form.doc',NULL,NULL,1),(32,'QLHS_3.LopInfo.doc','http://localhost/mycms/upload/files/1290963753_QLHS_3.LopInfo.doc',15,NULL,1),(33,'QLHS_3.HocSinhDataAccess.doc','http://localhost/mycms/upload/files/1291040873_QLHS_3.HocSinhDataAccess.doc',16,NULL,1),(34,'3Tiers_3Layers.zip','http://localhost/mycms/upload/files/1291041167_3Tiers_3Layers.zip',16,NULL,1),(35,'3Tiers_3Layers.zip','http://localhost/mycms/upload/files/1291041239_3Tiers_3Layers.zip',16,NULL,1),(36,'3Tiers_3Layers.zip','http://localhost/mycms/upload/files/1291041264_3Tiers_3Layers.zip',16,NULL,1),(37,'3Tiers_3Layers.zip','http://localhost/mycms/upload/files/1291041398_3Tiers_3Layers.zip',16,NULL,1),(38,'3Tiers_3Layers.zip','http://localhost/mycms/upload/files/1291041456_3Tiers_3Layers.zip',16,NULL,1),(39,'TemplatePTTKPM_bak1.rar','http://localhost/mycms/upload/files/1291047926_TemplatePTTKPM_bak1.rar',16,NULL,1),(40,'TemplatePTTKPM_bak1.rar','http://localhost/mycms/upload/files/1291048146_TemplatePTTKPM_bak1.rar',16,NULL,1),(41,'5.rar','http://localhost/mycms/upload/files/1291123869_5.rar',15,NULL,1),(42,'5.rar','http://localhost/mycms/upload/files/1291213934_5.rar',NULL,NULL,1),(43,'5.rar','http://localhost/mycms/upload/files/1291219665_5.rar',1,NULL,1),(44,'Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf','http://localhost/mycms/upload/files/1291219775_Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf',16,NULL,1),(45,'K14_VB2CQ.PHIEUDANGKY.MAU.pdf','http://localhost/mycms/upload/files/1291221620_K14_VB2CQ.PHIEUDANGKY.MAU.pdf',15,NULL,1),(46,'1290864404_DeXDPMHDT_05HCA.pdf','http://localhost/mycms/upload/files/1291223690_1290864404_DeXDPMHDT_05HCA.pdf',NULL,NULL,1),(47,'1290864404_DeXDPMHDT_05HCA.pdf','http://localhost/mycms/upload/files/1291228072_1290864404_DeXDPMHDT_05HCA.pdf',17,NULL,1),(48,'Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf','http://localhost/mycms/upload/files/1291228329_Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf',17,NULL,1),(49,'Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf','http://localhost/mycms/upload/files/1291228456_Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf',17,NULL,1),(51,'1290864404_DeXDPMHDT_05HCA.pdf','http://localhost/mycms/upload/files/1291302857_1290864404_DeXDPMHDT_05HCA.pdf',1,NULL,1),(52,'1290864404_DeXDPMHDT_05HCA.pdf','http://localhost/mycms/upload/files/1291303344_1290864404_DeXDPMHDT_05HCA.pdf',1,NULL,1),(53,'K14_VB2CQ.PHIEUDANGKY.MAU.pdf','http://localhost/mycms/upload/files/1291304208_K14_VB2CQ.PHIEUDANGKY.MAU.pdf',15,NULL,1),(54,'Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf','http://localhost/mycms/upload/files/1291308961_Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf',16,1,1),(55,'Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf','http://localhost/mycms/upload/files/1291309230_Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf',16,NULL,1),(56,'1290864404_DeXDPMHDT_05HCA.pdf','http://localhost/mycms/upload/files/1291310290_1290864404_DeXDPMHDT_05HCA.pdf',15,NULL,1),(57,'1.jpg','http://localhost/mycms/upload/files/1291494287_1.jpg',NULL,NULL,1),(58,'1a.jpg','http://localhost/mycms/upload/files/1291494326_1a.jpg',NULL,NULL,1),(59,'COG_112.pdf','http://localhost/mycms/upload/files/1291494582_COG_112.pdf',NULL,NULL,1),(60,'COG_112.pdf','http://localhost/mycms/upload/files/1291494750_COG_112.pdf',16,NULL,1),(61,'K14_VB2CQ.PHIEUDANGKY.MAU.pdf','http://localhost/mycms/upload/files/1291499983_K14_VB2CQ.PHIEUDANGKY.MAU.pdf',18,NULL,1),(62,'tipsy_0.1.7.zip','http://localhost/mycms/upload/files/1291510389_tipsy_0.1.7.zip',NULL,NULL,1),(63,'bt_0.9.5_rc1_0.zip','http://localhost/mycms/upload/files/1291510427_bt_0.9.5_rc1_0.zip',NULL,NULL,1),(64,'tipsy_0.1.7.zip','http://localhost/mycms/upload/files/1291510509_tipsy_0.1.7.zip',NULL,NULL,1),(65,'tipsy_0.1.7.zip','http://localhost/mycms/upload/files/1291510549_tipsy_0.1.7.zip',NULL,NULL,1),(66,'Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf','http://localhost/mycms/upload/files/1291510954_Thu_moi_tuyen_dung_CTV_CNTT_tai_HCM.PDF___Adobe_Acrobat.pdf',NULL,NULL,1),(67,'1290865628_KHHVu_CQ.pdf','http://localhost/mycms/upload/files/1291540192_1290865628_KHHVu_CQ.pdf',19,NULL,1),(68,'COG_112.pdf','http://localhost/mycms/upload/files/1291739016_COG_112.pdf',20,NULL,1),(69,'dau_thau.jpg','http://localhost/mycms/upload/files/1292073416_dau_thau.jpg',NULL,NULL,1),(70,'dau_thau.jpg','http://localhost/mycms/upload/files/1292073840_dau_thau.jpg',NULL,NULL,1),(71,'Guidelines_Procurement_vn.pdf','http://localhost/mycms/upload/files/1292168381_Guidelines_Procurement_vn.pdf',10,NULL,1),(72,'1290865628_KHHVu_CQ.pdf','http://localhost/mycms/upload/files/1292169668_1290865628_KHHVu_CQ.pdf',19,NULL,1),(73,'COG_112.pdf','http://localhost/mycms/upload/files/1292602378_COG_112.pdf',19,NULL,1),(74,'29_10_2010_03.pdf','http://localhost/mycms/upload/files/1292602774_29_10_2010_03.pdf',15,NULL,1),(75,'1290865628_KHHVu_CQ.pdf','http://localhost/mycms/upload/files/1292602924_1290865628_KHHVu_CQ.pdf',18,1,1),(76,'29_10_2010_03.pdf','http://localhost/mycms/upload/files/1292775668_29_10_2010_03.pdf',15,NULL,1);

/*Table structure for table `hosothaus` */

DROP TABLE IF EXISTS `hosothaus`;

CREATE TABLE `hosothaus` (
  `id` bigint(20) NOT NULL auto_increment,
  `giathau` bigint(20) default NULL,
  `milestone` int(11) default NULL,
  `thoigian` int(11) default NULL,
  `content` text character set utf8,
  `ngaygui` datetime default NULL,
  `nhathau_id` bigint(20) default NULL,
  `duan_id` bigint(20) default NULL,
  `trangthai` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_bids_duans` (`duan_id`),
  KEY `FK_hosothaus_nhathaus` (`nhathau_id`),
  CONSTRAINT `FK_bids_duans` FOREIGN KEY (`duan_id`) REFERENCES `duans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_hosothaus_nhathaus` FOREIGN KEY (`nhathau_id`) REFERENCES `nhathaus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `hosothaus` */

insert  into `hosothaus`(`id`,`giathau`,`milestone`,`thoigian`,`content`,`ngaygui`,`nhathau_id`,`duan_id`,`trangthai`) values (3,2000000,50,5,'vui long xem ho so cua toi','2010-12-17 21:29:35',12,16,1),(4,4000000,60,8,'Let\'s start ! can be done more detail in pm ','2010-12-17 21:30:37',12,15,1),(5,1000000,50,1,'Kindly check your Pm Thanks. ','2010-12-17 21:31:13',12,14,1),(6,100000,50,1,'Hi! Tôi thực sự quan tâm tham gia lập dự án. Xin vui lòng xem PM của tôi để biết chi tiết. Cảm ơn','2010-12-17 21:31:48',12,12,1),(16,600000,50,3,'Hi, Im a 10 + tuổi có kinh nghiệm chuyên gia photoshop hình ảnh kỹ thuật số. Tôi muốn làm việc trên các dự án tương lai của bạn. Xem Ban QLDA. cảm ơn, byron','2010-12-17 23:12:58',18,22,1),(18,550000,40,2,'hãy kiểm tra thankks Ban QLDA','2010-12-17 23:22:04',12,22,2),(19,500000,50,3,'da','2010-12-22 16:30:57',8,21,2),(21,500,NULL,1,'chuyên gia trong wordpress / php / công trình html, chỉnh bổ sung và lập trình có thể được thực hiện theo yêu cầu của bạn có thể làm perfeclty công việc của bạn, đã thực hiện nhiều dự án tương tự, có thể cung cấp u với w3c xác nhận, css dựa trên bố trí, qua trình duyệt hỗ trợ, tablelesss, gọn gàng và mã css sạch, mã được tối ưu hóa seo, plz thấy chiều để đánh giá công việc của tôi','2010-12-24 15:22:41',15,18,2),(22,600000,40,5,'Xin chào thưa ngài, tôi đã sẵn sàng để thiết kế logos.I của bạn sẽ làm việc cho đến khi bạn nhận được 100% satisfaction.Please tham khảo the\'Message Inbox\'for thêm chi tiết, danh mục đầu tư, các công trình mẫu','2010-12-26 14:55:58',12,19,1),(25,600000,50,5,'Tôi chắc chắn rằng dự án này là có thể cho tôi. Tôi đã thực hiện nhiều trang web. Tôi sẵn sàng để làm điều đó. Tôi chắc chắn rằng tôi sẽ hoàn thành nó trong 1 ngày. Xin vui lòng liên hệ với tôi.','2010-12-27 09:21:58',12,18,1),(26,600000,NULL,4,'dd','2010-12-28 11:50:22',12,14,1);

/*Table structure for table `images` */

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` bigint(20) NOT NULL auto_increment,
  `filename` varchar(50) default NULL,
  `fileurl` varchar(500) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `images` */

insert  into `images`(`id`,`filename`,`fileurl`) values (1,'1287474677_e2nz.png','http://localhost/mycms/images/upload/1287474677_e2nz.png'),(2,'1287544883_Fire_Dragon_Icon.jpg','http://localhost/mycms/images/upload/1287544883_Fire_Dragon_Icon.jpg'),(3,'1287544890_arrow.jpg','http://localhost/mycms/images/upload/1287544890_arrow.jpg'),(4,'1287544897_active.png','http://localhost/mycms/images/upload/1287544897_active.png'),(5,'1287544904_ActiveSync_icon_by_alex3305.png','http://localhost/mycms/images/upload/1287544904_ActiveSync_icon_by_alex3305.png'),(6,'1287563610_excel.png','http://localhost/mycms/images/upload/1287563610_excel.png'),(7,'1287632806_banner.jpg','http://localhost/mycms/images/upload/1287632806_banner.jpg'),(8,'1287644796_2[3].jpg','http://localhost/mycms/images/upload/1287644796_2[3].jpg'),(9,'1287645605_b2.jpg','http://localhost/mycms/images/upload/1287645605_b2.jpg'),(10,'1287645742_2a.jpg','http://localhost/mycms/images/upload/1287645742_2a.jpg'),(11,'1287645821_sub.jpg','http://localhost/mycms/images/upload/1287645821_sub.jpg'),(12,'1287646690_mes2.jpg','http://localhost/mycms/images/upload/1287646690_mes2.jpg'),(13,'1287647107_cuu1.jpg','http://localhost/mycms/images/upload/1287647107_cuu1.jpg'),(14,'1287647165_yk2.jpg','http://localhost/mycms/images/upload/1287647165_yk2.jpg'),(15,'1287712085_Older_IBM_Logo_2.png','http://localhost/mycms/images/upload/1287712085_Older_IBM_Logo_2.png'),(16,'1290442295_Koala.jpg','http://localhost/mycms/images/upload/1290442295_Koala.jpg'),(17,'1290442340_Lighthouse.jpg','http://localhost/mycms/images/upload/1290442340_Lighthouse.jpg');

/*Table structure for table `linhvucs` */

DROP TABLE IF EXISTS `linhvucs`;

CREATE TABLE `linhvucs` (
  `id` varchar(100) character set ascii NOT NULL,
  `tenlinhvuc` varchar(100) default NULL,
  `soduan` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `linhvucs` */

insert  into `linhvucs`(`id`,`tenlinhvuc`,`soduan`) values ('cntt','Công nghệ thông tin',3),('co_khi','Cơ khí',3),('design','Thiết kế',3),('dien_tu','Điện tử 1',2),('khac','Khác',1),('kien_truc','Kiến trúc',5),('seo','SEO',NULL);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` varchar(50) NOT NULL,
  `name` varchar(50) default NULL,
  `url` varchar(500) default NULL,
  `order` int(11) default NULL,
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

insert  into `menus`(`id`,`name`,`url`,`order`,`active`) values ('home','Trang Chủ','http://localhost/mycms',1,1),('lien-he','Liên Hệ','http://localhost/mycms/webmaster/contact',8,1),('login','Đăng Nhập','http://localhost/mycms/account/login',6,0),('news','Tin Tức','http://localhost/mycms/article/news',5,0),('page3','Page3','http://localhost/mycms/page/view/3/doc-suc-lo-cho-mien-trung-ruot-thit-',4,0),('tao-du-an','Tạo Dự Án','http://localhost/mycms/duan/add',2,1),('tim-du-an','Tìm Dự Án','http://localhost/mycms/duan/search',3,1),('tro-giup','Trợ Giúp','http://localhost/mycms/webmaster/help',6,1);

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL auto_increment,
  `thongdiep` text character set utf8,
  `time` datetime default NULL,
  `account_id` bigint(20) default NULL,
  `duan_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `messages` */

/*Table structure for table `nhathaulinhvucs` */

DROP TABLE IF EXISTS `nhathaulinhvucs`;

CREATE TABLE `nhathaulinhvucs` (
  `id` bigint(20) NOT NULL auto_increment,
  `nhathau_id` bigint(20) default NULL,
  `linhvuc_id` varchar(100) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_nhathaulinhvucs_nhathaus` (`nhathau_id`),
  CONSTRAINT `FK_nhathaulinhvucs_nhathaus` FOREIGN KEY (`nhathau_id`) REFERENCES `nhathaus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;

/*Data for the table `nhathaulinhvucs` */

insert  into `nhathaulinhvucs`(`id`,`nhathau_id`,`linhvuc_id`) values (91,NULL,'cntt'),(92,NULL,'design'),(93,NULL,'cntt'),(94,NULL,'design'),(95,NULL,'cntt'),(96,NULL,'design'),(108,8,'cntt'),(109,8,'design'),(110,8,'dien_tu'),(112,14,'kien_truc'),(126,18,'cntt'),(127,18,'khac'),(143,15,'cntt'),(144,22,'cntt'),(145,12,'kien_truc'),(146,12,'seo'),(147,21,'kien_truc'),(148,21,'seo'),(149,23,'seo'),(150,24,'seo');

/*Table structure for table `nhathaus` */

DROP TABLE IF EXISTS `nhathaus`;

CREATE TABLE `nhathaus` (
  `id` bigint(20) NOT NULL auto_increment,
  `displayname` varchar(255) character set utf8 default NULL,
  `motachitiet` text character set utf8,
  `gpkd_cmnd` varchar(100) character set utf8 default NULL,
  `birthyear` int(11) default NULL,
  `diachilienhe` varchar(255) character set utf8 default NULL,
  `file_id` bigint(20) default NULL,
  `account_id` bigint(20) default NULL,
  `diemdanhgia` int(11) default NULL,
  `nhanemail` tinyint(1) default NULL,
  `income` bigint(20) default NULL,
  `type` int(11) default NULL,
  `status` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_hosonhathaus_files` (`file_id`),
  KEY `FK_nhathaus_accounts` (`account_id`),
  CONSTRAINT `FK_hosonhathaus_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_nhathaus_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `nhathaus` */

insert  into `nhathaus`(`id`,`displayname`,`motachitiet`,`gpkd_cmnd`,`birthyear`,`diachilienhe`,`file_id`,`account_id`,`diemdanhgia`,`nhanemail`,`income`,`type`,`status`) values (8,'Công ty TNHH ABC','<p class=\"pHead\" style=\"font-weight: bold; color: #003300;\">SGTT.VN - Ng&agrave;y 2.12, tin từ C&ocirc;ng an th&agrave;nh phố Hải Ph&ograve;ng  cho biết người điều khiển xe đ&atilde; c&aacute;n chết một thanh ni&ecirc;n tại chỗ v&agrave; l&agrave;m  một người kh&aacute;c bị thương nặng đ&ecirc;m 27.11 l&agrave; trung t&aacute; Nguyễn Thị Lan Anh,  ph&oacute; trưởng ph&ograve;ng PA 65 C&ocirc;ng an Hải Ph&ograve;ng.</p>\n<p class=\"pBody\">Trung t&aacute; Nguyễn Thị Lan Anh (sinh năm 1972), ph&oacute; trưởng  ph&ograve;ng PA 65, C&ocirc;ng an Hải Ph&ograve;ng l&agrave; người điều khiển chiếc xe Kia Morning  biển số 16N - 2992 g&acirc;y tai nạn l&agrave;m anh Nguyễn T&acirc;n Cương (sinh năm 1983)  thiệt mạng v&agrave; anh Đỗ Văn Hiệp (sinh năm 1985 c&ugrave;ng tr&uacute; tại phường Ngọc  Hải, quận Đồ Sơn) bị thương trong đ&ecirc;m 27.11 tại Đồ Sơn.</p>','KOD 2212',NULL,NULL,52,1,4,1,NULL,2,1),(12,'Công ty TNHH Tuấn Ngọc Production','<P>Trẻ trung và thời trang, đó là phong cách đẳng cấp của <STRONG><FONT color=#33cc00>Tuấn Ngọc Production</FONT></STRONG></P>','KD 2010',2005,'233 Điện Biên Phủ',61,18,5,1,NULL,2,1),(14,'Tuấn Hưng','Tôi là Tuấn Hưng',NULL,NULL,NULL,68,20,0,1,NULL,1,1),(15,'Chí Long 2','<P>Nhan thiet ke web chuyen nghiep gia re</P>','225320320',1986,NULL,71,10,3,1,NULL,1,1),(18,'Công ty TNHH Tuấn Ngọc 2','Hồ sơ năng lực nhà thầu: Giấy phép đại lý độc quyền của nhà sản xuất, giấy đăng kí kinh doanh, kèm theo tài liệu chứng minh tư cách hợp lệ, kinh nghiệm và năng lực của nhà thầu. Giới thiệu các hợp đồng tương tự đã và đang thực hiện trong 3 năm gần đây: 2008, 2009 và 2010','KD4 2005',NULL,NULL,72,19,0,1,NULL,2,1),(21,'Lê Văn A','<P>Góp phần trong thực hiện nghiên cứu nói trên về phía Việt Nam, nguyên thứ trưởng bộ Tài nguyên - môi trường Đặng Hùng Võ cho biết, với 600 ý kiến của cán bộ cấp huyện, tỉnh, đại diện doanh nghiệp, người dân… của năm tỉnh, có thể thấy rằng, tham nhũng phổ biến nhất trong đất đai liên quan đến những người trung gian, hay còn gọi là “cò” đất.</P>\r\n<P>Loại tham nhũng này làm trì trệ thủ tục cấp giấy chứng nhận lần đầu, cũng như đăng ký các giao dịch về bất động sản. Người dân thường phải sử dụng dịch vụ “cò”, để làm nhanh thủ tục.<BR></P>','223443214',1966,'456 Hoang Hoa Tham',76,15,0,NULL,NULL,1,1),(22,'long','ddw','1234432',1989,'543 npt',0,22,0,1,NULL,1,1),(23,'My Trang','<SPAN id=result_box lang=vi class=short_text><SPAN class=hps title=\"Click for alternate translations\">Để</SPAN> <SPAN class=hps title=\"Click for alternate translations\">cung cấp các</SPAN> <SPAN class=hps title=\"Click for alternate translations\">giải pháp</SPAN> <SPAN class=hps title=\"Click for alternate translations\">sáng tạo</SPAN> <SPAN class=hps title=\"Click for alternate translations\">để thành công.</SPAN></SPAN>','123456789',1986,'465 Vuon Lai, Tan Phu',0,16,0,1,NULL,1,1),(24,'Cong ty TNHH Ngoi sao My Trang','Toi la My Trang','KD2010',2000,'70  Van Cao, Tan Phu',0,32,0,1,NULL,2,1);

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` bigint(20) NOT NULL auto_increment,
  `alias` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `content` text,
  `datemodified` datetime default NULL,
  `usermodified` varchar(100) default NULL,
  `menu_id` varchar(50) default '0',
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`id`,`alias`,`title`,`content`,`datemodified`,`usermodified`,`menu_id`,`active`) values (1,'products-12','Products 12','<p><span style=\"color: #ff0000;\"><strong>San pham test<br /></strong></span></p>','2010-10-22 22:14:17','admin','page2',1),(2,'trang-dem-cho-tim-xac-nguoi-than','Trắng đêm chờ  tìm xác người thân','<p class=\"Lead\">\"Thợ lặn b&aacute;o t&igrave;m được chiếc xe, t&ocirc;i chạy vội ra thắp  hương cầu khấn. Cả đ&ecirc;m kh&ocirc;ng t&agrave;i n&agrave;o ngủ được, đ&agrave;nh ra bờ s&ocirc;ng cầu mong  cho x&aacute;c chị c&ograve;n nằm trong đ&oacute;\", th&acirc;n nh&acirc;n của chị Phạm Thị C&uacute;c v&agrave; b&eacute; g&aacute;i 7  th&aacute;ng tuổi tr&ecirc;n chuyến xe định mệnh n&oacute;i. <br />&gt;<a class=\"Lead\" href=\"http://vnexpress.net/GL/Xa-hoi/2010/10/3BA21D05/\">Tiếng k&ecirc;u cứu tuyệt vọng tr&ecirc;n chiếc xe bị lũ cuốn</a>/ <a class=\"Lead\" href=\"http://vnexpress.net/GL/Xa-hoi/2010/10/3BA21E3B/\">T&igrave;m thấy xe kh&aacute;ch bị lũ cuốn tr&ocirc;i</a></p>\n<p class=\"Normal\">24h đ&ecirc;m, ngồi bần thần tr&ecirc;n quốc lộ 1A nh&igrave;n ra hai  chiếc t&agrave;u đang neo giữ chiếc xe kh&aacute;ch dưới l&ograve;ng s&ocirc;ng Lam đang chảy xiết,  chị Ho&agrave;ng Thị B&iacute;ch Hồng n&oacute;i như muốn kh&oacute;c: \"Thợ lặn b&aacute;o đ&atilde; t&igrave;m được  chiếc xe, t&ocirc;i chạy ngay ra bờ s&ocirc;ng thắp hương cầu khấn. Cả đ&ecirc;m kh&ocirc;ng t&agrave;i  n&agrave;o ngủ được, đ&agrave;nh ra bờ s&ocirc;ng cầu mong cho x&aacute;c chị c&ograve;n nằm trong đ&oacute;\".</p>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"268\" align=\"center\" bgcolor=\"#ddddff\">\n<tbody>\n<tr>\n<td>*<em>Clip</em> <a href=\"http://vnexpress.net/GL/Xa-hoi/2010/10/3BA21E6A/page_2.asp\"><strong>Cứu hộ xe kh&aacute;ch tr&ecirc;n s&ocirc;ng Lam</strong></a></td>\n</tr>\n</tbody>\n</table>\n<p class=\"Normal\">Chị Hồng l&agrave; người nh&agrave; của nạn nh&acirc;n Phạm Thị C&uacute;c v&agrave; b&eacute;  g&aacute;i 7 th&aacute;ng tuổi ở Đăk Lăk. Nghe tin hai mẹ con bị nạn tr&ecirc;n đường về  thăm qu&ecirc; Nam Định, cả đại gia đ&igrave;nh chị ngất l&ecirc;n ngất xuống, b&agrave; mẹ gi&agrave;  lịm dần phải v&agrave;o viện cấp cứu c&ograve;n chồng chị C&uacute;c cứ ngơ ngơ, ngẩn ngẩn&hellip;</p>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"1\" align=\"center\">\n<tbody>\n<tr>\n<td><img src=\"http://vnexpress.net/Files/Subject/3B/A2/1E/6A/IMG_0940a.jpg\" alt=\"\" width=\"495\" height=\"358\" /></td>\n</tr>\n<tr>\n<td class=\"Image\">Chị Hồng đau đ&aacute;u nh&igrave;n về s&ocirc;ng Lam, nơi đ&oacute; c&oacute; người chị vừa đứa ch&aacute;u g&aacute;i 7 th&aacute;ng tuổi của chị.</td>\n</tr>\n</tbody>\n</table>\n<p class=\"Normal\">Vượt mưa lũ từ Nam Định v&agrave;o Nghi Xu&acirc;n (H&agrave; Tĩnh), 3 đ&ecirc;m  liền chị Hồng ra bờ s&ocirc;ng ng&oacute;ng tr&ocirc;ng tin tức người chị xấu số. Mỗi khi  nghe một &acirc;m thanh lạ như tiếng c&ograve;i h&uacute; của cảnh s&aacute;t, xe cấp cứu&hellip;, &aacute;nh mắt  chị lại thấp thỏm chờ mong.</p>\n<p class=\"Normal\">Chiều 20/10, khi người thợ lặn ngoi l&ecirc;n bờ khẳng định  đ&atilde; t&igrave;m được chiếc xe bị tr&ocirc;i, chị đ&atilde; &ocirc;m chầm lấy th&acirc;n nh&acirc;n c&aacute;c nạn nh&acirc;n.  Cả đ&ecirc;m qua kh&ocirc;ng ngủ được, chị lại ra bờ s&ocirc;ng cầu khấn hy vọng cho x&aacute;c  sẽ c&ograve;n ở trong xe v&agrave; qu&aacute; tr&igrave;nh trục vớt diễn ra an to&agrave;n.</p>\n<p class=\"Normal\">Kế hoạch trục vớt chiếc xe ngay trong đ&ecirc;m bị hủy bỏ v&igrave;  s&oacute;ng to, gi&oacute; lớn v&agrave; nước s&acirc;u, một số th&acirc;n nh&acirc;n l&ecirc;n &ocirc;t&ocirc; về ph&ograve;ng nghỉ  lấy sức chờ ng&agrave;y mai, một số thức trắng tr&ecirc;n bờ s&ocirc;ng để cầu nguyện.</p>\n<p class=\"Normal\">C&ugrave;ng chung t&acirc;m trạng như chị Hồng, anh Nguyễn Văn Th&acirc;n  ở Thanh H&oacute;a, ch&uacute; ruột của hai chị em Đỗ Thị Phượng (17 tuổi), Đỗ Thị  Lan (15 tuổi) tr&ecirc;n chuyến xe định mệnh cũng chỉ hy vọng sẽ c&ograve;n x&aacute;c của  ch&aacute;u g&aacute;i m&igrave;nh trong xe.</p>\n<p class=\"Normal\">&ldquo;Hai chị em n&oacute; khổ lắm, học hết lớp 6 đ&atilde; phải bỏ học  đi T&acirc;y Nguy&ecirc;n trồng c&agrave; ph&ecirc;, nay hai đứa về để ăn cưới người d&igrave; ruột. Ai  ngờ mọi người lại phải lo đ&aacute;m tang chung cho hai đứa. Cha mẹ n&oacute; ngất xỉu  khi nghe tin con bị chết chưa t&igrave;m thấy x&aacute;c&rdquo;, anh Th&acirc;n n&oacute;i trong nước  mắt.</p>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"1\" align=\"center\">\n<tbody>\n<tr>\n<td><img src=\"http://vnexpress.net/Files/Subject/3B/A2/1E/6A/IMG_0945a.jpg\" alt=\"\" width=\"495\" height=\"362\" /></td>\n</tr>\n<tr>\n<td class=\"Image\">Anh Th&acirc;n thức trắng đ&ecirc;m b&ecirc;n bờ s&ocirc;ng Lam.</td>\n</tr>\n</tbody>\n</table>\n<p class=\"Normal\">Đ&ecirc;m qua, cả chị Hồng v&agrave; anh Th&acirc;n thẫn thờ nh&igrave;n ra biển  nước m&ecirc;nh m&ocirc;ng, thỉnh thoảng lại cầu trời mong cho đến s&aacute;ng. Ở kh&aacute;ch  sạn nơi những th&acirc;n nh&acirc;n đang nghỉ ngơi, những người kh&aacute;c cũng chong đ&egrave;n  suốt đ&ecirc;m chờ trời s&aacute;ng v&agrave; cầu mong cho x&aacute;c của người th&acirc;n chưa tr&ocirc;i khỏi  xe&hellip;</p>\n<p class=\"Normal\">Đ&ecirc;m qua, trăng s&aacute;ng vằng vặc, nước s&ocirc;ng Lam vẫn đỏ  ng&agrave;u, thỉnh thoảng tiếng s&oacute;ng nước vỗ v&agrave;o bờ k&egrave; lẫn với tiếng kh&oacute;c nức  nở của th&acirc;n nh&acirc;n nạn nh&acirc;n.</p>\n<p class=\"Normal\">4h s&aacute;ng 18/10, xe kh&aacute;ch từ Đăk N&ocirc;ng ra Bắc đến x&atilde; Xu&acirc;n  Lam (Nghi Xu&acirc;n, H&agrave; Tĩnh) đ&atilde; bị lũ cuốn lật v&agrave; tr&ocirc;i xuống s&ocirc;ng Lam.  Nhiều h&agrave;nh kh&aacute;ch đ&atilde; đập cửa k&iacute;nh tho&aacute;t ra. Lực lượng cứu hộ v&agrave; người d&acirc;n  ch&egrave;o thuyền ra cứu được 18 người. 20 người c&ograve;n lại bị mất t&iacute;ch.</p>\n<p class=\"Normal\" style=\"text-align: right;\"><strong>Nguy&ecirc;n Khoa &ndash; Nguyễn Hưng</strong></p>','2010-10-22 22:21:45','admin','page1',1),(3,'doc-suc-lo-cho-mien-trung-ruot-thit','Dốc sức lo cho miền Trung ruột thịt','<p class=\"Lead\">11h trưa nay, xe kh&aacute;ch bị cuốn tr&ocirc;i tại Nghi Xu&acirc;n (H&agrave;  Tĩnh) đ&atilde; được t&agrave;u k&eacute;o l&ecirc;n v&agrave; đưa v&agrave;o bờ s&ocirc;ng Lam. Trước đ&oacute; 4 x&aacute;c h&agrave;nh  kh&aacute;ch đ&atilde; được t&igrave;m thấy.<br />* Tiếp tục cập nhật (độc giả nhấn F5).<br />&gt; <a class=\"Lead\" href=\"http://vnexpress.net/GL/Xa-hoi/2010/10/3BA21D05/\">Tiếng k&ecirc;u cứu tuyệt vọng tr&ecirc;n chiếc xe bị lũ cuốn</a>/ <a class=\"Lead\" href=\"http://vnexpress.net/GL/Xa-hoi/2010/10/3BA21E3B/\">T&igrave;m thấy xe kh&aacute;ch bị lũ cuốn tr&ocirc;i</a></p>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"1\" align=\"center\">\n<tbody>\n<tr>\n<td><img src=\"http://vnexpress.net/Files/Subject/3B/A2/1E/3B/a5.jpg\" alt=\"\" width=\"495\" height=\"330\" /></td>\n</tr>\n<tr>\n<td class=\"Image\">C&aacute;c lực lượng tập kết tr&ecirc;n s&ocirc;ng Lam. Ảnh: <em>H&agrave; Khoa</em></td>\n</tr>\n</tbody>\n</table>\n<p class=\"Normal\">Trong số nạn nh&acirc;n được t&igrave;m thấy, một người đ&atilde; x&aacute;c định  danh t&iacute;nh l&agrave; t&agrave;i xế Đinh Văn Lương. Anh n&agrave;y bị mắc ngay bụi c&acirc;y c&aacute;ch  địa điểm xe bị tr&ocirc;i v&agrave;i trăm m&eacute;t, tr&ecirc;n người c&ograve;n nguy&ecirc;n chiếc v&iacute; chứa  rất nhiều giấy tờ v&agrave; tiền bạc. Trong xe được cho l&agrave; c&oacute; 19 nạn nh&acirc;n.</p>\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"3\" width=\"307\" align=\"center\" bgcolor=\"#ffe1e1\">\n<tbody>\n<tr>\n<td><em>Clip</em>:<strong><a href=\"http://vnexpress.net/GL/Xa-hoi/2010/10/3BA21E3B/page_2.asp\"> Cứu hộ xe kh&aacute;ch tr&ecirc;n s&ocirc;ng Lam</a></strong></td>\n</tr>\n</tbody>\n</table>\n<p class=\"Normal\">Từ 6h30 lực lượng trực vớt khoảng 100 người gồm c&ocirc;ng  binh, bộ đội bi&ecirc;n ph&ograve;ng, c&ocirc;ng an v&agrave; lực lượng cứu hộ của 6 doanh nghiệp  đ&atilde; c&oacute; mặt. Ngo&agrave;i hai t&agrave;u k&eacute;o cỡ lớn, hai x&agrave; lan của doanh nghiệp, rất  nhiều cano t&igrave;m kiếm trước đ&oacute;, s&aacute;ng nay qu&acirc;n đội đ&atilde; huy động th&ecirc;m một t&agrave;u  đầu k&eacute;o cỡ lớn phục vụ cho việc trục vớt.</p>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"1\" align=\"center\">\n<tbody>\n<tr>\n<td><img src=\"http://vnexpress.net/Files/Subject/3B/A2/1E/3B/902.jpg\" border=\"1\" alt=\"\" width=\"495\" height=\"350\" /></td>\n</tr>\n<tr>\n<td class=\"Image\">Chuẩn bị trục vớt.</td>\n</tr>\n</tbody>\n</table>\n<p class=\"Normal\">9h, hai chiếc t&agrave;u, hai chiếc x&agrave; lan chia th&agrave;nh hai  nh&oacute;m c&ugrave;ng tiếp cận vị tr&iacute; chiếc xe. C&aacute;c thợ lặn ngậm v&ograve;i oxy v&agrave; mang  theo d&acirc;y c&aacute;p, sẵn s&agrave;ng nhảy xuống s&ocirc;ng. Theo kế hoạch, sau khi m&oacute;c d&acirc;y  c&aacute;p, t&agrave;u v&agrave; x&agrave; lan sẽ n&acirc;ng xe l&ecirc;n, để xe lội nước v&agrave; xe đầu k&eacute;o chuy&ecirc;n  dụng của qu&acirc;n đội k&eacute;o v&agrave;o bờ.</p>\n<p class=\"Normal\">9h10, lực lượng cứu hộ vớt th&ecirc;m x&aacute;c một nạn nh&acirc;n l&agrave;  anh Đinh Xu&acirc;n Thường. Thi thể nạn nh&acirc;n được đưa v&agrave;o l&aacute;n tập kết, nơi c&oacute;  th&acirc;n nh&acirc;n đang chờ sẵn để nhận dạng.</p>\n<p class=\"Normal\">9h15 hai thợ lăn ngoi l&ecirc;n mặt nước cho biết xe kh&aacute;ch  nằm ngang s&ocirc;ng, họ đ&atilde; m&oacute;c d&acirc;y c&aacute;p v&agrave;o xe để chuẩn bị k&eacute;o l&ecirc;n. Tr&ecirc;n hai  chiếc t&agrave;u, người nh&agrave; nạn nh&acirc;n đang l&agrave;m lễ theo phong tục địa phương.</p>\n<p class=\"Normal\">9h50, hai thợ lặn ngoi l&ecirc;n mặt nước cho biết, việc  buộc c&aacute;p rất kh&oacute; khăn do nước xiết, xe nằm s&acirc;u. Tiện nhất l&agrave; buộc v&agrave;o  b&aacute;nh xe, nhưng cả 8 b&aacute;nh đều bị v&ugrave;i s&acirc;u trong c&aacute;t. Lực lượng trục vớt  lại hội &yacute; để b&agrave;n c&aacute;ch buộc d&acirc;y c&aacute;p kh&aacute;c.</p>\n<p class=\"Normal\">Khoảng 10 ph&uacute;t sau, thợ lặn th&ocirc;ng b&aacute;o đ&atilde; buộc được c&aacute;p v&agrave;o b&aacute;nh xe, chuẩn bị n&acirc;ng xe l&ecirc;n khỏi vị tr&iacute;.</p>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"1\" align=\"center\">\n<tbody>\n<tr>\n<td><img src=\"http://vnexpress.net/Files/Subject/3B/A2/1E/3B/lan.jpg\" alt=\"\" width=\"495\" height=\"353\" /></td>\n</tr>\n<tr>\n<td class=\"Image\">Thợ lặn đang m&oacute;c d&acirc;y c&aacute;p v&agrave;o xe kh&aacute;ch gặp nạn.</td>\n</tr>\n</tbody>\n</table>\n<p class=\"Normal\">10h30, lực lượng cứu hộ nhận được điện thoại của ngư  d&acirc;n b&aacute;o ph&aacute;t hiện một thi thể tr&ecirc;n s&ocirc;ng Lam đoạn qua phường Bến Thủy,  th&agrave;nh phố Vinh (Nghệ An), c&aacute;ch nơi vị tr&iacute; xe tai nạn khoảng 10 km. Ngư  d&acirc;n đ&atilde; neo x&aacute;c lại để chờ cơ quan chức năng đến giải quyết.</p>\n<p class=\"Normal\">Dọc bờ s&ocirc;ng Lam, khoảng 10 xuồng cao tốc của c&ocirc;ng an,  bộ đội, bi&ecirc;n ph&ograve;ng li&ecirc;n tục tuần tiễu quanh vị tr&iacute; xe gặp nạn để hỗ trợ.  Một số người d&acirc;n ch&egrave;o thuyền nan ra sẵn s&agrave;ng gi&uacute;p đỡ khi cần thiết.</p>\n<p class=\"Normal\">Quốc lộ 1A bị phong tỏa khoảng một km. Tuy nhi&ecirc;n, h&agrave;ng ngh&igrave;n người d&acirc;n đ&atilde; đi v&ograve;ng l&ecirc;n n&uacute;i để chứng kiến.</p>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"1\" align=\"center\">\n<tbody>\n<tr>\n<td><img src=\"http://vnexpress.net/Files/Subject/3B/A2/1E/3B/900.jpg\" border=\"1\" alt=\"\" width=\"495\" height=\"350\" /></td>\n</tr>\n<tr>\n<td class=\"Image\">H&agrave;ng ngh&igrave;n người đứng tr&ecirc;n n&uacute;i theo d&otilde;i trục vớt.</td>\n</tr>\n</tbody>\n</table>\n<p class=\"normal\">Tỉnh H&agrave; Tĩnh cho biết sẽ hỗ trợ to&agrave;n bộ kinh ph&iacute; kh&acirc;m  liệm, gi&aacute;m định ph&aacute;p y, vệ sinh y tế, chuẩn bị xe đưa thi thể nạn nh&acirc;n  về qu&ecirc;. Mỗi gia đ&igrave;nh được hỗ trợ 6 triệu đồng.</p>\n<p class=\"Normal\">Chiều tối 20/10, sau nhiều giờ lặn khảo s&aacute;t v&agrave; neo c&aacute;p  cố định chiếc xe kh&aacute;ch dưới l&ograve;ng s&ocirc;ng, lực lượng cứu hộ quyết định chờ  tới s&aacute;ng nay mới tiến h&agrave;nh trục vớt.</p>\n<p class=\"Normal\" style=\"text-align: right;\"><strong>Nguyễn Hưng - Nguy&ecirc;n Khoa</strong></p>\n<p>﻿</p>','2010-10-22 17:30:42','nclong','page3',1),(10,'test','test','<p>test</p>','2010-10-22 22:14:46','admin','0',0);

/*Table structure for table `ppl_onlines` */

DROP TABLE IF EXISTS `ppl_onlines`;

CREATE TABLE `ppl_onlines` (
  `id` bigint(20) NOT NULL auto_increment,
  `activity` datetime NOT NULL default '0000-00-00 00:00:00',
  `access_time` datetime default NULL,
  `account_id` bigint(20) default NULL,
  `ip_address` varchar(255) default '',
  `refurl` varchar(255) default '',
  `user_agent` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ppl_onlines` */

insert  into `ppl_onlines`(`id`,`activity`,`access_time`,`account_id`,`ip_address`,`refurl`,`user_agent`) values (1,'2010-12-28 15:18:55','2010-12-28 15:18:09',NULL,'127.0.0.1',NULL,'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0)'),(2,'2010-12-28 16:43:36','2010-12-28 15:19:37',NULL,'127.0.0.1',NULL,'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0)'),(3,'2010-12-28 16:43:48','2010-12-28 16:18:19',1,'127.0.0.1',NULL,'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13'),(4,'2010-12-28 23:06:11','2010-12-28 19:56:47',1,'127.0.0.1',NULL,'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13'),(5,'2010-12-28 22:04:47','2010-12-28 20:13:54',30,'127.0.0.1',NULL,'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0)');

/*Table structure for table `resetpasswords` */

DROP TABLE IF EXISTS `resetpasswords`;

CREATE TABLE `resetpasswords` (
  `id` bigint(20) NOT NULL auto_increment,
  `account_id` bigint(20) default NULL,
  `times` int(11) default NULL,
  `verify` varchar(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_resetpasswords_accounts` (`account_id`),
  CONSTRAINT `FK_resetpasswords_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `resetpasswords` */

/*Table structure for table `sendmails` */

DROP TABLE IF EXISTS `sendmails`;

CREATE TABLE `sendmails` (
  `id` bigint(20) NOT NULL auto_increment,
  `to` varchar(100) default NULL,
  `subject` varchar(255) default NULL,
  `content` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `sendmails` */

insert  into `sendmails`(`id`,`to`,`subject`,`content`) values (1,'tuanngoc@yahoo.com','Du An Moi Tren JobBid!!!','<div id=\":17\" class=\"ii gt\">\n<div id=\":18\">\n<p>Ch&agrave;o bạn,<br />Ch&uacute;ng t&ocirc;i vừa t&igrave;m thấy 1 dự &aacute;n mới ph&ugrave; hợp với hồ sơ của bạn tr&ecirc;n trang <a href=\"http://www.jobbid.vn\">www.jobbid.vn</a> :<br />T&ecirc;n dự &aacute;n : <strong>dự án long ca</strong><br />Kinh ph&iacute; : <strong>1500000 đến 3000000 (VNĐ) </strong><br />Ng&agrave;y kết th&uacute;c : <strong>29/12/2010</strong><br /><br />Link xem chi tiết dự &aacute;n n&agrave;y : <a href=\'http://www.jobbid.vn/duan/view/1/du-an-long-ca\'>http://www.jobbid.vn/duan/view/1/du-an-long-ca</a><br /><br />Xin ch&acirc;n th&agrave;nh cảm ơn bạn.<br /><br /> Ban quản trị <a href=\"http://www.jobbid.vn/\">jobbid.vn</a></p>\n<br />\n<p>------------------------------------------------------------------------------<br /><span style=\"color: #888888;\"> <br /> </span><a href=\"http://www.jobbid.vn/\">Jobbid.vn</a><span style=\"color: #888888;\">&nbsp; -&nbsp; Website đấu gi&aacute; dự &aacute;n, c&ocirc;ng việc parttime:<br /> Address: 137 Điện Bi&ecirc;n Phủ, Phường Đakao, Quận 1, TP HCM<br /> Phone: (84.8) 730 89 589 | 3911 5284 | 3911 5285 | 3911 5286<br /> Website: </span><a href=\"http://www.jobbid.vn/\">jobbid.vn</a><span style=\"color: #888888;\"><br />Email: <a href=\"mailto:support@jobbid.vn\" target=\"_blank\">support@jobbid.vn</a> | </span><a href=\"mailto:admin@jobbid.vn\" target=\"_blank\">admin@jobbid.vn</a><span style=\"color: #888888;\"> </span></p>\n</div>\n</div>'),(2,'mytrang@gmail.com','Du An Moi Tren JobBid!!!','<div id=\":17\" class=\"ii gt\">\n<div id=\":18\">\n<p>Ch&agrave;o bạn,<br />Ch&uacute;ng t&ocirc;i vừa t&igrave;m thấy 1 dự &aacute;n mới ph&ugrave; hợp với hồ sơ của bạn tr&ecirc;n trang <a href=\"http://www.jobbid.vn\">www.jobbid.vn</a> :<br />T&ecirc;n dự &aacute;n : <strong>dự án long ca</strong><br />Kinh ph&iacute; : <strong>1500000 đến 3000000 (VNĐ) </strong><br />Ng&agrave;y kết th&uacute;c : <strong>29/12/2010</strong><br /><br />Link xem chi tiết dự &aacute;n n&agrave;y : <a href=\'http://www.jobbid.vn/duan/view/1/du-an-long-ca\'>http://www.jobbid.vn/duan/view/1/du-an-long-ca</a><br /><br />Xin ch&acirc;n th&agrave;nh cảm ơn bạn.<br /><br /> Ban quản trị <a href=\"http://www.jobbid.vn/\">jobbid.vn</a></p>\n<br />\n<p>------------------------------------------------------------------------------<br /><span style=\"color: #888888;\"> <br /> </span><a href=\"http://www.jobbid.vn/\">Jobbid.vn</a><span style=\"color: #888888;\">&nbsp; -&nbsp; Website đấu gi&aacute; dự &aacute;n, c&ocirc;ng việc parttime:<br /> Address: 137 Điện Bi&ecirc;n Phủ, Phường Đakao, Quận 1, TP HCM<br /> Phone: (84.8) 730 89 589 | 3911 5284 | 3911 5285 | 3911 5286<br /> Website: </span><a href=\"http://www.jobbid.vn/\">jobbid.vn</a><span style=\"color: #888888;\"><br />Email: <a href=\"mailto:support@jobbid.vn\" target=\"_blank\">support@jobbid.vn</a> | </span><a href=\"mailto:admin@jobbid.vn\" target=\"_blank\">admin@jobbid.vn</a><span style=\"color: #888888;\"> </span></p>\n</div>\n</div>'),(3,'mytrang6789@yahoo.com','Du An Moi Tren JobBid!!!','<div id=\":17\" class=\"ii gt\">\n<div id=\":18\">\n<p>Ch&agrave;o bạn,<br />Ch&uacute;ng t&ocirc;i vừa t&igrave;m thấy 1 dự &aacute;n mới ph&ugrave; hợp với hồ sơ của bạn tr&ecirc;n trang <a href=\"http://www.jobbid.vn\">www.jobbid.vn</a> :<br />T&ecirc;n dự &aacute;n : <strong>dự án long ca</strong><br />Kinh ph&iacute; : <strong>1500000 đến 3000000 (VNĐ) </strong><br />Ng&agrave;y kết th&uacute;c : <strong>29/12/2010</strong><br /><br />Link xem chi tiết dự &aacute;n n&agrave;y : <a href=\'http://www.jobbid.vn/duan/view/1/du-an-long-ca\'>http://www.jobbid.vn/duan/view/1/du-an-long-ca</a><br /><br />Xin ch&acirc;n th&agrave;nh cảm ơn bạn.<br /><br /> Ban quản trị <a href=\"http://www.jobbid.vn/\">jobbid.vn</a></p>\n<br />\n<p>------------------------------------------------------------------------------<br /><span style=\"color: #888888;\"> <br /> </span><a href=\"http://www.jobbid.vn/\">Jobbid.vn</a><span style=\"color: #888888;\">&nbsp; -&nbsp; Website đấu gi&aacute; dự &aacute;n, c&ocirc;ng việc parttime:<br /> Address: 137 Điện Bi&ecirc;n Phủ, Phường Đakao, Quận 1, TP HCM<br /> Phone: (84.8) 730 89 589 | 3911 5284 | 3911 5285 | 3911 5286<br /> Website: </span><a href=\"http://www.jobbid.vn/\">jobbid.vn</a><span style=\"color: #888888;\"><br />Email: <a href=\"mailto:support@jobbid.vn\" target=\"_blank\">support@jobbid.vn</a> | </span><a href=\"mailto:admin@jobbid.vn\" target=\"_blank\">admin@jobbid.vn</a><span style=\"color: #888888;\"> </span></p>\n</div>\n</div>'),(6,'mytrang@gmail.com','Du An Cua Ban Tren JobBid Vua Co Nguoi Dat Thau!!!','<div id=\":17\" class=\"ii gt\">\n<div id=\":18\">\n<p>Ch&agrave;o bạn,<br />Dự &aacute;n <a href=\'http://localhost/mycms/duan/view/18/$data[\"duan\"][\"alias\"]\'>Đồ họa máy tính</a> của bạn tr&ecirc;n trang <a href=\"http://www.jobbid.vn\">www.jobbid.vn</a> vừa c&oacute; 1 nh&agrave; thầu đặt thầu, th&ocirc;ng tin g&oacute;i thầu như sau:<br />T&ecirc;n nh&agrave; thầu : <strong>Công ty TNHH Tuấn Ngọc Production</strong><br />Gi&aacute; thầu : <strong>600000</strong> VNĐ<br />Thời gian : <strong>5</strong> (ng&agrave;y)<br />MileStone : <strong>50</strong> (%)<br /><br />Link xem chi tiết th&ocirc;ng tin nh&agrave; thầu n&agrave;y : <a href=\'http://localhost/mycms/hosothau/xem_ho_so/25/18\'>http://localhost/mycms/hosothau/xem_ho_so/25/18</a><br /><br />Xin ch&acirc;n th&agrave;nh cảm ơn bạn.<br /><br /> Ban quản trị <a href=\"http://www.jobbid.vn/\">jobbid.vn</a></p>\n<br />\n<p>------------------------------------------------------------------------------<br /><span style=\"color: #888888;\"> <br /> </span><a href=\"http://www.jobbid.vn/\">Jobbid.vn</a><span style=\"color: #888888;\">&nbsp; -&nbsp; Website đấu gi&aacute; dự &aacute;n, c&ocirc;ng việc parttime:<br /> Address: 137 Điện Bi&ecirc;n Phủ, Phường Đakao, Quận 1, TP HCM<br /> Phone: (84.8) 730 89 589 | 3911 5284 | 3911 5285 | 3911 5286<br /> Website: </span><a href=\"http://www.jobbid.vn/\">jobbid.vn</a><span style=\"color: #888888;\"><br />Email: <a href=\"mailto:support@jobbid.vn\" target=\"_blank\">support@jobbid.vn</a> | </span><a href=\"mailto:admin@jobbid.vn\" target=\"_blank\">admin@jobbid.vn</a><span style=\"color: #888888;\"> </span></p>\n</div>\n</div>'),(9,'nclong87@jobbid.com','Chuc Mung Ban Da Thang Thau Du An Tren JobBid.vn!!!','<div id=\":17\" class=\"ii gt\">\n<div id=\":18\">\n<p>Ch&agrave;o bạn,<br />Xin ch&uacute;c mừng bạn đ&atilde; thắng trong phi&ecirc;n đấu thầu dự &aacute;n <a href=\'http://localhost/mycms/duan/view/18/do-hoa-may-tinh\'>Đồ họa máy tính</a>.<br />Ch&uacute;ng t&ocirc;i xin gửi th&ocirc;ng tin li&ecirc;n lạc của chủ dự &aacute;n đến cho bạn, bạn c&oacute; thể li&ecirc;n hệ ngay với chủ dự &aacute;n để thực hiện dự &aacute;n n&agrave;y:<br /><br />Email : <strong>mytrang@gmail.com</strong><br />Số điện thoại : <strong>0979932151</strong><br /><br />Mọi chi tiết bạn c&oacute; thể xem tr&ecirc;n trang <a href=\"http://www.jobbid.vn\">jobbid.vn</a> theo link sau : <a href=\'http://localhost/mycms/duan/view/18/do-hoa-may-tinh\'>http://localhost/mycms/duan/view/18/do-hoa-may-tinh</a><br />Ch&uacute;c bạn th&agrave;nh c&ocirc;ng.<br />Xin ch&acirc;n th&agrave;nh cảm ơn bạn.<br /><br /> Ban quản trị <a href=\"http://www.jobbid.vn/\">jobbid.vn</a></p>\n<br />\n<p>------------------------------------------------------------------------------<br /><span style=\"color: #888888;\"> <br /> </span><a href=\"http://www.jobbid.vn/\">Jobbid.vn</a><span style=\"color: #888888;\">&nbsp; -&nbsp; Website đấu gi&aacute; dự &aacute;n, c&ocirc;ng việc parttime:<br /> Address: 137 Điện Bi&ecirc;n Phủ, Phường Đakao, Quận 1, TP HCM<br /> Phone: (84.8) 730 89 589 | 3911 5284 | 3911 5285 | 3911 5286<br /> Website: </span><a href=\"http://www.jobbid.vn/\">jobbid.vn</a><span style=\"color: #888888;\"><br />Email: <a href=\"mailto:support@jobbid.vn\" target=\"_blank\">support@jobbid.vn</a> | </span><a href=\"mailto:admin@jobbid.vn\" target=\"_blank\">admin@jobbid.vn</a><span style=\"color: #888888;\"> </span></p>\n</div>\n</div>'),(10,'nclong87@jobbid.com','Du An Cua Ban Tren JobBid Vua Co Nguoi Dat Thau!!!','<div id=\":17\" class=\"ii gt\">\n<div id=\":18\">\n<p>Ch&agrave;o bạn,<br />Dự &aacute;n <a href=\'http://localhost/mycms/duan/view/14/thiet-ke-mach-dien-cho-cong-ty-a\'>Thiết kế mạch điện cho công ty A</a> của bạn tr&ecirc;n trang <a href=\"http://www.jobbid.vn\">www.jobbid.vn</a> vừa c&oacute; 1 nh&agrave; thầu đặt thầu, th&ocirc;ng tin g&oacute;i thầu như sau:<br />T&ecirc;n nh&agrave; thầu : <strong>Công ty TNHH Tuấn Ngọc Production</strong><br />Gi&aacute; thầu : <strong>600000</strong> VNĐ<br />Thời gian : <strong>4</strong> (ng&agrave;y)<br />MileStone : <strong></strong> (%)<br /><br />Link xem chi tiết th&ocirc;ng tin nh&agrave; thầu n&agrave;y : <a href=\'http://localhost/mycms/hosothau/xem_ho_so/26/14\'>http://localhost/mycms/hosothau/xem_ho_so/26/14</a><br /><br />Xin ch&acirc;n th&agrave;nh cảm ơn bạn.<br /><br /> Ban quản trị <a href=\"http://www.jobbid.vn/\">jobbid.vn</a></p>\n<br />\n<p>------------------------------------------------------------------------------<br /><span style=\"color: #888888;\"> <br /> </span><a href=\"http://www.jobbid.vn/\">Jobbid.vn</a><span style=\"color: #888888;\">&nbsp; -&nbsp; Website đấu gi&aacute; dự &aacute;n, c&ocirc;ng việc parttime:<br /> Address: 137 Điện Bi&ecirc;n Phủ, Phường Đakao, Quận 1, TP HCM<br /> Phone: (84.8) 730 89 589 | 3911 5284 | 3911 5285 | 3911 5286<br /> Website: </span><a href=\"http://www.jobbid.vn/\">jobbid.vn</a><span style=\"color: #888888;\"><br />Email: <a href=\"mailto:support@jobbid.vn\" target=\"_blank\">support@jobbid.vn</a> | </span><a href=\"mailto:admin@jobbid.vn\" target=\"_blank\">admin@jobbid.vn</a><span style=\"color: #888888;\"> </span></p>\n</div>\n</div>');

/*Table structure for table `skills` */

DROP TABLE IF EXISTS `skills`;

CREATE TABLE `skills` (
  `id` bigint(20) NOT NULL auto_increment,
  `skillname` varchar(100) character set utf8 default NULL,
  `linhvuc_id` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `skills` */

insert  into `skills`(`id`,`skillname`,`linhvuc_id`) values (1,'AJAX','cntt'),(3,'Java Script','cntt'),(4,'PhotoShop','design'),(5,'3D Max','design'),(6,'HTML','cntt'),(7,'Quản lý chất lượng kết cấu thép','co_khi'),(8,'Lập hồ sơ nghiệm thu công trình','co_khi'),(9,'Flash','design'),(10,'Corel','design'),(11,'Bảo trì & bảo dưỡng điện','dien_tu'),(12,'Sửa chữa điện dân dụng','dien_tu'),(13,'Tốt nghiệp Đại Học','kien_truc'),(14,'Tốt nghiệp Đại Học','dien_tu'),(15,'Tốt nghiệp Đại Học','design'),(16,'Tốt nghiệp Đại Học','co_khi'),(17,'Tốt nghiệp Đại Học','cntt'),(18,'Optimization Link','seo'),(19,'English Skill','seo');

/*Table structure for table `tests` */

DROP TABLE IF EXISTS `tests`;

CREATE TABLE `tests` (
  `test` text,
  FULLTEXT KEY `test` (`test`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `tests` */

insert  into `tests`(`test`) values ('MySQL 5.0\r\nTable default charset UTF8\r\nNgôn ngữ dữ liệu: Tiếng Việt\r\n\r\nTABLE ----------------------------\r\n\r\ncreate table exam(\r\nid int auto_increment primary key,\r\nname varchar(1000),\r\nfulltext key \'a\' (name)\r\n)Engine=MyISAM Charset=utf8;\r\n\r\nQUERY ------------------------------\r\n\r\n1. select name from exam where match(name) against(\'nhân\');\r\n2. select name from exam where match(name) against(\'nhan\');\r\n\r\nRESULT -----------------------------\r\n\r\nDòng 1 - Kết quả ra luôn cả những dòng dữ liệu là \"nhận\"\r\nDòng 2 - Kết quả là: #1030 - Got error -1 from storage engine   Sad\r\n\r\n\r\n---------------------------------------\r\nTôi hiện không thể giải thích cho vấn đề trên, mong mọi người giúp đỡ.'),('long test'),('Nguyễn Chí Long');

/*Table structure for table `tinhs` */

DROP TABLE IF EXISTS `tinhs`;

CREATE TABLE `tinhs` (
  `id` bigint(20) NOT NULL auto_increment,
  `tentinh` varchar(100) character set utf8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tinhs` */

insert  into `tinhs`(`id`,`tentinh`) values (1,'TP Hồ Chí Minh'),(2,'Hà Nội'),(3,'Đà Nẵng'),(4,'Khánh Hòa');

/*Table structure for table `violations` */

DROP TABLE IF EXISTS `violations`;

CREATE TABLE `violations` (
  `id` bigint(20) NOT NULL auto_increment,
  `url` varchar(255) default NULL,
  `account_id` bigint(20) default NULL,
  `status` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_violations_accounts` (`account_id`),
  CONSTRAINT `FK_violations_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `violations` */

/*Table structure for table `widgets` */

DROP TABLE IF EXISTS `widgets`;

CREATE TABLE `widgets` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `content` text,
  `position` varchar(50) default NULL,
  `order` int(11) default NULL,
  `iscomponent` tinyint(1) default NULL,
  `showtitle` tinyint(1) default '1',
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `widgets` */

insert  into `widgets`(`id`,`name`,`content`,`position`,`order`,`iscomponent`,`showtitle`,`active`) values (1,'banner','<img title=\"banner\" src=\"http://localhost/mycms/images/upload/1287632806_banner.jpg\" alt=\"banner\" width=\"1000\" height=\"200\" />','banner',1,0,1,NULL),(2,'Menu','components/menu_component/menu.php','menu',1,1,1,1),(3,'Tin Mới','components/lastnews_component/lastnews_widget.php','leftcol',1,1,1,0),(4,'Banner IBM','<a class=\"imgbanner\" title=\"IBM\" href=\"http://www.ibm.com\" target=\"_blank\"><img title=\"a\" src=\"http://localhost/mycms/images/upload/1287712085_Older_IBM_Logo_2.png\" alt=\"a\" width=\"240\" height=\"111\" /></a>','leftcol',1,0,0,0),(6,'Football','<img style=\"float: left;\" title=\"d\" src=\"http://vnexpress.net/Files/Subject/3B/A2/11/CD/tung.jpg\" alt=\"aa\" width=\"240\" height=\"245\" />','rightcol',1,0,1,0),(7,'Footer','<span style=\"font-size: small;\"><span style=\"color: #0000ff;\"><a href=\"www.mycms.com\">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"http://www.mycms.com\">Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"http://www.mycms.com\">Contact</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"http://www.mycms.com\">Page4&nbsp;</a>&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; <a href=\"http://www.mycms.com\" target=\"_blank\">Page5</a><br /></span><a title=\"www.mycompany.com\" href=\"http://www.mycompany.com\">My CMS</a></span><br /><span style=\"color: #0000ff; font-size: small;\">Design By Nguyễn Ch&iacute; Long</span>','footer',1,0,0,1),(8,'Thành Viên','components/account_component/account_widget.php','rightcol',1,1,1,1),(9,'Thống Kê','components/statistics_component/statistics.php','rightcol',2,1,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
