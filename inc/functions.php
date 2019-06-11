<?php
	function check_email_validation($email) {
		$pattern = "/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";

		if (preg_match($pattern, $email)) {
			return true;
		} else {
			return false;
		}
	}

	function get_user_ip_address() {
		$user_ip = @$_SERVER["HTTP_VIA"] ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
		$user_ip = $user_ip ? $user_ip : $_SERVER["REMOTE_ADDR"];

		return $user_ip;
	}
?>