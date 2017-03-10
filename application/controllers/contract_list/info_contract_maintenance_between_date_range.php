<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_contract_maintenance_between_date_range extends MY_Controller {

	public function __construct() {
        parent::__construct();
    }

    public function index() {
    	$this->load->model(array('contract_maintenance_detail_status_model'));

    	$data_send = array(
            'page_title' => ci_trans('info_maintenance_between_date_range_'),
            'default_date_search' => array(
        		'begin' => date('Y-m-01'),
        		'end' => date('Y-m-t', strtotime(date('Y-m-d')))
        	),
        	'contract_maintenance_detail_status' => $this->contract_maintenance_detail_status_model->get_all()
        );

        $this->page_render($data_send);
    }

    public function get_contract_maintenance_between_date_range() {
    	$this->load->model(array('contract_maintenance_detail_model', 'contract_list_model'));

    	$draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');

        $result_get_contract_id
        	= $this->contract_maintenance_detail_model
        		->get_contract_id_maintenance_between_date_range($start, $length);

		$temp_array_contract_id = array();
    	foreach($result_get_contract_id as $rgc) {
    		array_push($temp_array_contract_id, $rgc['contract_id']);
    	}

    	if(count($result_get_contract_id) == 0) {
			$data_return = array(
	            'draw' => $draw,
	            'recordsTotal' => 0,
	            'recordsFiltered' => 0,
	            'data' => array(),
                'contract_id_set' => array()
	        );

	        echo json_encode($data_return);
	        exit;
		}

		$result_list 
    		= $this->contract_list_model
    			->get_contract_by_contract_id_set($start, $length, $temp_array_contract_id);

		$array_data = array();
		foreach($result_list['data'] as $data) {
            $temp_array = array();

            $temp_array['running_no'] = $data['running_no'];
            $temp_array['contract_no'] = $data['contract_no'];
            $temp_array['contract_name'] = $data['contract_name'].'<span data-id="'.$data['id'].'"></span>';
            $temp_array['delivery_date'] = $data['delivery_date'];
            $temp_array['start_date'] = $data['start_date'];
            $temp_array['end_date'] = $data['end_date'];
            $temp_array['tools'] = $this->common_element->get_detail_button('data-id="'.$data['id'].'"');

            $array_data[] = $temp_array;
        }

        $data_return = array(
            'draw' => $draw,
            'recordsTotal' => $result_list['total_records'],
            'recordsFiltered' => $result_list['total_records'],
            'data' => $array_data,
            'contract_id_set' => $temp_array_contract_id
        );

        echo json_encode($data_return);
    }

    public function get_info_data() {
    	$this->load->model(array('contract_list_model', 'contract_maintenance_detail_model'));
    	$id = $this->input->get('id');

    	$result_contract = $this->contract_list_model->get_contract_by_id($id);

    	$result_contract_maintenance_detail 
    		= $this->contract_maintenance_detail_model
    			->get_contract_maintenance_detail_and_status_by_contract_id($id);

    	$data_return = array(
    		'contract' => $result_contract,
    		'contract_maintenance_detail' => $result_contract_maintenance_detail
		);

		echo json_encode($data_return);
    }

}