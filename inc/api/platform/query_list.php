<?php
	class query_list
	{
		const query_user_exists =
			"SELECT
				*
			FROM
				iot_users
			WHERE
				email = ?
			LIMIT 1";
		
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