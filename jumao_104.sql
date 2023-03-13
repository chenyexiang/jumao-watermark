-- MySQL dump 10.13  Distrib 5.7.40, for Linux (x86_64)
--
-- Host: localhost    Database: jumao
-- ------------------------------------------------------
-- Server version	5.7.40-log

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
-- Table structure for table `yoshop_admin_user`
--

DROP TABLE IF EXISTS `yoshop_admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_admin_user` (
  `admin_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`admin_user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8 COMMENT='超管用户记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_admin_user`
--

LOCK TABLES `yoshop_admin_user` WRITE;
/*!40000 ALTER TABLE `yoshop_admin_user` DISABLE KEYS */;
INSERT INTO `yoshop_admin_user` VALUES (10001,'admin','bf2df1b815ce5d541b7cc4309ba146e8',1670852595,1670852595);
/*!40000 ALTER TABLE `yoshop_admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_setting`
--

DROP TABLE IF EXISTS `yoshop_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_setting` (
  `key` varchar(30) NOT NULL COMMENT '设置项标示',
  `describe` varchar(255) DEFAULT NULL COMMENT '设置项描述',
  `values` mediumtext NOT NULL COMMENT '设置内容（json格式）',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  UNIQUE KEY `unique_key` (`key`,`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商城设置记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_setting`
--

LOCK TABLES `yoshop_setting` WRITE;
/*!40000 ALTER TABLE `yoshop_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_store_access`
--

DROP TABLE IF EXISTS `yoshop_store_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_store_access` (
  `access_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) DEFAULT NULL COMMENT '权限名称',
  `url` varchar(255) DEFAULT NULL COMMENT '权限url',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序(数字越小越靠前)',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='商家用户权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_store_access`
--

LOCK TABLES `yoshop_store_access` WRITE;
/*!40000 ALTER TABLE `yoshop_store_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_store_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_store_role`
--

DROP TABLE IF EXISTS `yoshop_store_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_store_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(50) DEFAULT NULL COMMENT '角色名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级角色id',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序(数字越小越靠前)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_store_role`
--

LOCK TABLES `yoshop_store_role` WRITE;
/*!40000 ALTER TABLE `yoshop_store_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_store_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_store_role_access`
--

DROP TABLE IF EXISTS `yoshop_store_role_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_store_role_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户角色权限关系表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_store_role_access`
--

LOCK TABLES `yoshop_store_role_access` WRITE;
/*!40000 ALTER TABLE `yoshop_store_role_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_store_role_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_store_user`
--

DROP TABLE IF EXISTS `yoshop_store_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_store_user` (
  `store_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `real_name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `is_super` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否为超级管理员',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`store_user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='商家用户记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_store_user`
--

LOCK TABLES `yoshop_store_user` WRITE;
/*!40000 ALTER TABLE `yoshop_store_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_store_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_store_user_role`
--

DROP TABLE IF EXISTS `yoshop_store_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_store_user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `store_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '超管用户id',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `admin_user_id` (`store_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户角色记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_store_user_role`
--

LOCK TABLES `yoshop_store_user_role` WRITE;
/*!40000 ALTER TABLE `yoshop_store_user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_store_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_user`
--

DROP TABLE IF EXISTS `yoshop_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `open_id` varchar(255) NOT NULL DEFAULT '0' COMMENT '微信openid(唯一标示)',
  `nickName` varchar(255) DEFAULT NULL COMMENT '微信昵称',
  `avatarUrl` varchar(255) DEFAULT NULL COMMENT '微信头像',
  `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用次数',
  `is_userdata` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已授权',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`),
  KEY `openid` (`open_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='用户记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_user`
--

LOCK TABLES `yoshop_user` WRITE;
/*!40000 ALTER TABLE `yoshop_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_user_record`
--

DROP TABLE IF EXISTS `yoshop_user_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_user_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_info` varchar(255) NOT NULL DEFAULT '0' COMMENT '用户信息',
  `ip` varchar(200) NOT NULL DEFAULT '0' COMMENT '解析ip',
  `url` varchar(255) DEFAULT NULL COMMENT '解析链接',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '解析状态（0=失败 1=成功）',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `admin_user_id` (`user_info`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户解析记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_user_record`
--

LOCK TABLES `yoshop_user_record` WRITE;
/*!40000 ALTER TABLE `yoshop_user_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_user_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_user_urls`
--

DROP TABLE IF EXISTS `yoshop_user_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_user_urls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `url` varchar(500) DEFAULT NULL COMMENT '解析链接',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '出现次数',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='域名记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_user_urls`
--

LOCK TABLES `yoshop_user_urls` WRITE;
/*!40000 ALTER TABLE `yoshop_user_urls` DISABLE KEYS */;
INSERT INTO `yoshop_user_urls` VALUES (1,'https://v3-default.ixigua.com',1,10001,1678533240,1678533240),(2,'https://v9-default.ixigua.com',3,10001,1678628665,1678628711);
/*!40000 ALTER TABLE `yoshop_user_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_wxapp`
--

DROP TABLE IF EXISTS `yoshop_wxapp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_wxapp` (
  `wxapp_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '小程序id',
  `app_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '小程序AppID',
  `app_secret` varchar(50) NOT NULL DEFAULT '0' COMMENT '小程序AppSecret',
  `notice` varchar(255) DEFAULT NULL COMMENT '公告',
  `is_ad` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否开启流量主',
  `ad_banner` varchar(255) DEFAULT NULL COMMENT 'Banner广告id',
  `ad_excitation` varchar(255) DEFAULT NULL COMMENT '激励广告id',
  `ad_screen` varchar(255) DEFAULT NULL COMMENT '插屏广告id',
  `ad_video` varchar(255) DEFAULT NULL COMMENT '视频广告id',
  `is_recycle` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否回收',
  `money_login` int(11) NOT NULL DEFAULT '0' COMMENT '首次登录奖励金币',
  `is_limit` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否限制用户解析',
  `is_analysis` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否使用内置解析接口（0=第三方 1=内置）',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`wxapp_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微信小程序记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_wxapp`
--

LOCK TABLES `yoshop_wxapp` WRITE;
/*!40000 ALTER TABLE `yoshop_wxapp` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_wxapp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_wxapp_category`
--

DROP TABLE IF EXISTS `yoshop_wxapp_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_wxapp_category` (
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `category_style` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '分类页样式(10一级分类[大图] 11一级分类[小图] 20二级分类)',
  `share_title` varchar(10) NOT NULL COMMENT '分享标题',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序分类页模板';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_wxapp_category`
--

LOCK TABLES `yoshop_wxapp_category` WRITE;
/*!40000 ALTER TABLE `yoshop_wxapp_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_wxapp_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_wxapp_formid`
--

DROP TABLE IF EXISTS `yoshop_wxapp_formid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_wxapp_formid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `form_id` varchar(50) NOT NULL COMMENT '小程序form_id',
  `expiry_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `is_used` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已使用',
  `used_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用时间',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='小程序form_id记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_wxapp_formid`
--

LOCK TABLES `yoshop_wxapp_formid` WRITE;
/*!40000 ALTER TABLE `yoshop_wxapp_formid` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_wxapp_formid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_wxapp_help`
--

DROP TABLE IF EXISTS `yoshop_wxapp_help`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_wxapp_help` (
  `help_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(255) NOT NULL COMMENT '帮助标题',
  `content` text NOT NULL COMMENT '帮助内容',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序(数字越小越靠前)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`help_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='微信小程序帮助';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_wxapp_help`
--

LOCK TABLES `yoshop_wxapp_help` WRITE;
/*!40000 ALTER TABLE `yoshop_wxapp_help` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_wxapp_help` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_wxapp_page`
--

DROP TABLE IF EXISTS `yoshop_wxapp_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_wxapp_page` (
  `page_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '页面id',
  `page_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '页面类型(10首页 20自定义页)',
  `page_name` varchar(255) NOT NULL COMMENT '页面名称',
  `page_data` longtext NOT NULL COMMENT '页面数据',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '微信小程序id',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '软删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`page_id`),
  KEY `wxapp_id` (`wxapp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='微信小程序diy页面表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_wxapp_page`
--

LOCK TABLES `yoshop_wxapp_page` WRITE;
/*!40000 ALTER TABLE `yoshop_wxapp_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_wxapp_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoshop_wxapp_prepay_id`
--

DROP TABLE IF EXISTS `yoshop_wxapp_prepay_id`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoshop_wxapp_prepay_id` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `prepay_id` varchar(50) NOT NULL COMMENT '微信支付prepay_id',
  `can_use_times` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可使用次数',
  `used_times` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '已使用次数',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态(1已支付)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `expiry_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='小程序prepay_id记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoshop_wxapp_prepay_id`
--

LOCK TABLES `yoshop_wxapp_prepay_id` WRITE;
/*!40000 ALTER TABLE `yoshop_wxapp_prepay_id` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoshop_wxapp_prepay_id` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'jumao'
--

--
-- Dumping routines for database 'jumao'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-13 14:49:44
