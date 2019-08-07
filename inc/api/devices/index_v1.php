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

	session_set_cookie_params(24 * 3600 * 365, "/");
	session_start();

	$returnObject = array();
	$exception = new api_error();

	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		switch ($_REQUEST['v1']) {
			case 'query_command':
				$post = json_decode(file_get_contents('php://input'), true);
				$returnObject = query_command(@$post['uuid'], @$post['device_id'], @$post['device_key'], @$post['type'], @$post['status']);

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

	
	/**
	 * 更新设备状态，用于硬件设备SDK
	 */
	function query_command($uuid, $device_id, $device_key, $type, $status) {
		global $exception, $mysqli;

		if (!isset($uuid) || !isset($device_id) || !isset($device_key) || !isset($type) || !isset($status)) {
			return $exception->get_response_object(2008);
		}

		$stmt = $mysqli->prepare(query_list_devices::query_command);
		$stmt->bind_param("isss", $status, $uuid, $device_id, $device_key);
		$stmt->execute();
		// $stmt->store_result();

		$stmt = $mysqli->prepare(query_list_devices::query_device_wanted_status);
		$stmt->bind_param("sss", $uuid, $device_id, $device_key);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($wanted_status);
		$stmt->fetch();

		if ($status == $wanted_status) {
			$wanted_status = -1;

			$stmt = $mysqli->prepare(query_list_devices::query_clear_device_wanted_status);
			$stmt->bind_param("sss", $uuid, $device_id, $device_key);
			$stmt->execute();
		}

		$returnObject = array(
			"result" => "success",
			"wanted_status" => $wanted_status
		);

		return $returnObject;
	}
?>