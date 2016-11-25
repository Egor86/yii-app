-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: egoist
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
  `discount` int(4) NOT NULL,
  `coupon_action_time` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign`
--

LOCK TABLES `campaign` WRITE;
/*!40000 ALTER TABLE `campaign` DISABLE KEYS */;
INSERT INTO `campaign` VALUES (1,'campaign_main',150,0,1,234324,1478851031),(2,'Акции Name',222,93780,0,1478264413,1478264413),(7,'5',5,0,0,1478268081,1478270304),(8,'6',6,0,0,1478268201,1478270293),(9,'asdasds',324,360240,0,1478270167,1478270167),(10,'gh',54,0,0,1478270385,1478271808);
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
  `parent` tinyint(3) unsigned NOT NULL DEFAULT '0',
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
INSERT INTO `category` VALUES (1,'Мужская одежда','Описание',0,'man-wear',2,123213,1479916210,0),(2,'Женская одежда','Описание',0,'woman-wear',2,213213,2132,1),(3,'Мужские штаны','Описание',2,'man-pants',2,2423,1480084160,3),(4,'Мужская','Описание',1,'man-weardddd',2,1476100971,1479916231,2);
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
  `rgb_code` varchar(7) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sort_by` int(10) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color`
--

LOCK TABLES `color` WRITE;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
INSERT INTO `color` VALUES (2,'Салатовый','#b4a7d6',233243,1475161065,NULL,0),(3,'Белый','#f3eded',1475061120,1475065487,NULL,0),(4,'Синий','#0000ff',1477387400,1477387400,NULL,0),(5,'Желтый','#ffff00',1478705680,1478705680,NULL,0),(19,'ывфывфыв444',NULL,1479741286,1479806782,NULL,1);
/*!40000 ALTER TABLE `color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `favorite` tinyint(1) NOT NULL DEFAULT '0',
  `user_name` varchar(30) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,100,'asdsadasd',0,0,'Иван',123123,123123123,NULL,''),(2,133,'Новый отзыв',1,0,'Васф',1480084631,1480084723,NULL,'asdasd@asd.as'),(3,133,'Новый отзыв',0,0,'Васф',1480084686,1480084686,NULL,'asdasd@asd.as');
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
  `campaign_id` tinyint(3) unsigned NOT NULL,
  `using_status` tinyint(1) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `expiry_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupon_code_UNIQUE` (`coupon_code`),
  KEY `fk_subscriber_id_idx` (`subscriber_id`),
  KEY `fk_campaign_id_idx` (`campaign_id`),
  CONSTRAINT `fk_campaign_id` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_subscriber_id` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon`
--

LOCK TABLES `coupon` WRITE;
/*!40000 ALTER TABLE `coupon` DISABLE KEYS */;
INSERT INTO `coupon` VALUES (1,'111',4,1,0,1212231,1477986286,NULL,NULL),(2,'444',5,1,0,234234,1478612327,NULL,NULL),(3,'666',6,1,1,123213,1478159048,NULL,NULL),(4,'22176-004',21,1,0,1478795329,1478795329,NULL,1478881729),(6,'22176-006',20,1,0,1478876496,1478876496,NULL,1478876496),(9,'22176-008',27,1,0,1479210063,1479210063,NULL,0),(10,'22176-010',28,1,0,1479218086,1479218086,NULL,0),(11,'22176-011',29,1,0,1479218573,1479218573,NULL,0),(12,'22176-012',25,1,0,1479218626,1479218626,NULL,0),(13,'22176-013',30,1,0,1479223831,1479223831,NULL,0),(14,'22176-014',31,1,0,1479223953,1479223953,NULL,0),(15,'22176-015',32,1,0,1479483539,1479483539,NULL,0),(16,'22176-016',33,1,0,1479483580,1479483580,NULL,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_storage`
--

LOCK TABLES `image_storage` WRITE;
/*!40000 ALTER TABLE `image_storage` DISABLE KEYS */;
INSERT INTO `image_storage` VALUES (40,'album-1-1-6eb27ebec2062bd72dcfa3-d823455fe9.jpg','common\\models\\Color',8,'/data/color_caver/album-1-1-6eb27ebec2062bd72dcfa3-27442d032a.jpg',0,1478857631,1478857631),(41,'13160160-f150ac2cbe.jpg','common\\models\\Item',108,'/data/product_images/13160160-60956bcf6c.jpg',0,1479119267,1479119267),(42,'13160160-f816884f6f.jpg','common\\models\\Item',128,'/data/product_images/13160160-4192becf7e.jpg',0,1479129640,1479471790),(43,'13160160-f33b8dafe9.jpg','common\\models\\Item',131,'/data/product_images/13160160-9a09943113.jpg',2,1479130864,1479130864),(46,'logo-5d9b7679ff.png','common\\models\\Item',100,'/data/product_images/logo-ed3b0820f9.png',0,1479299163,1479737860),(47,'snimokekranaot2016-11-1511-59-11-41297b6b17.png','common\\models\\Item',100,'/data/product_images/snimokekranaot2016-11-1511-59-11-e91107a0ce.png',2,1479303209,1479737860),(57,'mod3-47bbb2edad.jpg','common\\models\\Item',133,'/data/product_images/mod3-94ec92fc80.jpg',0,1479306276,1479306288),(58,'logo-b9d424bde6.png','common\\models\\Item',133,'/data/product_images/logo-686b19bc91.png',1,1479306276,1479306288),(67,'13160160-0db414f375.jpg','common\\models\\Item',128,'/data/product_images/13160160-0e014a4567.jpg',2,1479471722,1479471791),(68,'logo-5750fd72d9.png','common\\models\\Item',128,'/data/product_images/logo-1066779846.png',2,1479471791,1479471791),(69,'2160160-eeeebe6ba3.jpg','common\\models\\Item',128,'/data/product_images/2160160-ce1858524d.jpg',2,1479471791,1479471791),(74,'snimok-ekrana-ot-2016-11-15-16-2-339df97504.png','common\\models\\Item',100,'/data/product_images/snimok-ekrana-ot-2016-11-15-16-2-0f356772ef.png',2,1479737647,1479737860),(82,'snimokekranaot2016-11-1511-59-11-cbd2758e01.png','common\\models\\Color',19,'/data/color_caver/snimokekranaot2016-11-1511-59-11-8cef01dd25.png',2,1479806783,1479806783),(83,'image2-ac0bc9325b.jpg','common\\models\\Item',82,'/data/product_images/image2-d660fa25ca.jpg',0,1479977942,1479978159);
/*!40000 ALTER TABLE `image_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `stock_keeping_unit` varchar(45) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `discount_price` decimal(8,2) DEFAULT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `recommended` tinyint(1) DEFAULT '0',
  `isDeleted` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_keeping_unit_UNIQUE` (`stock_keeping_unit`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (82,83,3,'NewProd child11','cccaa','1111',500222.00,200.00,1477311325,1479387234,1,1,0),(100,80,3,'Наименование1','zxcxzc','zxczxc',22200.00,2.00,1477489230,1479469985,1,1,0),(108,90,2,'Наименование','xcvxcv','234234',0.00,0.00,1479119267,1479119267,1,1,0),(128,91,3,'asdsad','asdas','asd',22.00,0.00,1479129640,1480083318,1,1,0),(133,91,2,'aS','AsaS','Asa',11.00,0.00,1479306227,1479306227,1,1,0);
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
  UNIQUE KEY `item_id_size_id_UNIQUE` (`size_id`,`item_id`),
  KEY `fk_product_color_size_size_id_idx` (`size_id`),
  KEY `fk_item_size_item_id_idx` (`item_id`),
  CONSTRAINT `fk_item_size_size_id` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_size`
--

LOCK TABLES `item_size` WRITE;
/*!40000 ALTER TABLE `item_size` DISABLE KEYS */;
INSERT INTO `item_size` VALUES (4,12,4,4,1476091421,1476365607),(20,20,2,2211,1476172407,1476365437),(21,21,1,2,1476172407,1476365437),(22,22,4,1,1476173196,1476174694),(23,22,1,1,1476173196,1476174694),(24,23,2,1,1476173196,1476174694),(25,23,1,11,1476173196,1476174694),(26,23,4,111,1476173196,1476174694),(29,24,2,1,1476174903,1476175645),(31,25,2,2,1476174903,1476175645),(32,25,3,2,1476174929,1476175645),(39,28,2,1,1476184071,1476342804),(40,28,1,11,1476184071,1476342804),(41,28,3,11,1476184071,1476342804),(51,21,2,22333,1476195056,1476365437),(52,21,3,2,1476195056,1476365437),(53,31,1,44,1476339965,1476339965),(54,31,3,44,1476339965,1476339965),(60,28,7,111,1476342804,1476342804),(63,33,1,NULL,1477058209,1477058209),(95,79,1,1,1477298761,1477298761),(96,79,2,2,1477298761,1477298761),(97,79,3,3,1477298761,1477298761),(98,80,1,333,1477299559,1477299559),(177,100,5,2,1477489230,1479460874),(187,108,1,0,1479119267,1479119267),(207,128,2,3,1479129640,1479471821),(210,131,1,23,1479130864,1479130864),(211,100,2,2,1479286518,1479460874),(216,133,3,4,1479306227,1479306227),(225,100,4,2,1479460874,1479460874),(226,128,3,2,1479471821,1479471821),(227,82,1,1,1480084828,1480084828),(228,82,3,11,1480084828,1480084828);
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
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `country` varchar(45) NOT NULL DEFAULT 'Украина',
  `region` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `organization_name` varchar(45) DEFAULT NULL,
  `post_index` varchar(45) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `coupon_id` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '1',
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `value` text COMMENT 'Serialized cart data',
  `total_cost` int(11) unsigned DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (71,'Егор',NULL,'Украина',NULL,NULL,NULL,NULL,NULL,'0983331122','yeho@gmail.ru',NULL,NULL,1,1479906188,1479906188,NULL,NULL,NULL,NULL),(72,'Егор',NULL,'Украина',NULL,NULL,NULL,NULL,NULL,'0983331122','yeho333@mail.ru',NULL,NULL,1,1479906227,1479909932,NULL,'YToxOntzOjMyOiIwOGNhZGFmOWZlZjY3MTRmNjkxYWVkNGRmMmFlMTIyMCI7TzozMDoiY29tbW9uXG1vZGVsc1xJdGVtQ2FydFBvc2l0aW9uIjo0OntzOjI6ImlkIjtpOjEwMDtzOjQ6InNpemUiO3M6MToiMiI7czo4OiIAKgBfaXRlbSI7TzoxODoiY29tbW9uXG1vZGVsc1xJdGVtIjo5OntzOjM2OiIAeWlpXGRiXEJhc2VBY3RpdmVSZWNvcmQAX2F0dHJpYnV0ZXMiO2E6MTM6e3M6MjoiaWQiO2k6MTAwO3M6MTA6InByb2R1Y3RfaWQiO2k6ODA7czo4OiJjb2xvcl9pZCI7aTozO3M6NDoibmFtZSI7czoyNToi0J3QsNC40LzQtdC90L7QstCw0L3QuNC1MSI7czo0OiJzbHVnIjtzOjY6Inp4Y3h6YyI7czoxODoic3RvY2tfa2VlcGluZ191bml0IjtzOjY6Inp4Y3p4YyI7czo1OiJwcmljZSI7czo4OiIyMjIwMC4wMCI7czoxNDoiZGlzY291bnRfcHJpY2UiO3M6NDoiMi4wMCI7czoxMDoiY3JlYXRlZF9hdCI7aToxNDc3NDg5MjMwO3M6MTA6InVwZGF0ZWRfYXQiO2k6MTQ3OTQ2OTk4NTtzOjY6InN0YXR1cyI7aTowO3M6MTE6InJlY29tbWVuZGVkIjtpOjA7czo5OiJpc0RlbGV0ZWQiO2k6MDt9czozOToiAHlpaVxkYlxCYXNlQWN0aXZlUmVjb3JkAF9vbGRBdHRyaWJ1dGVzIjthOjEzOntzOjI6ImlkIjtpOjEwMDtzOjEwOiJwcm9kdWN0X2lkIjtpOjgwO3M6ODoiY29sb3JfaWQiO2k6MztzOjQ6Im5hbWUiO3M6MjU6ItCd0LDQuNC80LXQvdC+0LLQsNC90LjQtTEiO3M6NDoic2x1ZyI7czo2OiJ6eGN4emMiO3M6MTg6InN0b2NrX2tlZXBpbmdfdW5pdCI7czo2OiJ6eGN6eGMiO3M6NToicHJpY2UiO3M6ODoiMjIyMDAuMDAiO3M6MTQ6ImRpc2NvdW50X3ByaWNlIjtzOjQ6IjIuMDAiO3M6MTA6ImNyZWF0ZWRfYXQiO2k6MTQ3NzQ4OTIzMDtzOjEwOiJ1cGRhdGVkX2F0IjtpOjE0Nzk0Njk5ODU7czo2OiJzdGF0dXMiO2k6MDtzOjExOiJyZWNvbW1lbmRlZCI7aTowO3M6OToiaXNEZWxldGVkIjtpOjA7fXM6MzM6IgB5aWlcZGJcQmFzZUFjdGl2ZVJlY29yZABfcmVsYXRlZCI7YTowOnt9czoyMzoiAHlpaVxiYXNlXE1vZGVsAF9lcnJvcnMiO047czoyNzoiAHlpaVxiYXNlXE1vZGVsAF92YWxpZGF0b3JzIjtOO3M6MjU6IgB5aWlcYmFzZVxNb2RlbABfc2NlbmFyaW8iO3M6NzoiZGVmYXVsdCI7czoyNzoiAHlpaVxiYXNlXENvbXBvbmVudABfZXZlbnRzIjthOjU6e3M6MTI6ImJlZm9yZUluc2VydCI7YToxOntpOjA7YToyOntpOjA7YToyOntpOjA7TzozMToieWlpXGJlaGF2aW9yc1xUaW1lc3RhbXBCZWhhdmlvciI6Njp7czoxODoiY3JlYXRlZEF0QXR0cmlidXRlIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE4OiJ1cGRhdGVkQXRBdHRyaWJ1dGUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToidmFsdWUiO047czoxMDoiYXR0cmlidXRlcyI7YToyOntzOjEyOiJiZWZvcmVJbnNlcnQiO2E6Mjp7aTowO3M6MTA6ImNyZWF0ZWRfYXQiO2k6MTtzOjEwOiJ1cGRhdGVkX2F0Ijt9czoxMjoiYmVmb3JlVXBkYXRlIjthOjE6e2k6MDtzOjEwOiJ1cGRhdGVkX2F0Ijt9fXM6MTc6InNraXBVcGRhdGVPbkNsZWFuIjtiOjE7czo1OiJvd25lciI7cjo1O31pOjE7czoxODoiZXZhbHVhdGVBdHRyaWJ1dGVzIjt9aToxO047fX1zOjEyOiJiZWZvcmVVcGRhdGUiO2E6MTp7aTowO2E6Mjp7aTowO2E6Mjp7aTowO3I6NDI7aToxO3M6MTg6ImV2YWx1YXRlQXR0cmlidXRlcyI7fWk6MTtOO319czoxMToiYWZ0ZXJJbnNlcnQiO2E6MTp7aTowO2E6Mjp7aTowO2E6Mjp7aTowO086Mjc6ImNvbW1vblxiZWhhdmlvclxTZW9CZWhhdmlvciI6Mjp7czozNToiAGNvbW1vblxiZWhhdmlvclxTZW9CZWhhdmlvcgBfbW9kZWwiO047czo1OiJvd25lciI7cjo1O31pOjE7czoxMToiYWZ0ZXJJbnNlcnQiO31pOjE7Tjt9fXM6MTE6ImFmdGVyVXBkYXRlIjthOjE6e2k6MDthOjI6e2k6MDthOjI6e2k6MDtyOjY1O2k6MTtzOjExOiJhZnRlclVwZGF0ZSI7fWk6MTtOO319czoxMToiYWZ0ZXJEZWxldGUiO2E6MTp7aTowO2E6Mjp7aTowO2E6Mjp7aTowO3I6NjU7aToxO3M6MTE6ImFmdGVyRGVsZXRlIjt9aToxO047fX19czozMDoiAHlpaVxiYXNlXENvbXBvbmVudABfYmVoYXZpb3JzIjthOjM6e3M6OToidGltZXN0YW1wIjtyOjQyO3M6MTE6InNlb0JlaGF2aW9yIjtyOjY1O3M6MTg6InNvZnREZWxldGVCZWhhdmlvciI7Tzo0MToieWlpMnRlY2hcYXJcc29mdGRlbGV0ZVxTb2Z0RGVsZXRlQmVoYXZpb3IiOjc6e3M6MjU6InNvZnREZWxldGVBdHRyaWJ1dGVWYWx1ZXMiO2E6MTp7czo5OiJpc0RlbGV0ZWQiO2I6MTt9czoyMjoicmVzdG9yZUF0dHJpYnV0ZVZhbHVlcyI7TjtzOjE4OiJpbnZva2VEZWxldGVFdmVudHMiO2I6MTtzOjE5OiJhbGxvd0RlbGV0ZUNhbGxiYWNrIjtOO3M6MjM6ImRlbGV0ZUZhbGxiYWNrRXhjZXB0aW9uIjtzOjI1OiJ5aWlcZGJcSW50ZWdyaXR5RXhjZXB0aW9uIjtzOjY0OiIAeWlpMnRlY2hcYXJcc29mdGRlbGV0ZVxTb2Z0RGVsZXRlQmVoYXZpb3IAX3JlcGxhY2VSZWd1bGFyRGVsZXRlIjtiOjA7czo1OiJvd25lciI7cjo1O319czoxMjoiACoAX3F1YW50aXR5IjtOO31zOjg6InF1YW50aXR5IjtzOjE6IjEiO319',2,NULL),(73,'Егор',NULL,'Украина',NULL,NULL,NULL,NULL,NULL,'1234567896',NULL,NULL,NULL,0,1480085283,1480085283,NULL,'YToxOntzOjMyOiIzNmRlOTIwYzUzMTA3ZjA4NDU0YjhkMGY0M2Q3MTVhNiI7TzozMDoiY29tbW9uXG1vZGVsc1xJdGVtQ2FydFBvc2l0aW9uIjo0OntzOjI6ImlkIjtpOjgyO3M6NDoic2l6ZSI7czoxOiIxIjtzOjg6IgAqAF9pdGVtIjtPOjE4OiJjb21tb25cbW9kZWxzXEl0ZW0iOjk6e3M6MzY6IgB5aWlcZGJcQmFzZUFjdGl2ZVJlY29yZABfYXR0cmlidXRlcyI7YToxMzp7czoyOiJpZCI7aTo4MjtzOjEwOiJwcm9kdWN0X2lkIjtpOjgzO3M6ODoiY29sb3JfaWQiO2k6MztzOjQ6Im5hbWUiO3M6MTU6Ik5ld1Byb2QgY2hpbGQxMSI7czo0OiJzbHVnIjtzOjU6ImNjY2FhIjtzOjE4OiJzdG9ja19rZWVwaW5nX3VuaXQiO3M6NDoiMTExMSI7czo1OiJwcmljZSI7czo5OiI1MDAyMjIuMDAiO3M6MTQ6ImRpc2NvdW50X3ByaWNlIjtzOjY6IjIwMC4wMCI7czoxMDoiY3JlYXRlZF9hdCI7aToxNDc3MzExMzI1O3M6MTA6InVwZGF0ZWRfYXQiO2k6MTQ3OTM4NzIzNDtzOjY6InN0YXR1cyI7aToxO3M6MTE6InJlY29tbWVuZGVkIjtpOjE7czo5OiJpc0RlbGV0ZWQiO2k6MDt9czozOToiAHlpaVxkYlxCYXNlQWN0aXZlUmVjb3JkAF9vbGRBdHRyaWJ1dGVzIjthOjEzOntzOjI6ImlkIjtpOjgyO3M6MTA6InByb2R1Y3RfaWQiO2k6ODM7czo4OiJjb2xvcl9pZCI7aTozO3M6NDoibmFtZSI7czoxNToiTmV3UHJvZCBjaGlsZDExIjtzOjQ6InNsdWciO3M6NToiY2NjYWEiO3M6MTg6InN0b2NrX2tlZXBpbmdfdW5pdCI7czo0OiIxMTExIjtzOjU6InByaWNlIjtzOjk6IjUwMDIyMi4wMCI7czoxNDoiZGlzY291bnRfcHJpY2UiO3M6NjoiMjAwLjAwIjtzOjEwOiJjcmVhdGVkX2F0IjtpOjE0NzczMTEzMjU7czoxMDoidXBkYXRlZF9hdCI7aToxNDc5Mzg3MjM0O3M6Njoic3RhdHVzIjtpOjE7czoxMToicmVjb21tZW5kZWQiO2k6MTtzOjk6ImlzRGVsZXRlZCI7aTowO31zOjMzOiIAeWlpXGRiXEJhc2VBY3RpdmVSZWNvcmQAX3JlbGF0ZWQiO2E6MDp7fXM6MjM6IgB5aWlcYmFzZVxNb2RlbABfZXJyb3JzIjtOO3M6Mjc6IgB5aWlcYmFzZVxNb2RlbABfdmFsaWRhdG9ycyI7TjtzOjI1OiIAeWlpXGJhc2VcTW9kZWwAX3NjZW5hcmlvIjtzOjc6ImRlZmF1bHQiO3M6Mjc6IgB5aWlcYmFzZVxDb21wb25lbnQAX2V2ZW50cyI7YTo1OntzOjEyOiJiZWZvcmVJbnNlcnQiO2E6MTp7aTowO2E6Mjp7aTowO2E6Mjp7aTowO086MzE6InlpaVxiZWhhdmlvcnNcVGltZXN0YW1wQmVoYXZpb3IiOjY6e3M6MTg6ImNyZWF0ZWRBdEF0dHJpYnV0ZSI7czoxMDoiY3JlYXRlZF9hdCI7czoxODoidXBkYXRlZEF0QXR0cmlidXRlIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6InZhbHVlIjtOO3M6MTA6ImF0dHJpYnV0ZXMiO2E6Mjp7czoxMjoiYmVmb3JlSW5zZXJ0IjthOjI6e2k6MDtzOjEwOiJjcmVhdGVkX2F0IjtpOjE7czoxMDoidXBkYXRlZF9hdCI7fXM6MTI6ImJlZm9yZVVwZGF0ZSI7YToxOntpOjA7czoxMDoidXBkYXRlZF9hdCI7fX1zOjE3OiJza2lwVXBkYXRlT25DbGVhbiI7YjoxO3M6NToib3duZXIiO3I6NTt9aToxO3M6MTg6ImV2YWx1YXRlQXR0cmlidXRlcyI7fWk6MTtOO319czoxMjoiYmVmb3JlVXBkYXRlIjthOjE6e2k6MDthOjI6e2k6MDthOjI6e2k6MDtyOjQyO2k6MTtzOjE4OiJldmFsdWF0ZUF0dHJpYnV0ZXMiO31pOjE7Tjt9fXM6MTE6ImFmdGVySW5zZXJ0IjthOjE6e2k6MDthOjI6e2k6MDthOjI6e2k6MDtPOjI3OiJjb21tb25cYmVoYXZpb3JcU2VvQmVoYXZpb3IiOjI6e3M6MzU6IgBjb21tb25cYmVoYXZpb3JcU2VvQmVoYXZpb3IAX21vZGVsIjtOO3M6NToib3duZXIiO3I6NTt9aToxO3M6MTE6ImFmdGVySW5zZXJ0Ijt9aToxO047fX1zOjExOiJhZnRlclVwZGF0ZSI7YToxOntpOjA7YToyOntpOjA7YToyOntpOjA7cjo2NTtpOjE7czoxMToiYWZ0ZXJVcGRhdGUiO31pOjE7Tjt9fXM6MTE6ImFmdGVyRGVsZXRlIjthOjE6e2k6MDthOjI6e2k6MDthOjI6e2k6MDtyOjY1O2k6MTtzOjExOiJhZnRlckRlbGV0ZSI7fWk6MTtOO319fXM6MzA6IgB5aWlcYmFzZVxDb21wb25lbnQAX2JlaGF2aW9ycyI7YTozOntzOjk6InRpbWVzdGFtcCI7cjo0MjtzOjExOiJzZW9CZWhhdmlvciI7cjo2NTtzOjE4OiJzb2Z0RGVsZXRlQmVoYXZpb3IiO086NDE6InlpaTJ0ZWNoXGFyXHNvZnRkZWxldGVcU29mdERlbGV0ZUJlaGF2aW9yIjo3OntzOjI1OiJzb2Z0RGVsZXRlQXR0cmlidXRlVmFsdWVzIjthOjE6e3M6OToiaXNEZWxldGVkIjtiOjE7fXM6MjI6InJlc3RvcmVBdHRyaWJ1dGVWYWx1ZXMiO047czoxODoiaW52b2tlRGVsZXRlRXZlbnRzIjtiOjE7czoxOToiYWxsb3dEZWxldGVDYWxsYmFjayI7TjtzOjIzOiJkZWxldGVGYWxsYmFja0V4Y2VwdGlvbiI7czoyNToieWlpXGRiXEludGVncml0eUV4Y2VwdGlvbiI7czo2NDoiAHlpaTJ0ZWNoXGFyXHNvZnRkZWxldGVcU29mdERlbGV0ZUJlaGF2aW9yAF9yZXBsYWNlUmVndWxhckRlbGV0ZSI7YjowO3M6NToib3duZXIiO3I6NTt9fXM6MTI6IgAqAF9xdWFudGl0eSI7Tjt9czo4OiJxdWFudGl0eSI7czoxOiI0Ijt9fQ==',800,NULL),(74,'Егор',NULL,'Украина',NULL,NULL,NULL,NULL,NULL,'1234567896',NULL,NULL,NULL,0,1480085338,1480085338,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
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
INSERT INTO `page` VALUES (1,'O нас','<p>111Если вам приходилось работать с Yii2, наверняка возникала ситуация, когда нужно было сохранить связь «много ко многим».</p><p>Когда становилось ясно, что в сети еще нет поведений для работы с этим типом связи, тогда нужный код писался на событии «after save» и с напутствием «ну работает же» отправлялся в репозиторий.</p><p>Лично меня не устраивал такой расклад событий. Я решил написать то самое волшебное поведение, которого так не хватает в официальной сборке Yii2.</p>','about-us','0',23432434,1475234404,1),(2,'Контакты213','<p><br></p><p><img src=\"/data/page_images/57fe015055a10.jpg\" alt=\"57fe015055a10.jpg\"></p><p>ждлждвафды324123</p>','sdfdsfdsf','1',12323,1478178082,0);
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
  `item_id` int(11) unsigned NOT NULL,
  `size_id` tinyint(2) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_pre_order_item_id_idx` (`item_id`),
  KEY `fk_pre_order_size_id_idx` (`size_id`),
  CONSTRAINT `fk_pre_order_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pre_order_size_id` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_order`
--

LOCK TABLES `pre_order` WRITE;
/*!40000 ALTER TABLE `pre_order` DISABLE KEYS */;
INSERT INTO `pre_order` VALUES (7,82,5,'Егор','yehor111@mail.ru','0981112222',1478764655,1479225138,1),(10,82,4,'Егор','yehor112@mail.ru','0981122222',1478766060,1478766060,0),(11,82,1,'Егор','yehor112@mail.ru','0981122222',1478766460,1478766460,0),(13,82,8,'Егор','yeho333@mail.ru','0983331111',1478767074,1478767074,0),(14,82,8,'Егор','yeho@gmail.ru','0983331122',1478767108,1478767108,0);
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
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `sort_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_brand_id_idx` (`brand_id`),
  KEY `fk_product_category_id_idx` (`category_id`),
  CONSTRAINT `fk_product_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `fk_product_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (10,'Polo','<p>dsfdsf</p>',1,0,4,23432,1476101274,0,7),(11,'T-shirt','<p>asdsad</p>',1,0,3,234324,1475654949,0,5),(27,'Polo2','<p><strong>Описание</strong></p><p>Polo2</p>',1,NULL,4,1475590260,1476365474,0,9),(49,'Наименование','<p><strong>Наименование</strong></p>',1,NULL,3,1476103505,1476365453,1,10),(50,'TestName','<p>TestName<strong>Описание</strong><span class=\"redactor-invisible-space\"></span></p>',1,NULL,4,1476184042,1476184042,1,11),(52,'НаименованиеProduct','<p>asdsads</p>',1,NULL,3,1476339943,1476339943,1,6),(80,'New product2222','<p>New product Описа222</p>',1,31,3,1477041396,1480066364,1,0),(81,'New product','New produc333',1,32,4,1477041480,1477310984,0,2),(83,'New product','Описание',1,33,3,1477311241,1477311241,1,1),(89,'Наименование','sdfsdf',1,NULL,4,1479117002,1479117002,1,4),(90,'НаименованиеProduct','asdasd',1,NULL,3,1479117593,1479117593,1,8),(91,'Наименованиеasdsad','<p>Данные футболки подходят, как для отдыха, так и в качестве корпоративной одежды. Приятно одевать и носить. Оптимальное качество по соотношению с ценой.<br></p><ul><li> Узорчатый трикотаж.</li><li> Круглый вырез.</li><li> Отделка в виде стяжки.</li><li> Длина рукава: 60 см.</li><li> Длина: 60 см.</li><li> Ширина подмышками: 52 см.</li><li> Параметры указаны для размера: M.</li></ul><ul><li> Узор: узорные</li><li> Тип: короткие</li><li> Тип: вязаные</li></ul><p>Состав:<br>Основной материал: 40% Акрил, 60% Хлопок</p><p>Код товара: 4940-SWM048</p><p>Код произодителя: 10744502871</p>',1,34,4,1479127335,1480059669,1,3),(92,'asdasd','<p>Данные футболки подходят, как для отдыха, так и в качестве корпоративной одежды. Приятно одевать и носить. Оптимальное качество по соотношению с ценой.<br></p><ul><li>- Узорчатый трикотаж.</li><li>- Круглый вырез.</li><li>- Отделка в виде стяжки.</li><li>- Длина рукава: 60 см.</li><li>- Длина: 60 см.</li><li>- Ширина подмышками: 52 см.</li><li>- Параметры указаны для размера: M.</li></ul><ul><li>• Узор: узорные</li><li>• Тип: короткие</li><li>• Тип: вязаные</li></ul><p>Состав:<br>Основной материал: 40% Акрил, 60% Хлопок</p><p>Код товара: 4940-SWM048</p><p>Код произодителя: 10744502871</p>',1,NULL,3,1479721265,1480066350,1,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT INTO `seo` VALUES (1,'common\\models\\Page','seo Title',' seo Description','seo Keyword',2),(4,'common\\models\\Page','O нас','about us Description','about us',1),(6,'common\\models\\Product','seo Title','Description seo','seo Keyword',10),(8,'common\\models\\Product','seo Title112233','Description112233','seo Keyword112233',27),(11,'common\\models\\Category','seo Title','Description','seo Keyword',1),(13,'common\\models\\Category','seo Titled','Descriptiond','Keywordd',4),(17,'common\\models\\Product','seo Title','Цена','Keyword',49),(18,'common\\models\\Product','TitlePageTest2','Description','seo Keyword',50),(19,'common\\models\\Product','seo Title','ffffff','KeywordTitlePageTest2',51),(20,'common\\models\\Product','seo Title','Asasa','Keyword',52),(21,'common\\models\\Item','SEO Title','SEO Description','SEO Keyword',32),(61,'common\\models\\Item','SEO Title','SEO Descriptio','SEO Keyword',78),(62,'common\\models\\Item','SEO Title','SEO Descriptio','SEO Keyword',79),(63,'common\\models\\Item','seo Title','Description','Keyword',80),(82,'common\\models\\Item','seo Title','SEO Description','Keyword',100),(108,'common\\models\\Item','','','',133),(109,'common\\models\\Item','','SEO Description','',128);
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
  `euid` varchar(45) DEFAULT NULL COMMENT 'Mail Chimp Euid',
  `leid` varchar(45) DEFAULT NULL COMMENT 'Mail Chimp Leid',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `mail_chimp_status` varchar(45) DEFAULT '0',
  `group` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriber`
--

LOCK TABLES `subscriber` WRITE;
/*!40000 ALTER TABLE `subscriber` DISABLE KEYS */;
INSERT INTO `subscriber` VALUES (4,'Rgot','yehor86@mail.ru','0981111111','48d622a8b9','7156533',1475764192,1475824347,16,'pending',1),(5,'Rgot','belemets.egor@gmail.com','1111111111','fa11df2b60','7168885',1475764211,1475823197,15,'subscribed',1),(6,'Егор2','yewhor86@gmail.com','2222222222','e1613ce1e9','7169681',1477906244,1479397952,17,'subscribed',1),(11,'Ivan','ivan@ivanov.com','2342344444','0be1eba734','20556477',1478184017,1478184017,1,'pending',2),(12,'mike','mike@show.com','2345435411','046a297b7b','20556561',1478184658,1478184658,0,'pending',2),(13,'mike','mike@mike.com','1598742563','fd25c2c0be','20556797',1478184994,1478184994,7,'pending',2),(14,'john','admin@gmail.com','3698521475','753d5f82bc','20562329',1478185421,1478185421,8,'pending',2),(15,'Ivan','ivan@gmail.com','2221122222','e8ef571319','21696025',1478693359,1478693359,13,'pending',2),(16,'Егор','yehor111@mail.ru','0981112222','b3b4881d96','21888433',1478764655,1478764655,12,'pending',2),(17,'Егор','yeho333@mail.ru','0983331122','ff883047b3','21890389',1478767031,1478767031,11,'pending',2),(19,'Егор','yeho@gmail.ru','0983331122','2374fbb69f','21890393',1478767147,1478767147,1,'pending',2),(20,'Егор33','test@gmail.ru','0000000000','f62daad413','21890413',1478767609,1478767609,10,'pending',1),(21,'Егор','egor@jaws.com.ua','0503535352','c5db08c16f','30083635',1478792444,1478792444,9,'pending',3),(23,'wqeqw','qweqw','12312','12323','21321',1479081600,1479081600,8,'pending',1),(24,'asd','asd','123','123','123',1478995199,1478995200,7,'pending',1),(25,'Ivan','belemets2004@mail.ru','2342344444','426def038e','31178359',1479200119,1479200119,6,'pending',3),(26,'Ivan','yehor86@gmail.com','1111111111','e1613ce1e9','7169681',1479207903,1479207903,5,'pending',3),(27,'asdas','yehorqq86@gmail.com','2342344442','4d70073b72','23744129',1479210062,1479210062,4,'pending',3),(28,'Ivan','belemet@mail.ru','2342344444','76fbfe6933','23865697',1479218085,1479218085,2,'pending',3),(29,'Ivan','belemet2004@mail.ru','2342344444','fb209fbae3','23866233',1479218571,1479218571,3,'pending',3),(30,'Ivan','belesss2004@mail.ru','2342344444','3fcfe0e0fe','23974493',1479223830,1479223830,0,'pending',3),(31,'Ivan','beledds2004@mail.ru','2342344444','07ebd3c6c4','23974529',1479223950,1479223950,14,'pending',3),(32,'Ivan','belddemets2004@mail.ru','1111111111','8dd877fc7e','25126913',1479483536,1479483536,NULL,'pending',3),(33,'Ivan','belemets2ss004@mail.ru','2342344444','1efdbb9bd2','25126921',1479483579,1479483579,NULL,'pending',3);
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
INSERT INTO `user` VALUES (1,'Egor','93S6xOcRFzosN4kctDc3Ca2ni6OGXdJK','$2y$13$wO3mpVtp87jGAtVzf.LSq.o/Zl2MGU.DZm/0LXr7WEK4oDo8KBy2.','V9Udll1R6UOuFtbJZm--YDDlMOVygJ3__1479221170','belemets.egor@gmail.com',10,1473944097,1479477751,'user');
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_storage`
--

LOCK TABLES `video_storage` WRITE;
/*!40000 ALTER TABLE `video_storage` DISABLE KEYS */;
INSERT INTO `video_storage` VALUES (31,'video1-99f14bd9ed.mp4','common\\models\\Product',80,'/data/video_storage/video1-7173442461.mp4',1477310618,1477310618),(32,'video1-8a769f1cdb.mp4','common\\models\\Product',81,'/data/video_storage/video1-30bd85403f.mp4',1477310984,1477310984),(33,'video1-0141ad830a.mp4','common\\models\\Product',83,'/data/video_storage/video1-05b38306aa.mp4',1477311241,1477311241),(34,'video1-a9049cbc6f-af1372db03.mp4','common\\models\\Product',91,'/data/video_storage/video1-a9049cbc6f-4dcb185d43.mp4',1479998969,1479998969);
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

-- Dump completed on 2016-11-25 18:29:35
