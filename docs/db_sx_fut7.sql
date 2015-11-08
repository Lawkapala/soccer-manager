# ************************************************************
# Sequel Pro SQL dump
# Versión 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.26)
# Base de datos: sx_fut7
# Tiempo de Generación: 2015-11-08 22:42:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla player
# ------------------------------------------------------------

DROP TABLE IF EXISTS `player`;

CREATE TABLE `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `img_player` varchar(100) DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `num_player` int(11) DEFAULT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `player_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `player_position` (`id`),
  CONSTRAINT `player_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
