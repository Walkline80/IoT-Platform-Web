<?php
	$is_local = $_SERVER['SERVER_NAME'] === "localhost";

	if ($is_local) {
		$mysql_config = array (
			'host' => 'localhost',
			'db_user' => 'root',
			'db_pwd'  => '123456',
			'db'   => 'iot_platform'
		);
	} else {
		$mysql_config = array (
			'host' => '',
			'db_user' => '',
			'db_pwd'  => '',
			'db'   => ''
		);
	}

	$mysqli = @new mysqli($mysql_config['host'], $mysql_config['db_user'], $mysql_config['db_pwd']);

	if ($mysqli->connect_errno) {
		die("连接数据库失败：" . $mysqli->connect_error);
	}

	$mysqli->query("set names utf8");
	$mysqli->query("set character set utf8");
	$mysqli->select_db($mysql_config['db']);

	// 设置默认时区
	date_default_timezone_set("Asia/Shanghai");
?>