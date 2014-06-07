# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.25)
# Datenbank: tippspiel
# Erstellungsdauer: 2014-05-21 06:43:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `shortname` varchar(10) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `shortname`, `slug`, `created`, `modified`)
VALUES
	(1,'Gruppe A','Gr. A','Gruppe_A','2014-05-16 01:19:25','2014-05-16 01:33:26'),
	(2,'Gruppe B','Gr. B','Gruppe_B','2014-05-16 01:19:25','2014-05-16 01:33:41'),
	(3,'Gruppe C','Gr. C','Gruppe_C','2014-05-16 01:19:25','2014-05-16 01:33:50'),
	(4,'Gruppe D','Gr. D','Gruppe_D','2014-05-16 01:19:25','2014-05-16 01:36:31'),
	(5,'Gruppe E','Gr. E','Gruppe_E','2014-05-16 01:19:25','2014-05-16 01:34:06'),
	(6,'Gruppe F','Gr. F','Gruppe_F','2014-05-16 01:19:25','2014-05-16 01:34:15'),
	(7,'Gruppe G','Gr. G','Gruppe_G','2014-05-16 01:19:25','2014-05-16 01:34:24'),
	(8,'Gruppe H','Gr. H','Gruppe_H','2014-05-16 01:19:25','2014-05-16 01:34:33');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle matches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `matches`;

CREATE TABLE `matches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `team1_id` int(11) DEFAULT NULL,
  `team2_id` int(11) DEFAULT NULL,
  `round_id` int(11) DEFAULT NULL,
  `points_team1` int(11) DEFAULT '-1',
  `points_team2` int(11) DEFAULT '-1',
  `extratime` varchar(20) DEFAULT NULL,
  `isfinished` tinyint(1) DEFAULT NULL,
  `isfixed` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;

INSERT INTO `matches` (`id`, `name`, `datetime`, `stage_id`, `group_id`, `team1_id`, `team2_id`, `round_id`, `points_team1`, `points_team2`, `extratime`, `isfinished`, `isfixed`, `created`, `modified`)
VALUES
	(27028,'Brasilien - Kroatien','2014-06-12 22:00:00',NULL,1,753,146,1,1,2,'0',1,1,'2014-05-16 02:46:42','2014-05-19 02:07:14'),
	(27029,'Mexiko - Kamerun','2014-06-13 18:00:00',NULL,1,761,845,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-19 01:51:31'),
	(27030,'Spanien - Niederlande','2014-06-13 21:00:00',NULL,2,170,147,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27031,'Chile - Australien','2014-06-14 00:00:00',NULL,2,760,750,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-18 23:25:05'),
	(27032,'Kolumbien - Griechenland','2014-06-14 18:00:00',NULL,3,1469,142,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-18 23:14:24'),
	(27033,'Uruguay - Costa Rica','2014-06-14 21:00:00',NULL,4,849,2669,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27034,'England - Italien','2014-06-15 00:00:00',NULL,4,755,145,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27035,'Elfenbeinküste - Japan','2014-06-15 03:00:00',NULL,3,757,749,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27036,'Schweiz - Ecuador','2014-06-15 18:00:00',NULL,5,38,2670,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-18 23:24:57'),
	(27037,'Frankreich - Honduras','2014-06-15 21:00:00',NULL,5,144,765,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27038,'Argentinien - Bosnien und Herzegowina','2014-06-16 00:00:00',NULL,6,764,2671,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27039,'Deutschland - Portugal','2014-06-16 18:00:00',NULL,7,139,149,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27040,'Iran - Nigeria','2014-06-16 21:00:00',NULL,6,2672,847,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27041,'Ghana - USA','2014-06-17 00:00:00',NULL,7,754,762,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27042,'Belgien - Algerien','2014-06-17 18:00:00',NULL,8,2673,844,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27043,'Brasilien - Mexiko','2014-06-17 21:00:00',NULL,1,753,761,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27044,'Russland - Südkorea','2014-06-18 00:00:00',NULL,8,150,751,1,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27045,'Australien - Niederlande','2014-06-18 18:00:00',NULL,2,750,147,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27046,'Spanien - Chile','2014-06-18 21:00:00',NULL,2,170,760,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27047,'Kamerun - Kroatien','2014-06-19 00:00:00',NULL,1,845,146,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27048,'Kolumbien - Elfenbeinküste','2014-06-19 18:00:00',NULL,3,1469,757,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27049,'Uruguay - England','2014-06-19 21:00:00',NULL,4,849,755,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27050,'Japan - Griechenland','2014-06-20 00:00:00',NULL,3,749,142,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27051,'Italien - Costa Rica','2014-06-20 18:00:00',NULL,4,145,2669,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27052,'Schweiz - Frankreich','2014-06-20 21:00:00',NULL,5,38,144,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27053,'Honduras - Ecuador','2014-06-21 00:00:00',NULL,5,765,2670,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27054,'Argentinien - Iran','2014-06-21 18:00:00',NULL,6,764,2672,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27055,'Deutschland - Ghana','2014-06-21 21:00:00',NULL,7,139,754,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27056,'Nigeria - Bosnien und Herzegowina','2014-06-22 00:00:00',NULL,6,847,2671,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27057,'Belgien - Russland','2014-06-22 18:00:00',NULL,8,2673,150,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27058,'Südkorea - Algerien','2014-06-22 21:00:00',NULL,8,751,844,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27059,'USA - Portugal','2014-06-23 00:00:00',NULL,7,762,149,2,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27061,'Australien - Spanien','2014-06-23 18:00:00',NULL,2,750,170,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27062,'Niederlande - Chile','2014-06-23 18:00:00',NULL,2,147,760,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27063,'Kamerun - Brasilien','2014-06-23 22:00:00',NULL,1,845,753,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27064,'Kroatien - Mexiko','2014-06-23 22:00:00',NULL,1,146,761,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27065,'Italien - Uruguay','2014-06-24 18:00:00',NULL,4,145,849,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27066,'Costa Rica - England','2014-06-24 18:00:00',NULL,4,2669,755,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27067,'Japan - Kolumbien','2014-06-24 22:00:00',NULL,3,749,1469,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27068,'Griechenland - Elfenbeinküste','2014-06-24 22:00:00',NULL,3,142,757,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27069,'Nigeria - Argentinien','2014-06-25 18:00:00',NULL,6,847,764,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27070,'Bosnien und Herzegowina - Iran','2014-06-25 18:00:00',NULL,6,2671,2672,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27071,'Honduras - Schweiz','2014-06-25 22:00:00',NULL,5,765,38,3,11,7,'2',1,1,'2014-05-16 02:46:42','2014-05-19 01:51:16'),
	(27072,'Ecuador - Frankreich','2014-06-25 22:00:00',NULL,5,2670,144,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27073,'USA - Deutschland','2014-06-26 18:00:00',NULL,7,762,139,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27074,'Portugal - Ghana','2014-06-26 18:00:00',NULL,7,149,754,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27075,'Südkorea - Belgien','2014-06-26 22:00:00',NULL,8,751,2673,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27076,'Algerien - Russland','2014-06-26 22:00:00',NULL,8,844,150,3,NULL,NULL,'0',0,1,'2014-05-16 02:46:42','2014-05-16 02:46:42'),
	(27086,'1. Gruppe A - 2. Gruppe B','2014-06-28 18:00:00',NULL,NULL,2674,2677,4,NULL,NULL,'0',0,1,'2014-05-19 00:39:05','2014-05-19 01:08:04'),
	(27087,'1. Gruppe C - 2. Gruppe D','2014-06-28 22:00:00',NULL,NULL,2678,2681,4,NULL,NULL,'0',0,1,'2014-05-19 00:39:51','2014-05-19 01:22:54'),
	(27088,'1. Gruppe B - 2. Gruppe A','2014-06-29 18:00:00',NULL,NULL,2676,2675,4,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:13:42'),
	(27089,'1. Gruppe D - 2. Gruppe C','2014-06-29 22:00:00',NULL,NULL,2680,2679,4,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:14:15'),
	(27090,'1. Gruppe E - 2. Gruppe F','2014-06-30 18:00:00',NULL,NULL,2682,2685,4,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:15:08'),
	(27091,'1. Gruppe G - 2. Gruppe H','2014-06-30 22:00:00',NULL,NULL,2686,2689,4,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:37:16'),
	(27092,'1. Gruppe F - 2. Gruppe E','2014-06-30 18:00:00',NULL,NULL,2684,2683,4,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:21:33'),
	(27093,'1. Gruppe H - 2. Gruppe G','2014-06-30 22:00:00',NULL,NULL,2688,2687,4,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:22:02'),
	(27094,'Sieger AF 5 - Sieger AF 6','2014-07-04 18:00:00',NULL,NULL,2694,2695,5,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:24:32'),
	(27095,'Sieger AF 1 - Sieger AF 2','2014-07-04 22:00:00',NULL,NULL,2690,2691,5,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:24:58'),
	(27096,'Sieger AF 7 - Sieger AF 8','2014-07-05 18:00:00',NULL,NULL,2696,2697,5,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:25:22'),
	(27097,'Sieger AF 3 - Sieger AF 4','2014-07-05 22:00:00',NULL,NULL,2692,2693,5,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:25:45'),
	(27098,'Sieger VF 1 - Sieger VF 2','2014-07-08 22:00:00',NULL,NULL,2699,2700,6,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:26:16'),
	(27099,'Sieger VF 3 - Sieger VF 3','2014-07-09 22:00:00',NULL,NULL,2701,2701,6,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:26:34'),
	(27100,'Verlierer HF 1 - Verlierer HF 2','2014-07-12 22:00:00',NULL,NULL,2705,2706,7,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:26:53'),
	(27101,'Sieger HF 1 - Sieger HF 2','2014-07-13 21:00:00',NULL,NULL,2703,2704,8,NULL,NULL,'0',0,1,'2014-05-19 00:40:35','2014-05-19 01:27:07');

/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle rounds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rounds`;

CREATE TABLE `rounds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `shortname` varchar(10) DEFAULT NULL,
  `bonus` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `rounds` WRITE;
/*!40000 ALTER TABLE `rounds` DISABLE KEYS */;

INSERT INTO `rounds` (`id`, `name`, `slug`, `shortname`, `bonus`, `created`, `modified`)
VALUES
	(1,'Runde 1','Runde_1','R1',1,'2014-05-15 21:34:16','2014-05-16 00:42:03'),
	(2,'Runde 2','Runde_2','R2',1,'2014-05-15 21:34:16','2014-05-16 00:42:11'),
	(3,'Runde 3','Runde_3','R3',1,'2014-05-15 21:34:16','2014-05-16 00:31:57'),
	(4,'Achtelfinale','Achtelfinale','AF',NULL,'2014-05-15 21:34:16','2014-05-15 21:34:16'),
	(5,'Viertelfinale','Viertelfinale','VF',NULL,'2014-05-15 21:34:16','2014-05-15 21:34:16'),
	(6,'Halbfinale','Halbfinale','HF',NULL,'2014-05-15 21:34:16','2014-05-15 21:34:16'),
	(7,'Spiel um Platz 3','Spiel_um_Platz_3','P3',NULL,'2014-05-15 21:34:16','2014-05-15 21:34:16'),
	(8,'Finale','Finale','F',NULL,'2014-05-15 21:34:16','2014-05-15 21:34:16');

/*!40000 ALTER TABLE `rounds` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle stages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stages`;

CREATE TABLE `stages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '	',
  `name` varchar(100) DEFAULT NULL,
  `ko` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `stages` WRITE;
/*!40000 ALTER TABLE `stages` DISABLE KEYS */;

INSERT INTO `stages` (`id`, `name`, `ko`, `created`, `modified`)
VALUES
	(4,'Vorrunde',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,'Spieltag 1',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,'Spieltag 2',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,'Spieltag 3',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,'Spieltag 4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,'Spieltag 5',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,'Spieltag 6',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,'Spieltag 7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,'Spieltag 8',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,'Spieltag 9',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,'Spieltag 10',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(15,'Spieltag 11',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(16,'Spieltag 12',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(17,'Spieltag 13',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(18,'Spieltag 14',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(19,'Spieltag 15',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(20,'Achtelfinale',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(21,'Viertelfinale',2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(22,'Halbfinale',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(23,'Spiel um Platz 3',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(24,'Finale',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `stages` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle teams
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `iconurl` varchar(200) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL COMMENT '		',
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;

INSERT INTO `teams` (`id`, `name`, `iconurl`, `group_id`, `created`, `modified`)
VALUES
	(38,'Schweiz','http://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Flag_of_Switzerland_within_2to3.svg/20px-Flag_of_Switzerland_within_2to3.svg.png',5,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(139,'Deutschland','http://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Flag_of_Germany.svg/20px-Flag_of_Germany.svg.png',7,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(142,'Griechenland','http://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Flag_of_Greece.svg/20px-Flag_of_Greece.svg.png',3,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(144,'Frankreich','http://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Flag_of_France.svg/20px-Flag_of_France.svg.png',5,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(145,'Italien','http://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Flag_of_Italy.svg/20px-Flag_of_Italy.svg.png',4,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(146,'Kroatien','http://www.openligadb.de/images/teamicons/Kroatien.gif',1,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(147,'Niederlande','http://upload.wikimedia.org/wikipedia/commons/thumb/2/20/Flag_of_the_Netherlands.svg/20px-Flag_of_the_Netherlands.svg.png',2,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(149,'Portugal','http://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Flag_of_Portugal.svg/20px-Flag_of_Portugal.svg.png',7,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(150,'Russland','http://www.openligadb.de/images/teamicons/Russland.gif',6,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(170,'Spanien','http://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Flag_of_Spain.svg/20px-Flag_of_Spain.svg.png',2,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(749,'Japan','http://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Flag_of_Japan.svg/20px-Flag_of_Japan.svg.png',3,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(750,'Australien','http://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Flag_of_Australia.svg/20px-Flag_of_Australia.svg.png',2,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(751,'Südkorea','http://upload.wikimedia.org/wikipedia/commons/thumb/0/09/Flag_of_South_Korea.svg/20px-Flag_of_South_Korea.svg.png',8,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(753,'Brasilien','http://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Flag_of_Brazil.svg/20px-Flag_of_Brazil.svg.png',1,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(754,'Ghana','http://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Flag_of_Ghana.svg/20px-Flag_of_Ghana.svg.png',7,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(755,'England','http://upload.wikimedia.org/wikipedia/commons/thumb/b/be/Flag_of_England.svg/18px-Flag_of_England.svg.png',4,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(757,'Elfenbeinküste','http://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Flag_of_Cote_d%27Ivoire.svg/20px-Flag_of_Cote_d%27Ivoire.svg.png',3,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(760,'Chile','http://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Flag_of_Chile.svg/20px-Flag_of_Chile.svg.png',2,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(761,'Mexiko','http://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Flag_of_Mexico.svg/20px-Flag_of_Mexico.svg.png',1,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(762,'USA','http://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/20px-Flag_of_the_United_States.svg.png',6,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(764,'Argentinien','http://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Flag_of_Argentina.svg/20px-Flag_of_Argentina.svg.png',8,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(765,'Honduras','http://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Flag_of_Honduras.svg/20px-Flag_of_Honduras.svg.png',5,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(844,'Algerien','http://upload.wikimedia.org/wikipedia/commons/thumb/7/77/Flag_of_Algeria.svg/20px-Flag_of_Algeria.svg.png',7,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(845,'Kamerun','http://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Flag_of_Cameroon.svg/20px-Flag_of_Cameroon.svg.png',1,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(847,'Nigeria','http://upload.wikimedia.org/wikipedia/commons/thumb/7/79/Flag_of_Nigeria.svg/20px-Flag_of_Nigeria.svg.png',8,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(849,'Uruguay','http://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_Uruguay.svg/20px-Flag_of_Uruguay.svg.png',4,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(1469,'Kolumbien','http://ide.fifa.com/imgml/flags/s/col.gif',3,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(2669,'Costa Rica','http://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Flag_of_Costa_Rica.svg/20px-Flag_of_Costa_Rica.svg.png',4,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(2670,'Ecuador','http://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Flag_of_Ecuador.svg/20px-Flag_of_Ecuador.svg.png',5,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(2671,'Bosnien und Herzegowina','http://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/Flag_of_Bosnia_and_Herzegovina.svg/20px-Flag_of_Bosnia_and_Herzegovina.svg.png',6,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(2672,'Iran','http://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Flag_of_Iran.svg/20px-Flag_of_Iran.svg.png',6,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(2673,'Belgien','http://upload.wikimedia.org/wikipedia/commons/thumb/9/92/Flag_of_Belgium_%28civil%29.svg/20px-Flag_of_Belgium_%28civil%29.svg.png',8,'2014-05-19 00:58:14','2014-05-19 00:58:21'),
	(2674,'1. Gruppe A','',NULL,'2014-05-19 01:02:23','2014-05-19 01:02:23'),
	(2675,'2. Gruppe A','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2676,'1. Gruppe B','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2677,'2. Gruppe B','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2678,'1. Gruppe C','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2679,'2. Gruppe C','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2680,'1. Gruppe D','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2681,'2. Gruppe D','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2682,'1. Gruppe E','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2683,'2. Gruppe E','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2684,'1. Gruppe F','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2685,'2. Gruppe F','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2686,'1. Gruppe G','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2687,'2. Gruppe G','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2688,'1. Gruppe H','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2689,'2. Gruppe H','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2690,'Sieger AF 1','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2691,'Sieger AF 2','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2692,'Sieger AF 3','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2693,'Sieger AF 4','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2694,'Sieger AF 5','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2695,'Sieger AF 6','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2696,'Sieger AF 7','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2697,'Sieger AF 8','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2699,'Sieger VF 1','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2700,'Sieger VF 2','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2701,'Sieger VF 3','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2702,'Sieger VF 4','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2703,'Sieger HF 1','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2704,'Sieger HF 2','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2705,'Verlierer HF 1','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35'),
	(2706,'Verlierer HF 2','',NULL,'2014-05-19 01:02:35','2014-05-19 01:02:35');

/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle tipps
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tipps`;

CREATE TABLE `tipps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `points_team1` int(11) DEFAULT NULL,
  `points_team2` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tipps` WRITE;
/*!40000 ALTER TABLE `tipps` DISABLE KEYS */;

INSERT INTO `tipps` (`id`, `match_id`, `user_id`, `points_team1`, `points_team2`, `created`, `modified`)
VALUES
	(1,27028,NULL,1,2,'2014-05-12 02:45:43','2014-05-12 02:45:43'),
	(2,27032,NULL,2,1,'2014-05-12 02:46:35','2014-05-12 02:46:35'),
	(3,27039,'536ff523-e2c4-48cf-b57b-5081cbdd56cb',3,2,'2014-05-12 02:47:29','2014-05-12 02:47:29');

/*!40000 ALTER TABLE `tipps` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle user_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_details`;

CREATE TABLE `user_details` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `position` float NOT NULL DEFAULT '1',
  `field` varchar(255) NOT NULL,
  `value` text,
  `input` varchar(16) NOT NULL,
  `data_type` varchar(16) NOT NULL,
  `label` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_PROFILE_PROPERTY` (`field`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` varchar(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `password_token` varchar(128) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT '0',
  `email_token` varchar(255) DEFAULT NULL,
  `email_token_expires` datetime DEFAULT NULL,
  `tos` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_action` datetime DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `role` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `BY_USERNAME` (`username`),
  KEY `BY_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `name`, `slug`, `password`, `password_token`, `email`, `email_verified`, `email_token`, `email_token_expires`, `tos`, `active`, `last_login`, `last_action`, `is_admin`, `role`, `created`, `modified`)
VALUES
	('5365537a-2108-4961-89b3-130ecbdd56cb','clausthaler','Ralf Dannhauer','clausthaler','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'post@dannhauer.eu',1,NULL,NULL,1,1,'2014-05-21 00:30:03',NULL,1,'admin','2014-05-03 22:37:14','2014-05-21 00:30:03'),
	('536ff50f-04d4-430f-95d4-4feccbdd56cb','roberta58',NULL,'roberta58','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'gbrekke@rau.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-21c8-42d7-920b-4feccbdd56cb','melyssaferry',NULL,'melyssaferry','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'stanton.gertrude@yahoo.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-7c74-42c4-99f9-4feccbdd56cb','jmitchell',NULL,'jmitchell','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'ziemann.chris@murphy.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-ad34-4fd1-be3a-4feccbdd56cb','muellerjosefina',NULL,'muellerjosefina','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'pfeeney@hotmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-b00c-45de-b805-4feccbdd56cb','jarredkulas',NULL,'jarredkulas','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'pzieme@hotmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-c63c-411a-9ec5-4feccbdd56cb','zbraun',NULL,'zbraun','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'lnolan@yahoo.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-e4dc-4f6b-8b25-4feccbdd56cb','moenward',NULL,'moenward','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'cathy.sauer@shanahanlarson.net',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-e93c-4929-a22c-4feccbdd56cb','georgettepacocha',NULL,'georgettepacocha','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'lemke.tiana@gusikowskidaniel.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff50f-f618-4420-9335-4feccbdd56cb','niamosciski',NULL,'niamosciski','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'bertrand09@yahoo.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:19','2014-05-12 00:09:19'),
	('536ff523-365c-4d93-a5d3-5081cbdd56cb','edwinagoodwin',NULL,'edwinagoodwin','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'jane.mann@yahoo.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:39','2014-05-12 00:09:39'),
	('536ff523-7190-45fc-a81f-5081cbdd56cb','bergnaumlea',NULL,'bergnaumlea','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'keebler.nicole@welch.net',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:39','2014-05-12 00:09:39'),
	('536ff523-72c0-42d0-942d-5081cbdd56cb','mhessel',NULL,'mhessel','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'wendy.runolfsdottir@renner.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:39','2014-05-12 00:09:39'),
	('536ff523-88a8-49a6-86ff-5081cbdd56cb','tking',NULL,'tking','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'dfritsch@gmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:39','2014-05-12 00:09:39'),
	('536ff523-982c-4fa1-9a9e-5081cbdd56cb','kschuster',NULL,'kschuster','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'horace.jacobi@lebsack.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:39','2014-05-12 00:09:39'),
	('536ff523-e2c4-48cf-b57b-5081cbdd56cb','justussteuber','Justus Tester II','justussteuber','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'jonathon.fahey@gmail.com',1,NULL,NULL,1,1,'2014-05-12 00:13:15',NULL,0,'registered','2014-05-12 00:09:39','2014-05-12 00:13:15'),
	('536ff523-f4cc-4fa9-afb6-5081cbdd56cb','pacochaquinn',NULL,'pacochaquinn','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'tyrese.rogahn@heaney.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:39','2014-05-12 00:09:39'),
	('536ff525-083c-4cee-bddb-5081cbdd56cb','darius63',NULL,'darius63','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'hayes.werner@yahoo.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-170c-491b-bd24-5081cbdd56cb','yschoen',NULL,'yschoen','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'hstreich@gmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-605c-410b-ad6e-5081cbdd56cb','bill85',NULL,'bill85','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'burley.bashirian@hermannschowalter.org',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-68c0-485f-83fe-5081cbdd56cb','enawehner',NULL,'enawehner','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'laury.denesik@hotmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-6ef0-4dfb-9159-5081cbdd56cb','watersenola',NULL,'watersenola','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'avis75@abernathy.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-70c4-4c30-8dac-5081cbdd56cb','zmccullough',NULL,'zmccullough','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'jdare@turnersatterfield.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-a2dc-4e33-93c4-5081cbdd56cb','vickiehansen',NULL,'vickiehansen','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'eldridge17@marvin.net',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-a88c-4b61-8978-5081cbdd56cb','akeebler',NULL,'akeebler','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'ischamberger@hotmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-d8e8-489b-a3fc-5081cbdd56cb','schummmanuela',NULL,'schummmanuela','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'morissette.julien@bergnaumsmitham.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff525-ee44-45c0-949e-5081cbdd56cb','vonruedenjo',NULL,'vonruedenjo','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'bpurdy@flatleyschinner.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:41','2014-05-12 00:09:41'),
	('536ff527-1818-4075-9526-5081cbdd56cb','ocartwright',NULL,'ocartwright','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'kschowalter@hotmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-1ab4-446e-a884-5081cbdd56cb','bergejanick',NULL,'bergejanick','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'rkonopelski@yahoo.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-51a4-45cb-9eec-5081cbdd56cb','marcia45',NULL,'marcia45','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'natalia81@hotmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-5b38-4aad-aa6f-5081cbdd56cb','nbernier',NULL,'nbernier','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'hortense63@miller.biz',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-641c-4e68-bd1d-5081cbdd56cb','nvandervort',NULL,'nvandervort','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'robel.gaylord@gmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-7ba8-404b-9c21-5081cbdd56cb','hillardhintz',NULL,'hillardhintz','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'joanny95@hotmail.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-9c7c-43c6-90d4-5081cbdd56cb','rosenbaumkaya',NULL,'rosenbaumkaya','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'gaylord.gladyce@abshiresporer.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-a40c-4ada-a090-5081cbdd56cb','heathcotemarques',NULL,'heathcotemarques','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'marcia85@kuhn.com',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('536ff527-c43c-4a86-b964-5081cbdd56cb','cwisozk',NULL,'cwisozk','a89bfc668e0b15d2ef67e0f39a21ef30a10bda6a',NULL,'jessica.bogan@dickens.net',1,NULL,NULL,1,1,NULL,NULL,0,'registered','2014-05-12 00:09:43','2014-05-12 00:09:43'),
	('5375349d-02cc-4b26-b41f-7d11cbdd56cb','tester',NULL,'tester','969c046cf0e97192c413c9cc7d992428b244405b',NULL,'ccc@dddd.de',1,NULL,NULL,1,0,NULL,NULL,1,'admin','2014-05-15 23:41:49','2014-05-15 23:41:49'),
	('53753b0d-93f8-4988-9d78-7debcbdd56cb','ralfralf',NULL,'ralfralf','808053c1eeab842be9ff91e32ba6b4c5cb2027c4',NULL,'rrrr@dsdsd.dwdw',1,NULL,NULL,1,0,NULL,NULL,0,'registered','2014-05-16 00:09:17','2014-05-16 00:09:17'),
	('537bd179-f6e4-414c-8893-2994cbdd56cb','clausthaler2',NULL,'clausthaler2','969c046cf0e97192c413c9cc7d992428b244405b',NULL,'clausthaler007@hotmail.com',1,'',NULL,1,1,NULL,NULL,0,'registered','2014-05-21 00:04:41','2014-05-21 00:04:41');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
