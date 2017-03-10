<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_list_status extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model(array('status_model'));
    }

    public function index() {
    	$data_send = array(
            'page_title' => ci_trans('Contract list status')
        );

        $this->page_render($data_send);
    }

    public function get_contract_list_status_list() {
    	$draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $result_list = $this->status_model->get_contract_list_status_list($start, $length, $search);

        $array_data = array();
        foreach($result_list['data'] as $data) {
            $temp_array = array();

            $temp_array['status'] = $data['status'].'<span data-id="'.$data['id'].'"></span>';

            $array_data[] = $temp_array;
        }

        $data_return = array(
            'draw' => $draw,
            'recordsTotal' => $result_list['total_records'],
            'recordsFiltered' => $result_list['total_records'],
            'data' => $array_data
        );

        echo json_encode($data_return);
    }

    public function get_contract_list_status_by_id() {
        $id = $this->input->get('id');

        $primary_field = $this->status_model
            ->public_get_table_primary_field($this->status_model->base_table);

        $result = $this->status_model
            ->get_data_from_specify_field_value($primary_field, $id, $this->status_model->base_table);

        echo json_encode($result);
    }


    public function save_contract_list_status() {
    	$post = $this->received_request_data('post');

        /* 1 is enable, 2 is disable*/
        $array_not_allow_to_edit_id = array('1','2');
        if(in_array($post['id'], $array_not_allow_to_edit_id)) {
            echo json_encode(array(
                common_string::_RESULT_ => common_string::_ERROR_,
                common_string::_MESSAGE_ => ci_trans('Not allow to edit this data')
                    .'<br>'.ci_trans('because of').' '.ci_trans('it is important data of system')
            ));
            exit;
        }


    	$data_check_for_mandatory_field = array(
            'status' => ci_trans('please_complete_information').' : '.ci_trans('contract_list_status_')
        );
        $check_for_mandatory_field = $this->check_for_mandatory_field_($post,$data_check_for_mandatory_field);
        if(!$check_for_mandatory_field['result']) {
            echo json_encode(array(
                common_string::_RESULT_ => common_string::_WARNING_,
                common_string::_MESSAGE_ => $data_check_for_mandatory_field[$check_for_mandatory_field['field']]
            ));
            exit;
        }

        $result_simple_check_is_duplicated = $this->status_model->simple_check_is_duplicated($post['id'], 
            array(
                'status' => $post['status']
            )
        );

        if($result_simple_check_is_duplicated) {
            echo json_encode(array(
                common_string::_RESULT_ => common_string::_ERROR_,
                common_string::_MESSAGE_ => ci_trans('contract_list_status_is_duplicated')
            ));
            exit;
        }

        $result_save = $this->status_model->save($post);

        if($result_save) {
            $data_return =  array(
                common_string::_RESULT_ => common_string::_SUCCESS_,
                common_string::_MESSAGE_ => ci_trans('save_success')
            );
        }
        else {
            $data_return =  array(
                common_string::_RESULT_ => common_string::_ERROR_,
                common_string::_MESSAGE_ => ci_trans('save_failed')
            );
        }

        echo json_encode($data_return);
    }

}
