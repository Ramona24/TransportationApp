# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.13-MariaDB)
# Database: bus_system
# Generation Time: 2017-10-22 22:08:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table busses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `busses`;

CREATE TABLE `busses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `starting_point_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `busses` WRITE;
/*!40000 ALTER TABLE `busses` DISABLE KEYS */;

INSERT INTO `busses` (`id`, `number`, `starting_point_id`)
VALUES
	(1,12,1);

/*!40000 ALTER TABLE `busses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table point_in_day
# ------------------------------------------------------------

DROP TABLE IF EXISTS `point_in_day`;

CREATE TABLE `point_in_day` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) DEFAULT NULL,
  `point_id` int(11) DEFAULT NULL,
  `day` varchar(20) DEFAULT NULL,
  `hour` int(11) DEFAULT NULL,
  `minute` int(11) DEFAULT NULL,
  `time_of_day` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `point_in_day` WRITE;
/*!40000 ALTER TABLE `point_in_day` DISABLE KEYS */;

INSERT INTO `point_in_day` (`id`, `bus_id`, `point_id`, `day`, `hour`, `minute`, `time_of_day`)
VALUES
	(1,1,1,'Tuesday',9,0,NULL),
	(2,1,2,'Tuesday',9,45,NULL),
	(3,1,3,'Tuesday',10,20,NULL),
	(4,1,4,'Tuesday',10,35,NULL),
	(11,1,1,'Monday',6,9,NULL),
	(12,1,2,'Monday',6,45,NULL),
	(13,1,3,'Monday',7,0,NULL),
	(14,1,4,'Monday',7,20,NULL);

/*!40000 ALTER TABLE `point_in_day` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table points
# ------------------------------------------------------------

DROP TABLE IF EXISTS `points`;

CREATE TABLE `points` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `points` WRITE;
/*!40000 ALTER TABLE `points` DISABLE KEYS */;

INSERT INTO `points` (`id`, `bus_id`, `description`)
VALUES
	(1,1,'Half way tree'),
	(2,1,'Three Miles'),
	(3,1,'Portmore Mall'),
	(4,1,'Naggo Head'),
	(5,NULL,'Down Town');

/*!40000 ALTER TABLE `points` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
