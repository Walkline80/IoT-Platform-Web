<?php
	include_once('inc/connect2db.php');

	session_set_cookie_params(24 * 3600 * 365, "/");
	session_start();

	const sign_up_code =
		'<nav class="navbar navbar-dark bg-dark">
			<a class="navbar-brand mb-0 h1" href="/">走线物联</a>

			<span class="navbar-text">还没注册？<a href="./signup.php">马上注册</a></span>
		</nav>';
	
	const log_out_code =
		'<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand mb-0 h1" href="/">走线物联</a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarNav">
				<div class="navbar-nav mr-auto">
					<a class="nav-item nav-link" href="console.php">我的控制台</a>
					<a class="nav-item nav-link" href="#" id="logout">退出</a>
				</div>
			</div>
		</nav>';
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