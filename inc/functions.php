<?php
	function check_email_validation($email) {
		$pattern = "/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";

		if (preg_match($pattern, $email)) {
			return true;
		} else {
			return false;
		}
	}
?>