jQuery(document).ready(function() {
	list_table_.get_list();

	jQuery('#modal-edit').on('show.bs.modal', function () {
		$(this).find('.'+_REQUIRED_ERROR_CLASS_)
			.removeClass(_REQUIRED_ERROR_CLASS_);
	});

	jQuery('#new').click(function() {
		app.clear_form_data(jQuery('form[name="edit_form"]'));
		jQuery('#modal-edit [name="id"]').val('');

		jQuery('#modal-edit').modal('show');

		modal_edit_.set_focus_input();
	});

	page.init_save();

	jQuery('#list-table').on('dblclick', 'tbody tr', function() {
		var id = jQuery(this).find('span').attr('data-id');
		alert_util.confirmAlert('<p class="text-danger">' +
			app.translate('This change does affect the functionality of the system.') 
			+ '<br>' + app.translate('Please confirm to continue.') + '</p>'
			, function() {
			modal_edit_.get_data(id);
		},{
			animation: false,
			type: null
		});
	});
});

var page = (function() {

	return {
		init_save: function() {
			jQuery('form[name="edit_form"]').submit(function(e) {
				e.preventDefault();

				modal_edit_.save();
			});
		}
	};
})();

var list_table_ = (function() {

	return {
		get_list: function() {
			jQuery('#list-table').dataTable({
				destroy: true,
				autoWidth: false,
				processing: true,
		        serverSide: true,
		        //displayLength: 100,
		        bFilter: true,
		        ajax: {
		            url: 'contract_maintenance_detail_status/get_contract_maintenance_detail_status_list',
		            type: 'get'
		        },
		        columns: [
		            {data: 'status'}
		        ],
		        drawCallback: function(settings) {
		        	app.data_table.set_full_width();
				}
			});
		} 
	};
})();

var modal_edit_ = (function() {
	var _set_data_to_input = function(data) {
		var modal_edit = jQuery('#modal-edit');

		for(var index in data) {
			modal_edit.find('[name="'+ index +'"]').val(data[index]);
		}

	};

	return {
		set_focus_input: function() {
			setTimeout(function() {
				jQuery('#modal-edit [name="status"]').focus();
			}, 500);
		},
		set_id_modal: function(id) {
			jQuery('#modal-edit').find('[name="id"]').val(id);
		},
		get_data: function(id) {
			app.loading('show');

			setTimeout(function() {
				jQuery.ajax({
					type: 'get',
					url: 'contract_maintenance_detail_status/get_contract_maintenance_detail_status_by_id',
					cache: false,
					data: {
						id: id
					},
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

						app.loading('remove');

						modal_edit_.set_id_modal(id);

						_set_data_to_input(response);

						jQuery('#modal-edit').modal('show');

						modal_edit_.set_focus_input();
					},
					error: function() {
						app.show_notice_error_occour();

						app.loading('remove');
					}
				});
			}, 500);
		},
		save: function() {
			var result_simple_validate = app.form_utils.simple_validate_required_field(jQuery('form[name="edit_form"]'));
			var button_sumit_loading = jQuery('#modal-edit .btn-submit-loading');

			setTimeout(function() {
				if(result_simple_validate) {
					var form_data = jQuery('form[name="edit_form"]').serialize();

					jQuery.ajax({
						type: 'post',
						url: 'contract_maintenance_detail_status/save_contract_maintenance_detail_status',
						data: form_data,
						cache: false,
						beforeSend: function() {},
						success: function(response) {
							response = app.convert_to_json_object(response);

							if(response.result == _SUCCESS_) {
								jQuery('#modal-edit').modal('hide');
								list_table_.get_list();
							}

							app.show_notice({
								type: response.result,
								message: response.message
							});
						},
						error: function() {
							app.show_notice_error_occour();
							
						},
						complete: function() {
							button_sumit_loading.bootstrapBtn('reset');
						}
					});
				}
				else {
					app.show_notice({
						type: _WARNING_, 
						message: app.translate('please_complete_information')
					});

					button_sumit_loading.bootstrapBtn('reset');
				}
			}, 500);
		}
	};
})();	