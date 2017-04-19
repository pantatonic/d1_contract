jQuery(document).ready(function() {
	setTimeout(function() {
		chart_.render.all_chart();
	}, 500);

	page.init_datetimepicker();
	
	page.init_refresh_chart_data();
});

var page = (function() {

	return {
		init_refresh_chart_data: function() {

			jQuery('.refresh-chart-data').click(function() {
				var target_operation = jQuery(this).attr('target-operation');
				eval(target_operation)();
			});
		},
		init_datetimepicker: function() {
			var _init_year_picker_warranty_maintenance_chart = function() {
				var year_picker = jQuery('#box-warranty-maintenance-chart .year-picker');

				year_picker.datetimepicker({
					ignoreReadonly: true,
			        format: 'YYYY',
			        viewMode: 'years',
			        defaultDate: false,
			        useCurrent: false,
			        widgetPositioning: {
			            horizontal: 'right',
			            vertical: 'bottom'
			        }
			    });

			    year_picker.on('dp.change', function(e) {
			    	chart_.render.warranty_maintenance_detail_in_year();
			    });
			};


			_init_year_picker_warranty_maintenance_chart();
		}
	};
})();

// Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.3, //0.5
                cy: 0.5, //0.3
                r: 0.9
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.9).get('rgb')] // darken 0.3 0.9
            ]
        };
    });

Highcharts.getOptions().plotOptions.pie.colors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 50; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

var chart_ = (function() {
	var _loading = function(jquery_chart_element, type) {
		if(type == 'show') {
			app.loading_in_element('show',
                    jquery_chart_element.parent().parent().parent());
		}
		else {
			app.loading_in_element('remove',
                    jquery_chart_element.parent().parent().parent());
		}
	};

	return {
		render: {
			all_chart: function() {
				this.contracts_by_bank();
				this.contracts_by_type();
				this.warranty_maintenance_detail_in_year();
			},
			contracts_by_bank: function() {
				_loading(jQuery('#contract-by-bank-chart'), 'show');

				setTimeout(function() {
					jQuery.ajax({
						type: 'get',
						url: 'dashboard/get_chart_contracts_by_bank',
						data:{},
						cache: false,
						beforeSend: function() {},
						success: function(response) {
							response = app.convert_to_json_object(response);

							_loading(jQuery('#contract-by-bank-chart'), 'remove');

							jQuery('#contract-by-bank-chart').highcharts({
				                chart: {
				                    type: 'pie',
				                    options3d: {
				                        enabled: true,
				                        alpha: 55,
				                        beta: 0,
				                        dept:50
				                    },
				                    style: {
				                        fontFamily: '"Source Sans Pro",sans-serif;',
				                    },
				                    spacingBottom: 10,
				                    spacingTop: 10,
				                    spacingLeft: 0,
				                    spacingRight: 0
				                },
				                title: {
				                    text: app.translate('all_contracts_group_by_bank_and_coporate_')
				                },
				                subtitle: {
				                    text: app.translate('Total contracts') 
				                    	+ ' : ' + response.total_contracts
				                    	+ ' ' + app.translate('issuance_'),
				                    useHTML: true
				                },
				                tooltip: {
				                    enabled: true
				                },
				                plotOptions: {
				                    pie: {
				                        animation: true,
				                        allowPointSelect: true,
				                        innerSize: 80,
				                        depth: 20,
				                        cursor: 'pointer',
				                        dataLabels: {
				                            enabled: true,
				                            /*color: '#FFFFFF',
				                            connectorColor: '#000000',*/
				                            useHTML:true,
				                            distance: 0.5,
				                            formatter: function() {
				                                return '<div class="datalabel">' 
				                                	+ app.translate('number_of_contracts_')
				                                	+ ' : ' + this.y.toString() 
				                                	+ '<br>['+this.percentage.toFixed(2)+'%]'+
				                                        '</div>';
				                            }
				                        },
				                        showInLegend: true
				                    }
				                },
				                series: [{
				                    name: app.translate('number_of_contracts_'),
				                    /*data: [
				                        ['ธนาคารกรุงเทพฯจำกัด มหาชน', 2],
				                        ['ธนาคารกสิกรไทย', 7],
				                        ['ธนาคาร ทหารไทย', 9],
				                        ['ธนาคาร อาคารสงเคราะห์', 19],
				                        ['ธนาคาร UOB', 2],
				                        ['ธนาคาร กรุงไทย', 21],
				                        ['ธนาคาร กรุงศรีอยุธยา', 9],
				                        ['ธนาคาร ธนชาติ', 4]
			                        ]*/
				                    data: response.data_set
				                }],
				                exporting: {
				                    enabled: false
				                },
				                credits: {
				                    enabled: false
				                }
				            });
						},
						error: function() {
							app.show_notice_error_occour();

							_loading(jQuery('#contract-by-bank-chart'), 'remove');
						}
					});
				}, 500);
				

				
			},
			contracts_by_type: function() {
				_loading(jQuery('#contract-by-type-chart'), 'show');

				setTimeout(function() {
					jQuery.ajax({
						type: 'get',
						url: 'dashboard/get_chart_contracts_by_type',
						data:{},
						cache: false,
						beforeSend: function() {},
						success: function(response) {
							response = app.convert_to_json_object(response);

							_loading(jQuery('#contract-by-type-chart'), 'remove');

							jQuery('#contract-by-type-chart').highcharts({
				                chart: {
				                    plotBackgroundColor: null,
				                    plotBorderWidth: null,
				                    plotShadow: false,
				                    type: 'pie',
				                    style: {
				                        fontFamily: '"Source Sans Pro",sans-serif;'
				                    },
				                    spacingBottom: 10,
				                    spacingTop: 10,
				                    spacingLeft: 0,
				                    spacingRight: 0
				                },
				                title: {
				                    text: app.translate('all_contract_group_by_type')
				                },
				                subtitle: {
				                    text: app.translate('Total contracts') 
				                    	+ ' : ' + response.total_contracts
				                    	+ ' ' + app.translate('issuance_'),
				                    useHTML: true
				                },
				                tooltip: {
				                    enabled: true,
				                    //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
				                    pointFormat: '<b>{series.name}</b>: {point.y:.2f} ',
				                    shadow: true,
				                    useHTML: true
				                },
				                plotOptions: {
				                    pie: {
				                        animation: true,
				                        allowPointSelect: true,
				                        cursor: 'pointer',
				                        dataLabels: {
				                            enabled: true,
				                            /*color: '#FFFFFF',
				                            connectorColor: '#000000',*/
				                            useHTML:true,
				                            distance: 20,
				                            /*style: {
				                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
				                            },*/
				                            formatter: function() {
				                                return '<div class="datalabel">' 
				                                	+ app.translate('number_of_contracts_')
				                                	+ ' : ' + this.y.toString()
				                                	+ '<br>['+this.percentage.toFixed(2)+'%]'+
				                                        '</div>';
				                            }
				                        },
				                        showInLegend: true
				                    }
				                },
				                series: [{
				                    name: app.translate('number_of_contracts_'),
				                    colorByPoint: true,
				                    /*data: [
				                        ['ซื้อ HW,SW MA', 2],
				                        ['ซื้อขาย HW และ MA', 7],
				                        ['ซื้อขาย MA', 9],
				                        ['ซื้อขาย SW และ MA', 19]
			                        ]*/
				                    data: response.data_set
				                }],
				                exporting: {
				                    enabled: false
				                },
				                credits: {
				                    enabled: false
				                }
				            });
						},
						error: function() {
							app.show_notice_error_occour();

							_loading(jQuery('#contract-by-type-chart'), 'show');
						}
					});
				}, 500);
			},
			warranty_maintenance_detail_in_year: function() {
				var year_ = jQuery('#box-warranty-maintenance-chart [name="year_"]');

				_loading(jQuery('#warranty-maintenance-detail-chart'), 'show');

				setTimeout(function() {
					jQuery.ajax({
						type: 'get',
						url: 'dashboard/get_chart_warranty_maintenance_each_month',
						data:{
							year: year_.val()
						},
						cache: false,
						beforeSend: function() {},
						success: function(response) {
							response = app.convert_to_json_object(response);

							_loading(jQuery('#warranty-maintenance-detail-chart'), 'remove');

							jQuery('#warranty-maintenance-detail-chart').highcharts({
								title: {
							        text: app.translate('warranty_maintenance_detail_each_month_in_year_') 
							        	+' ' + response.year,
							        x: -20 //center
							    },
							    subtitle: {
							        text: app.translate('Warranty') + ' : ' 
							        	+ response.warranty.total + ' ' + app.translate('number_time_')
							        	+ ', '
							        	+ app.translate('ma_') + ' : ' 
							        	+ response.maintenance.total + ' ' + app.translate('number_time_'),
							        x: -20
							    },
							    xAxis: {
							        categories: response.month_short_name
							    },
							    yAxis: {
							    	min: 0,
							    	allowDecimals: false,
							        title: {
							            text: app.translate('work_number_time_')
							        },
							        plotLines: [{
							            value: 0,
							            width: 1,
							            color: '#808080'
							        }]
							    },
							    tooltip: {
							        valueSuffix: ' ' + app.translate('number_time_')
							    },
							    legend: {
							        layout: 'vertical',
							        align: 'right',
							        verticalAlign: 'middle',
							        borderWidth: 0
							    },
							    /*series: [{
							        name: 'Tokyo',
							        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
							    }, {
							        name: 'New York',
							        data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
							    }],*/
							    series: [{
							    	name: response.warranty.name,
							    	data: response.warranty.data_set
							    },{
							    	name: response.maintenance.name,
							    	data: response.maintenance.data_set
							    }],
							    exporting: {
				                    enabled: false
				                },
				                credits: {
				                    enabled: false
				                }
							});
						},
						error: function() {
							app.show_notice_error_occour();

							_loading(jQuery('#warranty-maintenance-detail-chart'), 'show');
						}
					});
				}, 500);

				
			},
			warranty_detail_in_year: function() {

			},
			maintenance_detail_in_year: function() {

			}
		}
	};
})();