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

	class query_list_devices
	{
		// 更新指定设备状态
		const query_command =
			"UPDATE iot_devices
			SET `status` = ?
			WHERE
				uuid = ?
			AND `key` = ?
			AND secret = ?";
		
		const query_clear_device_wanted_status =
			"UPDATE iot_devices
			SET wanted = ?
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
	}

	class query_list_platform
	{
		// 查询用户是否存在，用于注册账号
		const query_user_exists =
			"SELECT
				*
			FROM
				iot_users
			WHERE
				email = ?
			LIMIT 1";
		
		// 插入用户记录，用于注册账号
		const query_append_user =
			"INSERT INTO iot_users (
				email,
				nickname,
				passwd,
				ip,
				uuid,
				date
			)
			VALUES
				(
					?,
					?,
					?,
					?,
					UUID(),
					NOW()
				)";
		
		// 查询用户记录是否存在，用于用户登录
		const query_sign_in_user =
			"SELECT
				email,
				nickname,
				uuid,
				enabled
			FROM
				iot_users
			WHERE
				email = ?
			AND passwd = ?
			LIMIT 1";
		
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

		// 列出用户所有设备
		const query_device_lists =
			"SELECT
				`key`,
				secret,
				type,
				date,
				online_date,
				`status`,
				aligenie_enabled
			FROM
				iot_devices
			WHERE
				uuid = ?";
	}

	class query_list_tinyapp
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

		// 查询指定设备状态
		const query_device_status =
			"SELECT
				devices.`status`
			FROM
				iot_devices AS devices
			INNER JOIN iot_users AS users ON (users.uuid = devices.uuid)
			WHERE
				users.openid = ?
			AND devices.`key` = ?
			AND devices.secret = ?
			AND devices.type = ?";

		// 设置指定设备状态
		const query_set_device_status =
			"UPDATE iot_devices AS devices
			INNER JOIN iot_users AS users ON (users.uuid = devices.uuid)
			SET devices.wanted = ?
			WHERE
				users.openid = ?
			AND devices.`key` = ?
			AND devices.secret = ?
			AND devices.type = ?";
	}
?>