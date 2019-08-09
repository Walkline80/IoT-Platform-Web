SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `iot_aligenie_device_catalogs`;
CREATE TABLE `iot_aligenie_device_catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `value` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

insert into `iot_aligenie_device_catalogs`(`id`,`name`,`value`) values
('1','电视','television'),
('2','灯','light'),
('3','空调','aircondition'),
('4','空气净化器','outlet'),
('5','开关','switch'),
('6','扫地机器人','roboticvacuum'),
('7','窗帘','curtain'),
('8','加湿器','humidifier'),
('9','风扇','fan'),
('10','暖奶器','bottlewarmer'),
('11','豆浆机','soymilkmaker'),
('12','电热水壶','kettle'),
('13','饮水机','waterdispenser'),
('14','摄像头','camera'),
('15','路由器','router'),
('16','电饭煲','cooker'),
('17','热水器','waterheater'),
('18','烤箱','oven'),
('19','净水器','waterpurifier'),
('20','冰箱','fridge'),
('21','机顶盒','STB'),
('22','传感器','sensor'),
('23','洗衣机','washmachine'),
('24','智能床','smartbed'),
('25','香薰机','aromamachine'),
('26','窗','window'),
('27','抽油烟机','kitchenvenitilator'),
('28','指纹锁','fingerprintlock'),
('29','万能遥控器','telecontroller'),
('30','洗碗机','dishwasher'),
('31','除湿机','dehumidifier'),
('32','干衣机','dryer'),
('33','壁挂炉','wall-hung-boiler'),
('34','微波炉','microwaveoven'),
('35','取暖器','heater'),
('36','驱蚊器','mosquitoDispeller'),
('37','跑步机','treadmill'),
('38','智能门控(门锁)','smart-gating'),
('39','智能手环','smart-band'),
('40','晾衣架','hanger');
DROP TABLE IF EXISTS  `iot_devices`;
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

insert into `iot_devices`(`id`,`key`,`secret`,`uuid`,`type`,`date`,`online_date`,`status`,`wanted`,`aligenie_enabled`,`aligenie_id`,`aligenie_name`,`aligenie_type`,`aligenie_zone`,`aligenie_brand`,`aligenie_modal`,`aligenie_icon`) values
('1','73aa1223-ac41-11e9-b2b6-7085c2ae4575','26235483222704128','dfb8e47c-8c24-11e9-914b-7085c2ae4575','2','2019-07-22 13:28:03',null,'0','-1','1','26247063108845568','单路智能开关','switch','办公室','走线物联','wkliot_one_switch','https://walkline.wang/iot/images/icons/switch.png');
DROP TABLE IF EXISTS  `iot_operation_types`;
CREATE TABLE `iot_operation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `memo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

insert into `iot_operation_types`(`id`,`name`,`memo`) values
('1','Login','用户登入、登出等操作'),
('2','Device','添加、删除设备等操作'),
('3','Control','发送控制命令等操作'),
('4','Data','接收设备数据等操作'),
('5','Remote','接收来自远端命令等操作，如来自天猫精灵');
DROP TABLE IF EXISTS  `iot_operations`;
CREATE TABLE `iot_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `op_type` int(11) NOT NULL,
  `operation` int(11) NOT NULL,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

insert into `iot_operations`(`id`,`op_type`,`operation`,`description`) values
('1','1','1','用户登入'),
('2','1','2','用户登出'),
('3','1','3','用户未注册，或密码错误'),
('4','1','4','用户禁止登录');
DROP TABLE IF EXISTS  `iot_user_groups`;
CREATE TABLE `iot_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

insert into `iot_user_groups`(`id`,`name`) values
('1','Administrators'),
('2','Users');
DROP TABLE IF EXISTS  `iot_user_operations`;
CREATE TABLE `iot_user_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `op_type` int(11) NOT NULL,
  `operation` int(11) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `iot_users`;
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

insert into `iot_users`(`id`,`openid`,`email`,`nickname`,`passwd`,`mobile`,`uuid`,`usergroup`,`device_limit`,`enabled`,`ip`,`date`) values
('9','oy9W15GCIwazn8NCjE6wPZPmRkus','walkline@163.com','Walkline','e10adc3949ba59abbe56e057f20f883e',null,'dfb8e47c-8c24-11e9-914b-7085c2ae4575','2','3','1','::1','2019-06-11 16:42:41');
SET FOREIGN_KEY_CHECKS = 1;

/* PROCEDURES */;
DROP PROCEDURE IF EXISTS `update_and_feedback_status`;
DELIMITER $$
CREATE PROCEDURE `update_and_feedback_status`(
		IN in_uuid CHAR(36),
		IN in_device_id CHAR(36),
		IN in_device_key CHAR(36),
		IN in_status INT ,
		OUT out_wanted_status INT 
)
BEGIN
	UPDATE iot_devices
	SET `status` = in_status
	WHERE
		uuid = in_uuid
	AND `key` = in_device_id
	AND secret = in_device_key;

	SELECT
		wanted into out_wanted_status
	FROM
		iot_devices
	WHERE
		uuid = in_uuid
	AND `key` = in_device_id
	AND secret = in_device_key;

	IF in_status = out_wanted_status THEN
		UPDATE iot_devices
		SET wanted = -1
		WHERE
			uuid = in_uuid
		AND `key` = in_device_id
		AND secret = in_device_key;
	END IF;

	SELECT out_wanted_status;
END
$$
DELIMITER ;

