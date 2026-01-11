-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: tdw
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diaporama`
--

DROP TABLE IF EXISTS `diaporama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diaporama` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diaporama`
--

LOCK TABLES `diaporama` WRITE;
/*!40000 ALTER TABLE `diaporama` DISABLE KEYS */;
INSERT INTO `diaporama` VALUES (1,'Slide 1','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','public/assets/img.png'),(2,'slide 2','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','public/assets/img.png'),(3,'slide 3','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','public/assets/img.png'),(6,'Slide 6','whatever','public/assets/694ef7bb41c5d_distribution.png');
/*!40000 ALTER TABLE `diaporama` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'libre',
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--

LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
INSERT INTO `equipment` VALUES (1,'Server','serveur','High-precision optical microscope','reserve',4,'2025-12-13 15:39:33'),(2,'salle 31','salle','For separating samples','libre',1,'2025-12-13 15:39:33'),(3,'Chemistry Kit','Supplies','Basic chemicals and glassware','libre',3,'2025-12-13 15:39:33'),(4,'3D Printer','imprimante','For prototyping models','en-maintenance',3,'2025-12-13 15:39:33'),(6,'Salle 21','Salle','salle de td','reserve',0,'2025-12-27 13:51:43');
/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `event_date` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `registerOpen` tinyint(1) DEFAULT NULL,
  `isExtern` tinyint(1) DEFAULT NULL,
  `register_link` varchar(255) DEFAULT NULL,
  `agenda_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Event 1','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','','2025-12-02','public/assets/img.jpg',NULL,'2025-12-06 11:45:34',0,0,NULL,NULL),(2,'Event 2','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','','2025-12-31','public/assets/img.png',NULL,'2025-12-06 11:45:34',1,0,NULL,NULL),(3,'Event 3','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','','2016-12-06','public/assets/img.png',NULL,'2025-12-06 11:45:34',1,1,NULL,NULL),(4,'Event 4','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','','0000-00-00','public/assets/img.png',NULL,'2025-12-06 11:45:34',1,0,NULL,NULL),(5,'Event 5','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','','0000-00-00','public/assets/img.png',NULL,'2025-12-06 11:45:34',NULL,0,NULL,NULL),(39,'Conference AI','kjdbjsfkjgfkudry','conférence','2026-01-12','','Sid Ahmed Sarah','2026-01-11 12:30:21',NULL,0,NULL,'https://www.google.com/calendar/event?eid=NWM2b2hpY21xaTEyMmNiOWs5dXVmdmRlZjggYzMxMWNlM2EyNjYxMjhkODdiY2FmNzRmNzc5YTliMTU4ZTE0YmMwNGMzMTIyZDI2ZjlmYjI2YWZhYmFmM2IxOEBn');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Projet 2','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l\'innovation scientifique et technologique.','public/assets/img.png','2025-12-06 08:35:29'),(3,'Projet 4','dkjfjsguwegfkejfgkuerqy','public/assets/694ee9b36d8c1_correlation.png','2025-12-26 20:45:18');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opportunities`
--

DROP TABLE IF EXISTS `opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opportunities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `requirements` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opportunities`
--

LOCK TABLES `opportunities` WRITE;
/*!40000 ALTER TABLE `opportunities` DISABLE KEYS */;
INSERT INTO `opportunities` VALUES (2,'Mémoire de Master en Énergies Renouvelables','Travaillez sur un mémoire de master portant sur l\'optimisation de l\'énergie solaire.','Thèse','Étudiant en Master Génie Énergétique ou Physique','2026-03-15','energie-dept@example.com','ouvert','2026-01-11 13:03:51'),(3,'Bourse Internationale en Data Science','Bourse entièrement financée pour les étudiants poursuivant un Master en Data Science à l\'étranger.','Bourse','Moyenne > 15/20, compétences solides en programmation','2026-04-01','bourses@example.com','ouvert','2026-01-11 13:03:51'),(4,'Projet Collaboratif : Robotique','Participez à un projet collaboratif en robotique avec notre université partenaire.','Collaboration','Intérêt pour la robotique, esprit d\'équipe','2026-03-31','robotique-team@example.com','ouvert','2026-01-11 13:03:51'),(5,'Stage d\'été : Développement Web','Stage de 3 mois pour développer des applications web pour notre entreprise.','Stage','HTML, CSS, JavaScript, Git','2026-05-15','webdev@example.com','ouvert','2026-01-11 13:03:51'),(6,'Bourse Doctorale en Cybersécurité','Bourse doctorale destinée aux étudiants souhaitant mener une recherche en cybersécurité et protection des données.','bourse','Master en informatique ou réseaux, bases en sécurité informatique','2026-01-13','cybersecurity.lab@example.com','ferme','2026-01-11 15:52:06');
/*!40000 ALTER TABLE `opportunities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'Esi','Universite','public/assets/esi.png','Prestigieuse institution académique reconnue pour son excellence dans la recherche scientifique et l\'innovation technologique','2025-12-06 17:56:18'),(2,'Esi','Universite','public/assets/esi.png','Prestigieuse institution académique reconnue pour son excellence dans la recherche scientifique et l\'innovation technologique','2025-12-06 17:56:18'),(3,'Esi','Universite','public/assets/esi.png','Prestigieuse institution académique reconnue pour son excellence dans la recherche scientifique et l\'innovation technologique','2025-12-06 17:56:18'),(4,'Esi','Universite','public/assets/esi.png','Prestigieuse institution académique reconnue pour son excellence dans la recherche scientifique et l\'innovation technologique','2025-12-06 17:56:18'),(10,'TechFlow Algeria','Startup','public/assets/partners/694d20424180c_correlation.png','whatever it is','2025-12-25 11:30:10');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_user` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `fk_permission_user_permission` (`permission_id`),
  CONSTRAINT `fk_permission_user_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_permission_user_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `permission_user_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
INSERT INTO `permission_user` VALUES (29,1),(29,2),(33,1),(33,2),(33,3),(33,4),(33,5),(33,6),(33,7),(33,8),(33,9),(33,10),(33,11),(33,12),(33,13),(33,14),(33,15),(33,16),(33,17),(33,18),(33,19),(33,20),(33,21),(33,22),(33,23),(33,24),(33,25),(33,26),(33,27),(33,28),(33,29),(33,30),(33,31),(33,32),(33,33),(33,34),(33,35),(33,36),(33,37),(33,38),(33,39),(33,40),(33,41),(33,42),(33,43),(33,44),(33,45),(34,14),(34,17),(34,18),(34,22);
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'create_user'),(2,'read_user'),(3,'update_user'),(4,'delete_user'),(5,'create_team'),(6,'read_team'),(7,'update_team'),(8,'delete_team'),(9,'create_event'),(10,'read_event'),(11,'update_event'),(12,'delete_event'),(13,'create_project'),(14,'read_project'),(15,'update_project'),(16,'delete_project'),(17,'create_publication'),(18,'read_publication'),(19,'update_publication'),(20,'delete_publication'),(21,'create_equipment'),(22,'read_equipment'),(23,'update_equipment'),(24,'delete_equipment'),(25,'read_settings'),(26,'update_settings'),(27,'read_news'),(28,'create_news'),(29,'update_news'),(30,'delete_news'),(31,'read_slideshow'),(32,'create_slideshow'),(33,'update_slideshow'),(34,'delete_slideshow'),(35,'read_offre'),(36,'create_offre'),(37,'update_offre'),(38,'delete_offre'),(39,'read_role'),(40,'delete_role'),(41,'create_role'),(42,'create_partner'),(43,'update_partner'),(44,'delete_partner'),(45,'read_partner');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_members`
--

DROP TABLE IF EXISTS `project_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_members_user` (`member_id`),
  KEY `fk_project_members_project` (`project_id`),
  CONSTRAINT `fk_project_members_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_members_user` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_members_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `project_members_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_members`
--

LOCK TABLES `project_members` WRITE;
/*!40000 ALTER TABLE `project_members` DISABLE KEYS */;
INSERT INTO `project_members` VALUES (12,1,34),(15,2,11),(17,1,11);
/*!40000 ALTER TABLE `project_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_partners`
--

DROP TABLE IF EXISTS `project_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_partners` (
  `id_project` int(11) NOT NULL,
  `id_part` int(11) NOT NULL,
  PRIMARY KEY (`id_project`,`id_part`),
  KEY `fk_project_partners_partner` (`id_part`),
  CONSTRAINT `fk_project_partners_partner` FOREIGN KEY (`id_part`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_partners_project` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_partners_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id`),
  CONSTRAINT `project_partners_ibfk_2` FOREIGN KEY (`id_part`) REFERENCES `partners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_partners`
--

LOCK TABLES `project_partners` WRITE;
/*!40000 ALTER TABLE `project_partners` DISABLE KEYS */;
INSERT INTO `project_partners` VALUES (3,2),(3,3);
/*!40000 ALTER TABLE `project_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `theme` varchar(20) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `funding_type` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'en-cours',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_supervisor` (`supervisor_id`),
  CONSTRAINT `fk_project_supervisor` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'AI project','Le laboratoire [Nom du laboratoire] est un centre de recherche dédié à l','AI',33,'whatever','soumis','2023-01-16','2025-12-15','2025-12-07 13:29:26','public/assets/img.png'),(2,'projet 2','whatever','AI',29,'','termine','2023-01-15','2023-01-20','2025-12-12 09:46:58','public/assets/img.jpg'),(3,'AI Research Platform','A platform to centralize AI research projects in Algeria, allowing collaboration, tracking progress, and sharing resources among researchers.','Software',11,'','termine','2024-01-15','2025-12-15','2025-12-12 13:25:50','public/assets/img.jpg');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publication_authors`
--

DROP TABLE IF EXISTS `publication_authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publication_authors` (
  `publication_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`publication_id`,`user_id`),
  KEY `fk_publication_authors_user` (`user_id`),
  CONSTRAINT `fk_publication_authors_publication` FOREIGN KEY (`publication_id`) REFERENCES `publications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_publication_authors_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `publication_authors_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publications` (`id`),
  CONSTRAINT `publication_authors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publication_authors`
--

LOCK TABLES `publication_authors` WRITE;
/*!40000 ALTER TABLE `publication_authors` DISABLE KEYS */;
INSERT INTO `publication_authors` VALUES (1,29),(1,34),(2,34),(11,34);
/*!40000 ALTER TABLE `publication_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `abstract` text DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `publication_date` date DEFAULT NULL,
  `doi` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `domain` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'non-valide',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_publication_project` (`project_id`),
  CONSTRAINT `fk_publication_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL,
  CONSTRAINT `publications_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publications`
--

LOCK TABLES `publications` WRITE;
/*!40000 ALTER TABLE `publications` DISABLE KEYS */;
INSERT INTO `publications` VALUES (1,'AI in Healthcare','whatever, whatever\r\n','Journal','2025-01-10','10.1000/aihealth.2025','https://docs.google.com/document/d/1HrIEeXIqwSKKwWg8q_Tdh8oniyIP8ubH8hw1NFpwHjw/edit?tab=t.0',1,'Artificial Intellige','valide','2025-12-13 10:46:15'),(2,'Quantum Computing Basics','Introduction to quantum computing concepts.\r\nIntroduction to quantum computing concepts.','article','2025-03-22','10.1000/qcbasics.2025','/files/quantum_computing.pdf',1,'Quantum Computing','valide','2025-12-13 10:46:15'),(3,'Sustainable Energy Solutions','Research on renewable energy sources.\r\nResearch on renewable energy sources.','Journal','2025-05-15','10.1000/sustainable.2025','/files/sustainable_energy.pdf',3,'Energy','valide','2025-12-13 10:46:15'),(4,'Blockchain in Finance','Analysis of blockchain use in financial sectors.\r\nAnalysis of blockchain use in financial sectors.\r\n','article','2025-07-08','10.1000/blockchain.2025','/files/blockchain_finance.pdf',2,'Finance','valide','2025-12-13 10:46:15'),(5,'Educational Technology Trends','Study on emerging ed-tech tools and platforms.Study on emerging ed-tech tools and platforms.','Journal','2025-09-30','10.1000/edtech.2025','/files/edtech_trends.pdf',3,'Education','valide','2025-12-13 10:46:15'),(9,'bbcv,jdbfsz','mxnvmzdv,jsdg','article','2026-01-02','kjbdjhdgsrkure','xbfdksgrkruagfrkea',2,'Energy','valide','2026-01-01 14:57:18'),(10,'bbcv,jdbfsz','mxnvmzdv,jsdg','article','2026-01-02','kjbdjhdgsrkure','xbfdksgrkruagfrkea',2,'Energy','rejete','2026-01-01 15:02:38'),(11,'bbcv,jdbfsz','mxnvmzdv,jsdg','article','2026-01-02','kjbdjhdgsrkure','xbfdksgrkruagfrkea',2,'Energy','rejete','2026-01-01 15:03:21');
/*!40000 ALTER TABLE `publications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `purpose` text DEFAULT NULL,
  `status_res` varchar(20) NOT NULL DEFAULT 'en-attente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_reservations_user` (`user_id`),
  KEY `fk_reservations_equipment` (`equipment_id`),
  CONSTRAINT `fk_reservations_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reservations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`),
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (23,1,33,'2025-12-27 21:10:00','2026-01-20 21:10:00','whatever','confirme','2025-12-23 20:10:57'),(24,6,33,'2026-01-01 15:50:00','2026-01-07 15:50:00','whatever','refuse','2025-12-27 14:50:24'),(25,6,33,'2025-12-27 21:10:00','2026-01-08 21:10:00','kjsfjgargflae','refuse','2025-12-27 15:43:38'),(26,6,33,'2026-01-10 16:45:00','2026-01-27 16:45:00','kjbkbjlfagliuhf','refuse','2025-12-27 15:45:45'),(27,6,33,'2026-01-13 16:48:00','2026-01-13 19:48:00','hfgdhtdjyht','confirme','2025-12-27 15:49:12'),(28,6,33,'2026-01-01 19:34:00','2026-01-10 19:34:00','kjjafsgefufglgfr','refuse','2025-12-27 18:34:54'),(29,2,34,'2025-12-26 10:37:00','2025-12-28 10:37:00','khdkfiruhgal.s','confirme','2025-12-28 09:37:35'),(30,6,33,'2025-12-26 11:09:00','2025-12-27 11:09:00','jsefgjrgfakeurygtreu','confirme','2025-12-28 10:09:54'),(31,1,33,'2025-12-20 11:14:00','2025-12-21 11:14:00','kajbvjdfzglid,','confirme','2025-12-28 10:14:29');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin'),(6,'directeur'),(5,'doctorant'),(2,'enseignant'),(9,'invite');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(50) NOT NULL,
  `value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (3,'primary-color','#1565c0','pour les boutons et les lien','2026-01-02 12:25:31','2026-01-02 17:12:07','color'),(4,'primary-light','#42a5f5','pour le hover des boutons et liens','2026-01-02 12:25:31','2026-01-02 17:12:27','color'),(5,'primary-dark','#001429','pour le header et footer','2026-01-02 12:25:31','2026-01-02 20:43:23','color'),(6,'accent','#fbe032','pour les alerte et les actions','2026-01-02 12:25:31','2026-01-02 15:42:05','color'),(7,'success','#71fb56','pour les message de succes et les actions de validations','2026-01-02 12:25:31','2026-01-02 15:38:22','color'),(8,'error','#fd5144','pour les message erreurs et les actions de refus','2026-01-02 12:25:31','2026-01-02 15:38:22','color'),(9,'gray-light','#f8f8f9','pour le fond','2026-01-02 12:25:31','2026-01-02 15:06:36','color'),(10,'gray','#4b5563','pour le text secobdaire','2026-01-02 12:25:31','2026-01-02 17:51:05','color'),(11,'gray-dark','#192029','pour le text primaire','2026-01-02 12:25:31','2026-01-02 20:48:06','color'),(12,'white','#ffffff','pour le fond des carte et text','2026-01-02 12:25:31','2026-01-02 15:38:22','color'),(13,'labo_logo','public/assets/img.png',NULL,'2026-01-02 14:16:51','2026-01-02 15:06:36','file'),(14,'univ_logo','public/assets/6957e77a71731_ESI_Logo.png',NULL,'2026-01-02 14:16:51','2026-01-02 15:42:50','file'),(15,'theme','light',NULL,'2026-01-02 14:59:51','2026-01-11 16:16:37','text');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `research_themes` text DEFAULT NULL,
  `team_leader_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_teams_leader` (`team_leader_id`),
  CONSTRAINT `fk_teams_leader` FOREIGN KEY (`team_leader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`team_leader_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'team 1','description','AI and data science',33,'2025-12-13 18:05:08'),(2,'team 2','','AI and data science',29,'2025-12-13 18:05:08');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'public/assets/placeholder.jpg',
  `speciality` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `post` varchar(20) DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `status_user` varchar(20) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `id_team` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_users_team` (`id_team`),
  CONSTRAINT `fk_users_team` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (8,'jdoe','$2y$10$l/9Wrr7GAo22EZtzNwTq4ub8/TDNjbO6HVfwjsfyyDIJKwZjGFSdm','jdoe@example.com','John','Doe','directeur','public/assets/69492d46e576a_La IA aún debe generar confianza para funcionar en diferentes empresas.jpg','Informatics','Biography text here','directeur','Professor','active','',NULL,'2025-12-15 10:33:58','2025-12-15 10:33:58'),(11,'gojo_satoru','gojo2004','serdouahmed@gmail.com','Satoru','Gojo','etudiant','public/assets/69482cff17559_images.png','Computer science','jhdndvfjsernvbsdfvj,','Enseignant','M2','active','public/cv/69482cff18085_CV-Boussaid Meriem (1).pdf',NULL,'2025-12-21 17:23:11','2025-12-21 17:23:11'),(29,'lyes_boussaid','','admin4@example.com','Boussaid','Lyes','','','','','','','active','',NULL,'2025-12-22 11:56:09','2025-12-22 11:56:09'),(33,'admin','$2y$10$fhjpjBHdV8RQ58/CtJ479.1H4ls4GJiuo6UwDgccYK4ilGE.Sp9pi','ms_sidahmed@esi.dz','Sid Ahmed','Sarah','admin','public/assets/694ea88f13916_Kaoruko Waguri.jpg','Computer science','','Enseignant','M2','active','',NULL,'2025-12-22 14:16:08','2025-12-22 14:16:08'),(34,'user','$2y$10$.hX3x2xVwBKtx/JEUwqMVu8Ckv6mHwii8z8NxCCavUYVmKXSSo9HG','mm_boussaid@esi.dz','Boussaid','Meriem','doctorant','public/assets/69495583ec648_Desserte informatique réglable en hauteur sur roulettes.jpg','','','','','active','',1,'2025-12-22 14:26:01','2025-12-22 14:26:01'),(36,'boussaidZineb','$2y$10$J7pZUm3IWN8b.hm/wWdd6uc6NuWlGXwpaAvro.4zhU6fqI2MdIxxO','mz_boussaid@gmail.com','Boussaid','zineb','','','','','','','suspendu','',NULL,'2026-01-10 22:34:17','2026-01-10 22:34:17');
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

-- Dump completed on 2026-01-11 17:16:44
