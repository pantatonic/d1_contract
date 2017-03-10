jQuery(document).ready(function() {
	chk_box.init_chk_box();

	chk_box.set_value_after_page_load();

	page.init_save();
});

var page = (function() {

	return {
		init_save: function() {
			jQuery('form[name="edit_form"]').submit(function(e) {
				e.preventDefault();

				page.save();
			});
		},
		save: function() {
			var form_data = jQuery('form[name="edit_form"]').serialize();
			var button_sumit_loading = jQuery('form[name="edit_form"] .btn-submit-loading');

			setTimeout(function() {
				jQuery.ajax({
					type: 'post',
					url: 'contract_mandatory_field/save_contract_mandatory_field',
					data: form_data,
					cache: false,
					beforeSend: function() {},
					success: function(response) {
						response = app.convert_to_json_object(response);

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
			}, 500);
		}
	};
})();

var chk_box = (function() {
	return {
		set_value_after_page_load: function() {
			var list_table = jQuery('#list-table');

			list_table.find('tbody tr').each(function() {
				var this_tr = jQuery(this);
				var this_checkbox = this_tr.find('input[type="checkbox"].chk-box');
				var mandatory_element = this_tr.find('[name="mandatory[]"]');
				
				if(this_checkbox.is(':checked')) {
					mandatory_element.val('1');
				}
				else {
					mandatory_element.val('0');
				}
			});
		},
		init_chk_box: function() {
			jQuery('input[type="checkbox"].chk-box').click(function() {
				var this_checkbox = jQuery(this);
				var this_tr = this_checkbox.closest('tr');
				var mandatory_element = this_tr.find('[name="mandatory[]"]');
				
				if(this_checkbox.is(':checked')) {
					mandatory_element.val('1');
				}
				else {
					mandatory_element.val('0');
				}
			});
		}
	};
})();