<?php
	include_once('inc/connect2db.php');

	$page = "signup";

	load_pages($page);

	function load_pages($page) {
		$output = file_get_contents("interface/{$page}.html");

		echo $output;
	}
?>