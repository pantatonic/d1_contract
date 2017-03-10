var site_url;
var base_url;
var csrf_name;
var csrf_value;

var _REQUIRED_CLASS_ = 'required-field';
var _REQUIRED_ERROR_CLASS_ = 'required-field-error';
var _SUCCESS_ = 'success';
var _ERROR_ = 'error';
var _INFO_ = 'info';
var _WARNING_ = 'warning';
var _DELETE_CLASS_NAME_ = 'delete-icon';

jQuery(document).ready(function() {
    site_url = jQuery('[name="site_url"]').val();
	base_url = jQuery('[name="base_url"]').val();
    csrf_name = jQuery('[name="csrf_name"]').val();
    csrf_value = jQuery('[name="csrf_value"]').val();

    jQuery('body').on('mouseover', '.'+ _DELETE_CLASS_NAME_, function() {
        jQuery(this).css({'cursor':'pointer'});
    });

    jQuery.extend($.fn.dataTable.defaults, {
        /*lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],*/
        bLengthChange: false,
        displayLength: 10,
        language: {
            url: base_url + 'assets/data_table/languages/' + _LOCALE_ + '.json'
        },
        ordering: false,
        bFilter: false,
        pagingType: 'full_numbers'
    });

    jQuery.extend($.fn.datetimepicker.defaults, {
        locale: _LOCALE_SHORT_(_LOCALE_),
        ignoreReadonly: true
    });

    jQuery('form.form-submit').submit(function(e) {
        e.preventDefault();
        var this_form = jQuery(this);
        jQuery('.btn-submit-loading').bootstrapBtn('loading');
        setTimeout(function() {
            this_form.unbind().submit()
        },500);
    });

    jQuery('body').on('keydown keyup paste', '.integer-only', function(e) {
        var arr_allow = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            'Backspace', 'Delete', 'Del', 'Control', 'F5', 'Tab'];

        if(jQuery.inArray(e.key, arr_allow) == -1) {
            e.preventDefault();
            return false;
        }
    });

    jQuery('.btn-submit-loading').click(function() {
        jQuery(this).bootstrapBtn('loading');
    });

    jQuery('.number-digit-0').mask("#,###", {
        reverse: true
    });

    jQuery('.number-digit-2').mask("###,###,###,###,###,###,###.##", {
        reverse: true
    });
});
