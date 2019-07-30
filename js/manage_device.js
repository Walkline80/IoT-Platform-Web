"use strict";

$(document).ready(function () {
	app.init();
});

var app = {
	const: {
		dom_datatable: $('#datatable')
		// dom_output: $('#output'),
		// dom_output_text: $('#output_text'),
		
		// ip_group: '#ip_group',
		// class_name_group: '#className_group',

		// button_modify_device: $('#btnDeviceModify'),
		// button_delete_device: $('#btnDeviceDelete'),
		// button_search_device: $('#btnDeviceSearch'),
		// button_sync_device_params: $('#btnSyncDeviceParams'),

		// button_dialog_do_modify: '#btnDoModify',
		// button_dialog_do_delete: '#btnDoDelete',

		// text_id: '#txtID',
		// text_mac: '#txtMAC',
		// text_ip: '#txtIP',
		// text_serial_number: '#txtSerialNumber',
		// text_version: '#txtVersion',
		
		// dialog_modal_modify_device: $('#modifyDeviceDialog'),
		// dialog_modal_delete_device: $('#deleteDeviceDialog'),
		// dialog_modal_search_device: $('#searchDeviceDialog'),
		// // dialog_modal_batch_modify_ip: $('#batchModifyDeviceIpDialog'),

		// dialog_status_modify_device: '#modifyDeviceStatus',
		// dialog_status_search_device: '#searchDeviceStatus',
		// dialog_status_delete_device: '#deleteDeviceStatus'
	},

	datatable: {},

	init: function () {
		app.viewer.init();
		// app.controller.init();
	}
};

app.controller = {
	init: function () {
		this._bind_datatable_click_event();
		this._bind_datatable_dblclick_event();
		this._bind_sync_params_button_click_event();
		this._bind_output_close_event();
	},

	appendText: function (newString) {
		var output = app.const.dom_output_text;
	
		output.val(output.val() + newString + "\r\r");
		output.scrollTop(output[0].scrollHeight);  
	},

	_bind_output_close_event: function () {
		$('.tip').on('click', function () {
			app.const.dom_output_text.val('');
			app.const.dom_output.hide();
		});
	},

	_bind_sync_params_button_click_event: function () {
		app.const.button_sync_device_params.on('click', function () {
			app.const.dom_output.show();
			app.const.dom_output_text.val('');
			$(document).scrollTop(app.const.dom_output.offset().top);
			
			app.controller.appendText("正在下发教师数据...");
	
			$.each(app.datatable.rows().data(), function (index, row) {
				if ($.trim(row['className']) == "") {
					app.controller.appendText("设备 (" + row['IP'] + ")：所在班级名称未设置，无法同步参数！");
	
					return true;
				}
	
				$(document).queue("ajaxRequests", function () {
					$.post(WEBSERVICEURI + "sync_params", {ip: row['IP'], className: row['className']}, function (result) {
						app.controller.appendText(result.output);
	
						$(document).dequeue("ajaxRequests");
					})
				});
			});
	
			$(document).queue("ajaxRequests", function () {
				app.controller.appendText("下发教师数据完成");
			})
	
			$(document).dequeue("ajaxRequests");
		});
	},

	_bind_delete_device_button_click_event: function () {
		app.const.button_delete_device.on('click', function (e) {
			if ($(this).hasClass('disabled')) {return;}

			var currentRow = app.datatable.rows('.selected').data()[0];
			
			app.const.dialog_modal_delete_device.on('show.bs.modal', function () {
				$(app.const.text_id).val(currentRow['id']);

				$(this).find('.control-label').html("确认删除设备 " + currentRow['IP'] + " （" +currentRow['className'] + "） 吗？");
				$(this).css("overflow", "hidden");
				
				centerModals('#deleteDeviceDialog');
			});

			app.const.dialog_modal_delete_device.on('hidden.bs.modal', function () {
				$(app.const.dialog_status_delete_device).html("");
				$(app.const.button_dialog_do_delete).off('click');
				$(this).off('show.bs.modal');
			});
			
			app.const.dialog_modal_delete_device.modal({
				backdrop: "static"
			});

			app.controller.__bind_dialog_do_delete_click_event();
		});
	},

	__bind_dialog_do_delete_click_event: function () {
		$(app.const.button_dialog_do_delete).on('click', function () {
			var id = $(app.const.text_id).val();

			$.post(DATABASESERVICEURI + "delete_device", {id: id}, function (result) {
				if (!result.error_code) {
					if (result.result === "success") {
						app.controller._reload_datatable();
					}
				} else {
					$(app.const.dialog_status_delete_device).html(result.error_msg);
				}
			});
		});
	},

	_bind_search_device_button_click_event: function () {
		app.const.button_search_device.on('click', function () {
			if ($(this).hasClass('disabled')) {return;}

			app.const.button_search_device.addClass('disabled');

			app.const.dialog_modal_search_device.on('show.bs.modal', function () {
				$(this).css("overflow", "hidden");
				
				centerModals('#searchDeviceDialog');
			});

			app.const.dialog_modal_search_device.on('shown.bs.modal', function () {
				$.post(WEBSERVICEURI + "search_device", {}, function (result) {
					if (!result.error_code) {
						if (result.result === "success") {
							app.controller._reload_datatable();
						} 
					} else {
						$(app.const.dialog_status_search_device).html(result.error_msg);
					}
				});
			});

			app.const.dialog_modal_search_device.on('hidden.bs.modal', function () {
				$(app.const.dialog_status_search_device).html("");
				app.const.button_search_device.removeClass('disabled');
				$(this).off('shown.bs.modal');
				$(this).off('show.bs.modal');
			});

			app.const.dialog_modal_search_device.modal({
				backdrop: "static"
			});
		});
	},

	_bind_modify_device_button_click_event: function () {
		app.const.button_modify_device.on('click', function (e) {
			if ($(this).hasClass('disabled')) {return;}

			var currentRow = app.datatable.rows('.selected').data()[0];

			app.const.dialog_modal_modify_device.on('show.bs.modal', function () {
				$(this).css("overflow", "hidden");
				
				$(app.const.ip_group).removeClass('error');
				$(app.const.class_name_group).removeClass('error');

				$(app.const.text_id).val(currentRow['id']);
				$(app.const.text_mac).val(currentRow['MAC']);
				$(app.const.text_ip).val(currentRow['IP']);
				$(app.const.text_serial_number).val(currentRow['serialNumber']);
				$(app.const.text_version).val(currentRow['version']);

				$.each($('.select').find("option"), function () {
					if ($(this)[0].value === currentRow['classCode']) {
						$(this).prop("selected", "selected");

						return false;
					} else {
						$('.select')[0].selectedIndex = 0;
					}
				});

				$(app.const.dialog_status_modify_device).html('');
				
				centerModals('#modifyDeviceDialog')
			});

			app.const.dialog_modal_modify_device.on('shown.bs.modal', function () {
				$(app.const.text_ip).focus();
			});

			app.const.dialog_modal_modify_device.on('hidden.bs.modal', function () {
				$(app.const.button_dialog_do_modify).off('click');
				$(this).off('show.bs.modal');
				$(this).off('hidden.bs.modal');
			});
			
			app.const.dialog_modal_modify_device.modal({
				backdrop: "static"
			});

			app.controller.__bind_text_ip_keypress_event();
			app.controller.__bind_dialog_do_modify_click_event();
		});
	},

	__bind_dialog_do_modify_click_event: function () {
		$(app.const.button_dialog_do_modify).on('click', function () {
			var id = $(app.const.text_id).val();
			var ip = $(app.const.text_ip).val();
			var mac = $(app.const.text_mac).val();
			var currentSelection = $('select')[0].value;

			$(app.const.ip_group).removeClass('error');
			$(app.const.class_name_group).removeClass('error');
			$(app.const.dialog_status_modify_device).html('');

			if ($.trim(ip) == "") {
				$(app.const.ip_group).addClass('error');
				$(app.const.text_ip).focus();
			} else if (currentSelection == 0) {
				$(app.const.class_name_group).addClass('error');
				$('select').focus();
			} else {
				$.post(WEBSERVICEURI + "modify_ip", {id: id, mac: mac, ip: ip, classID: currentSelection}, function (result) {
					if (!result.error_code) {
						if (result.result === "success") {
							app.controller._reload_datatable();
						}
					} else {
						$(app.const.dialog_status_modify_device).html(result.error_msg);
					}
				});
			}
		});
	},

	__bind_text_ip_keypress_event: function () {
		$(app.const.text_ip).keypress(function(e) {
			if (!String.fromCharCode(e.keyCode).match(/[0-9\.]/)) {
				return false;
			}
		});
	},

	_bind_datatable_click_event: function () {
		app.const.dom_datatable.find('tbody').on('click', 'tr', function (e) {
			if (!app.datatable.row(this).data()) {return;}
			
			if ($(this).hasClass('selected')) {
				$(this).removeClass('selected');
				app.const.button_modify_device.addClass('disabled');
				app.const.button_delete_device.addClass('disabled');
			} else {
				app.const.dom_datatable.find('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				app.const.button_modify_device.removeClass('disabled');
				app.const.button_delete_device.removeClass('disabled');
			}
		});
	},

	_bind_datatable_dblclick_event: function () {
		app.const.dom_datatable.find('tbody').on('dblclick', 'tr', function (e) {
			if (!app.datatable.row(this).data()) {return;}
			
			$(this).addClass('selected');
			app.const.button_modify_device.removeClass('disabled');
			app.const.button_delete_device.removeClass('disabled');
			
			app.const.button_modify_device.click();
		});
	},

	_reload_datatable: function () {
		app.const.dialog_modal_modify_device.modal('hide');
		app.const.dialog_modal_search_device.modal('hide');
		app.const.dialog_modal_delete_device.modal('hide');

		app.datatable.ajax.reload();

		app.const.button_modify_device.addClass('disabled');
		app.const.button_delete_device.addClass('disabled');
	}
};

app.viewer = {
	init: function () {
		this._init_datatable();
		// this._init_modal_dialog();
		// this._fill_classes_options();
	},

	_init_modal_dialog: function () {
		app.const.dialog_modal_modify_device.load('interface/dialogs/modifyDeviceDialog', function () {
			app.controller._bind_modify_device_button_click_event();
		}).draggable();
		app.const.dialog_modal_delete_device.load('interface/dialogs/deleteDeviceDialog', function () {
			app.controller._bind_delete_device_button_click_event();
		}).draggable();
		app.const.dialog_modal_search_device.load('interface/dialogs/searchDeviceDialog', function () {
			app.controller._bind_search_device_button_click_event();
		}).draggable();
		// app.const.dialog_modal_batch_modify_ip.load('interface/dialogs/batchDeviceModifyIpDialog', function () {

		// }).draggable();
	},

	_init_datatable: function () {
		app.datatable = app.const.dom_datatable.DataTable({
			"lengthChange": false,
			"searching": false,
			"jQueryUI": true,
			"ordering": false,
			"info": false,
			"pageLength": 15,
			"pagingType": "full_numbers",
			"language": {
				"paginate": {
					"first": "首页",
					"previous": "上一页",
					"next": "下一页",
					"last": "尾页"
				},
				"sSearch": "搜索:",
				"sLoadingRecords": "努力读取中...",
				"sEmptyTable": "没找到符合条件的数据",
				"sZeroRecords": "没有匹配结果"
			},
			"serverSide": false,
			"ajax": {
				"url": Const.PLATFORM_API_URI + Const.Commands.get_device_lists,
				"type": "post",
				"dataSrc": 'lists'
			},
			"columns": [
				{"data": 'key', "className": 'center'},
				{"data": 'secret', "className": 'center'},
				{"data": 'type', "className": 'center'},
				{"data": 'date', "className": 'center'},
				{"data": 'online_date', "className": 'center'},
				{"data": 'status', "className": 'center'},
				{"data": 'aligenie_enabled', "className": 'center'}
			]
		});
	},

	_fill_classes_options: function () {
		var options = '<option value="0">选择班级名称</option>\n';

		$.get(DATABASESERVICEURI + "get_classes", {}, function (result) {
			$.each(result.lists, function (index, list) {
				options += '<option value="' + list.id + '">' + list.className + " (" + list.roomNumber + ")" + '</option>\n';
			});

			$('.select').html(options);
		});
	}
};
