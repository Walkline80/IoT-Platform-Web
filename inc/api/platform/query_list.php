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
	}
?>