<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work_calendar extends MY_Controller {

	public $feed_event_previous_day_render = '-7';

	public function __construct() {
        parent::__construct();
        $this->load->model(array(
        	'contract_warranty_detail_model', 
            'contract_warranty_detail_status_model',
        	'contract_maintenance_detail_model',
            'contract_maintenance_detail_status_model',
        	'contract_list_model',
            'bank_model'));
    }

    public function addition_resources_script() {
        $resources_script = array(
            'js' => array(
                '<script type="text/javascript" 
                src="'.base_url().'assets/plugins/fullcalendar/lib/moment.min.js"></script>',
                '<script type="text/javascript" 
                src="'.base_url().'assets/plugins/fullcalendar/fullcalendar.min.js"></script>',

                '<script type="text/javascript" 
                src="'.base_url().'assets/awesomplete/awesomplete.js"></script>'
            ),
            'css' => array(
                '<link rel="stylesheet" 
                href="'.base_url().'assets/plugins/fullcalendar/fullcalendar.css">',
                '<link rel="stylesheet" 
                href="'.base_url().'assets/plugins/fullcalendar/fullcalendar.print.css" 
                media="print">',

                '<link rel="stylesheet" 
                href="'.base_url().'assets/awesomplete/awesomplete.css">'
            )
        );

        return $resources_script;
    }

    public function index() {
    	$data_send = array(
            'page_title' => ci_trans('work_calendar_'),
            'contract_color_warranty' => $this->contract_color_warranty,
            'contract_color_maintenance' => $this->contract_color_maintenance,
            'contract_warranty_detail_status' => $this->contract_warranty_detail_status_model->get_all(),
            'contract_maintenance_detail_status' => $this->contract_maintenance_detail_status_model->get_all(),
        );

        $this->page_render($data_send);
    }

    public function feed_() {
    	echo '[{"id":"20170201","title":"CM-14-0052","start":"2017-02-01","end":"2017-02-08","allDay":true,"backgroundColor":"#'.$this->contract_color_warranty.'","borderColor":"#'.$this->contract_color_warranty.'"},
    	{"id":"20170202","title":"CM-15-0034","start":"2017-02-02","end":"2017-02-02","allDay":true,"backgroundColor":"#'.$this->contract_color_maintenance.'","borderColor":"#'.$this->contract_color_maintenance.'"}]';
    }

    public function feed() {
    	/*$start = $this->input->get('start');
        $end = $this->input->get('end');*/

        $count_loop = 1;

    	$current_date = $this->input->get('current_date');
        $day_in_month = cal_days_in_month(CAL_GREGORIAN,
            date('m',strtotime($current_date)),
            date('Y',strtotime($current_date)));
        $start = date('Y-m-01',strtotime($current_date));
        $end = date('Y-m-'.$day_in_month,strtotime($current_date));

        $result_warranty_detail
        	= $this->contract_warranty_detail_model
        		->get_contract_warranty_detail_by_date_range($start, $end);

    	$feed = array();
        foreach($result_warranty_detail as $data_warranty) {
            $primary_field_warranty_detail_status = $this->contract_warranty_detail_status_model
                ->public_get_table_primary_field($this->contract_warranty_detail_status_model->base_table);

            $result_warranty_detail_status = $this->contract_warranty_detail_status_model
                ->get_data_from_specify_field_value($primary_field_warranty_detail_status, 
                    $data_warranty['contract_warranty_detail_status_id'], 
                    $this->contract_warranty_detail_status_model->base_table);

            $result_contract_ = $this->contract_list_model->get_contract_by_id($data_warranty['contract_id']);

            $result_bank_ = $this->bank_model->get_bank_by_id($result_contract_['bank_id']);

            if(count($result_bank_) == 0) {
                $bank_name_ = '';
            }
            else {
                $bank_name_ = $this->custom_library->null_to_empty($result_bank_['name']);
            }

        	$data_array = array(
        		'id' => str_replace('-','',$data_warranty['warranty_date']).$count_loop,
        		'title' => $result_contract_['running_no']
                    .' : '.$bank_name_
                    .' - '.$result_warranty_detail_status['status']
        			/*.' : '.$this->_get_prev_adv_date($this->feed_event_previous_day_render, $data_warranty['warranty_date'])
        			.' - '.$data_warranty['warranty_date']*/,
        		
        		'start' => $this->_get_prev_adv_date($this->feed_event_previous_day_render, $data_warranty['warranty_date']),
        		'end' => $this->_get_prev_adv_date('+1', $data_warranty['warranty_date']),
        		'allDay' => true,
        		'backgroundColor' => '#'.$this->contract_color_warranty,
        		'borderColor' => '#'.$this->contract_color_warranty,
        		'contract_id' => $data_warranty[$this->contract_warranty_detail_model->foreign_key],
        		'warranty_date' => $data_warranty['warranty_date'],
        		'event_type' => 'warranty'
    		);

    		$count_loop = $count_loop + 1;

    		$feed[] = $data_array;
        }

        $result_maintenance_detail 
        	= $this->contract_maintenance_detail_model
        		->get_contract_maintenance_detail_by_date_range($start, $end);

    	foreach($result_maintenance_detail as $data_maintenance) {
            $primary_field_maintenance_detail_status = $this->contract_maintenance_detail_status_model
                ->public_get_table_primary_field($this->contract_maintenance_detail_status_model->base_table);

            $result_maintenance_detail_status = $this->contract_maintenance_detail_status_model
                ->get_data_from_specify_field_value($primary_field_maintenance_detail_status, 
                    $data_maintenance['contract_maintenance_detail_status_id'], 
                    $this->contract_maintenance_detail_status_model->base_table);

            $result_contract_ = $this->contract_list_model->get_contract_by_id($data_maintenance['contract_id']);

            $result_bank_ = $this->bank_model->get_bank_by_id($result_contract_['bank_id']);

    		$data_array = array(
        		'id' => str_replace('-','',$data_maintenance['maintenance_date']).$count_loop,
        		'title' => $result_contract_['running_no']
                    .' : '.$result_bank_['name']
                    .' - '.$result_maintenance_detail_status['status']
        			/*.' : '.$this->_get_prev_adv_date($this->feed_event_previous_day_render, $data_maintenance['maintenance_date'])
        			.' - '.$data_maintenance['maintenance_date']*/,

        		'start' => $this->_get_prev_adv_date($this->feed_event_previous_day_render, $data_maintenance['maintenance_date']),
        		'end' => $this->_get_prev_adv_date('+1', $data_maintenance['maintenance_date']),
        		'allDay' => true,
        		'backgroundColor' => '#'.$this->contract_color_maintenance,
        		'borderColor' => '#'.$this->contract_color_maintenance,
        		'contract_id' => $data_maintenance[$this->contract_maintenance_detail_model->foreign_key],
        		'maintenance_date' => $data_maintenance['maintenance_date'],
        		'event_type' => 'maintenance'
    		);

    		$count_loop = $count_loop + 1;

    		$feed[] = $data_array;
    	}

        echo json_encode($feed);
    }

    private function _get_prev_adv_date($date_prev_adv, $date_string) {
    	return date("Y-m-d", strtotime($date_prev_adv.' days '.$date_string));
    }

    public function save_detail_status() {
        $this->allow_method(['post']);

        $post = $this->received_request_data('post');

        $result_save = null;

        if($post['event_type'] == common_string::_WARRANTY_) {
            $result_save = $this->contract_warranty_detail_model->update_detail_status_id(array(
                'contract_id' => $post['contract_id'],
                'warranty_date' => $post['date_detail'],
                'contract_warranty_detail_status_id' => $post['detail_status_id']
            ));
        }
        else
        if($post['event_type'] == common_string::_MAINTENANCE_) {
            $result_save = $this->contract_maintenance_detail_model->update_detail_status_id(array(
                'contract_id' => $post['contract_id'],
                'maintenance_date' => $post['date_detail'],
                'contract_maintenance_detail_status_id' => $post['detail_status_id']
            ));
        }

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