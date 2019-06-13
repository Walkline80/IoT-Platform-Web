/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : iot_platform

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-06-13 15:28:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for iot_operation_types
-- ----------------------------
DROP TABLE IF EXISTS `iot_operation_types`;
CREATE TABLE `iot_operation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `memo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_operation_types
-- ----------------------------
INSERT INTO `iot_operation_types` VALUES ('1', 'Login', '用户登入、登出等操作');
INSERT INTO `iot_operation_types` VALUES ('2', 'Device', '添加、删除设备等操作');
INSERT INTO `iot_operation_types` VALUES ('3', 'Control', '发送控制命令等操作');
INSERT INTO `iot_operation_types` VALUES ('4', 'Data', '接收设备数据等操作');
INSERT INTO `iot_operation_types` VALUES ('5', 'Remote', '接收来自远端命令等操作，如来自天猫精灵');

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

-- ----------------------------
-- Table structure for iot_user_operations
-- ----------------------------
DROP TABLE IF EXISTS `iot_user_operations`;
CREATE TABLE `iot_user_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `op_type` int(11) NOT NULL,
  `operation` varchar(200) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
