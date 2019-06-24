/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : iot_platform

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-06-24 10:46:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for iot_aligenie_device_catalogs
-- ----------------------------
DROP TABLE IF EXISTS `iot_aligenie_device_catalogs`;
CREATE TABLE `iot_aligenie_device_catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `value` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_aligenie_device_catalogs
-- ----------------------------
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('1', '电视', 'television');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('2', '灯', 'light');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('3', '空调', 'aircondition');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('4', '空气净化器', 'outlet');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('5', '开关', 'switch');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('6', '扫地机器人', 'roboticvacuum');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('7', '窗帘', 'curtain');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('8', '加湿器', 'humidifier');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('9', '风扇', 'fan');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('10', '暖奶器', 'bottlewarmer');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('11', '豆浆机', 'soymilkmaker');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('12', '电热水壶', 'kettle');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('13', '饮水机', 'waterdispenser');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('14', '摄像头', 'camera');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('15', '路由器', 'router');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('16', '电饭煲', 'cooker');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('17', '热水器', 'waterheater');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('18', '烤箱', 'oven');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('19', '净水器', 'waterpurifier');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('20', '冰箱', 'fridge');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('21', '机顶盒', 'STB');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('22', '传感器', 'sensor');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('23', '洗衣机', 'washmachine');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('24', '智能床', 'smartbed');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('25', '香薰机', 'aromamachine');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('26', '窗', 'window');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('27', '抽油烟机', 'kitchenvenitilator');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('28', '指纹锁', 'fingerprintlock');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('29', '万能遥控器', 'telecontroller');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('30', '洗碗机', 'dishwasher');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('31', '除湿机', 'dehumidifier');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('32', '干衣机', 'dryer');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('33', '壁挂炉', 'wall-hung-boiler');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('34', '微波炉', 'microwaveoven');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('35', '取暖器', 'heater');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('36', '驱蚊器', 'mosquitoDispeller');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('37', '跑步机', 'treadmill');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('38', '智能门控(门锁)', 'smart-gating');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('39', '智能手环', 'smart-band');
INSERT INTO `iot_aligenie_device_catalogs` VALUES ('40', '晾衣架', 'hanger');

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
  `device_limit` int(11) NOT NULL,
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
