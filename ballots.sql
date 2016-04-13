-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: ballotbox
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Affiliate`
--

LOCK TABLES `Affiliate` WRITE;
/*!40000 ALTER TABLE `Affiliate` DISABLE KEYS */;
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
  `name` varchar(20) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ballot`
--

LOCK TABLES `Ballot` WRITE;
/*!40000 ALTER TABLE `Ballot` DISABLE KEYS */;
INSERT INTO `Ballot` VALUES (1,1,'Pants?',1460001600,1460692799,1,1,'2016-04-08 00:36:36','2016-04-09 04:09:49',4,'2016-04-09 04:09:49');
/*!40000 ALTER TABLE `Ballot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ballot_question`
--

DROP TABLE IF EXISTS `Ballot_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ballot_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ballot_id` int(10) unsigned NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `description` text,
  `readmore` varchar(255) DEFAULT NULL,
  `discussion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Ballot_question_fi_f4dbb1` (`ballot_id`),
  CONSTRAINT `Ballot_question_fk_f4dbb1` FOREIGN KEY (`ballot_id`) REFERENCES `Ballot` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ballot_question`
--

LOCK TABLES `Ballot_question` WRITE;
/*!40000 ALTER TABLE `Ballot_question` DISABLE KEYS */;
INSERT INTO `Ballot_question` VALUES (1,1,1,1,'Coolest Sabbat aNST',NULL,NULL,NULL);
/*!40000 ALTER TABLE `Ballot_question` ENABLE KEYS */;
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
  `name` varchar(20) NOT NULL,
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
INSERT INTO `Ballot_version` VALUES (1,1,'Pants?',1459915200,1460692799,1,1,'2016-04-08 00:36:36','2016-04-08 00:36:36',1,'2016-04-08 00:36:36',NULL,NULL,NULL,NULL,NULL,NULL),(1,1,'Pants?',1460088000,1460692799,1,1,'2016-04-08 00:36:36','2016-04-09 04:05:27',2,'2016-04-09 04:05:27','| 1 |','| 1 |','| 1 | 2 |','| 1 | 1 |',NULL,NULL),(1,1,'Pants?',1460260800,1460692799,1,1,'2016-04-08 00:36:36','2016-04-09 04:05:53',3,'2016-04-09 04:05:53','| 1 |','| 1 |','| 1 | 2 |','| 1 | 1 |',NULL,NULL),(1,1,'Pants?',1460001600,1460692799,1,1,'2016-04-08 00:36:36','2016-04-09 04:09:49',4,'2016-04-09 04:09:49','| 1 |','| 1 |','| 1 | 2 |','| 1 | 1 |',NULL,NULL);
/*!40000 ALTER TABLE `Ballot_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ballot_voter`
--

DROP TABLE IF EXISTS `Ballot_voter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ballot_voter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ballot_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `affiliate_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `timezone` tinyint(3) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ballot_voter`
--

LOCK TABLES `Ballot_voter` WRITE;
/*!40000 ALTER TABLE `Ballot_voter` DISABLE KEYS */;
/*!40000 ALTER TABLE `Ballot_voter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ballot_voter_version`
--

DROP TABLE IF EXISTS `Ballot_voter_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ballot_voter_version` (
  `id` int(10) unsigned NOT NULL,
  `ballot_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `affiliate_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `timezone` tinyint(3) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `version_created_at` datetime DEFAULT NULL,
  `version_created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`,`version`),
  CONSTRAINT `Ballot_voter_version_fk_7d4a89` FOREIGN KEY (`id`) REFERENCES `Ballot_voter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ballot_voter_version`
--

LOCK TABLES `Ballot_voter_version` WRITE;
/*!40000 ALTER TABLE `Ballot_voter_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `Ballot_voter_version` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Candidate`
--

LOCK TABLES `Candidate` WRITE;
/*!40000 ALTER TABLE `Candidate` DISABLE KEYS */;
INSERT INTO `Candidate` VALUES (1,1,1,NULL,'2016-04-08 00:38:08','2016-04-08 00:38:08',1,'2016-04-08 00:38:08','1'),(2,1,2,NULL,'2016-04-08 00:38:15','2016-04-08 00:38:15',1,'2016-04-08 00:38:15','1');
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
INSERT INTO `Candidate_version` VALUES (1,1,1,NULL,'2016-04-08 00:38:08','2016-04-08 00:38:08',1,'2016-04-08 00:38:08','1',1,NULL,NULL),(2,1,2,NULL,'2016-04-08 00:38:15','2016-04-08 00:38:15',1,'2016-04-08 00:38:15','1',1,NULL,NULL);
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
  `type` tinyint(4) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `name` varchar(20) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Question`
--

LOCK TABLES `Question` WRITE;
/*!40000 ALTER TABLE `Question` DISABLE KEYS */;
INSERT INTO `Question` VALUES (1,1,1,1,'Who gets pants?',NULL,NULL,NULL,'2016-04-08 00:36:47','2016-04-08 00:36:47',1,'2016-04-08 00:36:47','1'),(2,1,0,1,'Any pants at all?','Should anyone get pants?',NULL,NULL,'2016-04-08 01:08:29','2016-04-08 01:08:29',1,'2016-04-08 01:08:29','1');
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
  `type` tinyint(4) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `name` varchar(20) NOT NULL,
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
INSERT INTO `Question_version` VALUES (1,1,1,1,'Who gets pants?',NULL,NULL,NULL,'2016-04-08 00:36:47','2016-04-08 00:36:47',1,'2016-04-08 00:36:47','1',1,NULL,NULL,NULL,NULL),(2,1,0,1,'Any pants at all?','Should anyone get pants?',NULL,NULL,'2016-04-08 01:08:29','2016-04-08 01:08:29',1,'2016-04-08 01:08:29','1',1,NULL,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'US2010086415','Joseph','Terranova','joeterranova@gmail.com',1),(2,'US2002022365','Jason','Herman','jaherman@vt.edu',1);
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
  CONSTRAINT `Vote_item_fk_b2c012` FOREIGN KEY (`vote_id`) REFERENCES `Vote` (`id`),
  CONSTRAINT `Vote_item_fk_f2eb60` FOREIGN KEY (`candidate_id`) REFERENCES `Candidate` (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Voter`
--

LOCK TABLES `Voter` WRITE;
/*!40000 ALTER TABLE `Voter` DISABLE KEYS */;
INSERT INTO `Voter` VALUES (1,1,1,NULL,'2016-04-08 00:39:31','2016-04-08 00:39:31',1,'2016-04-08 00:39:31','1');
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
INSERT INTO `Voter_version` VALUES (1,1,1,NULL,'2016-04-08 00:39:31','2016-04-08 00:39:31',1,'2016-04-08 00:39:31','1',1);
/*!40000 ALTER TABLE `Voter_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propel_migration`
--

DROP TABLE IF EXISTS `propel_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propel_migration` (
  `version` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propel_migration`
--

LOCK TABLES `propel_migration` WRITE;
/*!40000 ALTER TABLE `propel_migration` DISABLE KEYS */;
INSERT INTO `propel_migration` VALUES (1449107948),(1449108156);
/*!40000 ALTER TABLE `propel_migration` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-09  4:21:22
