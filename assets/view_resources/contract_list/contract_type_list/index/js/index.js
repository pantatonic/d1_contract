jQuery(document).ready(function() {
	contract_type_list_table_.get_contract_type_list();

	jQuery('#modal-contract-type-edit').on('show.bs.modal', function () {
		$(this).find('.'+_REQUIRED_ERROR_CLASS_)
			.removeClass(_REQUIRED_ERROR_CLASS_);
	});

	jQuery('#new-contract-type').click(function() {
		app.clear_form_data(jQuery('form[name="edit_form"]'));
		jQuery('#modal-contract-type-edit [name="id"]').val('');

		jQuery('#modal-contract-type-edit').modal('show');

		modal_contract_type_edit_.set_focus_input();
	});

	page.init_save_contract_type();

	jQuery('#contract-type-list-table').on('dblclick', 'tbody tr', function() {
		var id = jQuery(this).find('span').attr('data-id');
		alert_util.confirmAlert('<p class="text-danger">' +
			app.translate('This change does affect the functionality of the system.') 
			+ '<br>' + app.translate('Please confirm to continue.') + '</p>'
			, function() {
			modal_contract_type_edit_.get_contract_type_data(id);
		},{
			animation: false,
			type: null
		});
	});


});

var page = (function() {

	return {
		init_save_contract_type: function() {
			jQuery('form[name="edit_form"]').submit(function(e) {
				e.preventDefault();

				modal_contract_type_edit_.save_contract_type();
			});
		}
	};
})();


var contract_type_list_table_ = (function() {

	return {
		get_contract_type_list: function() {
			jQuery('#contract-type-list-table').dataTable({
				destroy: true,
				autoWidth: false,
				processing: true,
		        serverSide: true,
		        //displayLength: 100,
		        bFilter: true,
		        ajax: {
		            url: 'contract_type_list/get_contract_type_list',
		            type: 'get'
		        },
		        columns: [
		            {data: 'contract_type'}
		        ],
		        drawCallback: function(settings) {
		        	app.data_table.set_full_width();
				}
			});
		}
	};
})();

var modal_contract_type_edit_ = (function() {
	var _set_data_to_input = function(data) {
		var modal_contract_type_edit = jQuery('#modal-contract-type-edit');

		for(var index in data) {
			modal_contract_type_edit.find('[name="'+ index +'"]').val(data[index]);
		}

	};

	return {
		set_focus_input: function() {
			setTimeout(function() {
				jQuery('#modal-contract-type-edit [name="contract_type"]').focus();
			}, 500);
		},
		set_id_modal: function(id) {
			jQuery('#modal-contract-type-edit').find('[name="id"]').val(id);
		},
		get_contract_type_data: function(id) {
			app.loading('show');

			setTimeout(function() {
				jQuery.ajax({
					type: 'get',
					url: 'contract_type_list/get_contract_type_by_id',
					cache: false,
					data: {
						id: id
					},
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

						app.loading('remove');

						modal_contract_type_edit_.set_id_modal(id);

						_set_data_to_input(response);

						jQuery('#modal-contract-type-edit').modal('show');

						modal_contract_type_edit_.set_focus_input();
					},
					error: function() {
						app.show_notice_error_occour();

						app.loading('remove');
					}
				});
			}, 500);
		},
		save_contract_type: function() {
			var result_simple_validate = app.form_utils.simple_validate_required_field(jQuery('form[name="edit_form"]'));
			var button_sumit_loading = jQuery('#modal-contract-type-edit .btn-submit-loading');

			setTimeout(function() {
				if(result_simple_validate) {
					var form_data = jQuery('form[name="edit_form"]').serialize();

					jQuery.ajax({
						type: 'post',
						url: 'contract_type_list/save_contract_type',
						data: form_data,
						cache: false,
						beforeSend: function() {},
						success: function(response) {
							response = app.convert_to_json_object(response);

							if(response.result == _SUCCESS_) {
								jQuery('#modal-contract-type-edit').modal('hide');
								contract_type_list_table_.get_contract_type_list();
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