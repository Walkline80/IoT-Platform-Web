<?php
	/**
	 * Restful API 提供程序
	 * 
	 * 提供全部的和网站、硬件设备交互的 API 接口程序
	 * 
	 * @author	Walkline Wang
	 * @license	MIT
	 * @version	0.0.1
	 */
	
	header('Content-Type: application/json');

	include_once('../../connect2db.php');
	include_once('../../functions.php');
	include_once('../exception.php');
	include_once('../query_list.php');
	include_once('../operations.php');
	include_once('tinyapp_config.php');

	session_set_cookie_params(24 * 3600 * 365, "/");
	session_start();

	$returnObject = array();
	$exception = new api_error();

	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		switch ($_REQUEST['v1']) {
			case 'get_device_lists':
				$post = json_decode(file_get_contents('php://input'), true);
				$returnObject = get_device_lists(@$post['open_id']);

				break;
			case 'get_device_status':
				$post = json_decode(file_get_contents('php://input'), true);
				$returnObject = get_device_status(@$post['open_id'], @$post['device_id'], @$post['device_key'], @$post['type']);

				break;
			case 'set_device_status':
				$post = json_decode(file_get_contents('php://input'), true);
				$returnObject = set_device_status(@$post['open_id'], @$post['device_id'], @$post['device_key'], @$post['type'], @$post['status']);

				break;
			default:
				$returnObject = (object) array(
					"error_code" => 1001,
					"error_msg" => "未知的api接口"
				);
		}
	} else if ($_SERVER['REQUEST_METHOD'] === "GET") {
		switch ($_REQUEST['v1']) {
			case 'get_openid':
				// $get = json_decode(file_get_contents('php://input'), true);
				// var_dump($get);
				$returnObject = get_openid(@$_GET['code']);

				break;
			default:
				$returnObject = (object) array(
					"error_code" => 1001,
					"error_msg" => "未知的api接口"
				);
		}
	} else {
		$returnObject = (object) array(
			"error_code" => 1001,
			"error_msg" => "未知的api接口"
		);
	}

	echo json_encode($returnObject);


	function get_openid($code) {
		global $exception;

		if (!isset($code)) {
			return $exception->get_response_object(2010);
		}

		$param = array(
			"appid" => APP_ID,
            "secret" => APP_SECRET,
            "js_code" => $code,
            "grant_type" => 'authorization_code'
		);

		$result = get_url_data("https://api.weixin.qq.com/sns/jscode2session?", $param);
		
		return json_decode($result, true);
	}

	/**
	 * 获取指定设备当前状态
	 */
	function get_device_status($open_id, $device_id, $device_key, $type) {
		global $exception, $mysqli;

		if (!isset($open_id) || !$open_id) {
			return $exception->get_response_object(2009);
		}

		if (!isset($device_id) || !isset($device_key) || !isset($type)) {
			return $exception->get_response_object(2008);
		}

		$stmt = $mysqli->prepare(query_list_tinyapp::query_device_status);
		$stmt->bind_param("sssi", $open_id, $device_id, $device_key, $type);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($status);
		$stmt->fetch();

		$returnObject = array(
			"result" => "success",
			"status" => $status
		);

		$stmt->close();
		$mysqli->close();

		return $returnObject;
	}

	/**
	 * 设置指定设备预期状态
	 */
	function set_device_status($open_id, $device_id, $device_key, $type, $wanted_status) {
		global $exception, $mysqli;

		if (!isset($open_id) || !$open_id) {
			return $exception->get_response_object(2009);
		}

		if (!isset($device_id) || !isset($device_key) || !isset($type) || !isset($wanted_status)) {
			return $exception->get_response_object(2008);
		}

		$stmt = $mysqli->prepare(query_list_tinyapp::query_set_device_status);
		$stmt->bind_param("isssi", $wanted_status, $open_id, $device_id, $device_key, $type);
		$stmt->execute();
		$stmt->store_result();

		$returnObject = array(
			"result" => "success"
		);

		$stmt->close();
		$mysqli->close();

		return $returnObject;
	}

	/**
	 * 获取用户设备列表
	 */
	function get_device_lists($open_id) {
		global $exception, $mysqli;

		if (!isset($open_id) || !$open_id) {
			return $exception->get_response_object(2009);
		}

		$stmt = $mysqli->prepare(query_list_tinyapp::query_device_lists);
		$stmt->bind_param("s", $open_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($key, $secret, $type, $date, $online_date, $status, $aligenie_enabled);
		
		$data_array = array();

		while ($stmt->fetch()) {
			$list = array(
				"key" => $key,
				"secret" => $secret,
				"type" => $type,
				"date" => $date,
				"online_date" => $online_date,
				"status" => $status,
				"aligenie_enabled" => $aligenie_enabled
			);

			$data_array[] = $list;
		}

		$returnObject = array(
			"result" => "success",
			"lists" => $data_array
		);

		// append_user_operation(1, "用户登入");
		// append_user_operation(Operations::Login, Login::log_in);

		$stmt->close();
		$mysqli->close();

		return $returnObject;
	}

	/**
	 * 用户注册操作
	 */
	// function sign_up_user($username, $password, $password_again) {
	// 	global $exception, $mysqli;
		
	// 	$username = strtolower($username);

	// 	if (!$username) {
	// 		return $exception->get_response_object(2000);
	// 	}

	// 	if (!$password || !$password_again) {
	// 	   return $exception->get_response_object(2001);
	// 	}

	// 	if ($password != $password_again) {
	// 		return $exception->get_response_object(2002);
	// 	}

	// 	if (strlen($password) < 6 || strlen($password_again) < 6) {
	// 		return $exception->get_response_object(2003);
	// 	}

	// 	if (!check_email_validation($username)) {
	// 		return $exception->get_response_object(2004);
	// 	}

	// 	$stmt = $mysqli->prepare(query_list::query_user_exists);
	// 	$stmt->bind_param("s", $username);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	// $query_result = $stmt->fetch();

	// 	if ($stmt->num_rows() >= 1) {
	// 		return $exception->get_response_object(2005);
	// 	}

	// 	$nickname = ucfirst(explode("@", $username)[0]);
	// 	$password = md5($password);
	// 	$ip_address = get_user_ip_address();

	// 	$stmt->close();
	// 	$stmt = $mysqli->prepare(query_list::query_append_user);
	// 	$stmt->bind_param("ssss", $username, $nickname, $password, $ip_address);
	// 	$stmt->execute();

	// 	$returnObject = array(
	// 		"result" => "success"
	// 	);

	// 	$stmt->close();
	// 	$mysqli->close();

	// 	return $returnObject;
	// }
?>