<?php
	$is_local = $_SERVER['SERVER_NAME'] === "localhost";

	if ($is_local) {
		$host = "localhost";
		$user = "root";
		$pass = "123456";
		$db_name = "iot_platform";
	} else {
		$host = "";
		$user = "";
		$pass = "";
		$db_name = "";
	}

	$connection = @mysql_connect($host, $user, $pass);

	if (!$connection) {die("连接数据库失败：" . mysql_error());}

	mysql_select_db($db_name, $connection);

	// 设置默认时区
	date_default_timezone_set("Asia/Shanghai");

	// 字符转换，读库
	mysql_query("set character set utf8");

	// 写库
	mysql_query("set names utf8");
?>