var data_criterai_export = null;
var data_contract_id_set = null;

jQuery(document).ready(function() {
	page.init_search_data();

	page.init_datetimepicker();

	jQuery('#modal-warranty-detail .modal-header').css({
        'overflow-x': 'hidden'
    });

	jQuery('#modal-warranty-detail .modal-body').css({
        'height': (jQuery(window).height() * 60)/ 100,
        'overflow-x': 'auto',
        'overflow-y': 'auto'
    });

	jQuery('#table-list').on('click', '.btn-detail', function() {
		var this_element = jQuery(this);
		var id = this_element.attr('data-id');

		modal_warranty_detail_.get_data(id);
	});

	jQuery('#modal-warranty-detail').on('show.bs.modal', function () {
		setTimeout(function() {
			jQuery("#modal-warranty-detail .modal-body").scrollTop(0);
		}, 500);
	});

	jQuery('#export-data-excel').click(function(e) {
		export_data.excel();
	});
});

var export_data = (function() {
	var _get_temp_form = function() {
		return jQuery('form#temp_form');
	};

	var _target_url_export_excel = 'contract_list/contract_list/export_data_excel';

	var _get_search_form = function() {
		return jQuery('form[name="search_form"]')
	};

	return {
		excel: function(force_export) {
			force_export = force_export || false;

			var search_form = _get_search_form();

			var temp_form = _get_temp_form();
			var target_url = site_url + _target_url_export_excel;
			
			if(data_contract_id_set == null || data_contract_id_set.length == 0) {
				app.show_notice({
					type: _WARNING_, 
					message: app.translate('Data not found')
				});

				return false;
			}

			var data = {
				contract_id_set: data_contract_id_set.toString()
			};


			data.export_type = 'info_warranty';

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

	return {
		init_datetimepicker: function() {
			var date_time_picker_element = jQuery('.dtpicker');

			date_time_picker_element.datetimepicker({
		        format: 'YYYY-MM-DD',
		        defaultDate: false,
		        useCurrent: false/*,
		        widgetPositioning: {
		            horizontal: 'right',
		            vertical: 'bottom'
		        }*/
		    });
		},
		init_search_data: function() {
			jQuery('form[name="search_form"]').submit(function(e) {
				e.preventDefault();

				var this_form = jQuery(this);
				var button_search = this_form.find('.btn-submit');
				
				button_search.bootstrapBtn('loading');

				setTimeout(function() {
					page.list_data();

					button_search.bootstrapBtn('reset');
				}, 500);
			});
		},
		list_data: function() {
			var _validate = function() {
				var all_validate_pass = true;
				var warranty_date_start = jQuery('[name="warranty_date_start"]');
				var warranty_date_end = jQuery('[name="warranty_date_end"]');

				var validate_warranty_date = function() {
					var _validate_pass = true;
					

					if(app.value_utils.is_empty_value(warranty_date_start.val()) 
						|| app.value_utils.is_empty_value(warranty_date_end.val())) {

						app.show_notice({
							type: _WARNING_,
							message: app.translate('Begin date and end date must not empty')
						});

						_validate_pass = false;
					}

					return _validate_pass;
				};

				var validate_warranty_date_range = function() {
					var _validate_pass = true;
					var result_validate_date_range = app.date_util
						.validate_date_range(warranty_date_start.val(), warranty_date_end.val());

					if(!result_validate_date_range) {
						app.show_notice({
							type: _WARNING_,
							message: app.translate('Start date must be less than end date')
						});
						
						_validate_pass = false;
					}

					return _validate_pass;
				};
				
				if(!validate_warranty_date() || !validate_warranty_date_range()) {
					all_validate_pass =  false;
				}

				return all_validate_pass;
			};

			if(!_validate()) {
				return false;
			}

			_set_data_criterai_export();

			jQuery('#table-list').dataTable({
				destroy: true,
				autoWidth: false,
				processing: true,
		        serverSide: true,
		        //displayLength: 100,
		        ajax: {
		            url: 'info_contract_warranty_between_date_range/get_contract_warranty_between_date_range',
		            type: 'get',
		            data: app.create_form_object_data(jQuery('form[name="search_form"]'))/*,
		            dataSrc: function (json) {
		            	console.log(json);
			        }*/
		        },
		        columns: [
		            {data: 'running_no'},
		            {data: 'contract_no'},
		            {data: 'contract_name'},
		            {data: 'delivery_date'},
		            {data: 'start_date'},
		            {data: 'end_date'},
		            {data: 'tools'}
		        ],
		        drawCallback: function(settings) {
		        	data_contract_id_set = settings.json.contract_id_set

		        	app.data_table.set_full_width();
				}
			});

			jQuery('#table-list').removeClass('hide');
		}
	}
})();

var modal_warranty_detail_ = (function() {
	var _set_data_to_modal = function(data) {
		var contract_data = data.contract;
		var contract_warranty_detail_data = data.contract_warranty_detail;

		var modal = jQuery('#modal-warranty-detail');

		var _show_text_month_year = function(data_string) {
			if(data_string == undefined 
				|| data_string == null 
				|| data_string == '') {
				
				return '';
			}
			else {
				var result_convert_to_year_month 
					= app.date_util.convert_month_to_year_month(data_string);
				var str = result_convert_to_year_month.year 
					+ ' ' + app.translate('Year(s)')
					+ ' ' 
					+ result_convert_to_year_month.month
					+ ' ' + app.translate('Month(s)');

				return str;
			}
		};

		modal.find('#running-no-text').html(contract_data.running_no);
		modal.find('#contract-no-text').html(contract_data.contract_no);
		modal.find('#contract-name-text').html(contract_data.contract_name);
		modal.find('#delivery-date-text').html(contract_data.delivery_date);
		modal.find('#warranty-text').html(contract_data.warranty);

		if(contract_data.warranty_range == undefined 
			|| contract_data.warranty_range == null 
			|| contract_data.warranty_range == '') {
			modal.find('#warranty-range-text').html('');
		}
		else {
			var str = contract_data.warranty_range +' '+ app.translate('Month(s)');
			modal.find('#warranty-range-text').html(str);
		}

		modal.find('#warranty-total-month-text').html( 
			contract_data.warranty_total_month + ' ' + app.translate('Month(s)')
			+ ' (' + _show_text_month_year(contract_data.warranty_total_month) + ')' );

		var html_tr = '';

		for(var index in contract_warranty_detail_data) {
			var each_data = contract_warranty_detail_data[index];

			html_tr += '<tr>'
				+ '<td class="td-warranty-index">'+ (Number(index) + 1) +'</td>'
				+ '<td class="td-warranty-date">'+ each_data.warranty_date +'</td>'
				+ '<td>'+ app.value_utils.null_to_empty(each_data.warranty_remark) +'</td>'
				+ '<td>'+ app.value_utils.null_to_empty(each_data.status) +'</td>'
				+ '</tr>';
		}

		jQuery('#table-warranty-detail tbody').html(html_tr);
	};

	return {
		get_data: function(id) {
			app.loading('show');

			setTimeout(function() {
				jQuery.ajax({
					type: 'get',
					url: 'info_contract_warranty_between_date_range/get_info_data',
					data: {
						id: id
					},
					cache: false,
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

						_set_data_to_modal(response);

						app.loading('remove');

						jQuery('#modal-warranty-detail').modal('show');
					},
					error: function() {
						app.show_notice_error_occour();

						app.loading('remove');
					}
				});
			}, 500);
		}
	};
})();