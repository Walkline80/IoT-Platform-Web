<?php
	include_once('inc/connect2db.php');

	session_set_cookie_params(24 * 3600 * 365, "/");
	session_start();

	define("sign_up_code", file_get_contents("interface/snippet/index_sign_up.html"));	
	define("log_out_code", file_get_contents("interface/snippet/index_log_out.html"));
	// <span class="navbar-text">Hello, World</span>

	$page = "index";

	load_pages($page);

	function load_pages($page) {
		$output = file_get_contents("interface/{$page}.html");

		if (!isset($_SESSION['userinfo']) || !isset($_SESSION['userinfo']['uuid'])) {
			$output = str_replace("###NAVBAR###", sign_up_code, $output);
			$output = str_replace("###SHOWHIDE###", "", $output);
		} else {
			$output = str_replace("###NAVBAR###", log_out_code, $output);
			$output = str_replace("###SHOWHIDE###", "style='display:none;'", $output);
		}

		echo $output;
	}
?>