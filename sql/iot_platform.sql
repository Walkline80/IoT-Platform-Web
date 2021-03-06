/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : iot_platform

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-06 13:13:40
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
-- Table structure for iot_devices
-- ----------------------------
DROP TABLE IF EXISTS `iot_devices`;
CREATE TABLE `iot_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(36) NOT NULL,
  `secret` varchar(36) NOT NULL,
  `uuid` varchar(36) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `online_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `wanted` int(11) DEFAULT '-1',
  `aligenie_enabled` int(11) NOT NULL DEFAULT '0',
  `aligenie_id` varchar(36) DEFAULT '',
  `aligenie_name` varchar(20) DEFAULT NULL,
  `aligenie_type` varchar(20) DEFAULT NULL,
  `aligenie_zone` varchar(20) DEFAULT NULL,
  `aligenie_brand` varchar(30) DEFAULT '',
  `aligenie_modal` varchar(30) DEFAULT NULL,
  `aligenie_icon` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_devices
-- ----------------------------
INSERT INTO `iot_devices` VALUES ('1', '73aa1223-ac41-11e9-b2b6-7085c2ae4575', '26235483222704128', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '2', '2019-07-22 13:28:03', null, '0', '-1', '1', '26247063108845568', '单路智能开关', 'switch', '办公室', '走线物联', 'wkliot_one_switch', 'https://walkline.wang/iot/images/icons/switch.png');

-- ----------------------------
-- Table structure for iot_operations
-- ----------------------------
DROP TABLE IF EXISTS `iot_operations`;
CREATE TABLE `iot_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `op_type` int(11) NOT NULL,
  `operation` int(11) NOT NULL,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_operations
-- ----------------------------
INSERT INTO `iot_operations` VALUES ('1', '1', '1', '用户登入');
INSERT INTO `iot_operations` VALUES ('2', '1', '2', '用户登出');
INSERT INTO `iot_operations` VALUES ('3', '1', '3', '用户未注册，或密码错误');
INSERT INTO `iot_operations` VALUES ('4', '1', '4', '用户禁止登录');

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
  `openid` char(32) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_users
-- ----------------------------
INSERT INTO `iot_users` VALUES ('9', 'oy9W15GCIwazn8NCjE6wPZPmRkus', 'walkline@163.com', 'Walkline', 'e10adc3949ba59abbe56e057f20f883e', null, 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '2', '3', '1', '::1', '2019-06-11 16:42:41');

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
  `operation` int(11) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_user_operations
-- ----------------------------
INSERT INTO `iot_user_operations` VALUES ('2', 'walkline@163.com', '1', '0', '::1', '2019-06-13 14:10:38');
INSERT INTO `iot_user_operations` VALUES ('3', 'walkline@163.com', '1', '0', '::1', '2019-06-13 14:10:57');
INSERT INTO `iot_user_operations` VALUES ('4', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '0', '::1', '2019-06-13 14:11:23');
INSERT INTO `iot_user_operations` VALUES ('5', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '0', '::1', '2019-06-13 14:14:08');
INSERT INTO `iot_user_operations` VALUES ('6', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '0', '::1', '2019-06-13 14:14:31');
INSERT INTO `iot_user_operations` VALUES ('7', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '0', '::1', '2019-06-13 14:15:22');
INSERT INTO `iot_user_operations` VALUES ('8', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '0', '::1', '2019-06-13 14:15:37');
INSERT INTO `iot_user_operations` VALUES ('9', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-06-24 14:59:53');
INSERT INTO `iot_user_operations` VALUES ('10', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '2', '::1', '2019-06-24 15:07:40');
INSERT INTO `iot_user_operations` VALUES ('11', 'walkline@163.com', '1', '3', '::1', '2019-07-22 10:29:37');
INSERT INTO `iot_user_operations` VALUES ('12', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-07-22 10:29:46');
INSERT INTO `iot_user_operations` VALUES ('13', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-07-22 17:08:36');
INSERT INTO `iot_user_operations` VALUES ('14', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-07-22 17:10:07');
INSERT INTO `iot_user_operations` VALUES ('15', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-07-23 15:47:20');
INSERT INTO `iot_user_operations` VALUES ('16', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-07-24 09:18:28');
INSERT INTO `iot_user_operations` VALUES ('17', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-07-24 09:18:58');
INSERT INTO `iot_user_operations` VALUES ('18', 'dfb8e47c-8c24-11e9-914b-7085c2ae4575', '1', '1', '::1', '2019-07-25 15:53:33');
