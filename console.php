<?php
	include_once('inc/connect2db.php');

	session_set_cookie_params(24 * 3600 * 365, "/");
	session_start();

	$page = "dashboard";

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}

	if (!file_exists("interface/console/{$page}.html")) {
		header ("Location: /console.php");
	}

	check_validation($page);

	function check_validation($page) {
		if (!isset($_SESSION['userinfo']) || !isset($_SESSION['userinfo']['uuid'])) {
			header("Location: /");
		} else {
			load_pages($page);
		}
	}

	function load_pages($page) {
		$output = file_get_contents("interface/console/{$page}.html");

		// if (!isset($_SESSION['userinfo']) || !isset($_SESSION['userinfo']['uuid'])) {
		// 	$output = str_replace("###NAVBAR###", sign_up_code, $output);
		// 	$output = str_replace("###SHOWHIDE###", "", $output);
		// } else {
		// 	$output = str_replace("###NAVBAR###", log_out_code, $output);
		// 	$output = str_replace("###SHOWHIDE###", "style='display:none;'", $output);
		// }

		echo $output;
	}
?>