/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.11-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: xtremecrm_chat
-- ------------------------------------------------------
-- Server version	10.11.11-MariaDB-0ubuntu0.24.04.2

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
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `author` varchar(100) DEFAULT 'XtremeCRM Team',
  `author_image_url` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `featured_image_url` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `published_at` datetime DEFAULT current_timestamp(),
  `is_published` tinyint(1) DEFAULT 1,
  `view_count` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES
(1,'Welcome to the XtremeCRM Blog','welcome-to-the-xtremecrm-blog','An introduction to our new blog where we share CRM tips, product updates, and automation strategies.','<p>This is the first official blog post for XtremeCRM. We’ll use this space to keep you informed about new features, upcoming integrations, and best practices for getting the most out of your CRM.</p><p>Stay tuned!</p>','Cari Valentine, Data Access Inc','/assets/images/cari_288.png','Announcements','welcome,introduction,crm',NULL,'Announcing the launch of the XtremeCRM blog: tips, updates, and more.','2025-05-16 16:56:00',1,0);
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_status`
--

DROP TABLE IF EXISTS `chat_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_status` (
  `session_id` varchar(255) NOT NULL,
  `typing` tinyint(1) DEFAULT 0,
  `typing_expires` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_status`
--

LOCK TABLES `chat_status` WRITE;
/*!40000 ALTER TABLE `chat_status` DISABLE KEYS */;
INSERT INTO `chat_status` VALUES
('10a5b0d407a3712cf987d2de2108bbe7',0,NULL,'2025-05-18 16:51:24'),
('68b944565cc3e0bab73a618ec67d8a60',0,NULL,'2025-05-18 16:49:41'),
('8f5f28bd52a29925ce6c2dcd3a637a84',0,NULL,'2025-05-19 18:05:24'),
('dad13acdadb6011d59a30d6b595788fc',1,'2025-05-15 17:58:48','2025-05-15 17:58:43');
/*!40000 ALTER TABLE `chat_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `sender` enum('user','admin') NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES
(1,'10a5b0d407a3712cf987d2de2108bbe7','user','Hey!','2025-05-15 16:20:50'),
(2,'10a5b0d407a3712cf987d2de2108bbe7','user','Wow!','2025-05-15 16:20:57'),
(3,'10a5b0d407a3712cf987d2de2108bbe7','user','Crazy!','2025-05-15 16:21:01'),
(4,'10a5b0d407a3712cf987d2de2108bbe7','user','Wot?','2025-05-15 16:21:14'),
(5,'10a5b0d407a3712cf987d2de2108bbe7','user','Dude!','2025-05-15 16:21:17'),
(6,'10a5b0d407a3712cf987d2de2108bbe7','user','Yo!','2025-05-15 16:21:20'),
(7,'10a5b0d407a3712cf987d2de2108bbe7','user','Ouch!','2025-05-15 16:21:24'),
(8,'10a5b0d407a3712cf987d2de2108bbe7','user','i see the time stamps now','2025-05-15 16:26:39'),
(9,'10a5b0d407a3712cf987d2de2108bbe7','user','woser','2025-05-15 16:32:47'),
(10,'10a5b0d407a3712cf987d2de2108bbe7','user','sfaqfge','2025-05-15 16:33:02'),
(11,'10a5b0d407a3712cf987d2de2108bbe7','user','Hello again!','2025-05-15 16:35:53'),
(12,'10a5b0d407a3712cf987d2de2108bbe7','user','dgdabababdagadbab','2025-05-15 16:41:59'),
(13,'10a5b0d407a3712cf987d2de2108bbe7','user','1','2025-05-15 16:45:59'),
(14,'10a5b0d407a3712cf987d2de2108bbe7','user','2','2025-05-15 16:45:59'),
(15,'10a5b0d407a3712cf987d2de2108bbe7','user','3','2025-05-15 16:46:00'),
(16,'10a5b0d407a3712cf987d2de2108bbe7','user','4','2025-05-15 16:46:01'),
(17,'10a5b0d407a3712cf987d2de2108bbe7','user','5','2025-05-15 16:46:01'),
(18,'10a5b0d407a3712cf987d2de2108bbe7','user','6','2025-05-15 16:46:02'),
(19,'10a5b0d407a3712cf987d2de2108bbe7','user','7','2025-05-15 16:46:02'),
(20,'10a5b0d407a3712cf987d2de2108bbe7','user','8','2025-05-15 16:46:02'),
(21,'10a5b0d407a3712cf987d2de2108bbe7','user','9','2025-05-15 16:46:03'),
(22,'10a5b0d407a3712cf987d2de2108bbe7','user','10','2025-05-15 16:46:05'),
(23,'10a5b0d407a3712cf987d2de2108bbe7','user','11','2025-05-15 16:46:05'),
(24,'10a5b0d407a3712cf987d2de2108bbe7','user','12','2025-05-15 16:46:06'),
(25,'10a5b0d407a3712cf987d2de2108bbe7','user','13','2025-05-15 16:46:06'),
(26,'10a5b0d407a3712cf987d2de2108bbe7','user','14','2025-05-15 16:46:08'),
(27,'10a5b0d407a3712cf987d2de2108bbe7','user','15','2025-05-15 16:46:08'),
(28,'10a5b0d407a3712cf987d2de2108bbe7','user','16','2025-05-15 16:46:09'),
(29,'10a5b0d407a3712cf987d2de2108bbe7','user','17','2025-05-15 16:46:10'),
(30,'10a5b0d407a3712cf987d2de2108bbe7','user','18','2025-05-15 16:46:11'),
(31,'10a5b0d407a3712cf987d2de2108bbe7','user','19','2025-05-15 16:46:12'),
(32,'10a5b0d407a3712cf987d2de2108bbe7','user','20','2025-05-15 16:46:15'),
(33,'10a5b0d407a3712cf987d2de2108bbe7','user','122122','2025-05-15 16:49:42'),
(34,'10a5b0d407a3712cf987d2de2108bbe7','user','211212','2025-05-15 16:49:43'),
(35,'10a5b0d407a3712cf987d2de2108bbe7','user','21','2025-05-15 16:49:43'),
(36,'10a5b0d407a3712cf987d2de2108bbe7','user','31','2025-05-15 16:49:43'),
(37,'10a5b0d407a3712cf987d2de2108bbe7','user','1','2025-05-15 16:49:44'),
(38,'10a5b0d407a3712cf987d2de2108bbe7','user','35','2025-05-15 16:49:44'),
(39,'10a5b0d407a3712cf987d2de2108bbe7','user','15','2025-05-15 16:49:44'),
(40,'10a5b0d407a3712cf987d2de2108bbe7','user','wer3rh','2025-05-15 16:49:45'),
(41,'10a5b0d407a3712cf987d2de2108bbe7','user','3h','2025-05-15 16:49:45'),
(42,'10a5b0d407a3712cf987d2de2108bbe7','user','h','2025-05-15 16:49:45'),
(43,'10a5b0d407a3712cf987d2de2108bbe7','user','3','2025-05-15 16:49:46'),
(44,'10a5b0d407a3712cf987d2de2108bbe7','user','rh3','2025-05-15 16:49:46'),
(45,'10a5b0d407a3712cf987d2de2108bbe7','user','rhrh3r','2025-05-15 16:49:46'),
(46,'10a5b0d407a3712cf987d2de2108bbe7','user','rh','2025-05-15 16:49:47'),
(47,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh3r','2025-05-15 16:49:47'),
(48,'10a5b0d407a3712cf987d2de2108bbe7','user','h3','2025-05-15 16:49:47'),
(49,'10a5b0d407a3712cf987d2de2108bbe7','user','rh','2025-05-15 16:49:47'),
(50,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:48'),
(51,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:48'),
(52,'10a5b0d407a3712cf987d2de2108bbe7','user','3','2025-05-15 16:49:48'),
(53,'10a5b0d407a3712cf987d2de2108bbe7','user','h','2025-05-15 16:49:48'),
(54,'10a5b0d407a3712cf987d2de2108bbe7','user','3h','2025-05-15 16:49:48'),
(55,'10a5b0d407a3712cf987d2de2108bbe7','user','r3h','2025-05-15 16:49:49'),
(56,'10a5b0d407a3712cf987d2de2108bbe7','user','3','2025-05-15 16:49:49'),
(57,'10a5b0d407a3712cf987d2de2108bbe7','user','h','2025-05-15 16:49:49'),
(58,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:49'),
(59,'10a5b0d407a3712cf987d2de2108bbe7','user','3','2025-05-15 16:49:49'),
(60,'10a5b0d407a3712cf987d2de2108bbe7','user','rh','2025-05-15 16:49:50'),
(61,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:50'),
(62,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:50'),
(63,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:50'),
(64,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:51'),
(65,'10a5b0d407a3712cf987d2de2108bbe7','user','3','2025-05-15 16:49:51'),
(66,'10a5b0d407a3712cf987d2de2108bbe7','user','rh','2025-05-15 16:49:51'),
(67,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:51'),
(68,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:51'),
(69,'10a5b0d407a3712cf987d2de2108bbe7','user','3r','2025-05-15 16:49:52'),
(70,'10a5b0d407a3712cf987d2de2108bbe7','user','h','2025-05-15 16:49:52'),
(71,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:52'),
(72,'10a5b0d407a3712cf987d2de2108bbe7','user','3rh','2025-05-15 16:49:52'),
(73,'10a5b0d407a3712cf987d2de2108bbe7','user','etrw','2025-05-15 16:49:53'),
(74,'10a5b0d407a3712cf987d2de2108bbe7','user','er','2025-05-15 16:49:53'),
(75,'10a5b0d407a3712cf987d2de2108bbe7','user','tw','2025-05-15 16:49:53'),
(76,'10a5b0d407a3712cf987d2de2108bbe7','user','j','2025-05-15 16:49:53'),
(77,'10a5b0d407a3712cf987d2de2108bbe7','user','wet','2025-05-15 16:49:54'),
(78,'10a5b0d407a3712cf987d2de2108bbe7','user','j','2025-05-15 16:49:54'),
(79,'10a5b0d407a3712cf987d2de2108bbe7','user','tj','2025-05-15 16:49:54'),
(80,'10a5b0d407a3712cf987d2de2108bbe7','user','wtj','2025-05-15 16:49:55'),
(81,'10a5b0d407a3712cf987d2de2108bbe7','user','f','2025-05-15 16:50:16'),
(82,'10a5b0d407a3712cf987d2de2108bbe7','user','gggggggggg','2025-05-15 17:04:28'),
(83,'10a5b0d407a3712cf987d2de2108bbe7','user','hahah','2025-05-15 17:12:23'),
(84,'10a5b0d407a3712cf987d2de2108bbe7','user','fwawfggweq','2025-05-15 17:14:31'),
(85,'10a5b0d407a3712cf987d2de2108bbe7','user','fgagadahadnnnnnnnfnsfnsfnsfnsnnsnsns','2025-05-15 17:15:07'),
(86,'10a5b0d407a3712cf987d2de2108bbe7','user','aeahaheaehaehahahah','2025-05-15 17:18:21'),
(87,'10a5b0d407a3712cf987d2de2108bbe7','admin','hey there','2025-05-15 17:32:05'),
(88,'10a5b0d407a3712cf987d2de2108bbe7','admin','is the admin typing?','2025-05-15 17:35:48'),
(89,'10a5b0d407a3712cf987d2de2108bbe7','user','v','2025-05-15 17:37:35'),
(90,'10a5b0d407a3712cf987d2de2108bbe7','user','welp...','2025-05-15 17:50:01'),
(91,'10a5b0d407a3712cf987d2de2108bbe7','admin','adadadvdav','2025-05-15 17:52:57'),
(92,'10a5b0d407a3712cf987d2de2108bbe7','user','asvassavsvasvasvasvasvsv','2025-05-15 17:53:09'),
(93,'10a5b0d407a3712cf987d2de2108bbe7','user','a','2025-05-15 17:53:20'),
(94,'dad13acdadb6011d59a30d6b595788fc','user','Hello there!','2025-05-15 17:57:33'),
(95,'dad13acdadb6011d59a30d6b595788fc','admin','well hello!','2025-05-15 17:57:54'),
(96,'10a5b0d407a3712cf987d2de2108bbe7','user','sdsds','2025-05-15 18:25:33'),
(97,'10a5b0d407a3712cf987d2de2108bbe7','user','we','2025-05-15 18:26:34'),
(98,'10a5b0d407a3712cf987d2de2108bbe7','user','hello','2025-05-15 18:29:35'),
(99,'10a5b0d407a3712cf987d2de2108bbe7','user','scfvb','2025-05-15 18:43:19'),
(100,'10a5b0d407a3712cf987d2de2108bbe7','user','cscs','2025-05-15 18:46:59'),
(101,'10a5b0d407a3712cf987d2de2108bbe7','user','afb','2025-05-15 18:52:41'),
(102,'10a5b0d407a3712cf987d2de2108bbe7','user','adba na n','2025-05-15 18:52:45'),
(103,'10a5b0d407a3712cf987d2de2108bbe7','user','sfsns','2025-05-15 18:54:42'),
(104,'10a5b0d407a3712cf987d2de2108bbe7','user','sfnssn','2025-05-15 18:54:46'),
(105,'10a5b0d407a3712cf987d2de2108bbe7','user','sfn','2025-05-15 18:54:48'),
(106,'10a5b0d407a3712cf987d2de2108bbe7','user','s','2025-05-15 18:54:49'),
(107,'10a5b0d407a3712cf987d2de2108bbe7','user','3yq3','2025-05-15 18:54:52'),
(108,'10a5b0d407a3712cf987d2de2108bbe7','user','svv','2025-05-15 18:56:13'),
(109,'10a5b0d407a3712cf987d2de2108bbe7','user','ss','2025-05-15 18:56:16'),
(110,'10a5b0d407a3712cf987d2de2108bbe7','user','hey','2025-05-18 13:35:40'),
(111,'10a5b0d407a3712cf987d2de2108bbe7','user','hi','2025-05-18 14:32:09'),
(112,'10a5b0d407a3712cf987d2de2108bbe7','user','aasbasbadbadbadbdbabad','2025-05-18 14:55:23'),
(113,'10a5b0d407a3712cf987d2de2108bbe7','user','dfnsdn f nf w','2025-05-18 15:26:20'),
(114,'10a5b0d407a3712cf987d2de2108bbe7','admin','hey','2025-05-18 15:39:20'),
(115,'10a5b0d407a3712cf987d2de2108bbe7','user','hey how aso daosdasswdasdsadassb sb sdsdbsdbsdbsdbsdbsdbsdbsdbsdbddasdasdas','2025-05-18 15:39:29'),
(116,'10a5b0d407a3712cf987d2de2108bbe7','user','sdsdgsdgdgsdgsdgsdggsdgsdgsdgsdgsdg','2025-05-18 15:51:32'),
(117,'10a5b0d407a3712cf987d2de2108bbe7','user','akjbsfkjbaslfbaslknaf','2025-05-18 15:53:13'),
(118,'10a5b0d407a3712cf987d2de2108bbe7','user','vavavavavavava','2025-05-18 15:53:35'),
(119,'10a5b0d407a3712cf987d2de2108bbe7','user','fgn','2025-05-18 15:53:49'),
(120,'10a5b0d407a3712cf987d2de2108bbe7','user','aetnaet','2025-05-18 15:53:50'),
(121,'10a5b0d407a3712cf987d2de2108bbe7','user','hello','2025-05-18 16:00:13'),
(122,'10a5b0d407a3712cf987d2de2108bbe7','user','kbkjbjbkjbkjbkjbkjbkjbk','2025-05-18 16:00:32'),
(123,'10a5b0d407a3712cf987d2de2108bbe7','user','kjbkjb','2025-05-18 16:00:37'),
(124,'10a5b0d407a3712cf987d2de2108bbe7','user','wahat?','2025-05-18 16:06:11'),
(125,'10a5b0d407a3712cf987d2de2108bbe7','admin','hey there','2025-05-18 16:06:35'),
(126,'10a5b0d407a3712cf987d2de2108bbe7','admin','hi','2025-05-18 16:06:42'),
(127,'10a5b0d407a3712cf987d2de2108bbe7','user','hello','2025-05-18 16:08:33'),
(128,'10a5b0d407a3712cf987d2de2108bbe7','user','tukl','2025-05-18 16:08:51'),
(129,'10a5b0d407a3712cf987d2de2108bbe7','user','guktgult','2025-05-18 16:08:53'),
(130,'10a5b0d407a3712cf987d2de2108bbe7','user','word up holmes','2025-05-18 16:10:45'),
(131,'10a5b0d407a3712cf987d2de2108bbe7','user','new message','2025-05-18 16:10:54'),
(132,'10a5b0d407a3712cf987d2de2108bbe7','user','another','2025-05-18 16:10:57'),
(133,'68b944565cc3e0bab73a618ec67d8a60','user','howdy partner','2025-05-18 16:11:24'),
(134,'68b944565cc3e0bab73a618ec67d8a60','user','what if i type somethign here','2025-05-18 16:11:42'),
(135,'10a5b0d407a3712cf987d2de2108bbe7','user','???','2025-05-18 16:21:30'),
(136,'10a5b0d407a3712cf987d2de2108bbe7','user','wrhwh','2025-05-18 16:21:51'),
(137,'10a5b0d407a3712cf987d2de2108bbe7','user','rhhw','2025-05-18 16:21:58'),
(138,'10a5b0d407a3712cf987d2de2108bbe7','user','wegweg','2025-05-18 16:22:01'),
(139,'10a5b0d407a3712cf987d2de2108bbe7','user','wrhwrwrh','2025-05-18 16:22:23'),
(140,'10a5b0d407a3712cf987d2de2108bbe7','user','hello!','2025-05-18 16:24:49'),
(141,'10a5b0d407a3712cf987d2de2108bbe7','user','hey there','2025-05-18 16:24:59'),
(142,'10a5b0d407a3712cf987d2de2108bbe7','user','another','2025-05-18 16:25:50'),
(143,'10a5b0d407a3712cf987d2de2108bbe7','user','Good afternoon!','2025-05-18 16:29:16'),
(144,'10a5b0d407a3712cf987d2de2108bbe7','user','hey','2025-05-18 16:29:36'),
(145,'68b944565cc3e0bab73a618ec67d8a60','user','what?','2025-05-18 16:29:55'),
(146,'68b944565cc3e0bab73a618ec67d8a60','user','a','2025-05-18 16:30:07'),
(147,'68b944565cc3e0bab73a618ec67d8a60','user','b','2025-05-18 16:30:07'),
(148,'68b944565cc3e0bab73a618ec67d8a60','user','c','2025-05-18 16:30:08'),
(149,'68b944565cc3e0bab73a618ec67d8a60','user','d','2025-05-18 16:30:08'),
(150,'68b944565cc3e0bab73a618ec67d8a60','user','e','2025-05-18 16:30:09'),
(151,'68b944565cc3e0bab73a618ec67d8a60','user','f','2025-05-18 16:30:09'),
(152,'68b944565cc3e0bab73a618ec67d8a60','user','g','2025-05-18 16:30:09'),
(153,'68b944565cc3e0bab73a618ec67d8a60','user','h','2025-05-18 16:30:10'),
(154,'68b944565cc3e0bab73a618ec67d8a60','user','i','2025-05-18 16:30:10'),
(155,'68b944565cc3e0bab73a618ec67d8a60','user','j','2025-05-18 16:30:11'),
(156,'68b944565cc3e0bab73a618ec67d8a60','user','k','2025-05-18 16:30:12'),
(157,'68b944565cc3e0bab73a618ec67d8a60','user','l','2025-05-18 16:30:15'),
(158,'68b944565cc3e0bab73a618ec67d8a60','user','m','2025-05-18 16:30:15'),
(159,'68b944565cc3e0bab73a618ec67d8a60','user','n','2025-05-18 16:30:16'),
(160,'68b944565cc3e0bab73a618ec67d8a60','user','o','2025-05-18 16:30:16'),
(161,'68b944565cc3e0bab73a618ec67d8a60','user','p','2025-05-18 16:30:17'),
(162,'68b944565cc3e0bab73a618ec67d8a60','user','q','2025-05-18 16:30:18'),
(163,'68b944565cc3e0bab73a618ec67d8a60','user','r','2025-05-18 16:30:18'),
(164,'68b944565cc3e0bab73a618ec67d8a60','user','s','2025-05-18 16:30:18'),
(165,'68b944565cc3e0bab73a618ec67d8a60','user','t','2025-05-18 16:30:19'),
(166,'68b944565cc3e0bab73a618ec67d8a60','user','u','2025-05-18 16:30:19'),
(167,'68b944565cc3e0bab73a618ec67d8a60','user','v','2025-05-18 16:30:20'),
(168,'68b944565cc3e0bab73a618ec67d8a60','user','w','2025-05-18 16:30:20'),
(169,'68b944565cc3e0bab73a618ec67d8a60','user','x','2025-05-18 16:30:21'),
(170,'68b944565cc3e0bab73a618ec67d8a60','user','y','2025-05-18 16:30:22'),
(171,'68b944565cc3e0bab73a618ec67d8a60','user','z','2025-05-18 16:30:25'),
(172,'10a5b0d407a3712cf987d2de2108bbe7','user','another message','2025-05-18 16:30:40'),
(173,'10a5b0d407a3712cf987d2de2108bbe7','user','or two','2025-05-18 16:30:42'),
(174,'10a5b0d407a3712cf987d2de2108bbe7','user','or three','2025-05-18 16:30:46'),
(175,'10a5b0d407a3712cf987d2de2108bbe7','user','hi','2025-05-18 16:42:15'),
(176,'68b944565cc3e0bab73a618ec67d8a60','user','df','2025-05-18 16:43:00'),
(177,'68b944565cc3e0bab73a618ec67d8a60','user','df','2025-05-18 16:43:03'),
(178,'68b944565cc3e0bab73a618ec67d8a60','user','df','2025-05-18 16:43:26'),
(179,'10a5b0d407a3712cf987d2de2108bbe7','user','dfdf','2025-05-18 16:43:43'),
(180,'10a5b0d407a3712cf987d2de2108bbe7','user','df','2025-05-18 16:43:47'),
(181,'10a5b0d407a3712cf987d2de2108bbe7','user','afa','2025-05-18 16:49:02'),
(182,'68b944565cc3e0bab73a618ec67d8a60','user','glarby','2025-05-18 16:49:41'),
(183,'10a5b0d407a3712cf987d2de2108bbe7','user','sdsd','2025-05-18 16:51:24'),
(184,'8f5f28bd52a29925ce6c2dcd3a637a84','user','Hello','2025-05-19 18:05:24'),
(185,'8f5f28bd52a29925ce6c2dcd3a637a84','admin','How can I help you today?','2025-05-19 18:06:46');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `session_id` varchar(64) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last_time` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('8f5f28bd52a29925ce6c2dcd3a637a84','Brandon','2025-05-19 18:05:24','2025-05-19 18:05:24');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-19 18:18:50
