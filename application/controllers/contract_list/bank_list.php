<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_list extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('bank_model'));
    }

    public function index() {
    	$data_send = array(
            'page_title' => ci_trans('Bank and Coporate')
        );

        $this->page_render($data_send);
    }

    public function get_json_all_bank() {
    	echo json_encode($this->bank_model->get_all_bank());
    }

    public function get_bank_list() {
        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $result_list = $this->bank_model->get_bank_list($start, $length, $search);

        $array_data = array();
        foreach($result_list['data'] as $data) {
            $temp_array = array();

            $temp_array['short_name'] = $data['short_name'].'<span data-id="'.$data['id'].'">';
            $temp_array['name'] = $data['name'];

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

    public function get_bank_by_id() {
        $id = $this->input->get('id');

        $result = $this->bank_model->get_bank_by_id($id);

        echo json_encode($result);
    }

    public function save_bank() {
    	$post = $this->received_request_data('post');

        $data_check_for_mandatory_field = array(
            'short_name' => ci_trans('please_complete_information').' : '.ci_trans('short_name_'),
            'name' => ci_trans('please_complete_information').' : '.ci_trans('bank_name_')
        );
        $check_for_mandatory_field = $this->check_for_mandatory_field_($post,$data_check_for_mandatory_field);
        if(!$check_for_mandatory_field['result']) {
            echo json_encode(array(
                common_string::_RESULT_ => common_string::_WARNING_,
                common_string::_MESSAGE_ => $data_check_for_mandatory_field[$check_for_mandatory_field['field']]
            ));
            exit;
        }

        $result_simple_check_is_duplicated = $this->bank_model->simple_check_is_duplicated($post['id'], 
            array(
                'short_name' => $post['short_name']
            )
        );

        if($result_simple_check_is_duplicated) {
            echo json_encode(array(
                common_string::_RESULT_ => common_string::_ERROR_,
                common_string::_MESSAGE_ => ci_trans('short_name_is_duplicated')
            ));
            exit;
        }

        $result_save = $this->bank_model->save($post);

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