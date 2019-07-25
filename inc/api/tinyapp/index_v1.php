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
	include_once('exception.php');
	include_once('query_list.php');
	include_once('operations.php');

	session_set_cookie_params(24 * 3600 * 365, "/");
	session_start();

	$returnObject = array();
	$exception = new api_error();

	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		switch ($_REQUEST['v1']) {
			// case 'query_command':
			// 	$post = json_decode(file_get_contents('php://input'), true);
			// 	$returnObject = query_command(@$post['uuid'], @$post['device_id'], @$post['device_key'], @$post['type'], @$post['status']);

			// 	break;
			case 'get_device_lists':
				$post = json_decode(file_get_contents('php://input'), true);
				$returnObject = get_device_lists(@$post['openID']);

				break;
			// case 'log_out_user':
			// 	$returnObject = log_out_user();

			// 	break;
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
	 * 添加用户操作记录
	 */
	function append_user_operation($op_type, $operation, $username="") {
		/*
			op_type:
					1 = Login, 用户登入、登出等操作;
					2 = Device, 添加、删除设备等操作;
					3 = Control, 发送控制命令等操作;
					4 = Data, 接收设备数据等操作;
					5 = Remote, 接收来自远端命令等操作，如来自天猫精灵;
		*/

		global $mysqli;

		$stmt = $mysqli->prepare(query_list::query_append_user_operation);
		$stmt->bind_param("siis", $uuid, $op_type, $operation, $ip_address);

		$uuid = isset($_SESSION['userinfo']['uuid']) ? $_SESSION['userinfo']['uuid'] : $username;
		$ip_address = get_user_ip_address();

		$stmt->execute();
		$stmt->close();
	}

	/**
	 * 更新设备状态
	 */
	function query_command($uuid, $device_id, $device_key, $type, $status) {
		global $exception, $mysqli;

		// if (!isset($_SESSION['userinfo']) || !isset($_SESSION['userinfo']['uuid'])) {
		// 	return $exception->get_response_object(5000);
		// }

		if (!isset($uuid) || !isset($device_id) || !isset($device_key) || !isset($type) || !isset($status)) {
			return $exception->get_response_object(2008);
		}

		$stmt = $mysqli->prepare(query_list::query_command);
		$stmt->bind_param("dsss", $status, $uuid, $device_id, $device_key);
		$stmt->execute();
		$stmt->store_result();

		// if ($stmt->num_rows() == 0) {
		// 	//
		// }

		$stmt = $mysqli->prepare(query_list::query_device_wanted_status);
		$stmt->bind_param("sss", $uuid, $device_id, $device_key);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($wanted_status);
		$stmt->fetch();

		$returnObject = array(
			"result" => "success",
			"wanted_status" => $wanted_status
		);

		return $returnObject;
	}

	/**
	 * 获取用户设备列表
	 */
	function get_device_lists($openID) {
		global $exception, $mysqli;

		if (!isset($openID) || !$openID) {
			return $exception->get_response_object(2009);
		}

		$stmt = $mysqli->prepare(query_list::query_device_lists);
		$stmt->bind_param("s", $openID);
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
	function sign_up_user($username, $password, $password_again) {
		global $exception, $mysqli;
		
		$username = strtolower($username);

		if (!$username) {
			return $exception->get_response_object(2000);
		}

		if (!$password || !$password_again) {
		   return $exception->get_response_object(2001);
		}

		if ($password != $password_again) {
			return $exception->get_response_object(2002);
		}

		if (strlen($password) < 6 || strlen($password_again) < 6) {
			return $exception->get_response_object(2003);
		}

		if (!check_email_validation($username)) {
			return $exception->get_response_object(2004);
		}

		$stmt = $mysqli->prepare(query_list::query_user_exists);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
		// $query_result = $stmt->fetch();

		if ($stmt->num_rows() >= 1) {
			return $exception->get_response_object(2005);
		}

		$nickname = ucfirst(explode("@", $username)[0]);
		$password = md5($password);
		$ip_address = get_user_ip_address();

		$stmt->close();
		$stmt = $mysqli->prepare(query_list::query_append_user);
		$stmt->bind_param("ssss", $username, $nickname, $password, $ip_address);
		$stmt->execute();

		$returnObject = array(
			"result" => "success"
		);

		$stmt->close();
		$mysqli->close();

		return $returnObject;
	}


















	
	function getChartsDataSubjectsBar() {
		$subject_names_7 = array();
		$subject_names_8 = array();
		$subject_names_9 = array();
		$subject_counts_7 = array();
		$subject_counts_8 = array();
		$subject_counts_9 = array();

		$query_subject_counts = 
								"SELECT
									`subject`,
									COUNT(*) AS total
								FROM
									rc_recorders
								WHERE
									grade_number = '%u'
								AND class_number != 0
								AND date >= '%s'
								AND date <= '%s'
								GROUP BY
									`subject`
								ORDER BY
									sub_index";

		list($start_date, $end_date) = getStartEndDate();

		$result = mysql_query(sprintf($query_subject_counts, 7, $start_date, $end_date));

		while ($row = mysql_fetch_assoc($result)) {
			$subject_names_7[] = $row['subject'];
			$subject_counts_7[] = $row['total'];
		}

		$result = mysql_query(sprintf($query_subject_counts, 8, $start_date, $end_date));

		while ($row = mysql_fetch_assoc($result)) {
			$subject_names_8[] = $row['subject'];
			$subject_counts_8[] = $row['total'];
		}

		$result = mysql_query(sprintf($query_subject_counts, 9, $start_date, $end_date));

		while ($row = mysql_fetch_assoc($result)) {
			$subject_names_9[] = $row['subject'];
			$subject_counts_9[] = $row['total'];
		}

		$returnObject = array(
			"result" => "success",
			"xAxis" => array(
				"data" => array(
					"grade_7" => $subject_names_7,
					"grade_8" => $subject_names_8,
					"grade_9" => $subject_names_9
				)
			),
			"series" => array(
				"data" => array(
					"grade_7" => $subject_counts_7,
					"grade_8" => $subject_counts_8,
					"grade_9" => $subject_counts_9
				)
			)
		);

		mysql_free_result($result);
		mysql_close();

		return $returnObject;
	}

	function getChartsDataSubjectsPie() {
		$not_selected = array();

		$query_subject_counts = 
								"SELECT
									`subject`,
									COUNT(*) AS total
								FROM
									rc_recorders
								WHERE
									date >= '%s'
								AND date <= '%s'
								AND class_number != 0
								GROUP BY
									`subject`
								ORDER BY
									sub_index";

		list($start_date, $end_date) = getStartEndDate();
		
		$result = mysql_query(sprintf($query_subject_counts, $start_date, $end_date));

		while ($row = mysql_fetch_assoc($result)) {
			if ($row['total'] <= 300) {
				$not_selected[$row['subject']] = false;
			}

			$series_data[] = array(
				"value" => $row['total'],
				"name" => $row['subject']
			);
		}

		$subjects = getSubjects();

		$returnObject = array(
			"result" => "success",
			"legend" => array(
				"data" => $subjects,
				"selected" => $not_selected
			),
			"series" => array(
				"data" => $series_data
			)
		);

		mysql_free_result($result);
		mysql_close();
		
		return $returnObject;
	}

	function getChartsDataGradesPie() {
		$grade_counts_7 = array();
		$grade_counts_8 = array();
		$grade_counts_9 = array();

		$query_grade_counts = 
								"SELECT
									grade_number AS grade,
									COUNT(*) AS total
								FROM
									rc_recorders
								WHERE
									date >= '%s'
								AND date <= '%s'
								GROUP BY
									grade_number";

		list($start_date, $end_date) = getStartEndDate();

		$result = mysql_query(sprintf($query_grade_counts, $start_date, $end_date));

		while ($row = mysql_fetch_assoc($result)) {
			switch ($row['grade']) {
				case "7":
					$grade_counts_7 = array(
						"value" => $row['total'],
						"name" => "初一年级"
					);

					break;
				case "8":
					$grade_counts_8 = array(
						"value" => $row['total'],
						"name" => "初二年级"
					);

					break;
				case "9":
					$grade_counts_9 = array(
						"value" => $row['total'],
						"name" => "初三年级"
					);

					break;
			}
		}

		$returnObject = array(
			"result" => "success",
			"series" => array(
				"data" => array(
					$grade_counts_7,
					$grade_counts_8,
					$grade_counts_9
				)
			)
		);

		mysql_free_result($result);
		mysql_close();
		
		return $returnObject;
	}

	function getRecorders($start_date, $end_date, $name, $sub_index, $class_number, $grade_number) {
		if (!$name) {$name = "%";}
		if (!$sub_index) {$sub_index = "%";}
		if (!$class_number) {$class_number = "%";}
		if (!$grade_number) {$grade_number = "%";}

		list($start_date_all, $end_date_all) = getStartEndDate();

		if (!$start_date) {
			$start_date = $start_date_all;
		} else {
			$start_date = validate_start_date($start_date);
		}

		if (!$end_date) {
			$end_date = $end_date_all;
		} else {
			$end_date = validate_end_date($end_date);
		}

		$count = 0;
		$record_lists = array();

		$query_recorders = 
							"SELECT
								`name`,
								`subject`,
								grade_name,
								class_name,
								`date`,
								lesson_order
							FROM
								rc_recorders
							INNER JOIN rc_grades ON rc_recorders.grade_number = rc_grades.grade_number
							WHERE
								`name` LIKE '%s'
							AND `sub_index` LIKE '%s'
							AND class_number LIKE '%s'
							AND rc_recorders.grade_number LIKE '%s'
							AND `date` >= '%s'
							AND `date` <= '%s'
							AND class_number != 0
							ORDER BY
								`date`";

		$result = mysql_query(sprintf($query_recorders, $name, $sub_index, $class_number, $grade_number, $start_date, $end_date));

		while ($row = mysql_fetch_assoc($result)) {
			$list = array(
				"id" => ++$count,
				"name" => $row['name'],
				"subject" => $row['subject'],
				"grade_name" => $row['grade_name'],
				"class_name" => $row['class_name'],
				"date" => $row['date'],
				"lesson_order" => $row['lesson_order']
			);

			$record_lists[] = $list;
		}

		$returnObject = array(
			"lists" => $record_lists
		);

		mysql_free_result($result);
		mysql_close();
		
		return $returnObject;
	}











	function getStartEndDate() {
		$result = mysql_query(
								"SELECT
									`date`
								FROM
									rc_recorders
								WHERE
									`date` = (
										SELECT
											MAX(`date`)
										FROM
											rc_recorders
									)
								OR `date` = (
									SELECT
										MIN(`date`)
									FROM
										rc_recorders
								)
								ORDER BY
									`date`"
		);

		$start_date = mysql_fetch_assoc($result)['date'];
		$end_date = mysql_fetch_assoc($result)['date'];

		mysql_free_result($result);

		$start_date = date("Y-m-d 00:00:00", strtotime($start_date));
		$end_date = date("Y-m-d 23:59:59", strtotime($end_date));
		$now = date("Y-m-d H:i:s");

		if ($end_date > $now) {
			$end_date = $now;
		}

		$result_date[] = $start_date;
		$result_date[] = $end_date;

		return $result_date;
	}

	function validate_start_date($start_date) {
		$start_date = date("Y-m-d 00:00:00", strtotime($start_date));

		return $start_date;
	}

	function validate_end_date($end_date) {
		$end_date = date("Y-m-d 23:59:59", strtotime($end_date));
		$now = date("Y-m-d H:i:s");

		if ($end_date > $now) {
			$end_date = $now;
		}

		return $end_date;
	}

	function getSubjects($need_count = false, $need_format = false) {
		if (!$need_count) {$need_count = false;}
		if (!$need_format) {$need_format = false;}

		$subjects = array();

		$result = mysql_query(
								"SELECT
									id,
									`subject`
								FROM
									rc_subjects"
		);

		while ($row = mysql_fetch_assoc($result)) {
			if ($need_format) {
				if (count($subjects) % 2 != 0) {
					$subjects[] = "\n" . $row['subject'];
				} else {
					$subjects[] = $row['subject'];
				}
			} else {
				if ($need_count) {
					$subjects[] = array(
						"id" => $row['id'],
						"subject" => $row['subject']
					);
				} else {
					$subjects[] = $row['subject'];
				}
			}
		}

		return $subjects;
	}

	function getGrades() {
		$grades = array();

		$result = mysql_query(
								"SELECT
									grade_number AS id,
									grade_name AS grade
								FROM
									rc_grades"
		);

		while ($row = mysql_fetch_assoc($result)) {
			$grades[] = array(
				"id" => $row['id'],
				"grade" => $row['grade']
			);
		}

		return $grades;
	}

	function getClasses() {
		$classes = array();

		$result = mysql_query(
								"SELECT
									grade_number AS grade,
									class_number AS id,
									class_name AS class
								FROM
									rc_recorders
								WHERE
									class_number != 0
								GROUP BY
									class_name
								ORDER BY
									grade_number,
									class_number");

		while ($row = mysql_fetch_assoc($result)) {
			$classes[] = array(
				"grade" => $row['grade'],
				"id" => $row['id'],
				"class" => $row['class']
			);
		}

		return $classes;
	}




























	function getRecordersAll() {
		$class_lists = array();
		
		$result = mysql_query("SELECT
									records.tcr_card,
									records.tcr_name,
									teacher.te_remark,
									ccinfo.cc_devName,
									ccinfo.cc_className,
									records.tcr_updatetime,
									cinfo.ct_Index
								FROM
									te_card_record AS records
								LEFT JOIN cs_classroom AS ccinfo ON records.tcr_device = ccinfo.cc_DevID
								LEFT JOIN te_teacher AS teacher ON records.tcr_name = teacher.te_teacherName
								AND records.tcr_card = teacher.te_number
								INNER JOIN te_classtime AS cinfo ON DATE_FORMAT(
									records.tcr_updatetime,
									'%H:%i:%s'
								) BETWEEN cinfo.ct_starttime
								AND cinfo.ct_endtime
								WHERE
									records.tcr_name != '未知'
								ORDER BY
									records.tcr_updatetime ASC"
							);

		$count = 0;

		while ($row = mysql_fetch_assoc($result)) {
			$list = array(
				"id" => ++$count,
				"cardNumber" => $row['tcr_card'],
				"userName" => $row['tcr_name'],
				"teachName" => $row['te_remark'],
				"className" => empty($row["cc_className"]) ? '' : $row['cc_className'] . " (" . $row['cc_devName'] . ")",
				"date" => $row['tcr_updatetime'],
				"lessionsOrder" => $row['ct_Index']
			);

			$class_lists[] = $list;
		}

		$returnObject = array(
			"lists" => $class_lists
		);

		return $returnObject;
	}

	function getRecord() {
		//if (!$deleted) {$deleted = false;}
		
		$record_lists = array();

		//$deleted = $deleted ? "" : "where Deleted=false";
		//$result = mysql_query("select * from `userinfo` where Deleted='$deleted' order by ID desc");
		$result = mysql_query("select * from `recorders` order by ID asc");

		$count = 0;
		
		while ($row = mysql_fetch_assoc($result)) {
			$list = array(
				"id" => ++$count,
				"cardNumber" => $row['CardNumber'],
				"pin" => $row['PIN'],
				"className" => $row['ClassName'],
				"verifyType" => $row['VerifyType'],
				"doorId" => $row['DoorId'],
				"eventType" => $row['EventType'],
				"state" => $row['State'],
				"date" => $row['Date']
			);

			$record_lists[] = $list;
		}

		$returnObject = array(
			"lists" => $record_lists
		);

		return $returnObject;
	}
?>