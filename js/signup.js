'use strict';

$(document).ready(function () {
	app.init();
});

var app = {
	controls: {
		text_sign_up_username: $("#sign_up_username"),
		text_sign_up_password: $("#sign_up_password"),
		text_sign_up_password_again: $("#sign_up_password_again"),
	
		button_sign_up: $("#signup")
	},

	init: function() {
		this._bind_sign_up_click_event();
		this._setup_toastr();
	},

	_bind_sign_up_click_event: function () {
		var that = this;

		that.controls.button_sign_up.on('click', function () {
			if (that._check_controls_is_not_empty_or_not_equals()) {
				if (that._check_email_validation()) {
					// alert("check email success");
					$.post(Const.API_URI + Const.Commands.sign_up_user, {
						username: that.controls.text_sign_up_username.val(),
						password: that.controls.text_sign_up_password.val(),
						password_again: that.controls.text_sign_up_password_again.val()
					}, function (result) {
						if (!result.error_code) {
							toastr.options.onHidden = function () {
								location.href = "/";
							}
							toastr.success('恭喜，注册成功！');
						} else {
							toastr.warning("错误：" + result.error_msg);
						}
					});
				}
			}
		});
	},

	_setup_toastr: function () {
		toastr.options.positionClass = "toast-bottom-center";
		toastr.options.timeOut = 3000;
	},

	_check_controls_is_not_empty_or_not_equals: function () {
		var result = true;
		var username = this.controls.text_sign_up_username.val(),
			password = this.controls.text_sign_up_password.val(),
			password_again = this.controls.text_sign_up_password_again.val();

		if (username === "") {
			alert("用户名不能为空！");

			result = false;
		} else if (password === "" || password_again === "") {
			alert("密码不能为空！");

			result = false;
		} else if (password !== password_again) {
			alert("两次输入的密码不一致！");

			result = false;
		} else if (password.length < 6 || password_again.length < 6) {
			alert("密码长度不能少于6个字符！");

			result = false;
		}

		return result;
	},

	_check_email_validation: function () {
		var result = true;
		var email_reg = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;

		if (email_reg.test(this.controls.text_sign_up_username.val()) == false) {
			alert("邮箱格式不正确！");

			result = false;
		}

		return result;
	}
};