<?php
	/**
	 * Restful API 数据库查询语句定义类
	 * 
	 * 提供全部的和网站、硬件设备交互的数据库查询
	 * 
	 * @author	Walkline Wang
	 * @license	MIT
	 * @version	0.0.1
	 */

	class query_list
	{
		// 列出用户所有设备
		const query_device_lists =
			"SELECT
				devices.`key`,
				devices.secret,
				devices.type,
				devices.date,
				devices.online_date,
				devices.`status`,
				devices.aligenie_enabled
			FROM
				iot_devices AS devices
			INNER JOIN iot_users AS users ON (users.uuid = devices.uuid)
			WHERE
				users.openid = ?";
		
		// 更新指定设备状态
		const query_command =
			"UPDATE iot_devices
				SET `status` = ?
				WHERE
					uuid = ?
				AND `key` = ?
				AND secret = ?";
		
		// 查询设备预期状态
		const query_device_wanted_status =
			"SELECT
				wanted
			FROM
				iot_devices
			WHERE
				uuid = ?
			AND `key` = ?
			AND secret = ?";
		
		// 插入用户操作记录
		const query_append_user_operation =
			"INSERT INTO iot_user_operations (
				uuid,
				op_type,
				operation,
				ip,
				date
			)
			VALUES
				(
					?,
					?,
					?,
					?,
					NOW()
				)";
	}
?>