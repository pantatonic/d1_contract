var _EVENT_WARRANTY_TYPE_ = 'warranty';
var _EVENT_MAINTENANCE_TYPE_ = 'maintenance';
var current_contract_id_detail = '';
var current_event_date_detail = '';
var current_event_type = '';

var latest_detail_status_id = '';

jQuery(document).ready(function() {
	jQuery('#modal-warranty-detail .modal-body, #modal-maintenance-detail .modal-body').css({
        'height': (jQuery(window).height() * 60)/ 100,
        'overflow-x': 'auto',
        'overflow-y': 'auto'
    });

	$('[data-toggle="tooltip"]').tooltip();

	page.init_event_calendar();

	page.set_color_block_explain();

	jQuery('.btn-save-loading').click(function() {
		page.save_detail_status();
	});
});

var page = (function() {

	return {
		init_event_calendar: function() {
			jQuery('#calendar').fullCalendar({
		        selectable: false,
		        selectHelper: true,
		        eventSources: [{
		            url: site_url + 'contract_list/work_calendar/feed', 
		            type: 'get',
		            data: function() {
		                var data_return = {
		                    current_date:jQuery('#calendar').fullCalendar('getDate').format()
		                };
		                return data_return;
		            }
		        }],
		        cache: false,
		        dayClick: function(date, jsEvent, view) {

		        },
		        eventClick: function(event) {
		            //event.start._i;

		            app.loading('show');
		            setTimeout(function() {
		            	event_calendar_.show_modal_contract_detail(event);
		            }, 500);
		        },
		        select: function(start, end, jsEvent, view) {
		            var start_ = new Date(start._d);
		                start_ = start_ / 1000;
		            var end_ = new Date(end._d);
		                end_ = end_ / 1000;

		            var diff = (end_-start_)/(60*60*24);

		            if(diff == 1) {
		                return false;
		            }
		            
		        },
		        eventRender: function(event, element, view) {
		          	element.find('span.fc-title').each(function() {
		          		var this_element = jQuery(this);
		          		var element_text = this_element.text();
		          		
		          		//this_element.html('<i class="fa fa-calendar"></i> ' + element_text);
		          		this_element.parent().attr('data-toggle', 'tooltip')
		          			.attr('title', element_text)
		          			.attr('data-placement', 'bottom');
		          	});
			    }
		    });
		},
		set_color_block_explain: function(){
			var warranty_block = jQuery('#warranty-block');
			var maintenance_block = jQuery('#maintenance-block');

			warranty_block.css({'background-color': '#' + jQuery('#contract_color_warranty').val()});
			maintenance_block.css({'background-color': '#' + jQuery('#contract_color_maintenance').val()});
		},
		save_detail_status: function() {
			var contract_id = current_contract_id_detail;
			var date_detail = current_event_date_detail;
			var detail_status_id = '';

			var validate = function(jquery_element) {
				jquery_element.removeClass(_REQUIRED_ERROR_CLASS_);

				if(app.value_utils.is_empty_value(jquery_element.val())) {
					jquery_element.addClass(_REQUIRED_ERROR_CLASS_);

					app.show_notice({
						type: _WARNING_, 
						message: app.translate('please_complete_information')
					});

					return false;
				}
				else {
					return true;
				}
			};

			var result_validate = null;

			if(current_event_type == _EVENT_WARRANTY_TYPE_) {
				var status_element = jQuery('#modal-warranty-detail [name="warranty_maintenance_detail_status_id"]');

				detail_status_id = status_element.val();
				result_validate = validate(status_element);
			}
			else
			if(current_event_type == _EVENT_MAINTENANCE_TYPE_) {
				var status_element = jQuery('#modal-maintenance-detail [name="warranty_maintenance_detail_status_id"]');

				detail_status_id = status_element.val();
				result_validate = validate(status_element);
			}

			var data_send = {
				contract_id: contract_id,
				date_detail: date_detail,
				detail_status_id: detail_status_id,
				event_type: current_event_type
			};
			data_send[csrf_name] = csrf_value;

			if(!result_validate) {
				return false;
			}



			var btn_save_loading = jQuery('.btn-save-loading');

			btn_save_loading.bootstrapBtn('loading');

			setTimeout(function() {
				jQuery.ajax({
					type: 'post',
					url: 'work_calendar/save_detail_status',
					data: data_send,
					cache: false,
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

						app.show_notice({
							type: response.result,
							message: response.message
						});

						btn_save_loading.bootstrapBtn('reset');
						jQuery('#calendar').fullCalendar('refetchEvents');
					},
					error: function() {
						app.show_notice_error_occour();

						btn_save_loading.bootstrapBtn('reset');
					}
				});
			}, 500);
		}
	};
})();

var event_calendar_ = (function() {
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

	var _set_data_warranty_to_modal = function(data) {
		var contract_data = data.contract;
		var contract_warranty_detail_data = data.contract_warranty_detail;

		var modal = jQuery('#modal-warranty-detail');

		var _generate_status = function(data, str) {
			if(data.contract_id == current_contract_id_detail 
				&& data.warranty_date == current_event_date_detail)  {

				latest_detail_status_id = data.contract_warranty_detail_status_id;

				return '<select name="warranty_maintenance_detail_status_id" class="form-control">'
					+ jQuery('#template-warranty-detail-status').html();
					+'</select>';
			}
			else {
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
				+ '<td>'+ _generate_status(each_data, app.value_utils.null_to_empty(each_data.status)) +'</td>'
				+ '</tr>';
		}

		jQuery('#table-warranty-detail tbody').html(html_tr);
		jQuery('#table-warranty-detail [name="warranty_maintenance_detail_status_id"]')
			.val(latest_detail_status_id);
	};

	var _set_data_maintenance_to_modal = function(data) {
		var contract_data = data.contract;
		var contract_maintenance_detail_data = data.contract_maintenance_detail;

		var modal = jQuery('#modal-maintenance-detail');

		var _generate_status = function(data, str) {
			if(data.contract_id == current_contract_id_detail 
				&& data.maintenance_date == current_event_date_detail)  {

				latest_detail_status_id = data.contract_maintenance_detail_status_id;

				return '<select name="warranty_maintenance_detail_status_id" class="form-control">'
					+ jQuery('#template-maintenance-detail-status').html();
					+'</select>';
			}
			else {
				return str;
			}
		};

		modal.find('#running-no-text').html(contract_data.running_no);
		modal.find('#contract-no-text').html(contract_data.contract_no);
		modal.find('#contract-name-text').html(contract_data.contract_name);
		modal.find('#delivery-date-text').html(contract_data.delivery_date);
		modal.find('#maintenance-text').html(contract_data.maintenance);

		if(contract_data.maintenance_range == undefined 
			|| contract_data.maintenance_range == null 
			|| contract_data.maintenance_range == '') {
			modal.find('#maintenance-range-text').html('');
		}
		else {
			var str = contract_data.maintenance_range +' '+ app.translate('Month(s)');
			modal.find('#maintenance-range-text').html(str);
		}

		modal.find('#maintenance-total-month-text').html( 
			contract_data.maintenance_total_month + ' ' + app.translate('Month(s)')
			+ ' (' + _show_text_month_year(contract_data.maintenance_total_month) + ')' );

		var html_tr = '';

		for(var index in contract_maintenance_detail_data) {
			var each_data = contract_maintenance_detail_data[index];

			html_tr += '<tr>'
				+ '<td class="td-maintenance-index">'+ (Number(index) + 1) +'</td>'
				+ '<td class="td-maintenance-date">'+ each_data.maintenance_date +'</td>'
				+ '<td>'+ app.value_utils.null_to_empty(each_data.maintenance_remark) +'</td>'
				+ '<td>'+ _generate_status(each_data, app.value_utils.null_to_empty(each_data.status)) +'</td>'
				+ '</tr>';
		}

		jQuery('#table-maintenance-detail tbody').html(html_tr);
		jQuery('#table-maintenance-detail [name="warranty_maintenance_detail_status_id"]')
			.val(latest_detail_status_id);
	};

	return {
		show_modal_contract_detail: function(event) {
			/*var event_type = event.event_type;
			var contract_id = event.contract_id;
			var maintenance_date = event.maintenance_date;
			var warranty_date = event.warranty_date;*/

			var event_detail_date = null;
			var target_url = null;
			var event_type_ = null;

			if(event.event_type == _EVENT_WARRANTY_TYPE_) {
				event_detail_date = event.warranty_date;
				target_url = 'info_contract_warranty_between_date_range/get_info_data';
				event_type_ = event.event_type;
			}
			else
			if(event.event_type == _EVENT_MAINTENANCE_TYPE_) {
				event_detail_date = event.maintenance_date;
				target_url = 'info_contract_maintenance_between_date_range/get_info_data';
				event_type_ = event.event_type;
			}

			/** set current event contract_id and event_date */
			current_contract_id_detail = event.contract_id;
			current_event_date_detail = event_detail_date;
			current_event_type = event_type_;

			var _get_event_detail_data = function() {
				jQuery.ajax({
					type: 'get',
					url: target_url,
					data: {
						id: event.contract_id
					},
					cache: false,
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

						if(event.event_type == _EVENT_WARRANTY_TYPE_) {
							_set_data_warranty_to_modal(response);

							jQuery('#modal-warranty-detail').modal('show');
						}
						else
						if(event.event_type == _EVENT_MAINTENANCE_TYPE_) {
							_set_data_maintenance_to_modal(response);

							jQuery('#modal-maintenance-detail').modal('show');
						}

						

						app.loading('remove');

						/*_set_data_to_modal(response);

						jQuery('#modal-contract-detail').modal('show');*/
					},
					error: function() {
						app.show_notice_error_occour();
						app.loading('remove');
					}

				});
			}


			_get_event_detail_data();
		}
	};
})();

