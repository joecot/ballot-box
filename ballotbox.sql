-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: ballotbox
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `Affiliate`
--

DROP TABLE IF EXISTS `Affiliate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Affiliate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Affiliate`
--

LOCK TABLES `Affiliate` WRITE;
/*!40000 ALTER TABLE `Affiliate` DISABLE KEYS */;
INSERT INTO `Affiliate` VALUES (1,'Mind\'s Eye Society'),(2,'Mind\'s Eye Society Brazil'),(3,'Canada @ Midnight'),(4,'Worldwide Theater Games'),(5,'Underground Theater');
/*!40000 ALTER TABLE `Affiliate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ballot`
--

DROP TABLE IF EXISTS `Ballot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ballot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(40) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `timezone` tinyint(3) unsigned NOT NULL,
  `version_created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ballot`
--

LOCK TABLES `Ballot` WRITE;
/*!40000 ALTER TABLE `Ballot` DISABLE KEYS */;
INSERT INTO `Ballot` VALUES (1,1,'pants',1480568400,1481173199,1,1,'2016-11-30 00:17:59','2016-11-30 00:18:30',2,'2016-11-30 00:18:30'),(2,1,'pants2',1480568400,1481173199,1,1,'2016-11-30 00:24:20','2016-11-30 00:24:20',1,'2016-11-30 00:24:20'),(3,1,'pants4',1480568400,1481173199,1,1,'2016-11-30 00:33:16','2016-11-30 00:33:16',1,'2016-11-30 00:33:16');
/*!40000 ALTER TABLE `Ballot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ballot_version`
--

DROP TABLE IF EXISTS `Ballot_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ballot_version` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(40) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `timezone` tinyint(3) unsigned NOT NULL,
  `version_created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `Voter_ids` text,
  `Voter_versions` text,
  `Question_ids` text,
  `Question_versions` text,
  `Vote_ids` text,
  `Vote_versions` text,
  PRIMARY KEY (`id`,`version`),
  CONSTRAINT `Ballot_version_fk_df6701` FOREIGN KEY (`id`) REFERENCES `Ballot` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ballot_version`
--

LOCK TABLES `Ballot_version` WRITE;
/*!40000 ALTER TABLE `Ballot_version` DISABLE KEYS */;
INSERT INTO `Ballot_version` VALUES (1,1,'',1480568400,1481173199,1,1,'2016-11-30 00:17:59','2016-11-30 00:17:59',1,'2016-11-30 00:17:59',NULL,NULL,NULL,NULL,NULL,NULL),(1,1,'pants',1480568400,1481173199,1,1,'2016-11-30 00:17:59','2016-11-30 00:18:30',2,'2016-11-30 00:18:30',NULL,NULL,NULL,NULL,NULL,NULL),(2,1,'pants2',1480568400,1481173199,1,1,'2016-11-30 00:24:20','2016-11-30 00:24:20',1,'2016-11-30 00:24:20',NULL,NULL,NULL,NULL,NULL,NULL),(3,1,'pants4',1480568400,1481173199,1,1,'2016-11-30 00:33:16','2016-11-30 00:33:16',1,'2016-11-30 00:33:16',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Ballot_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Candidate`
--

DROP TABLE IF EXISTS `Candidate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Candidate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `is_deleted` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `application` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Candidate_fi_3ff0cc` (`question_id`),
  KEY `Candidate_fi_29554a` (`user_id`),
  CONSTRAINT `Candidate_fk_29554a` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`),
  CONSTRAINT `Candidate_fk_3ff0cc` FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Candidate`
--

LOCK TABLES `Candidate` WRITE;
/*!40000 ALTER TABLE `Candidate` DISABLE KEYS */;
INSERT INTO `Candidate` VALUES (1,1,NULL,1,'','2016-11-30 00:19:05','2016-11-30 00:19:05',1,'2016-11-30 00:19:05','1');
/*!40000 ALTER TABLE `Candidate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Candidate_version`
--

DROP TABLE IF EXISTS `Candidate_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Candidate_version` (
  `id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `is_deleted` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `application` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  `question_id_version` int(11) DEFAULT '0',
  `Vote_item_ids` text,
  `Vote_item_versions` text,
  PRIMARY KEY (`id`,`version`),
  CONSTRAINT `Candidate_version_fk_48e368` FOREIGN KEY (`id`) REFERENCES `Candidate` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Candidate_version`
--

LOCK TABLES `Candidate_version` WRITE;
/*!40000 ALTER TABLE `Candidate_version` DISABLE KEYS */;
INSERT INTO `Candidate_version` VALUES (1,1,NULL,1,'','2016-11-30 00:19:05','2016-11-30 00:19:05',1,'2016-11-30 00:19:05','1',1,NULL,NULL);
/*!40000 ALTER TABLE `Candidate_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Question`
--

DROP TABLE IF EXISTS `Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ballot_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `is_deleted` int(10) unsigned DEFAULT '0',
  `type` tinyint(4) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `description` text,
  `readmore` varchar(255) DEFAULT NULL,
  `discussion` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Question_fi_f4dbb1` (`ballot_id`),
  CONSTRAINT `Question_fk_f4dbb1` FOREIGN KEY (`ballot_id`) REFERENCES `Ballot` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Question`
--

LOCK TABLES `Question` WRITE;
/*!40000 ALTER TABLE `Question` DISABLE KEYS */;
INSERT INTO `Question` VALUES (1,1,1,0,1,1,'test','test',NULL,NULL,'2016-11-30 00:18:37','2016-11-30 00:18:37',1,'2016-11-30 00:18:37','1'),(2,1,2,0,1,1,'pants2?',NULL,NULL,NULL,'2016-11-30 00:19:17','2016-11-30 00:19:17',1,'2016-11-30 00:19:17','1'),(3,1,3,0,0,1,'pants3?',NULL,NULL,NULL,'2016-11-30 00:19:26','2016-11-30 00:19:26',1,'2016-11-30 00:19:26','1');
/*!40000 ALTER TABLE `Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Question_version`
--

DROP TABLE IF EXISTS `Question_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Question_version` (
  `id` int(10) unsigned NOT NULL,
  `ballot_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `is_deleted` int(10) unsigned DEFAULT '0',
  `type` tinyint(4) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `description` text,
  `readmore` varchar(255) DEFAULT NULL,
  `discussion` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  `ballot_id_version` int(11) DEFAULT '0',
  `Candidate_ids` text,
  `Candidate_versions` text,
  `Vote_item_ids` text,
  `Vote_item_versions` text,
  PRIMARY KEY (`id`,`version`),
  CONSTRAINT `Question_version_fk_e2315c` FOREIGN KEY (`id`) REFERENCES `Question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Question_version`
--

LOCK TABLES `Question_version` WRITE;
/*!40000 ALTER TABLE `Question_version` DISABLE KEYS */;
INSERT INTO `Question_version` VALUES (1,1,1,0,1,1,'test','test',NULL,NULL,'2016-11-30 00:18:37','2016-11-30 00:18:37',1,'2016-11-30 00:18:37','1',2,NULL,NULL,NULL,NULL),(2,1,2,0,1,1,'pants2?',NULL,NULL,NULL,'2016-11-30 00:19:17','2016-11-30 00:19:17',1,'2016-11-30 00:19:17','1',2,NULL,NULL,NULL,NULL),(3,1,3,0,0,1,'pants3?',NULL,NULL,NULL,'2016-11-30 00:19:26','2016-11-30 00:19:26',1,'2016-11-30 00:19:26','1',2,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Question_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_number` varchar(20) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `email_address` varchar(128) NOT NULL,
  `affiliate_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membership_number` (`membership_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'US2010086415','Joseph','Terranova','joeterranova@gmail.com',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vote`
--

DROP TABLE IF EXISTS `Vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ballot_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Vote_fi_f4dbb1` (`ballot_id`),
  KEY `Vote_fi_29554a` (`user_id`),
  CONSTRAINT `Vote_fk_29554a` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`),
  CONSTRAINT `Vote_fk_f4dbb1` FOREIGN KEY (`ballot_id`) REFERENCES `Ballot` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vote`
--

LOCK TABLES `Vote` WRITE;
/*!40000 ALTER TABLE `Vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `Vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vote_item`
--

DROP TABLE IF EXISTS `Vote_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vote_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vote_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `candidate_id` int(10) unsigned DEFAULT NULL,
  `answer` tinyint(3) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Vote_item_fi_b2c012` (`vote_id`),
  KEY `Vote_item_fi_3ff0cc` (`question_id`),
  KEY `Vote_item_fi_f2eb60` (`candidate_id`),
  CONSTRAINT `Vote_item_fk_3ff0cc` FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`),
  CONSTRAINT `Vote_item_fk_b2c012` FOREIGN KEY (`vote_id`) REFERENCES `Vote` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vote_item`
--

LOCK TABLES `Vote_item` WRITE;
/*!40000 ALTER TABLE `Vote_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `Vote_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vote_item_version`
--

DROP TABLE IF EXISTS `Vote_item_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vote_item_version` (
  `id` int(10) unsigned NOT NULL,
  `vote_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `candidate_id` int(10) unsigned DEFAULT NULL,
  `answer` tinyint(3) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  `vote_id_version` int(11) DEFAULT '0',
  `question_id_version` int(11) DEFAULT '0',
  `candidate_id_version` int(11) DEFAULT '0',
  PRIMARY KEY (`id`,`version`),
  CONSTRAINT `Vote_item_version_fk_1af141` FOREIGN KEY (`id`) REFERENCES `Vote_item` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vote_item_version`
--

LOCK TABLES `Vote_item_version` WRITE;
/*!40000 ALTER TABLE `Vote_item_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `Vote_item_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vote_version`
--

DROP TABLE IF EXISTS `Vote_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vote_version` (
  `id` int(10) unsigned NOT NULL,
  `ballot_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  `ballot_id_version` int(11) DEFAULT '0',
  `Vote_item_ids` text,
  `Vote_item_versions` text,
  PRIMARY KEY (`id`,`version`),
  CONSTRAINT `Vote_version_fk_3ff174` FOREIGN KEY (`id`) REFERENCES `Vote` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vote_version`
--

LOCK TABLES `Vote_version` WRITE;
/*!40000 ALTER TABLE `Vote_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `Vote_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Voter`
--

DROP TABLE IF EXISTS `Voter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Voter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ballot_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `affiliate_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ballot_id` (`ballot_id`),
  KEY `Voter_fi_29554a` (`user_id`),
  KEY `Voter_fi_152383` (`affiliate_id`),
  CONSTRAINT `Voter_fk_152383` FOREIGN KEY (`affiliate_id`) REFERENCES `Affiliate` (`id`),
  CONSTRAINT `Voter_fk_29554a` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`),
  CONSTRAINT `Voter_fk_f4dbb1` FOREIGN KEY (`ballot_id`) REFERENCES `Ballot` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Voter`
--

LOCK TABLES `Voter` WRITE;
/*!40000 ALTER TABLE `Voter` DISABLE KEYS */;
/*!40000 ALTER TABLE `Voter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Voter_version`
--

DROP TABLE IF EXISTS `Voter_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Voter_version` (
  `id` int(10) unsigned NOT NULL,
  `ballot_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `affiliate_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  `ballot_id_version` int(11) DEFAULT '0',
  PRIMARY KEY (`id`,`version`),
  CONSTRAINT `Voter_version_fk_4feb47` FOREIGN KEY (`id`) REFERENCES `Voter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Voter_version`
--

LOCK TABLES `Voter_version` WRITE;
/*!40000 ALTER TABLE `Voter_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `Voter_version` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-02 22:00:06
