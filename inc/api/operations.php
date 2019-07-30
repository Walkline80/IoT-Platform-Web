<?php
	class Operations {
		const Login = 1;
		const Device  = 2;
		const Control = 3;
		const Data = 4;
		const Remote = 5;
	}

	class Login {
		const log_in = 1;
		const log_out = 2;
		const unregisted_or_wrong_password = 3;
		const forbidden = 4;
	}
?>