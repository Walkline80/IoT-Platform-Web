/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : iot_platform

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-06-11 16:45:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for iot_users
-- ----------------------------
DROP TABLE IF EXISTS `iot_users`;
CREATE TABLE `iot_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) NOT NULL,
  `nickname` varchar(20) DEFAULT NULL,
  `passwd` varchar(32) NOT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `uuid` varchar(36) NOT NULL DEFAULT '',
  `usergroup` int(11) NOT NULL DEFAULT '2',
  `enabled` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for iot_user_groups
-- ----------------------------
DROP TABLE IF EXISTS `iot_user_groups`;
CREATE TABLE `iot_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_user_groups
-- ----------------------------
INSERT INTO `iot_user_groups` VALUES ('1', 'Administrators');
INSERT INTO `iot_user_groups` VALUES ('2', 'Users');
