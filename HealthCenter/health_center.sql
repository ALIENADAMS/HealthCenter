-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: health_center
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `deseases`
--

DROP TABLE IF EXISTS `deseases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deseases` (
  `username` varchar(20) NOT NULL,
  `desease` varchar(50) NOT NULL,
  `diagnosis_date` date DEFAULT NULL,
  `diagnosis_making` varchar(50) DEFAULT NULL,
  `diagnosis_document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deseases`
--

LOCK TABLES `deseases` WRITE;
/*!40000 ALTER TABLE `deseases` DISABLE KEYS */;
INSERT INTO `deseases` VALUES ('ALIENADAMS','Bradykardia','1991-04-28','Danuta Balicka','Skan_20230809.jpg'),('ALIENADAMS','Polip dwunastnicy','2010-11-26','Abdulaziz Ahmad','Polip.jpg'),('ALIENADAMS','Wrzód żołądka z krwotokiem','2013-12-04','Andrzej Supron','Skan_20230809.jpg');
/*!40000 ALTER TABLE `deseases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctors` (
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `desease` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES ('Andrzej','Supron','Wrzód żołądka z krwotokiem','ALIENADAMS'),('Danuta','Balicka','Bradykardia','ALIENADAMS'),('Abdulaziz','Ahmad','Polip dwunastnicy','ALIENADAMS');
/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hemoglobin`
--

DROP TABLE IF EXISTS `hemoglobin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hemoglobin` (
  `username` varchar(20) DEFAULT NULL,
  `test_result` tinyint(4) DEFAULT NULL,
  `test_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hemoglobin`
--

LOCK TABLES `hemoglobin` WRITE;
/*!40000 ALTER TABLE `hemoglobin` DISABLE KEYS */;
INSERT INTO `hemoglobin` VALUES ('ALIENADAMS',10,'2023-08-01'),('ALIENADAMS',10,'2023-08-02'),('ALIENADAMS',11,'2023-08-03'),('ALIENADAMS',11,'2023-08-04'),('ALIENADAMS',11,'2023-08-05'),('ALIENADAMS',10,'2023-08-06'),('ALIENADAMS',10,'2023-08-07'),('ALIENADAMS',12,'2023-08-08'),('ALIENADAMS',11,'2023-08-09'),('ALIENADAMS',11,'2023-08-10');
/*!40000 ALTER TABLE `hemoglobin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_users`
--

DROP TABLE IF EXISTS `login_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_users` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_users`
--

LOCK TABLES `login_users` WRITE;
/*!40000 ALTER TABLE `login_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicines`
--

DROP TABLE IF EXISTS `medicines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicines` (
  `username` varchar(20) DEFAULT NULL,
  `medicine` varchar(20) DEFAULT NULL,
  `dose` char(10) DEFAULT NULL,
  `hour` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicines`
--

LOCK TABLES `medicines` WRITE;
/*!40000 ALTER TABLE `medicines` DISABLE KEYS */;
INSERT INTO `medicines` VALUES ('ALIENADAMS','Pantoprazol','40mg','08:00:00'),('ALIENADAMS','Pantoprazol','40mg','19:00:00'),('ALIENADAMS','Amantix','100mg','16:00:00');
/*!40000 ALTER TABLE `medicines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_data`
--

DROP TABLE IF EXISTS `personal_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_data` (
  `username` varchar(20) NOT NULL,
  `first_name` char(50) DEFAULT NULL,
  `last_name` char(50) DEFAULT NULL,
  `street` char(50) DEFAULT NULL,
  `home_number` char(20) DEFAULT NULL,
  `postal_code` char(6) DEFAULT NULL,
  `city` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_data`
--

LOCK TABLES `personal_data` WRITE;
/*!40000 ALTER TABLE `personal_data` DISABLE KEYS */;
INSERT INTO `personal_data` VALUES ('ALIENADAMS','Łukasz','Adamski','Nadjeziorna','4/2','14-220','Kisielice'),('Pasjonistka',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `personal_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `username` varchar(20) DEFAULT NULL,
  `test_name` varchar(50) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `reference_value_min` float DEFAULT NULL,
  `reference_value_max` float DEFAULT NULL,
  `test_value` float DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES ('ALIENADAMS','Hemoglobina','2023-08-12',12,18,10,2),('ALIENADAMS','Cukier','2023-08-12',70,99,90,3);
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treatment_process`
--

DROP TABLE IF EXISTS `treatment_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `treatment_process` (
  `username` varchar(20) NOT NULL,
  `desease` varchar(50) NOT NULL,
  `incident` varchar(50) DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `prescribed_medications` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatment_process`
--

LOCK TABLES `treatment_process` WRITE;
/*!40000 ALTER TABLE `treatment_process` DISABLE KEYS */;
INSERT INTO `treatment_process` VALUES ('ALIENADAMS','Niedrożność dwunastnicy','Trzustka obrączkowata','0000-00-00','-');
/*!40000 ALTER TABLE `treatment_process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `email_addr` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ALIENADAMS','22727d2fb1eeea2892a289ede8ff9fab40dfbd89','lukasz.roman.adamski@gmail.com',1),(2,'Pasjonistka','def75949ebc194cb8e2f2921f383c5fa9346fdb3','karolina.mordak@op.pl',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `username` varchar(20) DEFAULT NULL,
  `doctor_first_name` varchar(20) DEFAULT NULL,
  `doctor_last_name` varchar(20) DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `visit_hour` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
INSERT INTO `visits` VALUES ('ALIENADAMS','Jacek','Drzewiecki','2023-08-16','10:00:00'),('ALIENADAMS','Agnieszka','Bielawska','2023-08-17','12:00:00');
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-16 15:49:23
