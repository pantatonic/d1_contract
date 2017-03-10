var app = {

    loading : function(type) {
        if (type == 'show') {
            if (jQuery('#overlay').length > 0) {
                return false;
            }
            var over = '<div id="overlay">' +
                '<img id="loading" src="'+base_url+'assets/dist/img/loading.gif">' +
                '</div>';
            jQuery(over).appendTo('body');
        }
        else if (type == 'remove') {
            jQuery('#overlay').remove();
        }
    },

    loading_in_element : function(type,element_object) {
        if (type == 'show') {
            if (jQuery('#overlay-in-element').length > 0) {
                return false;
            }
            var over = '<div class="overlay-in-element">' +
                '<img class="loading_2" src="'+base_url+'assets/dist/img/loading.gif">' +
                '</div>';
            element_object.prepend(over);
        }
        else if (type == 'remove') {
            element_object.find('.overlay-in-element').remove();
            
        }
    },

    get_now_timestamp : function() {
        return new Date().getTime()
    },

    get_number_format : function(number) {
        if(number == null) {
            return '';
        }

        if(app.value_utils.is_empty_value(number)) {
            return '';
        }

        if(typeof number !== 'number') {
            number = Number(number);
        }

        return number.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')
    },

    remove_comma : function(string) {
        return string.replace(/,/g, '')
    },
  
    translate : function(key) {
        var js_string = jQuery('#js_language_strings').text();
        js_string = JSON.parse(js_string);

        if(key in js_string) {
            return js_string[key];
        }
        else {
            return key;
        }
    },
	
	get_file_info : function(file_element) {
		var file = $(file_element)[0].files[0];	
		return file;
	},

    set_animate_custom : function(element,animate_type,delay_millisec) {
        delay_millisec = delay_millisec || 2000;
        element.addClass('animated '+animate_type);
        setTimeout(function() {
            element.removeClass('animated');
            element.removeClass(animate_type);
        },delay_millisec);
    },

    create_form_object_data: function(jquery_form_object) {
        var input_form_data = jquery_form_object.serializeArray();
        var data_send = {};

        for (var index in input_form_data) {
            data_send[input_form_data[index].name] = input_form_data[index].value;
        }

        return data_send;
    },

    convert_to_json_object: function(data) {
        if(typeof data !== 'object') {
            try {
                return JSON.parse(data);
            }
            catch(e) {
                return data;
            }
        }
        else {
            return data;
        }
    },

    clear_form_data: function(jquery_form_object) {
        var reset_button = jQuery('<button/>', {
            type: 'reset',
            html: 'Reset',
            style: 'display: none'
        });
        
        reset_button.appendTo(jquery_form_object);
        jquery_form_object.find('button[type="reset"]').click();
        reset_button.remove();
    },

    check_notice_exist: function(specify_class) {
        if(specify_class == undefined) {
            return jQuery('.ui-pnotify').length > 0 ? true : false;    
        }
        else {
            return jQuery('.'+ specify_class).length > 0 ? true : false;
        }
    },

    show_notice: function(options) {
        if(options.addclass == undefined) {
            options.addclass = '';
        }

        new PNotify({
            title: app.translate('Message'),
            text: options.message,
            type: options.type,
            addclass: options.addclass
        });
    },

    show_notice_error_occour: function() {
        new PNotify({
            title: app.translate('Message'),
            text: app.translate('error_occurred'),
            type: _ERROR_
        });
    },

    form_redirect_post: function(jquery_form_element, target_url, params) {
        jquery_form_element.attr('action', target_url);

        jquery_form_element.find('input').filter(function() {
            return jQuery(this).attr('name') != csrf_name ? true : false;
        }).remove();

        for(var key in params) {
            jQuery('<input>').attr({
                type: 'hidden',
                id: key,
                name: key,
                value: params[key]
            }).appendTo('form#' + jquery_form_element.attr('id'));
        }

        setTimeout(function() {
            jquery_form_element.submit();
        }, 300);
    },

    /**
    * value utilities
    */
    value_utils: {

        is_empty_value: function(string_data) {
            return (string_data.trim() == '' ? true : false);
        },
        undefined_to_empty: function(data) {
            return data == undefined ? '':data;
        },
        null_to_empty: function(data) {
            return data == null ? '':data;
        }

    },

    /**
    * page utilities
    */
    page_utils: {

        remove_element: function(jquery_element_object) {
            jquery_element_object.fadeOut('fast', function () {
                $(this).remove();
            });
        }

    },

    /**
    * data table
    */
    data_table: {
        set_full_width: function() {
            setTimeout(function() {
                jQuery('.dataTable').css({
                    width: '100%'
                });
            }, 10);
        }
    },

    date_util: {
        validate_date_range: function(startDate, endDate) {
            if (startDate === '' || endDate === '') {
                return false;
            }
          
            var separator = '-';
            var startDateTimeStamp = new Date(startDate.split(separator).join(separator)).getTime();
            var endDateTimeStamp = new Date(endDate.split(separator).join(separator)).getTime();

            if (startDateTimeStamp > endDateTimeStamp) {
                return false;
            } else {
                return true;
            }
        },
        convert_month_to_year_month: function(month_number) {
            var month_number_ = Number(month_number);

            return {
                year: Math.floor(month_number_ / 12),
                month: month_number_ % 12
            }
        }
    },

    form_utils: {
        simple_validate_required_field: function(jquery_form_object) {
            var validate_pass = true;
            var required_element = jquery_form_object.find('.' + _REQUIRED_CLASS_);
            
            required_element.removeClass(_REQUIRED_ERROR_CLASS_);

            required_element.each(function() {
                var this_element = $(this);

                if(app.value_utils.is_empty_value(this_element.val())) {
                    validate_pass = false;
                    this_element.addClass(_REQUIRED_ERROR_CLASS_);
                }
            });

            return validate_pass;
        }
    },

    table_utils: {
        remove_tr: function (tr_element) {
            tr_element.fadeOut('slow', function() {
                jQuery(this).remove();
            });
        },
        order_sequence: function (table_object, order_column) {
            table_object.find('tbody tr').each(function (index) {
                jQuery(this).find('td').eq(order_column).html(index + 1);
            });
        },
        check_all_empty_input_in_tr: function (tr_object) {
            var input_in_tr = tr_object.find(':input');
            var all_input_empty = true;

            input_in_tr.each(function () {
                if ($(this).prop('tagName') === 'INPUT') {
                    if ($(this).attr('type') === 'hidden') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            if (!!$(this).val()) {
                                all_input_empty = false;
                            }
                        }
                    } else if ($(this).attr('type') === 'text') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            //if (!!$(this).val()) {
                            if (!!$(this).val() != '') {
                                all_input_empty = false;
                            }
                        }
                    } else if ($(this).attr('type') === 'number') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            if (!!$(this).val()) {
                                all_input_empty = false;
                            }
                        }
                    } else if ($(this).attr('type') === 'checkbox') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            if ($(this).is(':checked')) {
                                all_input_empty = false;
                            }
                        }
                    } else if ($(this).attr('type') === 'radio') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            if ($('input[name="' + $(this).attr('name') + '"]:checked').size() > 0) {
                                all_input_empty = false;
                            }
                        }
                    } else if ($(this).attr('type') === 'file') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            if (!!$(this).val()) {
                                all_input_empty = false;
                            }
                        }
                    }
                } else if ($(this).prop('tagName') === 'SELECT') {
                    if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                        if (!!$(this).val()) {
                            all_input_empty = false;
                        }
                    }
                } else if ($(this).prop('tagName') === 'TEXTAREA') {
                    if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                        if (!!$(this).val()) {
                            all_input_empty = false;
                        }
                    }
                }

                //console.log($(this), $(this).attr('type'), $(this).val(), allInputEmpty);
            });

            return all_input_empty;
        }
    }

};
