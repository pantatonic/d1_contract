<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_mandatory_field extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model(array('common_mandatory_field_model'));
    }

    public function index() {
    	$this->load->model('contract_list_model');

    	$data_set = array();

    	$result_get_contract_fields 
    		= $this->common_mandatory_field_model
    		->get_fields_of_table($this->contract_list_model->base_table);

		$result_get_mandatory 
			= $this->common_mandatory_field_model
			->get_mandatory_field_of_table($this->contract_list_model->base_table);

		foreach($result_get_contract_fields as $rgcf) {
			$field_name_  = $rgcf;
			$found = false;
			foreach($result_get_mandatory as $rgm) {
				if($field_name_ == $rgm['field_name']) {
					$data_set[$field_name_]['field_name'] = $field_name_;
					$data_set[$field_name_]['mandatory'] = $rgm['mandatory'];

					$found = true;

					continue;
				}
			}

			if(!$found) {
				$data_set[$field_name_]['field_name'] = $field_name_;
				$data_set[$field_name_]['mandatory'] = null;
			}
		}

    	$data_send = array(
            'page_title' => ci_trans('contract_mandatory_field'),
            'contract_fields' => $result_get_contract_fields,
            'data_set' => $data_set
        );

        $this->page_render($data_send);
    }

    public function save_contract_mandatory_field() {
    	if($this->input->post()) {
    		$result_save = $this->common_mandatory_field_model->save_contract_mandatory_field();

    		if($result_save) {
    			echo json_encode(array(
    				common_string::_RESULT_ => common_string::_SUCCESS_,
                	common_string::_MESSAGE_ => ci_trans('save_success')
				));
    		}
    		else {
    			echo json_encode(array(
    				common_string::_RESULT_ => common_string::_ERROR_,
                	common_string::_MESSAGE_ => ci_trans('save_failed')
				));
    		}
    	}
    	else {
    		echo common_string::_NOT_ALLOW_THIS_FOR_THIS_METHOD_;
    	}
    }

}
