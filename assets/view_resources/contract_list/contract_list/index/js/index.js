var _CURRENT_DATE_ = moment().format('YYYY-MM-DD');

var data_to_calculate_is_change_without_calculate = false;
var data_to_calculate_is_change_without_calculate_show_text = '';
var data_criterai_export = null;

var array_table_payment_period = null;

var string_log_warranty = '';
var string_log_maintenance = '';

var process_type_contract = null;

var array_warranty_remark = new Array();
var array_maintenance_remark = new Array();

jQuery(document).ready(function() {
	array_table_payment_period = [jQuery('#table-payment-period-hardware'),
					jQuery('#table-payment-period-software')];

	data_to_calculate_is_change_without_calculate_show_text 
		= app.translate('data_to_calculate_is_change_without_calculate_');

	page.list_data();

	page.init_save_contract();

	page.init_datetimepicker_payment_period();

	page.init_period_payment_percent_value();

	conditions_for_maintenance_.init_create_new_element();

	jQuery('#contract-fine-table').tableAutoRow({
		showSequence: false
	});

	jQuery('#table-payment-period-hardware, #table-payment-period-software').tableAutoRow({
		afterNewRow: function(row) {
			page.init_datetimepicker_payment_period();

			var new_row = jQuery(row);
			var table = new_row.closest('table');

			table.find('tbody tr').eq(-1).find('td').eq(0).html('');

			modal_contract_edit_.sequential_calculate_period_payment('percent_value');
		},
		afterAutoRemove: function (index, table) {
			var table = jQuery(table);

			table.find('tbody tr').eq(-1).find('td').eq(0).html('');
        }
	});

	jQuery('#modal-contract-edit .modal-body').css({
        'height': (jQuery(window).height() * 60) / 78, // /100
        'overflow-x': 'auto',
        'overflow-y': 'auto'
    });

	page.init_datetimepicker();

	page.init_search_data();

	jQuery('#modal-contract-edit').on('show.bs.modal', function () {
		setTimeout(function() {
			jQuery("#modal-contract-edit .modal-body").scrollTop(0);
		}, 500);
		modal_contract_edit_.remove_required_error_input(jQuery('form[name="edit_form"]'));

	    modal_contract_edit_.init_display_text_data();

	    data_to_calculate_is_change_without_calculate = false;
	    page.show_change_without_calculate('remove');
	});

	jQuery('#new-contract .to-new-contract').click(function() {
		var this_element = jQuery(this);
		process_type_contract = this_element.attr('process-type-contract');

		app.clear_form_data(jQuery('form[name="edit_form"]'));

		modal_contract_edit_.set_contract_type_for_process_type_contract();
		modal_contract_edit_.set_something_for_process_type_contract_ma();

		modal_contract_edit_.clear_conditions_for_maintenance_input();
		modal_contract_edit_.clear_contract_fine_input();
		modal_contract_edit_.clear_data_table_calculate_warranty();
		modal_contract_edit_.clear_data_table_calculate_maintenance();
		modal_contract_edit_.render_empty_last_tr_for_hardware_software();
		modal_contract_edit_.reset_datepicker();

		jQuery('#total-payment-percent-text, #total-payment-value-text').html('0.00');

		jQuery('#modal-contract-edit [name="id"]').val('');

		jQuery('#modal-contract-edit #detail-dropdown-export').addClass('hide');

		jQuery('#modal-contract-edit').modal('show');

		page.init_datetimepicker_payment_period();
	});

	jQuery('table#table-list').on('dblclick', 'tbody tr', function() {
		var this_tr = jQuery(this);
		var p_type_contract = this_tr.find('span[process-type-contract]').attr('process-type-contract');

		process_type_contract = p_type_contract;

		modal_contract_edit_.set_contract_type_for_process_type_contract();
		modal_contract_edit_.set_something_for_process_type_contract_ma();

		modal_contract_edit_.get_contract_data(this_tr.find('span').attr('data-id'));
		jQuery('#modal-contract-edit #detail-dropdown-export').removeClass('hide');
	});

	jQuery('#modal-contract-edit').on('blur', '[name="conditions_for_maintenance[]"]', function() {
		conditions_for_maintenance_.remove_empty_data();
	});

	jQuery('#modal-contract-edit [name="warranty"], '
		+ '#modal-contract-edit [name="warranty_range"], '
		+ '#modal-contract-edit [name="warranty_total_month"], '
		+ '#modal-contract-edit [name="maintenance"], '
		+ '#modal-contract-edit [name="maintenance_range"], '
		+ '#modal-contract-edit [name="maintenance_total_month"]').keyup(function() {
		modal_contract_edit_.init_display_text_data();
	});

	jQuery('#modal-contract-edit [name="warranty"], #modal-contract-edit [name="warranty_range"], #modal-contract-edit [name="warranty_total_month"], '
		+ '#modal-contract-edit [name="maintenance"], #modal-contract-edit [name="maintenance_range"], #modal-contract-edit [name="maintenance_total_month"]').change(function() {
		//modal_contract_edit_.calculate_warrany_detail_pre_process();

		data_to_calculate_is_change_without_calculate = true;
		page.show_change_without_calculate('show');
	});


	jQuery('#calculate-warranty').click(function() {
		modal_contract_edit_.calculate_warrany_detail_pre_process();
	});

	jQuery('#export-data-excel').click(function(e) {
		export_data.excel();
	});

	jQuery('#export-data-detail-excel').click(function() {
		export_data.excel_modal();
	});

	jQuery('#modal-contract-edit').on('click', '.'+ _DELETE_CLASS_NAME_, function() {
		var this_element = jQuery(this);
		var tr_this_element = this_element.closest('tr');
		var table = tr_this_element.closest('table');

		if(!tr_this_element.is(':last-child')) {
			app.table_utils.remove_tr(tr_this_element);

			setTimeout(function() {
				app.table_utils.order_sequence(table, 0);

				table.find('tbody tr').eq(-1).find('td').eq(0).html('');

				modal_contract_edit_.sequential_calculate_period_payment();
			}, 700);
		}
	});

	jQuery('#modal-contract-edit').on('keyup', '[name="project_value"]', function() {
		modal_contract_edit_.sequential_calculate_period_payment('percent_value');
	});

	jQuery('#parent-warranty-detail-status-id').change(function() {
		var parent_status = jQuery(this);
		var table = jQuery('#table-calculate-warranty');

		var result_check_warranty_maintenance_status_data 
			= modal_contract_edit_.check_warranty_maintenance_status_data(table);

		var process_ = function(table) {
			table.find('tbody tr').each(function() {
				var current_tr = jQuery(this);
				var status = current_tr.find('[name="contract_warranty_detail_status_id[]"]');

				status.val(parent_status.val());

				app.set_animate_custom(status, 'jello', 500);
			});

			parent_status.val('');
			
			parent_status.blur();
		};

		if(result_check_warranty_maintenance_status_data) {
			alert_util.confirmAlert('<p class="text-warning">' 
					+ app.translate('status_detail_have_data_please_confirm_to_continue')
					+ '</p>', function() {
				process_(table);
			}, function() {
				parent_status.val('');
			
				parent_status.blur();
			},{
				animation: false,
				type: null
			});
		}
		else {
			process_(table);
		}
	});

	jQuery('#parent-maintenance-detail-status-id').change(function() {
		var parent_status = jQuery(this);
		var table = jQuery('#table-calculate-maintenance');

		var result_check_warranty_maintenance_status_data 
			= modal_contract_edit_.check_warranty_maintenance_status_data(table);

		var process_ = function() {
			table.find('tbody tr').each(function() {
				var current_tr = jQuery(this);
				var status = current_tr.find('[name="contract_maintenance_detail_status_id[]"]');

				status.val(parent_status.val());

				app.set_animate_custom(status, 'jello', 500);
			});

			parent_status.val('');

			parent_status.blur();
		};

		if(result_check_warranty_maintenance_status_data) {
			alert_util.confirmAlert('<p class="text-warning">' 
					+ app.translate('status_detail_have_data_please_confirm_to_continue')
					+ '</p>', function() {
				process_(table);
			}, function() {
				parent_status.val('');
			
				parent_status.blur();
			},{
				animation: false,
				type: null
			});
		}
		else {
			process_(table);
		}
	});


	/*$('body').dblclick(function() {
		console.log($('[name="contract_no"]').attr('name'));

		$('.dtpicker').each(function() {
			var this_element = $(this);

			if(this_element.find('input[type="text"]').attr('name') == 'start_date_end') {
				console.log(this_element);
				console.log(this_element.data('DateTimePicker').date(null));
			}
		});
	});*/
});

var export_data = (function() {
	var _get_temp_form = function() {
		return jQuery('form#temp_form');
	};

	var _target_url_export_excel = 'contract_list/contract_list/export_data_excel';;

	return {
		excel: function(force_export) {
			force_export = force_export || false;

			var temp_form = _get_temp_form();
			var target_url = site_url + _target_url_export_excel;
			var data = data_criterai_export;

			data.export_type = 'all_contract_in_criteria';

			data.force_export = !force_export ? 'false' : 'true';

			app.form_redirect_post(temp_form, target_url, data);
		},
		excel_modal: function(force_export) {
			force_export = force_export || false;

			var temp_form = _get_temp_form();
			var target_url = site_url + _target_url_export_excel;

			var data = {
				id : jQuery('#modal-contract-edit [name="id"]').val()
			};

			data.export_type = 'contract_detail';

			data.force_export = !force_export ? 'false' : 'true';

			app.form_redirect_post(temp_form, target_url, data);
		}
	};
})();

var page = (function() {
	var _set_data_criterai_export = function() {
		var form_data = app.create_form_object_data(jQuery('form[name="search_form"]'));

		data_criterai_export = form_data;

		delete data_criterai_export[csrf_name];
	};

	var _validate_date_range = function(search_form) {
		var validate_pass = true;
		var array_group_element = [
 			[search_form.find('[name="delivery_date_start"]'), search_form.find('[name="delivery_date_end"]')],
 			[search_form.find('[name="start_date_start"]'), search_form.find('[name="start_date_end"]')],
 			[search_form.find('[name="end_date_start"]'), search_form.find('[name="end_date_end"]')]
 		];
		var __validate_date = function(array_group_element) {
			for(var index in array_group_element) {
				var start_element = array_group_element[index][0];
				var end_element = array_group_element[index][1];

				start_element.removeClass(_REQUIRED_ERROR_CLASS_);
				end_element.removeClass(_REQUIRED_ERROR_CLASS_);

				if(!app.value_utils.is_empty_value(start_element.val()) && 
 					!app.value_utils.is_empty_value(end_element.val())) {

					if(!app.date_util.validate_date_range(start_element.val(), end_element.val())) {
						start_element.addClass(_REQUIRED_ERROR_CLASS_);
						end_element.addClass(_REQUIRED_ERROR_CLASS_);
	 					validate_pass = false;
	 				}
				}
			}
		};

 		__validate_date(array_group_element);

		return validate_pass;
	};


	return {
		init_search_data: function() {
			jQuery('form[name="search_form"]').submit(function(event) {
				event.preventDefault();

				var this_form = jQuery(this);
				var button_search = this_form.find('.btn-submit');

				if(!_validate_date_range(this_form)) {
					app.show_notice({
						type: _WARNING_,
						message: app.translate('Start date must be less than end date')
					});

					return false;
				}

				button_search.bootstrapBtn('loading');

				setTimeout(function() {
					page.list_data();

					button_search.bootstrapBtn('reset');
				}, 500);
			});
		},
		list_data: function() {
			_set_data_criterai_export();

			jQuery('#table-list').dataTable({
				destroy: true,
				autoWidth: false,
				processing: true,
		        serverSide: true,
		        ajax: {
		            url: 'contract_list/get_index_contract_list',
		            type: 'get',
		            data: app.create_form_object_data(jQuery('form[name="search_form"]'))
		        },
		        columns: [
		            {data: 'running_no'},
		            {data: 'contract_no'},
		            {data: 'contract_name'},
		            {data: 'delivery_date'},
		            {data: 'start_date'},
		            {data: 'end_date'}
		        ],
		        drawCallback: function(settings) {
		        	app.data_table.set_full_width();
				}
			});
		},
		init_save_contract: function() {
			jQuery('form[name="edit_form"]').submit(function(e) {
				e.preventDefault();

				modal_contract_edit_.save_contract();
			});
		},
		init_datetimepicker: function() {
			var date_time_picker_element = jQuery('.dtpicker');

			date_time_picker_element.datetimepicker({
		        format: 'YYYY-MM-DD',
		        defaultDate: false,
		        useCurrent: false,
		        widgetPositioning: {
		            horizontal: 'right',
		            vertical: 'bottom'
		        }
		    });

		    date_time_picker_element.on('dp.change', function(e) {
		    	/*var element_name = e.currentTarget.children[0].name;

		    	if(element_name == 'delivery_date') {
		    		if(e.oldDate != null) {
			    		modal_contract_edit_.init_display_text_data();
			    		modal_contract_edit_.calculate_warrany_detail_pre_process();
			    	}
		    	}*/

		    	var element_name = e.currentTarget.children[0].name;

		    	if(element_name == 'delivery_date') {
		    		var _delivery_date_temp = jQuery('#_delivery_date_temp');
		    		var delivery_date = jQuery('[name="delivery_date"]');

		    		if(_delivery_date_temp.val() != delivery_date.val())  {
		    			_delivery_date_temp.val(delivery_date.val());
		    			modal_contract_edit_.init_display_text_data();
			    		/*modal_contract_edit_.calculate_warrany_detail_pre_process();*/

			    		data_to_calculate_is_change_without_calculate = true;
			    		page.show_change_without_calculate('show');
		    		}
		    	}

		    	if(element_name == 'start_date') {
		    		if(process_type_contract == page.get_process_contract.ma()) {
			    		jQuery('#modal-contract-edit')
			    			.find('[name="delivery_date"]')
			    			.val( jQuery('#modal-contract-edit').find('[name="start_date"]').val() );

		    			modal_contract_edit_.init_display_text_data();

		    			data_to_calculate_is_change_without_calculate = true;
			    		page.show_change_without_calculate('show');
			    	}
		    	}

		    	if(element_name == 'end_date') {
		    		var table_calculate_warranty = jQuery('#table-calculate-warranty');

		    		table_calculate_warranty.find('tbody tr').each(function() {
		    			var current_tr = jQuery(this);
		    			var warranty_date = current_tr.find('[name="warranty_date[]"]');

		    			modal_contract_edit_.fill_color_if_over_end_date(warranty_date.val(), current_tr);
		    		});

		    		var table_calculate_maintenance = jQuery('#table-calculate-maintenance');

		    		table_calculate_maintenance.find('tbody tr').each(function() {
		    			var current_tr = jQuery(this);
		    			var maintenance_date = current_tr.find('[name="maintenance_date[]"]');

		    			modal_contract_edit_.fill_color_if_over_end_date(maintenance_date.val(), current_tr);
		    		});
		    	}
		    });
		},
		init_datetimepicker_warranty_detail: function() {
			var date_time_picker_element = jQuery('.dtpicker-warranty-detail');

			date_time_picker_element.datetimepicker({
		        format: 'YYYY-MM-DD',
		        defaultDate: false,
		        useCurrent: false,
		        widgetPositioning: {
		            horizontal: 'left',
		            vertical: 'bottom'
		        }
		    });

		    date_time_picker_element.on('dp.change', function(e) {

		    });
		},
		init_datetimepicker_maintenance_detail: function() {
			var date_time_picker_element = jQuery('.dtpicker-maintenance-detail');

			date_time_picker_element.datetimepicker({
		        format: 'YYYY-MM-DD',
		        defaultDate: false,
		        useCurrent: false,
		        widgetPositioning: {
		            horizontal: 'left',
		            vertical: 'bottom'
		        }
		    });

		    date_time_picker_element.on('dp.change', function(e) {

		    });
		},
		init_datetimepicker_payment_period: function() {
			var date_time_picker_element = jQuery('.dtpicker-payment-period');

			date_time_picker_element.datetimepicker({
		        format: 'YYYY-MM-DD',
		        defaultDate: false,
		        useCurrent: false,
		        widgetPositioning: {
		            horizontal: 'left',
		            vertical: 'bottom'
		        }
		    });

		    date_time_picker_element.on('dp.change', function(e) {
		    	var this_element = jQuery(e.currentTarget).trigger('change');
		    	var payment_period_remark = this_element.closest('tr').find('[name="payment_period_remark[]"]');

		    	setTimeout(function() {
		    		payment_period_remark.change();
		    	}, 500);
		    });
		},
		init_period_payment_percent_value: function() {
			jQuery('#modal-contract-edit').on('keyup', '[name="percent_value[]"], [name="payment_value[]"]', function() {
				modal_contract_edit_.period_payment_percent_value(jQuery(this));
			});
		},
		show_change_without_calculate: function(type) {
			var html  = '';

			if(type == 'show') {
				html = data_to_calculate_is_change_without_calculate_show_text ;
			}

			jQuery('#change-without-calculate-text-caution').html(html);
		},
		get_process_contract: {
			normal: function() {
				return jQuery('#process-type-contract-normal').val();
			},
			ma: function() {
				return jQuery('#process-type-contract-ma').val();
			}
		},
		active_tab_after_calculate: function() {
			var modal_edit = jQuery('#modal-contract-edit');
			var table_calculate_warranty = modal_edit.find('#table-calculate-warranty');

			if(table_calculate_warranty.find('tbody tr').length == 0) {
				jQuery('#contract-list-tab a[href="#maintenance-detail-tab"]').tab('show');
			}
		}
	};
})();

var conditions_for_maintenance_ = (function() {
	var _conditions_for_maintenance_name = 'conditions_for_maintenance[]';

	return {
		init_create_new_element: function() {
			jQuery('#modal-contract-edit')
				.on('change', '[name="'+ _conditions_for_maintenance_name +'"]', function() {
					var this_element = jQuery(this);

					if(this_element.is(':last-child')) {
						var clone_element = this_element.eq(-1).clone();

						clone_element.appendTo(this_element.parent());
					}

					jQuery('#modal-contract-edit')
						.find('[name="'+ _conditions_for_maintenance_name +'"]')
						.last()
						.val('');
			});
		},
		remove_empty_data: function() {
			jQuery('#modal-contract-edit')
				.find('[name="'+ _conditions_for_maintenance_name +'"]').each(function() {
					var this_element = jQuery(this);
					
					if(app.value_utils.is_empty_value(this_element.val())) {
						var element_exist = jQuery('[name="'+ _conditions_for_maintenance_name +'"]').length;

						if(element_exist !== 1) {
							if(!this_element.is(':last-child')) {
								app.page_utils.remove_element(this_element);
							}
						}
					}
			});
		}
	}
})();

var modal_contract_edit_ = (function() {
	var _set_data_to_input = function(data) {
		var modal_contract_edit = jQuery('#modal-contract-edit');
		var html_conditions_for_maintenance = '';
		var html_tr_contract_fine_table = '';
		var _render_tr_contract_fine_table = function(fine_detail, fine_value) {
			fine_detail = fine_detail || '';
			fine_value = fine_value || '';

			var html = '';
			html += '<tr>'
				+  '<td>' + modal_contract_edit_.get_contract_fine_detail_html_input(fine_detail) + '</td>'
				+  '<td>' + modal_contract_edit_.get_contract_fine_value_html_input(fine_value) + '</td>';
				+ '</tr>';

			return html;
		}

		for(var index in data) {
			if(index == 'project_value') {
				data[index] = app.get_number_format(data[index]);
			}

			modal_contract_edit.find('[name="'+ index +'"]').val(data[index]);
			

			if(index === 'conditions_for_maintenance') {
				for(var ii in data[index]) {
					html_conditions_for_maintenance 
						+= modal_contract_edit_.get_conditions_for_maintenance_html_input.input_open;

					html_conditions_for_maintenance 
						+=	data[index][ii].detail
						+ modal_contract_edit_.get_conditions_for_maintenance_html_input.input_close;
				}
				html_conditions_for_maintenance 
					+= modal_contract_edit_.get_conditions_for_maintenance_html_input.full_input;
				jQuery('#modal-contract-edit #td-conditions-for-maintenance').html(html_conditions_for_maintenance);
			}

			if(index === 'delivery_date') {
				jQuery('#_delivery_date_temp').val(data[index]);
			}

			if(index === 'contract_fine') {
				for(var iii in data[index]) {
					html_tr_contract_fine_table 
						+= _render_tr_contract_fine_table(data[index][iii].fine_detail, data[index][iii].fine_value);
				}
				html_tr_contract_fine_table += _render_tr_contract_fine_table();

				jQuery('#contract-fine-table tbody').html(html_tr_contract_fine_table);
			}

			if(index === 'contract_warranty_detail') {
				var table_calculate_warranty = jQuery('#table-calculate-warranty');
				var tr_template = jQuery('#template-calculate-warranty').val();
				var html = '';
				var __set_data = function(data, seq) {
					var current_tr = table_calculate_warranty.find('tbody tr').eq(seq);

					current_tr.find('td:first').html(Number(seq) + 1);
					current_tr.find('.warranty-date-display-text').html(data.warranty_date);
					current_tr.find('[name="warranty_date[]"]').val(data.warranty_date);
					current_tr.find('[name="warranty_remark[]"]').val(data.warranty_remark);
					current_tr.find('[name="contract_warranty_detail_status_id[]"]')
						.val(data.contract_warranty_detail_status_id);

					modal_contract_edit_.fill_color_if_over_end_date(data.warranty_date, current_tr);
				};

				table_calculate_warranty.find('tbody').html(html);

				for(var j in data[index]) {
					html = tr_template;

					table_calculate_warranty.find('tbody').append(html);
					__set_data(data[index][j], j);
				}

				page.init_datetimepicker_warranty_detail();
				//table_calculate_warranty.find('tbody').html(html);
			}

			if(index === 'contract_maintenance_detail') {
				var table_calculate_maintenance = jQuery('#table-calculate-maintenance');
				var tr_template = jQuery('#template-calculate-maintenance').val();
				var html = '';
				var __set_data = function(data, seq) {
					var current_tr = table_calculate_maintenance.find('tbody tr').eq(seq);

					current_tr.find('td:first').html(Number(seq) + 1);
					current_tr.find('.maintenance-date-display-text').html(data.maintenance_date);
					current_tr.find('[name="maintenance_date[]"]').val(data.maintenance_date);
					current_tr.find('[name="maintenance_remark[]"]').val(data.maintenance_remark);
					current_tr.find('[name="contract_maintenance_detail_status_id[]"]')
						.val(data.contract_maintenance_detail_status_id);

					modal_contract_edit_.fill_color_if_over_end_date(data.maintenance_date, current_tr);
				};

				table_calculate_maintenance.find('tbody').html(html);

				for(var k in data[index]) {
					html = tr_template;

					table_calculate_maintenance.find('tbody').append(html);
					__set_data(data[index][k], k);
				}

				page.init_datetimepicker_maintenance_detail();
			}

			if(index === 'contract_payment_period') {
				for(var table_period_ in array_table_payment_period) {
					var table_payment_period = array_table_payment_period[table_period_];
					var payment_period_type_ = table_payment_period.attr('data-peyment-period-type');
					var tr_template = jQuery('#template-payment-period').val();
					var last_tr_template = tr_template;
					var html = '';
					var __set_data = function(data, seq) {
						var current_tr = table_payment_period.find('tbody tr').eq(seq);

						current_tr.find('td:first').html(Number(seq) + 1);
						current_tr.find('td:nth-child(2)').html('<i class="fa fa-trash '+ _DELETE_CLASS_NAME_ +'"></i>');
						current_tr.find('[name="contract_payment_period_type[]"]').val(payment_period_type_);
						current_tr.find('[name="percent_value[]"]').val(data.percent_value);
						current_tr.find('[name="payment_value[]"]').val(data.payment_value);
						current_tr.find('[name="payment_date[]"]').val(data.payment_date);
						current_tr.find('[name="payment_period_remark[]"]').val(data.payment_period_remark);
						current_tr.find('[name="contract_payment_period_status_id[]"]')
							.val(data.contract_payment_period_status_id);
						current_tr.find('[name="invoice_no[]"]').val(data.invoice_no);
					};

					table_payment_period.find('tbody').html(html);

					for(var type in data[index]) {
						for(var cpp in data[index][type]) {
							if(payment_period_type_ 
								== data[index][type][cpp].contract_payment_period_type) {
								html = tr_template;

								table_payment_period.find('tbody').append(html);
							__set_data(data[index][type][cpp], cpp);
							}
						}
					}

					table_payment_period.find('tbody').append(last_tr_template);
					table_payment_period.find('tbody tr')
						.eq(-1).find('[name="contract_payment_period_type[]"]').val(payment_period_type_);

					page.init_datetimepicker_payment_period();

				}
			}
		}
	};

	var _show_payyment_percent_text = function(target_element, txt) {
		txt = txt.toString();
		target_element.html(app.get_number_format(txt));
	};

	var _check_over_of_percent_payment_value = function(to_show_notice) {
		var result_check_pass = true;

		var is_over_msg = '';
		if(modal_contract_edit_.period_payment_is_over_100()) {
			is_over_msg += '<p>'+ app.translate('Total percent must less than 100') +'</p>';
			result_check_pass = false;
		}

		if(modal_contract_edit_.period_payment_is_over_project_value()) {
			is_over_msg += '<p>'+ app.translate('Total payment must less than project value') +'</p>';
			result_check_pass = false;
		}

		if(is_over_msg != '') {
			if(!app.check_notice_exist('over-percent-peayment-value')) {
				if(to_show_notice !== false) {
					app.show_notice({
						type: _WARNING_,
						message: is_over_msg,
						addclass: 'over-percent-peayment-value'
					});
				}
			}
		}

		return result_check_pass;
	};


	return {
		fill_color_if_over_end_date: function(date_string, tr_element) {
			var modal_edit = jQuery('#modal-contract-edit');
			var end_date_element = modal_edit.find('[name="end_date"]');
			var end_date_val = end_date_element.val();
			var _CAUTION_CLASS_SPAN_ = 'caution-over-end-date';
			var _OVER_CLASS_ = 'over-end-date';
			var html_ = '<span class="label label-warning col-xs-12 '+ _CAUTION_CLASS_SPAN_ +'">'+ app.translate('over_contrace_end_date_') +'</span>';

			if(!app.value_utils.is_empty_value(end_date_element.val())) {
				var separator = '-';
	            var date_string_timestamp = new Date(date_string.split(separator).join(separator)).getTime();
	            var end_date_timestamp = new Date(end_date_val.split(separator).join(separator)).getTime();

	            if(date_string_timestamp > end_date_timestamp) {
	            	tr_element.addClass(_OVER_CLASS_);

	            	if(tr_element.find('.'+_CAUTION_CLASS_SPAN_).length == 0) {
	            		tr_element.find('td').eq(1).append(html_);
	            	}
	            }
	            else {
	            	tr_element.removeClass(_OVER_CLASS_);

	            	tr_element.find('.'+_CAUTION_CLASS_SPAN_).remove();
	            }
			}
		},
		remember_last_warranty_remark: function() {
			var table_calculate_warranty = jQuery('#modal-contract-edit')
				.find('#table-calculate-warranty');

			array_warranty_remark = [];

			table_calculate_warranty.find('tbody tr').each(function() {
				var this_tr = jQuery(this);
				var remark = this_tr.find('[name="warranty_remark[]"]');

				array_warranty_remark.push(remark.val());
			});
		},
		remember_last_maintenance_remark: function() {
			var table_calculate_maintenance = jQuery('#modal-contract-edit')
				.find('#table-calculate-maintenance');

			array_maintenance_remark = [];

			table_calculate_maintenance.find('tbody tr').each(function() {
				var this_tr = jQuery(this);
				var remark = this_tr.find('[name="maintenance_remark[]"]');

				array_maintenance_remark.push(remark.val());
			});
		},
		set_something_for_process_type_contract_ma: function() {
			var modal_edit = jQuery('#modal-contract-edit');
			var start_date_notice = modal_edit.find('#start-date-notice');
			var delivery_date_element = modal_edit.find('[name="delivery_date"]');
			var delivery_date_box_calendar = delivery_date_element
				.closest('td').find('.input-group-addon');
			var arr_set_readonly = [
				delivery_date_element, 
				modal_edit.find('[name="warranty_range"]'), 
				modal_edit.find('[name="warranty_total_month"]')
			];
			var arr_set_zero = [
				modal_edit.find('[name="warranty_range"]'), 
				modal_edit.find('[name="warranty_total_month"]')
			];

			if(process_type_contract == page.get_process_contract.ma()) {
				start_date_notice.removeClass('hide');
				delivery_date_box_calendar.addClass('hide');

				for(var index in arr_set_readonly) {
					arr_set_readonly[index].attr('readonly','readonly');
				}

				for(var index_ in arr_set_zero) {
					arr_set_zero[index_].val('0');
				}
			}
			else {
				start_date_notice.addClass('hide');
				delivery_date_box_calendar.removeClass('hide');

				for(var index in arr_set_readonly) {
					arr_set_readonly[index].removeAttr('readonly','readonly');
				}
			}
		},
		set_contract_type_for_process_type_contract: function() {
			var modal_edit = jQuery('#modal-contract-edit');
			var contract_type_element = modal_edit.find('[name="contract_type_id"]');

			contract_type_element.find('option').removeAttr('disabled');

			if(process_type_contract == page.get_process_contract.ma()) {
				contract_type_element.find('option').filter(function() {
					return jQuery(this).val() == '3' ? false : true;
				}).attr('disabled','disabled');

				contract_type_element.val('3');
			}
			else {
				contract_type_element.find('option').filter(function() {
					return jQuery(this).val() == '3' ? true : false;
				}).attr('disabled','disabled');

				contract_type_element.val('');
			}
		},
		clear_data_table_calculate_warranty: function() {
			jQuery('#table-calculate-warranty tbody').html('');
		},
		clear_data_table_calculate_maintenance: function() {
			jQuery('#table-calculate-maintenance tbody').html('');
		},
		render_empty_last_tr_for_hardware_software: function() {
			for(var table_ in array_table_payment_period) {
				var current_table_ = array_table_payment_period[table_];
				var payment_period_type_ = current_table_.attr('data-peyment-period-type');

				current_table_.find('tbody').html(jQuery('#template-payment-period').val());
				current_table_.find('[name="contract_payment_period_type[]"]').val(payment_period_type_);
			}
		},
		remove_required_error_input: function(edit_form) {
			edit_form.find('.'+_REQUIRED_ERROR_CLASS_).removeClass(_REQUIRED_ERROR_CLASS_);
		},
		set_id_modal: function(id) {
			jQuery('#modal-contract-edit').find('[name="id"]').val(id);
		},
		get_contract_data: function(id) {
			app.loading('show');

			setTimeout(function() {
				jQuery.ajax({
					type: 'get',
					url: 'contract_list/get_contract_by_id',
					cache: false,
					data: {
						id: id
					},
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

						app.loading('remove');

						if(response.id != undefined) {
							modal_contract_edit_.set_id_modal(id);

							_set_data_to_input(response);

							array_table_payment_period[0]
								.find('tbody tr').first()
								.find('[name="payment_value[]"]').trigger('keyup');

							jQuery('#modal-contract-edit').modal('show');
						}
						else {
							app.show_notice({
								type: _WARNING_, 
								message: app.translate('Data not found')
							});
						}
					},
					error: function() {
						alert('error');

						app.loading('remove');
					}
				});
			}, 500);
		},
		save_contract: function() {
			var edit_form = jQuery('form[name="edit_form"]');
			var form_data = edit_form.serializeArray();

			var result_simple_validate 
				= app.form_utils.simple_validate_required_field(edit_form);

			var _reset_state_submit_button = function() {
				edit_form.find('.btn-submit-loading').bootstrapBtn('reset');
			};

			var _validate_start_date_end_date = function() {
				var validate_pass = true;
				var __start_date = edit_form.find('[name="start_date"]');
				var __start_date_value = __start_date.val();
				var __end_date = edit_form.find('[name="end_date"]');
				var __end_date_value = __end_date.val();

				__start_date.removeClass(_REQUIRED_ERROR_CLASS_);
				__end_date.removeClass(_REQUIRED_ERROR_CLASS_);

				if(!app.value_utils.is_empty_value(__start_date_value) 
					&& !app.value_utils.is_empty_value(__end_date_value)) {

					if(!app.date_util.validate_date_range(__start_date_value, __end_date_value)) {
						__start_date.addClass(_REQUIRED_ERROR_CLASS_);
						__end_date.addClass(_REQUIRED_ERROR_CLASS_);

						_reset_state_submit_button();
						validate_pass = false;
					}
				}

				return validate_pass;
			}

			var _check_warranty_detail_have_data = function() {
				if(process_type_contract == page.get_process_contract.ma()) {
					return true;
				}
				else {
					return jQuery('#table-calculate-warranty tbody tr').length > 0 ? true : false;
				}
			};

			var _validate_warranty_detail = function() {
				var validate_pass = true;
				var edit_form = jQuery('form[name="edit_form"]');
				var warranty_detail_status = edit_form.find('[name="contract_warranty_detail_status_id[]"]');

				warranty_detail_status.removeClass(_REQUIRED_ERROR_CLASS_);

				warranty_detail_status.each(function() {
					var this_warranty_detail_status = jQuery(this);

					if(app.value_utils.is_empty_value(this_warranty_detail_status.val())) {
						this_warranty_detail_status.addClass(_REQUIRED_ERROR_CLASS_);
						validate_pass = false;
					}
				});

				return validate_pass;
			};

			var _check_maintenance_detail_have_data = function() {
				return jQuery('#table-calculate-maintenance tbody tr').length > 0 ? true : false;
			};

			var _validate_maintenance_detail = function() {
				var validate_pass = true;
				var edit_form = jQuery('form[name="edit_form"]');
				var maintenance_detail_status = edit_form.find('[name="contract_maintenance_detail_status_id[]"]');

				maintenance_detail_status.removeClass(_REQUIRED_ERROR_CLASS_);

				maintenance_detail_status.each(function() {
					var this_maintenance_detail_status = jQuery(this);

					if(app.value_utils.is_empty_value(this_maintenance_detail_status.val())) {
						this_maintenance_detail_status.addClass(_REQUIRED_ERROR_CLASS_);
						validate_pass = false;
					}
				});

				return validate_pass;
			}

			var _validate_payment_period = function() {
				var validate_pass = true;
				var validate_invoice_no = true;
				var edit_form = jQuery('form[name="edit_form"]');
				var table_payment_period_hardware = edit_form.find('#table-payment-period-hardware');
				var table_payment_period_software = edit_form.find('#table-payment-period-software');
				var __validate_invoice_no_with_period_status = function(period_status_element) {
					var this_tr = period_status_element.closest('tr');
					var invoice_no = this_tr.find('[name="invoice_no[]"]');
					
					period_status_element.removeClass(_REQUIRED_ERROR_CLASS_);
					invoice_no.removeClass(_REQUIRED_ERROR_CLASS_);

					if(app.value_utils.is_empty_value(invoice_no.val())) {
						period_status_element.addClass(_REQUIRED_ERROR_CLASS_);
						invoice_no.addClass(_REQUIRED_ERROR_CLASS_);

						return false;
					}
					else {
						return true;
					}
				};

				for(var table_ in array_table_payment_period) {
					var this_table = array_table_payment_period[table_];
					this_table.find('tbody tr').each(function() {
						var this_tr = jQuery(this);
						var array_input_validate = [
							this_tr.find('[name="payment_date[]"]'),
							this_tr.find('[name="payment_value[]"]'),
							this_tr.find('[name="contract_payment_period_status_id[]"]')
						];

						for(var i in array_input_validate) {
							var this_element = array_input_validate[i];
							var tr_this_element = this_element.closest('tr');

							tr_this_element.find('[name="invoice_no[]"]').removeClass(_REQUIRED_ERROR_CLASS_);

							this_element.removeClass(_REQUIRED_ERROR_CLASS_);

							if(!tr_this_element.is(':last-child')) {
								if(app.value_utils.is_empty_value(this_element.val())) {
									this_element.addClass(_REQUIRED_ERROR_CLASS_);

									validate_pass = false;
								}
								else {
									if(this_element.attr('name') 
										== 'contract_payment_period_status_id[]') {
										if(this_element.val() == '2') {
											if(!__validate_invoice_no_with_period_status(this_element)) {
												validate_invoice_no = false;
											}
										}
									}
								}
							}
						}
					});
				}

				if(!validate_invoice_no) {
					validate_pass = false;
				}

				return validate_pass;
			};

			var _validate_payment_period_percent_value = function() {
				var validate_pass = true; 

				if(!_check_over_of_percent_payment_value()) {
					validate_pass = false;
				}

				return validate_pass;
			};

			var _validate_period_without_a_remainder = function() {
				var _validate_pass = true;
				var modal_edit = jQuery('#modal-contract-edit');

				var __warranty_period = function() {
					var result_validate = true;
					var warranty_range = modal_edit.find('[name="warranty_range"]');
					var warranty_range_val = Number(warranty_range.val());
					var warranty_total_month = modal_edit.find('[name="warranty_total_month"]');
					var warranty_total_month_val = Number(warranty_total_month.val());
					var result_mod = null;

					warranty_range.removeClass(_REQUIRED_ERROR_CLASS_);
					warranty_total_month.removeClass(_REQUIRED_ERROR_CLASS_);

					if(process_type_contract == page.get_process_contract.ma()) {
						result_validate = true;
					}
					else {
						result_mod = (warranty_total_month_val % warranty_range_val);

						if(result_mod > 0) {
							warranty_range.addClass(_REQUIRED_ERROR_CLASS_);
							warranty_total_month.addClass(_REQUIRED_ERROR_CLASS_);

							result_validate = false;
						}
						else {
							result_validate = true;
						}
					}

					return result_validate;
				};

				var __maintenance_period = function() {
					var result_validate = true;
					var maintenance_range = modal_edit.find('[name="maintenance_range"]');
					var maintenance_range_val = Number(maintenance_range.val());
					var maintenance_total_month = modal_edit.find('[name="maintenance_total_month"]');
					var maintenance_total_month_val = Number(maintenance_total_month.val());
					var result_mod = null;

					maintenance_range.removeClass(_REQUIRED_ERROR_CLASS_);
					maintenance_total_month.removeClass(_REQUIRED_ERROR_CLASS_);

					result_mod = (maintenance_total_month_val % maintenance_range_val);

					if(result_mod > 0) {
						maintenance_range.addClass(_REQUIRED_ERROR_CLASS_);
						maintenance_total_month.addClass(_REQUIRED_ERROR_CLASS_);

						result_validate = false;
					}
					else {
						result_validate = true;
					}

					return result_validate;
				};

				if(!__warranty_period() || !__maintenance_period()) {
					if(!app.check_notice_exist('notice-period-remainder')) {
						app.show_notice({
							type: _WARNING_,
							message: app.translate('notice_period_with_a_reminder'),
							addclass: 'notice-period-remainder'
						});
					}

					_validate_pass = false;
				}


				return _validate_pass;
			};

			var _validate_last_maintenance_with_end_date = function() {
				var modal_edit = jQuery('#modal-contract-edit');
				var end_date = modal_edit.find('[name="end_date"]');
				var table_calculate_maintenance = modal_edit.find('#table-calculate-maintenance');
				var last_maintenance = table_calculate_maintenance
					.find('tbody tr').last().find('[name="maintenance_date[]"]');
				var result_validate_date_range = null;

				var _validate_is_over_end_date_ = function(end_date, last_maintenance_date) {
					if(process_type_contract == page.get_process_contract.ma()) {
						if (end_date === '' || last_maintenance_date === '') {
			                return false;
			            }
			          
			            var separator = '-';
			            var end_date_timestamp = new Date(end_date.split(separator).join(separator)).getTime();
			            var last_maintenance_date_timestamp = new Date(last_maintenance_date.split(separator).join(separator)).getTime();

			            if (end_date_timestamp >= last_maintenance_date_timestamp) {
			                return true;
			            } else {
			                return false;
			            }
					}
					else {
						return true;
					}
		        };

		        if(table_calculate_maintenance.find('tbody tr').length == 0) {
	        		result_validate_date_range = true;
		        }
		        else {
	        		result_validate_date_range = _validate_is_over_end_date_(end_date.val(), last_maintenance.val());

	        		if(!result_validate_date_range) {
        				if(!app.check_notice_exist('notice-ma-over-enddate')) {
							app.show_notice({
								type: _WARNING_, 
								message: app.translate('last_maintenance_date_is_over_end_date')
									+ '<br>'+ app.translate('end_date_') + ' : '+ end_date.val()
									+ '<br>'+ app.translate('Last maintenance date') +' : '+ last_maintenance.val(),
								addclass: 'notice-ma-over-enddate'
							});
						}
	        		}
		        }

				return result_validate_date_range;
			};


			if(!result_simple_validate) {
				app.show_notice({
					type: _WARNING_, 
					message: app.translate('please_complete_information')
				});

				jQuery('#contract-list-tab a[href="#contract-detail-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}

			if(!_validate_start_date_end_date()) {
				app.show_notice({
					type: _WARNING_,
					message: app.translate('Start date must be less than end date')
				});

				jQuery('#contract-list-tab a[href="#contract-detail-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}

			if(!_validate_warranty_detail()) {
				app.show_notice({
					type: _WARNING_,
					message: app.translate('Please select warranty process status')
				});

				jQuery('#contract-list-tab a[href="#warranty-detail-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}

			if(!_validate_maintenance_detail()) {
				app.show_notice({
					type: _WARNING_,
					message: app.translate('Please select maintenance process status')
				});

				jQuery('#contract-list-tab a[href="#maintenance-detail-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}

			if(!_validate_payment_period()) {
				app.show_notice({
					type: _WARNING_, 
					message: app.translate('please_complete_information')
				});

				jQuery('#contract-list-tab a[href="#payment-period-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}

			if(!_validate_payment_period_percent_value()) {
				jQuery('#contract-list-tab a[href="#payment-period-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}

			if(!_validate_period_without_a_remainder()) {
				jQuery('#contract-list-tab a[href="#contract-detail-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}

			if(!_validate_last_maintenance_with_end_date()) {
				jQuery('#contract-list-tab a[href="#contract-detail-tab"]').tab('show');

				_reset_state_submit_button();
				return false;
			}


			if(data_to_calculate_is_change_without_calculate) {
				alert_util.basicWarningAlert('<p class="text-danger">'
					+ app.translate('data_to_calculate_is_changed_')
					+ '<br>'
					+ app.translate('please_click_calculate_button_again_'), function() {
					
				},{
					animation: false,
					type: null
				});

				_reset_state_submit_button();
				return false;
			}

			var _to_save = function() {
				setTimeout(function() {
					jQuery.ajax({
						type: 'post',
						url: 'contract_list/save_contract',
						data: form_data,
						cache: false,
						beforeSend: function() {},
						success: function(response) {
							response = app.convert_to_json_object(response);

							if(response.result == _SUCCESS_) {
								//jQuery('#modal-contract-edit').modal('hide');
								page.list_data();

								if(app.value_utils.undefined_to_empty(response.return_id) != '') {
									jQuery('#modal-contract-edit [name="id"]').val(response.return_id);
								}
							}

							app.show_notice({
								type: response.result,
								message: response.message
							});

							_reset_state_submit_button();
						},
						error: function() {
							app.show_notice_error_occour();

							_reset_state_submit_button();
						},
						complete: function() {
							_reset_state_submit_button();
						}
					});
				}, 500);
			};

			if(!_check_warranty_detail_have_data() || !_check_maintenance_detail_have_data()) {
				alert_util.confirmAlert('<p class="text-danger">'
					+ app.translate('Not have calculate warranty and maintenance detail')
					+ '<br>'
					+ app.translate('Please confirm to continue.'), function() {

					_to_save();
					
				}, function() {
					_reset_state_submit_button();
				},{
					animation: false,
					type: null
				});
			}
			else {
				_to_save();
			}
		},
		get_conditions_for_maintenance_html_input: {
			input_open: '<textarea name="conditions_for_maintenance[]" class="form-control" rows="1">',
			input_close: '</textarea>',
			full_input: '<textarea name="conditions_for_maintenance[]" class="form-control" rows="1"></textarea>'
		},
		clear_conditions_for_maintenance_input: function() {
			var conditions_for_maintenance_html = modal_contract_edit_
				.get_conditions_for_maintenance_html_input
				.full_input;

			jQuery('#modal-contract-edit #td-conditions-for-maintenance')
				.html(conditions_for_maintenance_html);
		},
		clear_contract_fine_input: function() {
			var contract_fine_html = '';
			contract_fine_html += '<tr>'
				+  '<td>' + modal_contract_edit_.get_contract_fine_detail_html_input() + '</td>'
				+  '<td>' + modal_contract_edit_.get_contract_fine_value_html_input() + '</td>';
				+ '</tr>';
			jQuery('#modal-contract-edit #contract-fine-table tbody').html(contract_fine_html);
		},
		get_contract_fine_detail_html_input: function(value) {
			value = value || '';
			var html_return = '';

			html_return += '<textarea name="fine_detail[]" class="form-control" rows="1">'
				+ value + '</textarea>';

			return html_return;
		},
		get_contract_fine_value_html_input: function(value) {
			value = value || '';
			var html_return = '';

			html_return += '<div class="col-xs-12 input-group">'
				+ '<input type="text" name="fine_value[]" class="form-control number-digit-2" '
				+ 'value="'+ app.get_number_format(value) +'">'
				+ '<span class="input-group-addon">'+ app.translate('Baht') + '</span>'
				+ '</div>';

			return html_return;
		},
		init_display_text_data: function() {
			var _display_warranty = function() {
				var warranty_element = jQuery('#modal-contract-edit [name="warranty"]');
				var text = '';

				if(!app.value_utils.is_empty_value(warranty_element.val())) {
					text = warranty_element.val();
				}

				jQuery('#modal-contract-edit #warranty-range-show-text').html(text);
			};

			var _display_warranty_year_month = function() {
				var warranty_range_element = jQuery('#modal-contract-edit [name="warranty_range"]');
				var result = app.date_util.convert_month_to_year_month(warranty_range_element.val());
				var text = '';

				if(!app.value_utils.is_empty_value(warranty_range_element.val())) {
					if(result.year == 0) {
						text = warranty_range_element.val() + ' ' + app.translate('Month(s)') + ' '
							/*+ ' ('+result.month + ' '+app.translate('Month(s)')+ ')'*/;
					}
					else {
						text =  warranty_range_element.val() + ' ' + app.translate('Month(s)') + ' '
							+ ' ('+result.year + ' ' 
							+ app.translate('Year(s)') + ' ' 
							/*+ result.month + ' '+app.translate('Month(s)')+ ')'*/;
					}
				}

				jQuery('#modal-contract-edit .warranty-year-month-show').html(text);
			};

			var _display_warranty_total_month = function() {
				var warranty_total_month_element = jQuery('#modal-contract-edit [name="warranty_total_month"]');
				var result = app.date_util.convert_month_to_year_month(warranty_total_month_element.val());
				var text = '';

				if(!app.value_utils.is_empty_value(warranty_total_month_element.val())) {
					if(result.year == 0) {
						text = warranty_total_month_element.val() + ' ' + app.translate('Month(s)') + ' '
							+ ' ('+result.month + ' '+app.translate('Month(s)')+ ')';
					}
					else {
						text =  warranty_total_month_element.val() + ' ' + app.translate('Month(s)') + ' '
							+ ' ('+result.year + ' ' 
							+ app.translate('Year(s)') + ' ' 
							+ result.month + ' '+app.translate('Month(s)')+ ')';
					}
				}

				jQuery('#modal-contract-edit .warranty-total-month-show').html(text);
			};

			var _display_delivery_date = function() {
				var delivery_date_element = jQuery('#modal-contract-edit [name="delivery_date"]');

				var text = '';

				if(!app.value_utils.is_empty_value(delivery_date_element.val())) {
					text = delivery_date_element.val();
				}

				jQuery('#modal-contract-edit .delivery-date-show-text').html(text);
			};
			//--
			var _display_maintenance = function() {
				var maintenance_element = jQuery('#modal-contract-edit [name="maintenance"]');
				var text = '';

				if(!app.value_utils.is_empty_value(maintenance_element.val())) {
					text = maintenance_element.val();
				}

				jQuery('#modal-contract-edit #maintenance-range-show-text').html(text);
			};

			var _display_maintenance_year_month = function() {
				var maintenance_range_element = jQuery('#modal-contract-edit [name="maintenance_range"]');
				var result = app.date_util.convert_month_to_year_month(maintenance_range_element.val());
				var text = '';

				if(!app.value_utils.is_empty_value(maintenance_range_element.val())) {
					if(result.year == 0) {
						text = maintenance_range_element.val() + ' ' + app.translate('Month(s)') + ' ' 
							/*+ ' ('+result.month + ' '+app.translate('Month(s)')+ ')'*/;
					}
					else {
						text = maintenance_range_element.val() + ' ' + app.translate('Month(s)') + ' ' 
							/*+ ' ('+result.year + ' ' 
							+ app.translate('Year(s)') + ' ' 
							+ result.month + ' '+app.translate('Month(s)')+ ')'*/;
					}
				}

				jQuery('#modal-contract-edit .maintenance-year-month-show').html(text);
			};

			var _display_maintenance_total_month = function() {
				var maintenance_total_month_element = jQuery('#modal-contract-edit [name="maintenance_total_month"]');
				var result = app.date_util.convert_month_to_year_month(maintenance_total_month_element.val());
				var text = '';

				if(!app.value_utils.is_empty_value(maintenance_total_month_element.val())) {
					if(result.year == 0) {
						text = maintenance_total_month_element.val() + ' ' + app.translate('Month(s)') + ' '
							+ ' ('+result.month + ' '+app.translate('Month(s)')+ ')';
					}
					else {
						text =  maintenance_total_month_element.val() + ' ' + app.translate('Month(s)') + ' '
							+ ' ('+result.year + ' ' 
							+ app.translate('Year(s)') + ' ' 
							+ result.month + ' '+app.translate('Month(s)')+ ')';
					}
				}

				jQuery('#modal-contract-edit .maintenance-total-month-show').html(text);
			};



			$('#contract-list-tab a:first').tab('show');

			_display_warranty();
			_display_warranty_year_month();
			_display_warranty_total_month()
			_display_delivery_date();

			_display_maintenance();
			_display_maintenance_year_month();
			_display_maintenance_total_month();
		},
		calculate_warrany_detail_pre_process: function() {
			var have_data_calculate = function() {
				return jQuery('#table-calculate-warranty tbody tr').length > 0 ? true : false;
			};

			/*if(have_data_calculate()) {
				alert_util.confirmAlert('<p class="text-danger">'
					+ app.translate('This change take effect to warranty calculate.')
					+ '<br>'
					+ app.translate('Warranty calculate will calculate all again.')
					, function() {
					modal_contract_edit_.calculate_warrany_detail();
				}, function() {
					alert('no');
				},{
					animation: false,
					type: null
				});
			}
			else {
				modal_contract_edit_.calculate_warrany_detail();
			}*/

			modal_contract_edit_.remember_last_warranty_remark();
			modal_contract_edit_.remember_last_maintenance_remark();



			if(have_data_calculate()) {
				alert_util.basicWarningAlert('<p class="text-danger">'
					+ app.translate('This change take effect to warranty calculate.')
					+ '<br>'
					+ app.translate('Warranty calculate will calculate all again.'), function() {
					modal_contract_edit_.calculate_warrany_detail();
				},{
					animation: false,
					type: null
				});
			}
			else {
				modal_contract_edit_.calculate_warrany_detail();
			}



		},
		calculate_warrany_detail: function() {
			$('#contract-list-tab a[href="#warranty-detail-tab"]').tab('show');

			setTimeout(function() {
				jQuery('#calculate-warranty').bootstrapBtn('loading');

				var temp_loading = '';
				temp_loading += '<tr><td colspan="2" align="center">'
					+ '<img src="'+ site_url +'assets/dist/img/loading.gif" width="25"> '
					+ app.translate('Processing...') 
					+'</td></tr>';
				jQuery('#table-calculate-warranty tbody').html(temp_loading);
				
				setTimeout(function() {
					//modal_contract_edit_.calculate_warrany_detail_();
					modal_contract_edit_.calculate_warrany_detail__();
					jQuery('#calculate-warranty').bootstrapBtn('reset');
				}, 500);
			}, 500);

			
		},
		calculate_warrany_detail__: function() {
			var warranty_element = jQuery('#modal-contract-edit [name="warranty"]');
			var warranty_range = jQuery('#modal-contract-edit [name="warranty_range"]');
			var period_time = warranty_range.val();
			var warranty_total_month = jQuery('#modal-contract-edit [name="warranty_total_month"]');

			var delivery_date = jQuery('#modal-contract-edit [name="delivery_date"]');

			var tr_template = jQuery('#template-calculate-warranty').val();

			var table_calculate_warranty = jQuery('#table-calculate-warranty');

			var html = '';

			/**
			* begin main calculate
			*/

			/** add validate hear */
			if(app.value_utils.is_empty_value(warranty_element.val()) 
				|| app.value_utils.is_empty_value(warranty_range.val())
				|| app.value_utils.is_empty_value(warranty_total_month.val()) 
				|| app.value_utils.is_empty_value(delivery_date.val())
				|| app.value_utils.is_empty_value(jQuery('#modal-contract-edit [name="maintenance"]').val()) 
				|| app.value_utils.is_empty_value(jQuery('#modal-contract-edit [name="maintenance_range"]').val()) 
				|| app.value_utils.is_empty_value(jQuery('#modal-contract-edit [name="maintenance_total_month"]').val()) 
				) {

				table_calculate_warranty.find('tbody').html('');
				jQuery('#table-calculate-maintenance').find('tbody').html('');

				alert_util.basicErrorAlert('<p class="text-danger">' +
					app.translate('Not enought data to calculate.') 
					+ '<br>' + app.translate('please_complete_information') 
					+ '<br><br><span style="font-size: 15px; color: #dc8700;">' + app.translate('delivery_date_')
					+ ',' + app.translate('Warranty')
					+ ',' + app.translate('every_period_warranty_') 
					+ ',' + app.translate('Warranty Range') 
					+ '<br>'
					+ app.translate('ma_') 
					+ ',' + app.translate('every_period_ma_') 
					+ ',' + app.translate('ma_range_')
					+ '</span>'
					+ '</p>'
					, function() {
					
				},{
					animation: false,
					type: null
				});

				return false;
			}

			/** calculate number of time */
			var warranty_time_number = warranty_total_month.val() / warranty_range.val();

			var _calculate_maintenance_detail = function() {
				var maintenance_element = jQuery('#modal-contract-edit [name="maintenance"]');
				var maintenance_range = jQuery('#modal-contract-edit [name="maintenance_range"]');
				var maintenance_total_month = jQuery('#modal-contract-edit [name="maintenance_total_month"]');
				var period_time_ = maintenance_range.val();

				var table_calculate_maintenance = jQuery('#table-calculate-maintenance');

				/** calculate number of time */
				var maintenance_time_number = maintenance_total_month.val() / maintenance_range.val();

				if(maintenance_time_number == Infinity || maintenance_time_number == 0) {
					table_calculate_maintenance.find('tbody').html('');
					return false;
				}


				var table_calculate_warranty = jQuery('#table-calculate-warranty');
				var last_warranty_date 
					= table_calculate_warranty.find('tbody tr').last().find('[name="warranty_date[]"]');
				var first_start_for_maintenance_date_calculate = function() {
					if(last_warranty_date.length == 0) {
						return jQuery('#modal-contract-edit').find('[name="delivery_date"]').val();
					}
					else {
						//return last_warranty_date.val();
						return moment(last_warranty_date.val()).add(1, 'days').format('YYYY-MM-DD');
					}
				};

				/** calculate first period */
				var first_maintenance_date = moment(first_start_for_maintenance_date_calculate()).add(period_time_, 'month').format('YYYY-MM-DD');

				var tr_template_ = jQuery('#template-calculate-maintenance').val();

				var temp_start_;
				var arr_temp_start_ = [];

				var html_ = '';

				/** loop for render html tr */
				for(var ii = 0; ii <= (maintenance_time_number - 1); ii++) {
					var maintenance_date_;

					if(ii === 0) {
						/*
						temp_start_ = first_maintenance_date;
						maintenance_date_ = temp_start_;
						*/

						temp_start_ = first_maintenance_date;
						maintenance_date_ = moment(temp_start_).subtract(1, 'days').format('YYYY-MM-DD');
					}
					else {
						/*
						maintenance_date_ = moment(temp_start_).add(period_time_, 'month').format('YYYY-MM-DD');
						temp_start_ = maintenance_date_;
						*/

						var advance_full_month_ = moment(temp_start_).add(period_time_, 'month').format('YYYY-MM-DD');
						var decrease_1_day_ = moment(advance_full_month_).subtract(1, 'days').format('YYYY-MM-DD');

						maintenance_date_ = decrease_1_day_;
						temp_start_ = advance_full_month_;
					}

					arr_temp_start_.push(maintenance_date_);

					html_ += tr_template_;
				}

				/** render tr */
				table_calculate_maintenance.find('tbody').html(html_);

				/** loop for input value */
				for(var index_ in arr_temp_start_) {
					var tr = table_calculate_maintenance.find('tbody tr').eq(index_);

					tr.find('td:first').html(Number(index_) + 1);
					tr.find('.maintenance-date-display-text').html(arr_temp_start_[index_]);
					tr.find('[name="maintenance_date[]"]').val(arr_temp_start_[index_]);
					tr.find('[name="maintenance_remark[]"]').val('');

					/** fill the latest data to remark */
					if(array_maintenance_remark[index_] != undefined) {
						tr.find('[name="maintenance_remark[]"]').val(array_maintenance_remark[index_]);
					}

					modal_contract_edit_.fill_color_if_over_end_date(arr_temp_start_[index_], tr);
				}

				page.init_datetimepicker_maintenance_detail();
			};

			/** if warranty_time_number is equal 0 or Infonity */
			if(warranty_time_number == Infinity || warranty_time_number == 0) {
				table_calculate_warranty.find('tbody').html('');

				_calculate_maintenance_detail();

				data_to_calculate_is_change_without_calculate = false;
				page.show_change_without_calculate('remove');

				page.active_tab_after_calculate();

				return false;
			}

			/** calculate first period from delivery_date */
			var first_warranty_date = moment(delivery_date.val()).add(period_time, 'month').format('YYYY-MM-DD');

			/**
			* end main calculate
			*/

			table_calculate_warranty.find('tbody').html(tr_template);

			var temp_start;
			var arr_temp_start = [];

			/** loop for render html tr */
			for(var i = 0; i <= (warranty_time_number - 1); i++ ) {
				var warranty_date_;

				if(i === 0) {
					/*
					temp_start = first_warranty_date;
					warranty_date_ = temp_start;
					*/

					temp_start = first_warranty_date;
					warranty_date_ = moment(temp_start).subtract(1, 'days').format('YYYY-MM-DD');
				}
				else {
					/*
					warranty_date_ = moment(temp_start).add(period_time, 'month').format('YYYY-MM-DD');
					temp_start = warranty_date_;
					*/

					var advance_full_month = moment(temp_start).add(period_time, 'month').format('YYYY-MM-DD');
					var decrease_1_day = moment(advance_full_month).subtract(1, 'days').format('YYYY-MM-DD');

					warranty_date_ = decrease_1_day;
					temp_start = advance_full_month;
				}

				arr_temp_start.push(warranty_date_);

				html += tr_template;
			}

			/** render tr */
			table_calculate_warranty.find('tbody').html(html);

			/** loop for input value */
			for(var index in arr_temp_start) {
				var tr = table_calculate_warranty.find('tbody tr').eq(index);

				tr.find('td:first').html(Number(index) + 1);
				tr.find('.warranty-date-display-text').html(arr_temp_start[index]);
				tr.find('[name="warranty_date[]"]').val(arr_temp_start[index]);
				tr.find('[name="warranty_remark[]"]').val('');

				/** fill the latest data to remark */
				if(array_warranty_remark[index] != undefined) {
					tr.find('[name="warranty_remark[]"]').val(array_warranty_remark[index]);
				}

				modal_contract_edit_.fill_color_if_over_end_date(arr_temp_start[index], tr);
			}

			/** _calculate_maintenance_detail */
			//_calculate_maintenance_detail is here in the past
			

			page.init_datetimepicker_warranty_detail();

			_calculate_maintenance_detail();

			data_to_calculate_is_change_without_calculate = false;
			page.show_change_without_calculate('remove');

			page.active_tab_after_calculate();
		},
		calculate_warrany_detail_: function() {
			var month_in_year = 12;
			var warranty_element = jQuery('#modal-contract-edit [name="warranty"]');
			var warranty_range = jQuery('#modal-contract-edit [name="warranty_range"]');

			var delivery_date = jQuery('#modal-contract-edit [name="delivery_date"]');

			var tr_template = jQuery('#template-calculate-warranty').val();

			var table_calculate_warranty = jQuery('#table-calculate-warranty');

			var html = '';

			/**
			* begin main calculate
			*/

			/** calculate tr number for warranty */
			var warranty_per_year = warranty_element.val() / month_in_year;
			//var warranty_time_number = Math.ceil(warranty_per_year * warranty_range.val());
			var warranty_time_number = (warranty_per_year * warranty_range.val()) < 1 
				? Math.ceil(warranty_per_year * warranty_range.val()) : Math.floor(warranty_per_year * warranty_range.val())

			/** calculate each period time */
			var period_time = month_in_year / warranty_element.val();

			string_log_warranty = 'ช่วงห่าง : '+month_in_year+' หาร '+warranty_element.val()+' = '+period_time+'เดือน'+"\n"
				+ 'จำนวนครั้ง : ('+warranty_element.val()+' หาร '+month_in_year+') คูณ '+warranty_range.val()+' = '+(warranty_per_year * warranty_range.val()) +' ครั้ง'+"\n"
				+ 'ปัดเป็น '+warranty_time_number+' ครั้ง';

			/** calculate first period from delivery_date */
			var first_warranty_date = moment(delivery_date.val()).add(period_time, 'month').format('YYYY-MM-DD');

			/**
			* end main calculate
			*/


			/*console.log('period_time : '+period_time);
			console.log('first_warranty_date : '+first_warranty_date);*/

			if(app.value_utils.is_empty_value(warranty_element.val()) 
				|| app.value_utils.is_empty_value(warranty_range.val()) 
				|| app.value_utils.is_empty_value(delivery_date.val())
				|| app.value_utils.is_empty_value(jQuery('#modal-contract-edit [name="maintenance"]').val()) 
				|| app.value_utils.is_empty_value(jQuery('#modal-contract-edit [name="maintenance_range"]').val()) 
				) {

				table_calculate_warranty.find('tbody').html('');
				jQuery('#table-calculate-maintenance').find('tbody').html('');

				alert_util.basicErrorAlert('<p class="text-danger">' +
					app.translate('Not enought data to calculate.') 
					+ '<br>' + app.translate('please_complete_information') 
					+ '<br><br><span style="font-size: 15px; color: #dc8700;">' + app.translate('delivery_date_')
					+ ',' + app.translate('Warranty')
					+ ',' + app.translate('Warranty Range') 
					+ '<br>'
					+ app.translate('ma_') 
					+ ',' + app.translate('ma_range_')
					+ '</span>'
					+ '</p>'
					, function() {
					
				},{
					animation: false,
					type: null
				});

				return false;
			}

			

			//alert(warranty_time_number);
			table_calculate_warranty.find('tbody').html(tr_template);

			var temp_start;
			var arr_temp_start = [];

			/** loop for render html tr */
			for(var i = 0; i <= (warranty_time_number - 1); i++ ) {
				var warranty_date_;

				if(i === 0) {
					temp_start = first_warranty_date;
					warranty_date_ = temp_start;
				}
				else {
					warranty_date_ = moment(temp_start).add(period_time, 'month').format('YYYY-MM-DD');
					temp_start = warranty_date_;
				}

				arr_temp_start.push(warranty_date_);

				html += tr_template;
			}

			/** render tr */
			table_calculate_warranty.find('tbody').html(html);

			/** loop for inout value */
			for(var index in arr_temp_start) {
				var tr = table_calculate_warranty.find('tbody tr').eq(index);

				tr.find('td:first').html(Number(index) + 1);
				tr.find('.warranty-date-display-text').html(arr_temp_start[index]);
				tr.find('[name="warranty_date[]"]').val(arr_temp_start[index]);
				tr.find('[name="warranty_remark[]"]').val('');
			}


			var _calculate_maintenance_detail = function() {
				var maintenance_element = jQuery('#modal-contract-edit [name="maintenance"]');
				var maintenance_range = jQuery('#modal-contract-edit [name="maintenance_range"]');

				/** calculate tr number for warranty*/
				var maintenance_per_year = maintenance_element.val() / month_in_year;
				//var maintenance_time_number = Math.floor(maintenance_per_year * maintenance_range.val());
				var maintenance_time_number = (maintenance_per_year * maintenance_range.val()) < 1 
					? Math.ceil(maintenance_per_year * maintenance_range.val()) : Math.floor(maintenance_per_year * maintenance_range.val())

				/** find last warranty date */
				var table_calculate_warranty = jQuery('#table-calculate-warranty');
				var last_warranty_date 
					= table_calculate_warranty.find('tbody tr').last().find('[name="warranty_date[]"]');

				var first_start_for_maintenance_date_calculate = function() {
					if(last_warranty_date.length == 0) {
						return jQuery('#modal-contract-edit').find('[name="delivery_date"]').val();
					}
					else {
						return last_warranty_date.val();
					}
				};

				/** calculate each period time of maintenance*/
				var period_time_ = month_in_year / maintenance_element.val();

				/** calculate first period */
				var first_maintenance_date = moment(first_start_for_maintenance_date_calculate()).add(period_time_, 'month').format('YYYY-MM-DD');

				var tr_template_ = jQuery('#template-calculate-maintenance').val();

				var table_calculate_maintenance = jQuery('#table-calculate-maintenance');

				var temp_start_;
				var arr_temp_start_ = [];

				var html_;

				string_log_maintenance = 'ช่วงห่าง : '+month_in_year+' หาร '+maintenance_element.val()+' = '+period_time_+'เดือน'+"\n"
				+ 'จำนวนครั้ง : ('+maintenance_element.val()+' หาร '+month_in_year+') คูณ '+maintenance_range.val()+' = '+(maintenance_per_year * maintenance_range.val()) +' ครั้ง'+"\n"
				+ 'ปัดเป็น '+maintenance_time_number+' ครั้ง';

				/** loop for render html tr */
				for(var ii = 0; ii <= (maintenance_time_number - 1); ii++) {
					var maintenance_date_;

					if(ii === 0) {
						temp_start_ = first_maintenance_date;
						maintenance_date_ = temp_start_;
					}
					else {
						maintenance_date_ = moment(temp_start_).add(period_time_, 'month').format('YYYY-MM-DD');
						temp_start_ = maintenance_date_;
					}

					arr_temp_start_.push(maintenance_date_);

					html_ += tr_template_;
				}

				/** render tr */
				table_calculate_maintenance.find('tbody').html(html_);

				/** loop for inout value */
				for(var index_ in arr_temp_start_) {
					var tr = table_calculate_maintenance.find('tbody tr').eq(index_);

					tr.find('td:first').html(Number(index_) + 1);
					tr.find('.maintenance-date-display-text').html(arr_temp_start_[index_]);
					tr.find('[name="maintenance_date[]"]').val(arr_temp_start_[index_]);
					tr.find('[name="maintenance_remark[]"]').val('');
				}

				page.init_datetimepicker_maintenance_detail();
			};


			page.init_datetimepicker_warranty_detail();

			_calculate_maintenance_detail();

			data_to_calculate_is_change_without_calculate = false;
			page.show_change_without_calculate('remove');
		},
		period_payment_percent_value: function(element, to_show_notice) {
			var project_value = jQuery('#modal-contract-edit [name="project_value"]');
			var project_value_ = parseFloat(app.remove_comma(project_value.val()));
			var this_tr = element.closest('tr');
			var element_target = {
				'percent_value[]': 'payment_value[]',
				'payment_value[]': 'percent_value[]'
			};

			var _get_percent_by_payment = function(payment, target_element) {
				var payment_value_ = parseFloat(app.remove_comma(payment).trim());
				var result = (payment_value_ / project_value_) * 100;

				if(payment.trim() != '') {
					if(isNaN(result)) {
						if(!app.check_notice_exist('notice-project-value')) {
							app.show_notice({
								type: _WARNING_,
								message: app.translate('Please enter project value'),
								addclass: 'notice-project-value'
							});
						}
					}
					else {
						target_element.val(result.toFixed(2));
					}
				}
				else {
					target_element.val('');
				}
			};

			var _get_peyment_by_percent = function(percent, target_element) {
				var percent_value_ = parseFloat(app.remove_comma(percent).trim());
				var result = (project_value_ * percent_value_) / 100;

				if(percent.trim() != '') {
					if(isNaN(result)) {
						if(!app.check_notice_exist('notice-project-value')) {
							app.show_notice({
								type: _WARNING_,
								message: app.translate('Please enter project value'),
								addclass: 'notice-project-value'
							});
						}
					}
					else {
						target_element.val(app.get_number_format(result.toString()));
					}
				}
				else {
					target_element.val('');
				}
			};

			var target_element = this_tr.find('[name="'+ element_target[element.attr('name')] +'"]');

			if(element.attr('name') == 'payment_value[]') {
				_get_percent_by_payment(element.val(), target_element);
			}
			else {
				_get_peyment_by_percent(element.val(), target_element);
			}

			_check_over_of_percent_payment_value(to_show_notice);
		},
		period_payment_is_over_100: function() {
			var percent_value = jQuery('.table-payment-period [name="percent_value[]"]');
			var total_percent = 0;

			percent_value.each(function() {
				var this_element = jQuery(this);
				var tr_this_element = this_element.closest('tr');
				var percent_value_this_element = this_element.val();

				if(!tr_this_element.is(':last-child')) {
					total_percent = total_percent + Number(percent_value_this_element);
				}
			});

			_show_payyment_percent_text(jQuery('#total-payment-percent-text'), total_percent);

			return total_percent > 100 ? true : false;
		},
		period_payment_is_over_project_value: function() {
			var project_value 
				= Number(app.remove_comma(jQuery('#modal-contract-edit [name="project_value"]').val()));
			var payment_value = jQuery('.table-payment-period [name="payment_value[]"]');
			var total_value = 0;

			payment_value.each(function() {
				var this_element = jQuery(this);
				var tr_this_element = this_element.closest('tr');
				var peyment_value_this_element = app.remove_comma(this_element.val());

				if(!tr_this_element.is(':last-child')) {
					total_value = total_value + Number(peyment_value_this_element);
				}
			});

			_show_payyment_percent_text(jQuery('#total-payment-value-text'), total_value);

			return total_value > project_value ? true : false;
		},
		sequential_calculate_period_payment: function(calculate_by_percent) {
			if(calculate_by_percent != undefined) {
				for(var table_period_ in array_table_payment_period) {
					var table = array_table_payment_period[table_period_];

					table.find('tbody tr').each(function() {
						var this_tr = jQuery(this);
						var percent_value_element = this_tr.find('[name="percent_value[]"]');

						modal_contract_edit_.period_payment_percent_value(percent_value_element, false);
					});
				}
			}
			else {
				for(var table_period_ in array_table_payment_period) {
					var table = array_table_payment_period[table_period_];

					table.find('tbody tr').each(function() {
						var this_tr = jQuery(this);
						var payment_value_element = this_tr.find('[name="payment_value[]"]');

						modal_contract_edit_.period_payment_percent_value(payment_value_element, false);
					});
				}
			}
		},
		check_warranty_maintenance_status_data: function(jquery_table) {

			var table_id = jquery_table.attr('id');
			var status_element_name = null;
			var have_date = false;

			if(table_id == 'table-calculate-warranty') {
				status_element_name = 'contract_warranty_detail_status_id[]';
			}
			else 
			if(table_id == 'table-calculate-maintenance') {
				status_element_name = 'contract_maintenance_detail_status_id[]';
			}

			jquery_table.find('tbody tr').each(function() {
				var current_tr = jQuery(this);
				var current_status = current_tr
				var current_status_element = current_tr.find('[name="'+ status_element_name +'"]');

				if(current_status_element.val() != '') {
					have_date = true;
				}
			});

			return have_date;
		},
		reset_datepicker: function() {
			var modal = jQuery('#modal-contract-edit');
			var array_input = [
				modal.find('[name="start_date"]'),
				modal.find('[name="end_date"]'),
				modal.find('[name="delivery_date"]')
			];

			for(var index in array_input) {
				var current_element = array_input[index];
				var div_dt = current_element.parent();

				//current_element.val(_CURRENT_DATE_);
				//current_element.data('DateTimePicker').date(null)
				div_dt.data('DateTimePicker').date(_CURRENT_DATE_);
				div_dt.data('DateTimePicker').date(null);
			}

		}
	};
})();