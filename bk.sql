-- MySQL dump 10.13  Distrib 5.6.21, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: s4h
-- ------------------------------------------------------
-- Server version	5.6.21-1~dotdeb.1

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
-- Table structure for table `families`
--

DROP TABLE IF EXISTS `families`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `families` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `countrie_id` int(11) NOT NULL,
  `zipcode_id` int(11) NOT NULL,
  `suburb_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `numberint` varchar(50) NOT NULL,
  `numberext` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_Families_group_id_idx` (`group_id`),
  CONSTRAINT `FK_Families_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `families`
--

LOCK TABLES `families` WRITE;
/*!40000 ALTER TABLE `families` DISABLE KEYS */;
INSERT INTO `families` VALUES (31,NULL,31,1,15073,63907,'','','','','','','2014-10-28 21:50:56','2014-10-28 21:50:56'),(44,NULL,44,1,15073,63907,'','','','','','','2014-10-28 21:50:56','2014-10-28 21:50:56');
/*!40000 ALTER TABLE `families` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fileName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (25,'default.jpg','https://s3.amazonaws.com/soft4h/default.jpg','image/jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(26,'defaultfamily.png','https://s3.amazonaws.com/soft4h/defaultfamily.png','image/png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,'10600554_819092671466368_6796286882243604048_n.jpg','https://s3.amazonaws.com/soft4h/1d5766389f53ec8f9de0741e81438fd7245f48cd.jpg','image/jpeg',22,'2014-10-29 01:23:47','2014-10-29 01:23:47'),(32,'af2e16c218830d82a96563745a634af1cf68f74b.JPG','https://s3.amazonaws.com/soft4h/a1add7a9e4355c4d9b52b08184b718148663c49f.JPG','image/jpeg',22,'2014-10-29 01:25:29','2014-10-29 01:25:29');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_person`
--

DROP TABLE IF EXISTS `group_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `GroupId_idx` (`group_id`),
  KEY `FK_GroupMembers_PersonId_idx` (`role_id`),
  KEY `FK_group_person.person_id__people.id_idx` (`person_id`),
  CONSTRAINT `FK_group_person.person_id__people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  CONSTRAINT `FK_group_person.role_id_Roles.Id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `FK_groups.id__group_person.id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_person`
--

LOCK TABLES `group_person` WRITE;
/*!40000 ALTER TABLE `group_person` DISABLE KEYS */;
INSERT INTO `group_person` VALUES (20,31,77,1,1),(21,31,78,0,1),(22,31,79,0,1),(23,31,80,0,1),(24,31,81,0,1),(25,31,82,0,1),(26,31,83,0,1),(55,44,99,1,1),(56,44,77,0,1);
/*!40000 ALTER TABLE `group_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `GroupTypeID` int(10) unsigned NOT NULL,
  `JoinAuthOption` int(10) unsigned NOT NULL,
  `InviteAuthOption` int(10) unsigned NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `GroupTypeID` (`GroupTypeID`),
  KEY `FK_groups.file_id_files.id_idx` (`file_id`),
  CONSTRAINT `FK_groups.file_id_files.id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Groups.GroupTypeID_GroupTypes.Id` FOREIGN KEY (`GroupTypeID`) REFERENCES `grouptypes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (31,'Los simpson',1,2,2,1,26,'2014-10-28 21:50:56','2014-10-28 21:50:56'),(44,'Familia de la comunidad',2,2,2,1,26,'2014-10-28 21:50:56','2014-10-28 21:50:56');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grouptypes`
--

DROP TABLE IF EXISTS `grouptypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grouptypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GroupType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grouptypes`
--

LOCK TABLES `grouptypes` WRITE;
/*!40000 ALTER TABLE `grouptypes` DISABLE KEYS */;
INSERT INTO `grouptypes` VALUES (1,'Family',1,'2014-09-15 00:00:00','0000-00-00 00:00:00'),(2,'Community',1,'2014-09-15 00:00:00','0000-00-00 00:00:00'),(3,'Group',1,'2014-09-15 00:00:00','0000-00-00 00:00:00'),(4,'FamilyFriends',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `grouptypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mothersname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_people.file_id_files.id_idx` (`file_id`),
  CONSTRAINT `FK_people.file_id_files.id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (77,25,'Bart','Simpson','Bouvier','2014-12-16',1,'132456','bart@gmail.com','2014-12-16 18:24:02','2014-12-16 18:24:02'),(78,25,'Homero','Simpson','','1970-01-01',1,'','','2014-12-16 20:26:24','2014-12-16 20:26:24'),(79,25,'Marge','Simpson','','1970-01-01',2,'','','2014-12-16 20:30:23','2014-12-16 20:30:23'),(80,25,'Abraham','Simpson','','1970-01-01',1,'','','2014-12-16 20:30:40','2014-12-16 20:30:40'),(81,25,'Mona','Simpson','','1970-01-01',2,'','','2014-12-16 20:30:53','2014-12-16 20:30:53'),(82,25,'Clancy','Bouvier','','1970-01-01',1,'','','2014-12-16 20:31:09','2014-12-16 20:31:09'),(83,25,'Jacqueline','Bouvier','','1970-01-01',2,'','','2014-12-16 20:31:35','2014-12-16 20:31:35'),(99,25,'Milhouse','Van Hauten','','1978-12-12',1,'(322) 135-5928','milhouse@gmail.com','2014-10-28 21:50:54','2014-10-28 22:04:09');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL,
  `grouptype_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  KEY `FK_roles.grouptype_id_grouptypes.id_idx` (`grouptype_id`),
  CONSTRAINT `FK_roles.grouptype_id_grouptypes.id` FOREIGN KEY (`grouptype_id`) REFERENCES `grouptypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,1,'Pap',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,'Mam',2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,'Hijo/a',3,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `share_types`
--

DROP TABLE IF EXISTS `share_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `share_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sharetype` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` varchar(45) NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `share_types`
--

LOCK TABLES `share_types` WRITE;
/*!40000 ALTER TABLE `share_types` DISABLE KEYS */;
INSERT INTO `share_types` VALUES (1,'give','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'take','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'respond','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'receive','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `share_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sharedetail_shareoption`
--

DROP TABLE IF EXISTS `sharedetail_shareoption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sharedetail_shareoption` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sharedetail_id` int(10) unsigned NOT NULL,
  `shareoption_id` int(10) unsigned NOT NULL,
  `value` varchar(512) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_sharedetailoption_sharedetail_id_idx` (`sharedetail_id`),
  KEY `FK_sharedetailoption_shareoptions_id_idx` (`shareoption_id`),
  CONSTRAINT `FK_sharedetailoption_sharedetails_id` FOREIGN KEY (`sharedetail_id`) REFERENCES `sharedetails` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_sharedetailoption_shareoptions_id` FOREIGN KEY (`shareoption_id`) REFERENCES `shareoptions` (`share_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sharedetail_shareoption`
--

LOCK TABLES `sharedetail_shareoption` WRITE;
/*!40000 ALTER TABLE `sharedetail_shareoption` DISABLE KEYS */;
/*!40000 ALTER TABLE `sharedetail_shareoption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sharedetails`
--

DROP TABLE IF EXISTS `sharedetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sharedetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `share_id` int(10) unsigned NOT NULL,
  `status` int(11) DEFAULT NULL,
  `person_id` int(10) unsigned DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_sharedetails.share_id__shares.id_idx` (`share_id`),
  CONSTRAINT `FK_sharedetails.share_id__shares.id` FOREIGN KEY (`share_id`) REFERENCES `shares` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sharedetails`
--

LOCK TABLES `sharedetails` WRITE;
/*!40000 ALTER TABLE `sharedetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `sharedetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shareoptions`
--

DROP TABLE IF EXISTS `shareoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shareoptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `share_id` int(10) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `option` varchar(512) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_shareoptions.shareoption_id__shares.id_idx` (`share_id`),
  CONSTRAINT `FK_shareoptions.shareoption_id__shares.id` FOREIGN KEY (`share_id`) REFERENCES `shares` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shareoptions`
--

LOCK TABLES `shareoptions` WRITE;
/*!40000 ALTER TABLE `shareoptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `shareoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shares`
--

DROP TABLE IF EXISTS `shares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `sharetype_id` int(10) unsigned NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `element_id` int(11) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_share.sharetype_id__sharetype.id_idx` (`sharetype_id`),
  KEY `FK_share.person_id__people.id_idx` (`person_id`),
  CONSTRAINT `FK_share.person_id__people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_share.sharetype_id__sharetype.id` FOREIGN KEY (`sharetype_id`) REFERENCES `share_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shares`
--

LOCK TABLES `shares` WRITE;
/*!40000 ALTER TABLE `shares` DISABLE KEYS */;
/*!40000 ALTER TABLE `shares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `person_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_users.person_id__people.id_idx` (`person_id`),
  CONSTRAINT `FK_users.person_id__people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (23,'bartsimpson','bart@gmail.com','$2y$10$0trYexoxJ1k3wrc2FxTp9O0IA.pYLHw71lbmYIYTeuRidfmMh0YpG','f24a615b641c85815613e27f781449a9',1,77,'2014-12-16 18:24:02','2014-12-16 18:24:02');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-19 20:27:17
