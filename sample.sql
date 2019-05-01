# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: pewpew.ru    Database: finefin
# ------------------------------------------------------
# Server version 5.0.77

#
# Source for table accounts
#

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `name` varchar(255) default NULL,
  `curr_id` int(11) default NULL,
  `color` varchar(6) NOT NULL default '000000',
  `icon` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table accounts
#

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (30,2,'Тестовый счёт',3,'000000',NULL);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table currencies
#

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `short` varchar(4) default NULL,
  `prefix` varchar(4) default NULL,
  `postfix` varchar(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table currencies
#

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'Доллар США','USD','$',NULL);
INSERT INTO `currencies` VALUES (2,'Евро','EUR','€',NULL);
INSERT INTO `currencies` VALUES (3,'Российский рубль','RUR',NULL,'р.');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table debts
#

DROP TABLE IF EXISTS `debts`;
CREATE TABLE `debts` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL COMMENT 'ID Пользователя',
  `sum` double(10,2) default '0.00' COMMENT 'Сумма',
  `start_date` timestamp NULL default CURRENT_TIMESTAMP COMMENT 'Начало долга',
  `end_date` timestamp NULL default NULL COMMENT 'Дата погашения долга',
  `is_my_debt` int(1) unsigned default '0' COMMENT 'Флаг - Я должен',
  `account_id` int(11) unsigned default NULL COMMENT 'Счёт, на котором висит долг',
  `description` text COMMENT 'Описание',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Долги';

#
# Dumping data for table debts
#

LOCK TABLES `debts` WRITE;
/*!40000 ALTER TABLE `debts` DISABLE KEYS */;
/*!40000 ALTER TABLE `debts` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table operation_tags
#

DROP TABLE IF EXISTS `operation_tags`;
CREATE TABLE `operation_tags` (
  `id` int(11) NOT NULL auto_increment,
  `operation_id` int(11) default NULL,
  `tag_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=952 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Dumping data for table operation_tags
#

LOCK TABLES `operation_tags` WRITE;
/*!40000 ALTER TABLE `operation_tags` DISABLE KEYS */;
INSERT INTO `operation_tags` VALUES (623,505,67);
/*!40000 ALTER TABLE `operation_tags` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table operations
#

DROP TABLE IF EXISTS `operations`;
CREATE TABLE `operations` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL COMMENT 'Пользователь',
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT 'Дата-Время',
  `sum` double(10,2) NOT NULL default '0.00' COMMENT 'Сумма',
  `op_type` int(3) default '1' COMMENT 'Тип операции (1-расход, 2-доход, 3-перевод)',
  `currency` int(11) default NULL COMMENT 'Валюта (3 - рубль)',
  `description` varchar(255) default NULL COMMENT 'Примечание',
  `account_id` int(11) default NULL COMMENT 'Счёт',
  `account2_id` int(11) default NULL COMMENT 'Счёт 2 (куда перевод)',
  `required` bit(1) NOT NULL default b'1' COMMENT 'Нужный',
  `planned` bit(1) NOT NULL default b'1' COMMENT 'Запланировано',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=677 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table operations
#

LOCK TABLES `operations` WRITE;
/*!40000 ALTER TABLE `operations` DISABLE KEYS */;
INSERT INTO `operations` VALUES (505,2,'2013-04-24',100,1,3,'Тестовый платёж',30,NULL,b'1',b'1');
/*!40000 ALTER TABLE `operations` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table tags_template
#

DROP TABLE IF EXISTS `tags_template`;
CREATE TABLE `tags_template` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table tags_template
#

LOCK TABLES `tags_template` WRITE;
/*!40000 ALTER TABLE `tags_template` DISABLE KEYS */;
INSERT INTO `tags_template` VALUES (1,'еда');
INSERT INTO `tags_template` VALUES (2,'к чаю');
INSERT INTO `tags_template` VALUES (3,'обед');
INSERT INTO `tags_template` VALUES (4,'wow');
INSERT INTO `tags_template` VALUES (5,'развлечения');
INSERT INTO `tags_template` VALUES (6,'настольные игры');
INSERT INTO `tags_template` VALUES (7,'подарок');
INSERT INTO `tags_template` VALUES (8,'прочее');
INSERT INTO `tags_template` VALUES (9,'вода');
INSERT INTO `tags_template` VALUES (10,'транспорт');
INSERT INTO `tags_template` VALUES (11,'телефон');
INSERT INTO `tags_template` VALUES (12,'друзья');
INSERT INTO `tags_template` VALUES (13,'бытовая техника');
INSERT INTO `tags_template` VALUES (14,'квартплата');
INSERT INTO `tags_template` VALUES (15,'кредит');
INSERT INTO `tags_template` VALUES (16,'beeline');
INSERT INTO `tags_template` VALUES (17,'utel');
INSERT INTO `tags_template` VALUES (18,'интернет');
INSERT INTO `tags_template` VALUES (19,'перевод');
INSERT INTO `tags_template` VALUES (20,'такси');
INSERT INTO `tags_template` VALUES (21,'алкоголь');
INSERT INTO `tags_template` VALUES (22,'аптека');
INSERT INTO `tags_template` VALUES (23,'налоги');
INSERT INTO `tags_template` VALUES (24,'программирование');
INSERT INTO `tags_template` VALUES (25,'благотворительность');
INSERT INTO `tags_template` VALUES (26,'хобби');
INSERT INTO `tags_template` VALUES (27,'пиво');
INSERT INTO `tags_template` VALUES (28,'вино');
INSERT INTO `tags_template` VALUES (29,'суши');
INSERT INTO `tags_template` VALUES (30,'пицца');
INSERT INTO `tags_template` VALUES (31,'долг');
INSERT INTO `tags_template` VALUES (32,'зарплата');
INSERT INTO `tags_template` VALUES (33,'шабашка');
INSERT INTO `tags_template` VALUES (34,'начисления');
INSERT INTO `tags_template` VALUES (35,'бытовая химия');
INSERT INTO `tags_template` VALUES (36,'кино');
INSERT INTO `tags_template` VALUES (38,'суд');
INSERT INTO `tags_template` VALUES (39,'автомобиль');
INSERT INTO `tags_template` VALUES (40,'бензин');
INSERT INTO `tags_template` VALUES (41,'проезд');
INSERT INTO `tags_template` VALUES (42,'одежда');
INSERT INTO `tags_template` VALUES (43,'красота');
INSERT INTO `tags_template` VALUES (44,'родственники');
INSERT INTO `tags_template` VALUES (45,'интерьер');
INSERT INTO `tags_template` VALUES (46,'ремонт');
INSERT INTO `tags_template` VALUES (47,'путешествия');
INSERT INTO `tags_template` VALUES (48,'спорт');
INSERT INTO `tags_template` VALUES (49,'ребёнок');
INSERT INTO `tags_template` VALUES (50,'офис');
INSERT INTO `tags_template` VALUES (51,'сапа');
INSERT INTO `tags_template` VALUES (52,'дача');
INSERT INTO `tags_template` VALUES (53,'семья');
INSERT INTO `tags_template` VALUES (54,'отдых');
INSERT INTO `tags_template` VALUES (55,'здоровье');
INSERT INTO `tags_template` VALUES (56,'дом');
INSERT INTO `tags_template` VALUES (57,'быт');
INSERT INTO `tags_template` VALUES (58,'табак');
INSERT INTO `tags_template` VALUES (59,'сигареты');
/*!40000 ALTER TABLE `tags_template` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table tokens
#

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `code` varchar(255) default NULL,
  `expires` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table tokens
#

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table user_tags
#

DROP TABLE IF EXISTS `user_tags`;
CREATE TABLE `user_tags` (
  `id` int(11) NOT NULL auto_increment,
  `name` text,
  `user_id` int(11) default NULL,
  `template_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1004 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table user_tags
#

LOCK TABLES `user_tags` WRITE;
/*!40000 ALTER TABLE `user_tags` DISABLE KEYS */;
INSERT INTO `user_tags` VALUES (60,'еда',2,1);
INSERT INTO `user_tags` VALUES (61,'к чаю',2,2);
INSERT INTO `user_tags` VALUES (62,'обед',2,3);
INSERT INTO `user_tags` VALUES (63,'wow',2,4);
INSERT INTO `user_tags` VALUES (64,'развлечения',2,5);
INSERT INTO `user_tags` VALUES (65,'настольные игры',2,6);
INSERT INTO `user_tags` VALUES (66,'подарок',2,7);
INSERT INTO `user_tags` VALUES (67,'прочее',2,8);
INSERT INTO `user_tags` VALUES (68,'вода',2,9);
INSERT INTO `user_tags` VALUES (69,'транспорт',2,10);
INSERT INTO `user_tags` VALUES (70,'телефон',2,11);
INSERT INTO `user_tags` VALUES (71,'друзья',2,12);
INSERT INTO `user_tags` VALUES (72,'бытовая техника',2,13);
INSERT INTO `user_tags` VALUES (73,'квартплата',2,14);
INSERT INTO `user_tags` VALUES (74,'кредит',2,15);
INSERT INTO `user_tags` VALUES (75,'beeline',2,16);
INSERT INTO `user_tags` VALUES (76,'utel',2,17);
INSERT INTO `user_tags` VALUES (77,'интернет',2,18);
INSERT INTO `user_tags` VALUES (78,'перевод',2,19);
INSERT INTO `user_tags` VALUES (79,'такси',2,20);
INSERT INTO `user_tags` VALUES (80,'алкоголь',2,21);
INSERT INTO `user_tags` VALUES (81,'аптека',2,22);
INSERT INTO `user_tags` VALUES (82,'налоги',2,23);
INSERT INTO `user_tags` VALUES (83,'программирование',2,24);
INSERT INTO `user_tags` VALUES (84,'благотворительность',2,25);
INSERT INTO `user_tags` VALUES (85,'хобби',2,26);
INSERT INTO `user_tags` VALUES (86,'пиво',2,27);
INSERT INTO `user_tags` VALUES (87,'вино',2,28);
INSERT INTO `user_tags` VALUES (88,'суши',2,29);
INSERT INTO `user_tags` VALUES (89,'пицца',2,30);
INSERT INTO `user_tags` VALUES (90,'долг',2,31);
INSERT INTO `user_tags` VALUES (91,'зарплата',2,32);
INSERT INTO `user_tags` VALUES (92,'шабашка',2,33);
INSERT INTO `user_tags` VALUES (93,'начисления',2,34);
INSERT INTO `user_tags` VALUES (94,'бытовая химия',2,35);
INSERT INTO `user_tags` VALUES (95,'кино',2,36);
INSERT INTO `user_tags` VALUES (97,'суд',2,38);
INSERT INTO `user_tags` VALUES (98,'автомобиль',2,39);
INSERT INTO `user_tags` VALUES (99,'бензин',2,40);
INSERT INTO `user_tags` VALUES (100,'проезд',2,41);
INSERT INTO `user_tags` VALUES (101,'одежда',2,42);
INSERT INTO `user_tags` VALUES (102,'красота',2,43);
INSERT INTO `user_tags` VALUES (103,'родственники',2,44);
INSERT INTO `user_tags` VALUES (104,'интерьер',2,45);
INSERT INTO `user_tags` VALUES (105,'ремонт',2,46);
INSERT INTO `user_tags` VALUES (106,'путешествия',2,47);
INSERT INTO `user_tags` VALUES (107,'спорт',2,48);
INSERT INTO `user_tags` VALUES (108,'ребёнок',2,49);
INSERT INTO `user_tags` VALUES (109,'офис',2,50);
INSERT INTO `user_tags` VALUES (110,'сапа',2,51);
INSERT INTO `user_tags` VALUES (111,'дача',2,52);
INSERT INTO `user_tags` VALUES (112,'семья',2,53);
INSERT INTO `user_tags` VALUES (113,'отдых',2,54);
INSERT INTO `user_tags` VALUES (114,'здоровье',2,55);
INSERT INTO `user_tags` VALUES (115,'дом',2,56);
INSERT INTO `user_tags` VALUES (116,'быт',2,57);
INSERT INTO `user_tags` VALUES (117,'табак',2,58);
INSERT INTO `user_tags` VALUES (118,'сигареты',2,59);
/*!40000 ALTER TABLE `user_tags` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table users
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `pass` varchar(255) default NULL,
  `network` varchar(64) default NULL,
  `uid` varchar(64) default NULL,
  `url` varchar(255) default NULL,
  `default_currency` int(6) NOT NULL default '3',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ulogin_unique` (`network`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table users
#

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Демо','demo@finefin.ru','ed6f12a0615b909eb0918ac07ab6ade0',NULL,NULL,NULL,3);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
