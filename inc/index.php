<?php
	header('Content-Type: application/json');
	set_time_limit(0);

	include_once('connect2db.php');

	$post = json_decode(file_get_contents("php://input"), true);

	$uuid = @$post['uuid'];
	$device_id = @$post['device_id'];
	$device_key = @$post['device_key'];
	$type = @$post['type'];

	while (true) {
		if (check_staus($uuid, $device_id, $device_key)) {
			break;
		}

		usleep(200000);
	}

	function check_staus($uuid, $device_id, $device_key) {
		global $mysqli;

		if (!isset($uuid) || !isset($device_id) || !isset($device_key)) {
			return false;
		}

		$query =
			"SELECT
				wanted
			FROM
				iot_devices
			WHERE
				uuid = ?
			AND `key` = ?
			AND secret = ?";
		
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("sss", $uuid, $device_id, $device_key);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($wanted_status);
		$stmt->fetch();
		// $stmt->close();
		// $mysqli->close();

		$query =
			"UPDATE iot_devices
			SET wanted = -1
			WHERE
				uuid = ?
			AND `key` = ?
			AND secret = ?";

		if ($wanted_status != -1) {
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("sss", $uuid, $device_id, $device_key);
			$stmt->execute();
			$stmt->close();
			$mysqli->close();

			$returnObject = array(
				"result" => "success",
				"wanted_status" => $wanted_status
			);

			echo json_encode($returnObject);

			return true;
		}

		return false;
	}
?>