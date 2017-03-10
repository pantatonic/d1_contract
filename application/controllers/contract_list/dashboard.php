<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model(array(
        	'dashboard_model'
    	));
    }

    public function addition_resources_script() {
        $resources_script = array(
            'js' => array(
                '<script type="text/javascript" src="'.base_url().'assets/highcharts/js/highcharts.js"></script>',
                '<script type="text/javascript" src="'.base_url().'assets/highcharts/js/highcharts-3d.js"></script>',
                '<script type="text/javascript" src="'.base_url().'assets/highcharts/js/modules/exporting.js"></script>'
            )
        );

        return $resources_script;
    }

    public function index() {
    	$data_send = array(
            'page_title' => ci_trans('dashboard_')
        );

        $this->page_render($data_send);
    }

    public function get_chart_contracts_by_bank() {
    	$result = $this->dashboard_model->get_chart_contracts_by_bank();

    	$total_contracts = 0;

    	$data_set = array();
    	foreach($result as $data) {
    		$temp_array = array();

    		$total_contracts = $total_contracts + $data['count_data'];

    		array_push($temp_array, $data['name']);
    		array_push($temp_array, intval($data['count_data']));

    		array_push($data_set, $temp_array);
    	}

    	echo json_encode(array(
    		'data_set' => $data_set,
    		'total_contracts' => $total_contracts
		));
    }

    public function get_chart_contracts_by_type() {
    	$result = $this->dashboard_model->get_chart_contracts_by_type();

    	$total_contracts = 0;

    	$data_set = array();
    	foreach($result as $data) {
    		$temp_array = array();

    		$total_contracts = $total_contracts + $data['count_data'];

    		array_push($temp_array, $data['contract_type']);
    		array_push($temp_array, intval($data['count_data']));

    		array_push($data_set, $temp_array);
    	}

    	echo json_encode(array(
    		'data_set' => $data_set,
    		'total_contracts' => $total_contracts
		));
    }

    public function get_chart_warranty_maintenance_each_month() {
    	$year = $this->input->get('year');

    	$start_date = $year.'-01-01';
    	$end_date = $year.'-12-31';

    	$data_return = array();
    	$data_return['month_short_name'] = array(
    		ci_trans('Jan'), ci_trans('Feb'), ci_trans('Mar'), ci_trans('Apr'),
    		ci_trans('May'), ci_trans('Jun'), ci_trans('Jul'), ci_trans('Aug'),
    		ci_trans('Sep'), ci_trans('Oct'), ci_trans('Nov'), ci_trans('Dec'),
		);

    	$array_month_warranty = array();
    	$array_month_maintenance = array();
    	$count_data_warranty = 0;
    	$count_data_maintenance = 0;
		for($i = 0; $i <= 11; $i++) {
			array_push($array_month_warranty, 0);
			array_push($array_month_maintenance, 0);
		}

	   	$result_warranty_detail 
    		= $this->dashboard_model->get_chart_warranty_detail_each_month($start_date, $end_date);

		foreach($result_warranty_detail as $w) {
			$month_number_ = $w['month_number'];
			$count_data_warranty = $count_data_warranty + $w['count_data'];

			$array_month_warranty[$month_number_ - 1] = intval($w['count_data']);
		}
		
		$data_return[common_string::_WARRANTY_]['data_set'] = $array_month_warranty;
		$data_return[common_string::_WARRANTY_]['name'] = ci_trans('Warranty');
		$data_return[common_string::_WARRANTY_]['total'] = $count_data_warranty;

		$result_maintenance_detail 
			= $this->dashboard_model->get_chart_maintenance_detail_each_month($start_date, $end_date);

		foreach($result_maintenance_detail as $m) {
			$month_number_ = $m['month_number'];
			$count_data_maintenance = $count_data_maintenance + $m['count_data'];

			$array_month_maintenance[$month_number_ - 1] = intval($m['count_data']);
		}

		$data_return[common_string::_MAINTENANCE_]['data_set'] = $array_month_maintenance;
		$data_return[common_string::_MAINTENANCE_]['name'] = ci_trans('ma_');
		$data_return[common_string::_MAINTENANCE_]['total'] = $count_data_maintenance;

		$data_return['year'] = $year;

		echo json_encode($data_return);
    }

}