-- MySQL dump 10.13  Distrib 5.7.15, for Linux (x86_64)
--
-- Host: localhost    Database: egoist
-- ------------------------------------------------------
-- Server version	5.7.15-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brand` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` mediumtext,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sort_by` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'egoist',NULL,0,0,NULL);
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaign`
--

DROP TABLE IF EXISTS `campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign`
--

LOCK TABLES `campaign` WRITE;
/*!40000 ALTER TABLE `campaign` DISABLE KEYS */;
INSERT INTO `campaign` VALUES (1,'campaign_main',234324,234324);
/*!40000 ALTER TABLE `campaign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cart_subscriber_id` (`order_id`),
  CONSTRAINT `fk_cart_subscriber_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `parent` tinyint(3) unsigned DEFAULT '0',
  `slug` varchar(30) NOT NULL,
  `size_table_name_id` tinyint(2) unsigned NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sort_by` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_category_size_yable_name_id_idx` (`size_table_name_id`),
  CONSTRAINT `fk_category_size_yable_name_id` FOREIGN KEY (`size_table_name_id`) REFERENCES `size_table_name` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Мужская одежда','Описание',NULL,'man_wear',2,123213,1475671587,0),(2,'Женская одежда','Описание',0,'woman_wear',2,213213,2132,2),(3,'Мужские штаны','Описание',NULL,'man_pants',1,2423,1475161160,1),(4,'Мужская','Описание',NULL,'man_wear11dddd',2,1476100971,1476100978,NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `color`
--

DROP TABLE IF EXISTS `color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `color` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `rgb_code` varchar(7) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sort_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `rgb_code_UNIQUE` (`rgb_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color`
--

LOCK TABLES `color` WRITE;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
INSERT INTO `color` VALUES (2,'Салатовый','#b4a7d6',233243,1475161065,NULL),(3,'Белый','#f3eded',1475061120,1475065487,NULL);
/*!40000 ALTER TABLE `color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `favorite` tinyint(1) NOT NULL DEFAULT '0',
  `user_name` varchar(30) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comment_product_id` (`product_id`),
  CONSTRAINT `fk_comment_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,50,'Test comment',0,0,'Егор',1476360990,1476360990,1),(2,52,'комментарияТекст',0,0,'Игорь',1476362403,1476962151,0);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon`
--

DROP TABLE IF EXISTS `coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(45) NOT NULL,
  `subscriber_id` int(11) unsigned NOT NULL,
  `campaign_id` tinyint(3) unsigned DEFAULT '1',
  `using_status` tinyint(1) DEFAULT '0',
  `discount` int(11) DEFAULT '300',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sort_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupon_code_UNIQUE` (`coupon_code`),
  KEY `fk_subscriber_id_idx` (`subscriber_id`),
  KEY `fk_campaign_id_idx` (`campaign_id`),
  CONSTRAINT `fk_campaign_id` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_subscriber_id` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon`
--

LOCK TABLES `coupon` WRITE;
/*!40000 ALTER TABLE `coupon` DISABLE KEYS */;
INSERT INTO `coupon` VALUES (1,'111',4,1,1,300,1212231,1476968892,NULL);
/*!40000 ALTER TABLE `coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_storage`
--

DROP TABLE IF EXISTS `image_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_storage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `class` varchar(64) NOT NULL,
  `class_item_id` int(11) unsigned NOT NULL,
  `file_path` varchar(256) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - first main photo, 1 - second main photo, 2 - other photo',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_storage`
--

LOCK TABLES `image_storage` WRITE;
/*!40000 ALTER TABLE `image_storage` DISABLE KEYS */;
INSERT INTO `image_storage` VALUES (1,'1160160-e49c5650c5.jpg','common\\models\\Product',35,'/data/1160160-6805446aa9.jpg',0,1476097894,1476097894),(3,'12160160-df9599e2f8.jpg','common\\models\\Product',35,'/data/12160160-e16fba6bc6.jpg',2,1476097910,1476097910),(4,'1160160-b8f10764f6.jpg','common\\models\\Product',35,'/data/1160160-7fb05ecffd.jpg',2,1476097910,1476097910),(5,'2160160-c207448002.jpg','common\\models\\Product',35,'/data/2160160-34f1753e17.jpg',2,1476097910,1476097910),(6,'13160160-37a187d6cd.jpg','common\\models\\Product',35,'/data/13160160-1e86c1b167.jpg',1,1476097933,1476097933),(7,'12160160-050e19f855.jpg','common\\models\\Product',27,'/data/12160160-aa26510ffe.jpg',0,1476258179,1476258179);
/*!40000 ALTER TABLE `image_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `stock_keeping_unit` varchar(45) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `discount_price` decimal(8,2) DEFAULT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_keeping_unit_UNIQUE` (`stock_keeping_unit`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (12,27,2,'','as','zx',0.00,NULL,NULL,NULL),(20,49,2,'','sd','qw',0.00,NULL,NULL,NULL),(21,49,3,'','df','we',0.00,NULL,NULL,NULL),(22,11,2,'','fg','er',0.00,NULL,NULL,NULL),(23,11,3,'','gh','rt',0.00,NULL,NULL,NULL),(24,10,2,'','hj','ty',0.00,NULL,NULL,NULL),(25,10,3,'','jk','yu',0.00,NULL,NULL,NULL),(28,50,2,'','kl','ui',0.00,NULL,NULL,NULL),(31,52,2,'','zx','uo',0.00,NULL,NULL,NULL),(32,82,2,'Наименование','URL','Артикул',1232.22,12312.00,1477051834,1477051834);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_size`
--

DROP TABLE IF EXISTS `item_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `size_id` tinyint(2) unsigned NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_color_size_size_id_idx` (`size_id`),
  CONSTRAINT `fk_product_color_size_size_id` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_size`
--

LOCK TABLES `item_size` WRITE;
/*!40000 ALTER TABLE `item_size` DISABLE KEYS */;
INSERT INTO `item_size` VALUES (4,12,4,4,1476091421,1476365607),(20,20,2,2211,1476172407,1476365437),(21,21,1,2,1476172407,1476365437),(22,22,4,1,1476173196,1476174694),(23,22,1,1,1476173196,1476174694),(24,23,2,1,1476173196,1476174694),(25,23,1,11,1476173196,1476174694),(26,23,4,111,1476173196,1476174694),(29,24,2,1,1476174903,1476175645),(31,25,2,2,1476174903,1476175645),(32,25,3,2,1476174929,1476175645),(39,28,2,1,1476184071,1476342804),(40,28,1,11,1476184071,1476342804),(41,28,3,11,1476184071,1476342804),(51,21,2,22333,1476195056,1476365437),(52,21,3,2,1476195056,1476365437),(53,31,1,44,1476339965,1476339965),(54,31,3,44,1476339965,1476339965),(60,28,7,111,1476342804,1476342804),(61,32,1,1,NULL,NULL),(62,32,3,2,NULL,NULL),(63,33,1,NULL,1477058209,1477058209);
/*!40000 ALTER TABLE `item_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1473943831),('m130524_201442_init',1473943836),('m160117_225613_create_cart_table',1476687899),('m161005_111453_product_sizes',1475666924),('m161007_113211_create_product_colors_table',1475840410),('m161013_110159_comment_table',1476357009),('m161013_112714_comment_table',1476358222);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `country` varchar(45) NOT NULL DEFAULT 'Украина',
  `region` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `organization_name` varchar(45) DEFAULT NULL,
  `post_index` varchar(45) DEFAULT NULL,
  `phone` varchar(64) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `coupon_id` int(11) unsigned DEFAULT NULL,
  `status_id` tinyint(1) unsigned DEFAULT '1',
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `value` text COMMENT 'Serialized cart data',
  `total_cost` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'Егор',NULL,'Украина',NULL,NULL,NULL,NULL,NULL,'0981111111',NULL,NULL,NULL,0,1476272326,1476272326,NULL,NULL,NULL),(20,'Егор','','Украина','','Киев','ул. Пушкина 12б, 123','','','0981111111','yehor86@mail.ru','2016-10-21',NULL,1,1476958844,1476958844,NULL,'a:3:{s:32:\"a341bc5744f7aad76fd9a84e52cd6079\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:10;s:4:\"size\";s:1:\"2\";s:5:\"color\";s:1:\"2\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:10;s:4:\"name\";s:4:\"Polo\";s:11:\"description\";s:13:\"<p>dsfdsf</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:6:\"123222\";s:4:\"slug\";s:7:\"polo222\";s:5:\"price\";s:6:\"111.00\";s:14:\"discount_price\";s:6:\"220.00\";s:10:\"created_at\";i:23432;s:10:\"updated_at\";i:1476101274;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:0;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:10;s:4:\"name\";s:4:\"Polo\";s:11:\"description\";s:13:\"<p>dsfdsf</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:6:\"123222\";s:4:\"slug\";s:7:\"polo222\";s:5:\"price\";s:6:\"111.00\";s:14:\"discount_price\";s:6:\"220.00\";s:10:\"created_at\";i:23432;s:10:\"updated_at\";i:1476101274;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:0;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:6;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:47;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:6;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:47;s:11:\"seoBehavior\";r:70;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"1\";}s:32:\"f7112b9a7e2764cd339bb96e0998d97a\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:11;s:4:\"size\";s:1:\"4\";s:5:\"color\";s:1:\"3\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"T-shirt\";s:11:\"description\";s:13:\"<p>asdsad</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:5:\"27132\";s:4:\"slug\";s:7:\"t_shirt\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"123.00\";s:10:\"created_at\";i:234324;s:10:\"updated_at\";i:1475654949;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:1;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"T-shirt\";s:11:\"description\";s:13:\"<p>asdsad</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:5:\"27132\";s:4:\"slug\";s:7:\"t_shirt\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"123.00\";s:10:\"created_at\";i:234324;s:10:\"updated_at\";i:1475654949;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:1;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:96;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:137;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:96;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:160;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:160;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:137;s:11:\"seoBehavior\";r:160;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"3\";}s:32:\"ab0fd07647a72b2c6ab3267576eb6455\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:52;s:4:\"size\";s:1:\"1\";s:5:\"color\";s:1:\"2\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:52;s:4:\"name\";s:31:\"НаименованиеProduct\";s:11:\"description\";s:14:\"<p>asdsads</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:8:\"27132aSA\";s:4:\"slug\";s:3:\"asA\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:4:\"0.00\";s:10:\"created_at\";i:1476339943;s:10:\"updated_at\";i:1476339943;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:52;s:4:\"name\";s:31:\"НаименованиеProduct\";s:11:\"description\";s:14:\"<p>asdsads</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:8:\"27132aSA\";s:4:\"slug\";s:3:\"asA\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:4:\"0.00\";s:10:\"created_at\";i:1476339943;s:10:\"updated_at\";i:1476339943;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:186;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:227;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:186;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:250;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:250;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:227;s:11:\"seoBehavior\";r:250;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"1\";}}',NULL),(21,'Егор','','Украина','','Киев','ул. Пушкина 12б, 123','','','0981111111','yehor86@mail.ru','2016-10-21',1,1,1476961747,1476961747,NULL,'a:3:{s:32:\"a341bc5744f7aad76fd9a84e52cd6079\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:10;s:4:\"size\";s:1:\"2\";s:5:\"color\";s:1:\"2\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:10;s:4:\"name\";s:4:\"Polo\";s:11:\"description\";s:13:\"<p>dsfdsf</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:6:\"123222\";s:4:\"slug\";s:7:\"polo222\";s:5:\"price\";s:6:\"111.00\";s:14:\"discount_price\";s:6:\"220.00\";s:10:\"created_at\";i:23432;s:10:\"updated_at\";i:1476101274;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:0;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:10;s:4:\"name\";s:4:\"Polo\";s:11:\"description\";s:13:\"<p>dsfdsf</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:6:\"123222\";s:4:\"slug\";s:7:\"polo222\";s:5:\"price\";s:6:\"111.00\";s:14:\"discount_price\";s:6:\"220.00\";s:10:\"created_at\";i:23432;s:10:\"updated_at\";i:1476101274;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:0;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:6;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:47;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:6;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:47;s:11:\"seoBehavior\";r:70;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"1\";}s:32:\"f7112b9a7e2764cd339bb96e0998d97a\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:11;s:4:\"size\";s:1:\"4\";s:5:\"color\";s:1:\"3\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"T-shirt\";s:11:\"description\";s:13:\"<p>asdsad</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:5:\"27132\";s:4:\"slug\";s:7:\"t_shirt\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"123.00\";s:10:\"created_at\";i:234324;s:10:\"updated_at\";i:1475654949;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:1;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"T-shirt\";s:11:\"description\";s:13:\"<p>asdsad</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:5:\"27132\";s:4:\"slug\";s:7:\"t_shirt\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"123.00\";s:10:\"created_at\";i:234324;s:10:\"updated_at\";i:1475654949;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:1;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:96;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:137;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:96;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:160;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:160;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:137;s:11:\"seoBehavior\";r:160;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"3\";}s:32:\"ab0fd07647a72b2c6ab3267576eb6455\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:52;s:4:\"size\";s:1:\"1\";s:5:\"color\";s:1:\"2\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:52;s:4:\"name\";s:31:\"НаименованиеProduct\";s:11:\"description\";s:14:\"<p>asdsads</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:8:\"27132aSA\";s:4:\"slug\";s:3:\"asA\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:4:\"0.00\";s:10:\"created_at\";i:1476339943;s:10:\"updated_at\";i:1476339943;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:52;s:4:\"name\";s:31:\"НаименованиеProduct\";s:11:\"description\";s:14:\"<p>asdsads</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:8:\"27132aSA\";s:4:\"slug\";s:3:\"asA\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:4:\"0.00\";s:10:\"created_at\";i:1476339943;s:10:\"updated_at\";i:1476339943;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:186;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:227;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:186;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:250;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:250;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:227;s:11:\"seoBehavior\";r:250;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"1\";}}',NULL),(36,'Егор33','','Украина','','Киев','ул. Пушкина 12б, 2','','','0981111111','yehor86@mail.ru','2016-10-22',1,1,1476968892,1476968892,NULL,'a:2:{s:32:\"c835612d70a229edb922244676602fa6\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:49;s:4:\"size\";s:1:\"2\";s:5:\"color\";s:1:\"2\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:49;s:4:\"name\";s:24:\"Наименование\";s:11:\"description\";s:48:\"<p><strong>Наименование</strong></p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:6:\"2713dd\";s:4:\"slug\";s:1:\"v\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"234.00\";s:10:\"created_at\";i:1476103505;s:10:\"updated_at\";i:1476365453;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:49;s:4:\"name\";s:24:\"Наименование\";s:11:\"description\";s:48:\"<p><strong>Наименование</strong></p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:6:\"2713dd\";s:4:\"slug\";s:1:\"v\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"234.00\";s:10:\"created_at\";i:1476103505;s:10:\"updated_at\";i:1476365453;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:6;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:47;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:6;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:47;s:11:\"seoBehavior\";r:70;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"1\";}s:32:\"582a7a14a12ed76341cf00e1f875f983\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:50;s:4:\"size\";s:1:\"2\";s:5:\"color\";s:1:\"2\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:50;s:4:\"name\";s:8:\"TestName\";s:11:\"description\";s:94:\"<p>TestName<strong>Описание</strong><span class=\"redactor-invisible-space\"></span></p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:14:\"Описани\";s:4:\"slug\";s:7:\"testsss\";s:5:\"price\";s:6:\"123.00\";s:14:\"discount_price\";s:6:\"234.00\";s:10:\"created_at\";i:1476184042;s:10:\"updated_at\";i:1476184042;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:50;s:4:\"name\";s:8:\"TestName\";s:11:\"description\";s:94:\"<p>TestName<strong>Описание</strong><span class=\"redactor-invisible-space\"></span></p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";N;s:11:\"category_id\";i:1;s:18:\"stock_keeping_unit\";s:14:\"Описани\";s:4:\"slug\";s:7:\"testsss\";s:5:\"price\";s:6:\"123.00\";s:14:\"discount_price\";s:6:\"234.00\";s:10:\"created_at\";i:1476184042;s:10:\"updated_at\";i:1476184042;s:9:\"published\";s:1:\"0\";s:7:\"sort_by\";N;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:96;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:137;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:96;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:160;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:160;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:137;s:11:\"seoBehavior\";r:160;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"2\";}}',702),(37,'Егор33','','','','Киев','ул. Пушкина 12б, 123','','','0982222222','qwe@mail.ru','2016-10-29',NULL,1,1476969286,1476969286,NULL,'a:1:{s:32:\"f7112b9a7e2764cd339bb96e0998d97a\";O:33:\"common\\models\\ProductCartPosition\":5:{s:2:\"id\";i:11;s:4:\"size\";s:1:\"4\";s:5:\"color\";s:1:\"3\";s:11:\"\0*\0_product\";O:21:\"common\\models\\Product\":9:{s:36:\"\0yii\\db\\BaseActiveRecord\0_attributes\";a:15:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"T-shirt\";s:11:\"description\";s:13:\"<p>asdsad</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:5:\"27132\";s:4:\"slug\";s:7:\"t_shirt\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"123.00\";s:10:\"created_at\";i:234324;s:10:\"updated_at\";i:1475654949;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:1;s:6:\"amount\";N;}s:39:\"\0yii\\db\\BaseActiveRecord\0_oldAttributes\";a:15:{s:2:\"id\";i:11;s:4:\"name\";s:7:\"T-shirt\";s:11:\"description\";s:13:\"<p>asdsad</p>\";s:8:\"brand_id\";i:1;s:8:\"video_id\";i:0;s:11:\"category_id\";i:2;s:18:\"stock_keeping_unit\";s:5:\"27132\";s:4:\"slug\";s:7:\"t_shirt\";s:5:\"price\";s:7:\"3224.00\";s:14:\"discount_price\";s:6:\"123.00\";s:10:\"created_at\";i:234324;s:10:\"updated_at\";i:1475654949;s:9:\"published\";s:1:\"1\";s:7:\"sort_by\";i:1;s:6:\"amount\";N;}s:33:\"\0yii\\db\\BaseActiveRecord\0_related\";a:0:{}s:23:\"\0yii\\base\\Model\0_errors\";N;s:27:\"\0yii\\base\\Model\0_validators\";N;s:25:\"\0yii\\base\\Model\0_scenario\";s:7:\"default\";s:27:\"\0yii\\base\\Component\0_events\";a:5:{s:12:\"beforeInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:31:\"yii\\behaviors\\TimestampBehavior\":6:{s:18:\"createdAtAttribute\";s:10:\"created_at\";s:18:\"updatedAtAttribute\";s:10:\"updated_at\";s:5:\"value\";N;s:10:\"attributes\";a:2:{s:12:\"beforeInsert\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}s:12:\"beforeUpdate\";a:1:{i:0;s:10:\"updated_at\";}}s:17:\"skipUpdateOnClean\";b:1;s:5:\"owner\";r:6;}i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:12:\"beforeUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:47;i:1;s:18:\"evaluateAttributes\";}i:1;N;}}s:11:\"afterInsert\";a:1:{i:0;a:2:{i:0;a:2:{i:0;O:27:\"common\\behavior\\SeoBehavior\":2:{s:35:\"\0common\\behavior\\SeoBehavior\0_model\";N;s:5:\"owner\";r:6;}i:1;s:11:\"afterInsert\";}i:1;N;}}s:11:\"afterUpdate\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterUpdate\";}i:1;N;}}s:11:\"afterDelete\";a:1:{i:0;a:2:{i:0;a:2:{i:0;r:70;i:1;s:11:\"afterDelete\";}i:1;N;}}}s:30:\"\0yii\\base\\Component\0_behaviors\";a:2:{s:9:\"timestamp\";r:47;s:11:\"seoBehavior\";r:70;}s:12:\"\0*\0_quantity\";N;}s:8:\"quantity\";s:1:\"1\";}}',123);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` VALUES (1,'Новый'),(2,'В процессе'),(3,'Отменен'),(4,'Закрыт');
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `text` mediumtext NOT NULL,
  `slug` varchar(45) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1 - active page, 0 - not active',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  `sort_by` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` VALUES (1,'O нас','<p>111Если вам приходилось работать с Yii2, наверняка возникала ситуация, когда нужно было сохранить связь «много ко многим».</p><p>Когда становилось ясно, что в сети еще нет поведений для работы с этим типом связи, тогда нужный код писался на событии «after save» и с напутствием «ну работает же» отправлялся в репозиторий.</p><p>Лично меня не устраивал такой расклад событий. Я решил написать то самое волшебное поведение, которого так не хватает в официальной сборке Yii2.</p>','about-us','0',23432434,1475234404,1),(2,'Контакты213','<p><img src=\"/data/page_images/57fe015055a10.jpg\"></p><p><img src=\"/data/57fdea5d7dde8.jpg\" alt=\"57fdea5d7dde8.jpg\"></p><p>ждлждвафды324123</p>','$changedAttributescontacts213','1',12323,1476962284,0);
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_order`
--

DROP TABLE IF EXISTS `pre_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pre_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subscriber_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `color_id` int(10) unsigned NOT NULL,
  `size_id` tinyint(2) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pre_order_subscriber_id_idx` (`subscriber_id`),
  CONSTRAINT `fk_pre_order_subscriber_id` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_order`
--

LOCK TABLES `pre_order` WRITE;
/*!40000 ALTER TABLE `pre_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `pre_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand_id` tinyint(3) unsigned NOT NULL,
  `video_id` int(10) unsigned DEFAULT NULL,
  `category_id` tinyint(3) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '1',
  `sort_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_brand_id_idx` (`brand_id`),
  KEY `fk_product_category_id_idx` (`category_id`),
  CONSTRAINT `fk_product_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `fk_product_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (10,'Polo','<p>dsfdsf</p>',1,0,1,23432,1476101274,'1',2),(11,'T-shirt','<p>asdsad</p>',1,0,2,234324,1475654949,'1',0),(27,'Polo2','<p><strong>Описание</strong></p><p>Polo2</p>',1,NULL,1,1475590260,1476365474,'1',3),(49,'Наименование','<p><strong>Наименование</strong></p>',1,NULL,2,1476103505,1476365453,'0',4),(50,'TestName','<p>TestName<strong>Описание</strong><span class=\"redactor-invisible-space\"></span></p>',1,NULL,1,1476184042,1476184042,'0',5),(51,'22','<p><strong>Описаниеwww</strong></p>',1,29,1,1476264530,1476266403,'0',6),(52,'НаименованиеProduct','<p>asdsads</p>',1,NULL,1,1476339943,1476339943,'0',1),(80,'New product','New product Описание',1,NULL,2,1477041396,1477041396,'1',NULL),(81,'New product','New product Описание',1,NULL,2,1477041480,1477041480,'1',NULL),(82,'New product','New product Описание',1,30,2,1477041501,1477041501,'1',NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo`
--

DROP TABLE IF EXISTS `seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `class_item_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_name_goods_id` (`class_name`,`class_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT INTO `seo` VALUES (1,'common\\models\\Page','seo Title',' seo Description','seo Keyword',2),(4,'common\\models\\Page','O нас','about us Description','about us',1),(6,'common\\models\\Product','seo Title','Description seo','seo Keyword',10),(8,'common\\models\\Product','seo Title112233','Description112233','seo Keyword112233',27),(11,'common\\models\\Category','seo Title','Description','seo Keyword',1),(13,'common\\models\\Category','seo Titled','Descriptiond','Keywordd',4),(17,'common\\models\\Product','seo Title','Цена','Keyword',49),(18,'common\\models\\Product','TitlePageTest2','Description','seo Keyword',50),(19,'common\\models\\Product','seo Title','ffffff','KeywordTitlePageTest2',51),(20,'common\\models\\Product','seo Title','Asasa','Keyword',52),(21,'common\\models\\Item','SEO Title','SEO Description','SEO Keyword',32);
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoes_size_table`
--

DROP TABLE IF EXISTS `shoes_size_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoes_size_table` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `size_ru` decimal(3,1) unsigned NOT NULL,
  `size_uk` decimal(3,1) unsigned NOT NULL,
  `size_eu` decimal(3,1) unsigned NOT NULL,
  `size_us` decimal(3,1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoes_size_table`
--

LOCK TABLES `shoes_size_table` WRITE;
/*!40000 ALTER TABLE `shoes_size_table` DISABLE KEYS */;
INSERT INTO `shoes_size_table` VALUES (8,37.0,5.0,38.0,6.0),(9,37.5,5.5,38.5,6.5),(10,38.0,6.0,39.0,7.0),(11,39.0,6.5,40.0,7.5),(12,39.5,7.0,40.5,8.0),(13,40.0,7.5,41.0,8.5),(14,41.0,8.0,42.0,9.0),(15,41.5,8.5,42.5,9.5),(16,42.0,9.0,43.0,10.0),(17,43.0,9.5,44.0,10.5),(18,43.5,10.0,44.5,11.0),(19,44.0,10.5,45.0,11.5),(20,45.0,11.0,46.0,12.0),(21,45.5,11.5,46.5,12.5),(22,46.0,12.0,47.0,13.0),(23,47.5,13.0,48.5,14.0),(24,48.5,14.0,49.5,15.0),(25,50.0,15.0,51.0,16.0);
/*!40000 ALTER TABLE `shoes_size_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `size`
--

DROP TABLE IF EXISTS `size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `size` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(15) NOT NULL,
  `size_table_name_id` tinyint(2) unsigned NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_size_table_name_id_idx` (`size_table_name_id`),
  CONSTRAINT `fk_size_table_name_id` FOREIGN KEY (`size_table_name_id`) REFERENCES `size_table_name` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size`
--

LOCK TABLES `size` WRITE;
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
INSERT INTO `size` VALUES (1,'XS',2,NULL,1476263084),(2,'S',2,NULL,NULL),(3,'M',2,NULL,NULL),(4,'L',2,NULL,NULL),(5,'XL',2,NULL,NULL),(6,'XXL',2,NULL,NULL),(7,'XXXL',2,NULL,NULL),(8,'Универсальный',2,NULL,NULL);
/*!40000 ALTER TABLE `size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `size_table_name`
--

DROP TABLE IF EXISTS `size_table_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `size_table_name` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size_table_name`
--

LOCK TABLES `size_table_name` WRITE;
/*!40000 ALTER TABLE `size_table_name` DISABLE KEYS */;
INSERT INTO `size_table_name` VALUES (1,'shoes_size_table'),(2,'wear_size_table');
/*!40000 ALTER TABLE `size_table_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriber`
--

DROP TABLE IF EXISTS `subscriber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `mail_chimp_euid` varchar(10) NOT NULL,
  `mail_chimp_leid` varchar(45) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `mail_chimp_status` varchar(15) DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `phone_UNIQUE` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriber`
--

LOCK TABLES `subscriber` WRITE;
/*!40000 ALTER TABLE `subscriber` DISABLE KEYS */;
INSERT INTO `subscriber` VALUES (4,'Rgot','yehor86@mail.ru','0981111111','48d622a8b9','7156533',1475764192,1475824347,NULL,'pending'),(5,'Rgot','belemets.egor@gmail.com','1111111111','fa11df2b60','7168885',1475764211,1475823197,NULL,'subscribed');
/*!40000 ALTER TABLE `subscriber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `type` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Egor','93S6xOcRFzosN4kctDc3Ca2ni6OGXdJK','$2y$13$Eci1vKNLc5tt2yJ2CgDLhuVR.zCEjHkFwdC3DmQLIAPSBF2W3sk8.',NULL,'egor@jaws.com',10,1473944097,1473944097,'user');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_storage`
--

DROP TABLE IF EXISTS `video_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_storage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(45) NOT NULL,
  `class` varchar(45) NOT NULL,
  `item_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_storage`
--

LOCK TABLES `video_storage` WRITE;
/*!40000 ALTER TABLE `video_storage` DISABLE KEYS */;
INSERT INTO `video_storage` VALUES (25,'video1-ac60022786.mp4','common\\models\\Product',30,'/data/video1-a9049cbc6f.mp4',1475753095,1475753095),(26,'video1-37a340bba0.mp4','common\\models\\Product',33,'/data/video1-dd5c7bec38.mp4',1476097432,1476097432),(29,'video1-10f62f6b8b.mp4','common\\models\\Product',51,'/data/video_storage/video1-882d4c1fa6.mp4',1476266403,1476266403),(30,'video1-6c329545aa.mp4','common\\models\\Product',82,'/data/video_storage/video1-1415593259.mp4',1477041501,1477041501);
/*!40000 ALTER TABLE `video_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wear_size_table`
--

DROP TABLE IF EXISTS `wear_size_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wear_size_table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(45) NOT NULL,
  `34/XS/42` varchar(10) NOT NULL,
  `36/S/44` varchar(10) NOT NULL,
  `38/M/46` varchar(10) NOT NULL,
  `40/L/48` varchar(10) NOT NULL,
  `42/XL/50` varchar(10) NOT NULL,
  `44/XXL/52` varchar(10) NOT NULL,
  `46/XXXL/54` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wear_size_table`
--

LOCK TABLES `wear_size_table` WRITE;
/*!40000 ALTER TABLE `wear_size_table` DISABLE KEYS */;
INSERT INTO `wear_size_table` VALUES (1,'ОБХВАТ ГРУДИ','78 - 81','82 - 85','86 - 89','90 - 93','94 - 97','98 - 101','102 - 106'),(2,'ОБХВАТ ТАЛИИ','62 - 64','65 - 67','68 - 71','72 - 75','76 - 79','80 - 84','85-89'),(3,'ОБХВАТ БЕДЕР','86 - 89','93 - 96','97 - 100','101 - 104','105 - 107','108 - 112','113 - 117');
/*!40000 ALTER TABLE `wear_size_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-21 18:15:43
