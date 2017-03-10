var bank_list_table_loading_tr;

jQuery(document).ready(function() {
	bank_list_table_loading_tr = jQuery('#bank-list-table tbody').html();

	bank_list_table_.get_bank_list();

	jQuery('#modal-bank-edit').on('show.bs.modal', function () {
		$(this).find('.'+_REQUIRED_ERROR_CLASS_)
			.removeClass(_REQUIRED_ERROR_CLASS_);
	});

	jQuery('#new-bank').click(function() {
		app.clear_form_data(jQuery('form[name="edit_form"]'));
		jQuery('#modal-bank-edit [name="id"]').val('');

		jQuery('#modal-bank-edit').modal('show');

		modal_bank_edit_.set_focus_input();
	});

	page.init_save_bank();

	jQuery('#bank-list-table').on('dblclick', 'tbody tr', function() {
		var id = jQuery(this).find('span').attr('data-id');
		alert_util.confirmAlert('<p class="text-danger">' +
			app.translate('This change does affect the functionality of the system.') 
			+ '<br>' + app.translate('Please confirm to continue.') + '</p>'
			, function() {
			modal_bank_edit_.get_bank_data(id);
		},{
			animation: false,
			type: null
		});
	});
	
});

var page = (function() {

	return {
		init_save_bank: function() {
			jQuery('form[name="edit_form"]').submit(function(e) {
				e.preventDefault();

				modal_bank_edit_.save_bank();
			});
		}
	};
})();

var bank_list_table_ = (function() {

	return {
		get_bank_list: function() {
			jQuery('#bank-list-table').dataTable({
				destroy: true,
				autoWidth: false,
				processing: true,
		        serverSide: true,
		        //displayLength: 100,
		        bFilter: true,
		        ajax: {
		            url: 'bank_list/get_bank_list',
		            type: 'get'
		        },
		        columns: [
		            {data: 'short_name'},
		            {data: 'name'}
		        ],
		        drawCallback: function(settings) {
		        	app.data_table.set_full_width();
				}
			});
		}
	}
})();

var modal_bank_edit_ = (function() {
	var _set_data_to_input = function(data) {
		var modal_bank_edit = jQuery('#modal-bank-edit');

		for(var index in data) {
			modal_bank_edit.find('[name="'+ index +'"]').val(data[index]);
		}

	};

	return {
		set_focus_input: function() {
			setTimeout(function() {
				jQuery('#modal-bank-edit [name="short_name"]').focus();
			}, 500);
		},
		set_id_modal: function(id) {
			jQuery('#modal-bank-edit').find('[name="id"]').val(id);
		},
		get_bank_data: function(id) {
			app.loading('show');

			setTimeout(function() {
				jQuery.ajax({
					type: 'get',
					url: 'bank_list/get_bank_by_id',
					cache: false,
					data: {
						id: id
					},
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

						app.loading('remove');

						modal_bank_edit_.set_id_modal(id);

						_set_data_to_input(response);

						jQuery('#modal-bank-edit').modal('show');

						modal_bank_edit_.set_focus_input();
					},
					error: function() {
						app.show_notice_error_occour();

						app.loading('remove');
					}
				});
			}, 500);
		},
		save_bank: function() {
			var result_simple_validate = app.form_utils.simple_validate_required_field(jQuery('form[name="edit_form"]'));
			var button_sumit_loading = jQuery('#modal-bank-edit .btn-submit-loading');

			setTimeout(function() {
				if(result_simple_validate) {
					var form_data = jQuery('form[name="edit_form"]').serialize();

					jQuery.ajax({
						type: 'post',
						url: 'bank_list/save_bank',
						data: form_data,
						cache: false,
						beforeSend: function() {},
						success: function(response) {
							response = app.convert_to_json_object(response);

							//jQuery('#bank-list-table tbody').html(bank_list_table_loading_tr);

							if(response.result == _SUCCESS_) {
								jQuery('#modal-bank-edit').modal('hide');
								bank_list_table_.get_bank_list();
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