jQuery(document).ready(function() {
	var data1Element = jQuery('.dtpicker');
	page.list_data();

	data1Element.datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'        
    });

    data1Element.on('dp.change', function() {

    });

	jQuery('form[name="search_form"]').submit(function(event) {
		event.preventDefault();
		page.list_data();
	});
});

var page = (function() {

	return {
		list_data: function() {
			jQuery('#table-list').dataTable({
				destroy: true,
				processing: true,
		        serverSide: true,
		        ajax: {
		            url: 'test/test_datatable',
		            type: 'get',
		            data: app.create_form_object_data($('form[name="search_form"]'))
		        },
		        columns: [
		            {data: 'head_column_1'},
		            {data: 'head_column_2'},
		            {data: 'head_column_3'}
		        ],
		        drawCallback: function( settings ) {
		        	setTimeout(function() {
		        		jQuery('.dataTable').css({
					    	width: 'inherit'
					    });
		        	}, 10);
				    
				}
			});
		}
	};
})();