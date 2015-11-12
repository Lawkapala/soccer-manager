/*
SQLyog Ultimate v9.51 
MySQL - 5.6.16 : Database - sx_fut7
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sx_fut7` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `sx_fut7`;

/*Table structure for table `f7_event` */

DROP TABLE IF EXISTS `f7_event`;

CREATE TABLE `f7_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `img_event` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `f7_event` */

insert  into `f7_event`(`id`,`name`,`img_event`) values (1,'gol',NULL),(2,'asistencia',NULL),(3,'gol en propia',NULL),(4,'tarjeta amarilla',NULL),(5,'tarjeta roja',NULL),(6,'expulsión doble amarilla',NULL),(7,'lesión',NULL),(8,'hjkl','asistencia.png'),(9,'chj','doble_amarilla.png');

/*Table structure for table `f7_match` */

DROP TABLE IF EXISTS `f7_match`;

CREATE TABLE `f7_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matchday_id` int(11) NOT NULL,
  `home_team` int(11) NOT NULL,
  `score_home_team` int(11) DEFAULT '0',
  `away_team` int(11) NOT NULL,
  `score_away_team` int(11) DEFAULT '0',
  `location` varchar(50) DEFAULT NULL,
  `played` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `matchday_id` (`matchday_id`),
  KEY `away_team` (`away_team`),
  KEY `home_team` (`home_team`),
  CONSTRAINT `f7_match_ibfk_5` FOREIGN KEY (`home_team`) REFERENCES `f7_team` (`id`),
  CONSTRAINT `f7_match_ibfk_1` FOREIGN KEY (`matchday_id`) REFERENCES `f7_matchday` (`id`),
  CONSTRAINT `f7_match_ibfk_4` FOREIGN KEY (`away_team`) REFERENCES `f7_team` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `f7_match` */

insert  into `f7_match`(`id`,`matchday_id`,`home_team`,`score_home_team`,`away_team`,`score_away_team`,`location`,`played`) values (1,1,1,4,2,2,NULL,0),(2,1,3,2,4,2,NULL,0),(3,2,1,0,4,0,NULL,0),(4,2,2,0,3,0,NULL,0);

/*Table structure for table `f7_match_event` */

DROP TABLE IF EXISTS `f7_match_event`;

CREATE TABLE `f7_match_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `f7_match_event` */

/*Table structure for table `f7_matchday` */

DROP TABLE IF EXISTS `f7_matchday`;

CREATE TABLE `f7_matchday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `f7_matchday` */

insert  into `f7_matchday`(`id`,`name`) values (1,'JORNADA 1'),(2,'fghj');

/*Table structure for table `f7_player` */

DROP TABLE IF EXISTS `f7_player`;

CREATE TABLE `f7_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `img_player` varchar(100) DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `num_player` int(11) DEFAULT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `f7_player_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `f7_player_position` (`id`),
  CONSTRAINT `f7_player_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `f7_team` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `f7_player` */

insert  into `f7_player`(`id`,`name`,`alias`,`img_player`,`position_id`,`num_player`,`team_id`) values (1,'marc ginovart','gino',NULL,2,14,1),(2,'dzfg',NULL,NULL,1,NULL,1),(3,'dzfg',NULL,NULL,1,NULL,1),(4,'sdfg','dgg',NULL,1,545,1),(5,'sdfg','dgg',NULL,1,545,1);

/*Table structure for table `f7_player_position` */

DROP TABLE IF EXISTS `f7_player_position`;

CREATE TABLE `f7_player_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `f7_player_position` */

insert  into `f7_player_position`(`id`,`name`) values (1,'portero'),(2,'defensa'),(3,'defensa-medio'),(4,'medio'),(5,'medio-delantero'),(6,'delantero'),(7,'fty');

/*Table structure for table `f7_squard` */

DROP TABLE IF EXISTS `f7_squard`;

CREATE TABLE `f7_squard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `player_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `team_id` (`team_id`),
  KEY `player_id` (`player_id`),
  CONSTRAINT `f7_squard_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `f7_match` (`id`),
  CONSTRAINT `f7_squard_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `f7_team` (`id`),
  CONSTRAINT `f7_squard_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `f7_player` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `f7_squard` */

/*Table structure for table `f7_team` */

DROP TABLE IF EXISTS `f7_team`;

CREATE TABLE `f7_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `shield_name` varchar(50) DEFAULT NULL,
  `user_team` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `f7_team` */

insert  into `f7_team`(`id`,`name`,`shield_name`,`user_team`) values (1,'atl. perroflautas','perroflautas.png',1),(2,'afdasdf','default.png',NULL),(3,'gjtytt','default.png',NULL),(4,'team4','default.png',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
