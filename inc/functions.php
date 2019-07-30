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

	function get_url_data($url, $param='') {
        ini_set("max_execution_time", 100);
        $curl = curl_init();

		if (is_array($param)) {
			$param = http_build_query($param);
		}

		$options = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url . $param,
			CURLOPT_CONNECTTIMEOUT => 90,
			CURLOPT_TIMEOUT => 90,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_SSL_VERIFYPEER => false
		);

		curl_setopt_array($curl, $options);

		$res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
?>