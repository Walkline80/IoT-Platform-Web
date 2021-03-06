'use strict';

$(document).ready(function () {
	app.init();
});

var app = {
	controls: {
		text_sign_in_username: $("#sign_in_username"),
		text_sign_in_password: $("#sign_in_password"),

		button_sign_in: $("#signin"),
		button_log_out: $("#logout")
	},

	init: function () {
		this._bind_sign_in_click_event();
		this._bind_log_out_click_event();
		this._setup_toastr();
	},

	_bind_log_out_click_event: function () {
		this.controls.button_log_out.on('click', function () {
			$.post(Const.PLATFORM_API_URI + Const.Commands.log_out_user, {}, function (result) {
				if (!result.error_code) {
					location.href = "/";
				}
			});
		});
	},

	_bind_sign_in_click_event: function () {
		var that = this;

		that.controls.button_sign_in.on('click', function () {
			if (that._check_controls_is_not_empty()) {
				$.post(Const.PLATFORM_API_URI + Const.Commands.sign_in_user, {
					username: that.controls.text_sign_in_username.val(),
					password: $.md5(that.controls.text_sign_in_password.val())
				}, function (result) {
					if (!result.error_code) {
						location.href = "/";
					} else {
						toastr.warning("错误：" + result.error_msg);
					}
				});
			}
		});
	},

	_setup_toastr: function () {
		toastr.options.positionClass = "toast-bottom-center";
		toastr.options.timeOut = 3000;
	},

	_check_controls_is_not_empty: function () {
		var result = true;
		var username = this.controls.text_sign_in_username.val(),
			password = this.controls.text_sign_in_password.val();

		if (username === "") {
			alert("用户名不能为空！");

			result = false;
		} else if (password === "") {
			alert("密码不能为空！");

			result = false;
		}

		return result;
	},
};