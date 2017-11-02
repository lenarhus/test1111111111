-- MySQL dump 10.13  Distrib 5.5.52, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: dev
-- ------------------------------------------------------
-- Server version	5.5.52-0ubuntu0.14.04.1-log

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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `group_code` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  KEY `fk_auth_item_group_code` (`group_code`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_auth_item_group_code` FOREIGN KEY (`group_code`) REFERENCES `auth_item_group` (`code`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//controller',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//crud',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//extension',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//form',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//model',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('//module',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/asset/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/asset/compress',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/asset/template',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/cache/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/cache/flush',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/cache/flush-all',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/cache/flush-schema',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/cache/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/fixture/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/fixture/load',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/fixture/unload',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/gii/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/gii/default/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/gii/default/action',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/gii/default/diff',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/gii/default/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/gii/default/preview',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/gii/default/view',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/hello/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/hello/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/help/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/help/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/message/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/message/config',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/message/config-template',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/message/extract',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/create',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/down',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/history',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/mark',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/new',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/redo',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/to',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/migrate/up',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/rbac/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/rbac/init',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/serve/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/serve/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/bulk-activate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/bulk-deactivate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/bulk-delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/create',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/grid-page-size',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/grid-sort',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/toggle-attribute',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/update',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth-item-group/view',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/captcha',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/change-own-password',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/confirm-email',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/confirm-email-receive',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/confirm-registration-email',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/login',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/logout',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/password-recovery',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/password-recovery-receive',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/auth/registration',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/bulk-activate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/bulk-deactivate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/bulk-delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/create',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/grid-page-size',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/grid-sort',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/refresh-routes',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/set-child-permissions',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/set-child-routes',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/toggle-attribute',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/update',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/permission/view',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/bulk-activate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/bulk-deactivate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/bulk-delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/create',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/grid-page-size',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/grid-sort',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/set-child-permissions',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/set-child-roles',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/toggle-attribute',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/update',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/role/view',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-permission/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-permission/set',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-permission/set-roles',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/bulk-activate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/bulk-deactivate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/bulk-delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/create',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/grid-page-size',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/grid-sort',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/toggle-attribute',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/update',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user-visit-log/view',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/*',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/bulk-activate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/bulk-deactivate',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/bulk-delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/change-password',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/create',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/delete',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/grid-page-size',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/grid-sort',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/index',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/toggle-attribute',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/update',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('/user-management/user/view',3,NULL,NULL,NULL,1472374595,1472374595,NULL),('Admin',1,'Admin',NULL,NULL,1472374595,1472374595,NULL),('assignRolesToUsers',2,'Assign roles to users',NULL,NULL,1472374595,1472374595,'userManagement'),('bindUserToIp',2,'Bind user to IP',NULL,NULL,1472374595,1472374595,'userManagement'),('changeOwnPassword',2,'Change own password',NULL,NULL,1472374595,1472374595,'userCommonPermissions'),('changeUserPassword',2,'Change user password',NULL,NULL,1472374595,1472374595,'userManagement'),('commonPermission',2,'Common permission',NULL,NULL,1472374593,1472374593,NULL),('createUsers',2,'Create users',NULL,NULL,1472374595,1472374595,'userManagement'),('deleteUsers',2,'Delete users',NULL,NULL,1472374595,1472374595,'userManagement'),('editUserEmail',2,'Edit user email',NULL,NULL,1472374595,1472374595,'userManagement'),('editUsers',2,'Edit users',NULL,NULL,1472374595,1472374595,'userManagement'),('viewRegistrationIp',2,'View registration IP',NULL,NULL,1472374595,1472374595,'userManagement'),('viewUserEmail',2,'View user email',NULL,NULL,1472374595,1472374595,'userManagement'),('viewUserRoles',2,'View user roles',NULL,NULL,1472374595,1472374595,'userManagement'),('viewUsers',2,'View users',NULL,NULL,1472374595,1472374595,'userManagement'),('viewVisitLog',2,'View visit log',NULL,NULL,1472374595,1472374595,'userManagement');
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('changeOwnPassword','/user-management/auth/change-own-password'),('assignRolesToUsers','/user-management/user-permission/set'),('assignRolesToUsers','/user-management/user-permission/set-roles'),('viewVisitLog','/user-management/user-visit-log/grid-page-size'),('viewVisitLog','/user-management/user-visit-log/index'),('viewVisitLog','/user-management/user-visit-log/view'),('editUsers','/user-management/user/bulk-activate'),('editUsers','/user-management/user/bulk-deactivate'),('deleteUsers','/user-management/user/bulk-delete'),('changeUserPassword','/user-management/user/change-password'),('createUsers','/user-management/user/create'),('deleteUsers','/user-management/user/delete'),('viewUsers','/user-management/user/grid-page-size'),('viewUsers','/user-management/user/index'),('editUsers','/user-management/user/update'),('viewUsers','/user-management/user/view'),('Admin','assignRolesToUsers'),('Admin','changeOwnPassword'),('Admin','changeUserPassword'),('Admin','createUsers'),('Admin','deleteUsers'),('Admin','editUsers'),('editUserEmail','viewUserEmail'),('assignRolesToUsers','viewUserRoles'),('Admin','viewUsers'),('assignRolesToUsers','viewUsers'),('changeUserPassword','viewUsers'),('createUsers','viewUsers'),('deleteUsers','viewUsers'),('editUsers','viewUsers');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_group`
--

DROP TABLE IF EXISTS `auth_item_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_group` (
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_group`
--

LOCK TABLES `auth_item_group` WRITE;
/*!40000 ALTER TABLE `auth_item_group` DISABLE KEYS */;
INSERT INTO `auth_item_group` VALUES ('userCommonPermissions','User common permission',1472374595,1472374595),('userManagement','User management',1472374595,1472374595);
/*!40000 ALTER TABLE `auth_item_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
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
  `confirmation_token` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `superadmin` smallint(6) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `registration_ip` varchar(15) DEFAULT NULL,
  `bind_to_ip` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `email_confirmed` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'superadmin','3W6k019rkg506EC-TeNXt_BuohOgxBgW','$2y$13$pnq6mggl.PsoTVYkNENZBepHQrwqXTSFni.bjZ/f2IBep.XqW9dQe',NULL,1,1,1472374593,1472375522,NULL,'',NULL,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_visit_log`
--

DROP TABLE IF EXISTS `user_visit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_visit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `language` char(2) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `visit_time` int(11) NOT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_visit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_visit_log`
--

LOCK TABLES `user_visit_log` WRITE;
/*!40000 ALTER TABLE `user_visit_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_visit_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-10 14:21:38
