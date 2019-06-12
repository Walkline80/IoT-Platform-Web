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
					'%s',
					'%s',
					'%s',
					'%s',
					UUID(),
					NOW()
				)";
	}
?>