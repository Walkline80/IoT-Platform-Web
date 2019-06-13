<?php
	class api_error
	{
		public function get_response_object($error_code) {
			$error_msg = "";
			$returnObject = array();

			switch ($error_code) {
				case 2000:
					$error_msg = "用户名不能为空！";
					break;
				case 2001:
					$error_msg = "密码不能为空！";
					break;
				case 2002:
					$error_msg = "两次输入的密码不一致！";
					break;
				case 2003:
					$error_msg = "密码长度不能小于6个字符！";
					break;
				case 2004:
					$error_msg = "邮箱格式不正确！";
					break;
				case 2005:
					$error_msg = "用户已存在！";
					break;
				case 2006:
					$error_msg = "用户不存在，或密码不正确！";
					break;
			}

			$returnObject = array(
				"error_code" => $error_code,
				"error_msg" => $error_msg
			);

			return $returnObject;
		}
	}
?>