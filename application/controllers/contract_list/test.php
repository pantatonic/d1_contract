<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contract_list_model');
    }

    public function addition_resources_script() {
        $resources_script = array(
            'js' => array(
                '<script type="text/javascript" 
                src="'.base_url().'assets/data_table/media/js/jquery.dataTables.js"></script>',
                '<script type="text/javascript" 
                src="'.base_url().'assets/data_table/media/js/dataTables.bootstrap.js"></script>',
                '<script type="text/javascript" 
                src="'.base_url().'assets/data_table/extensions/Responsive/js/dataTables.responsive.js"></script>'
            ),
            'css' => array(
                '<link rel="stylesheet" 
                href="'.base_url().'assets/data_table/media/css/dataTables.bootstrap.css">',
                '<link rel="stylesheet" 
                href="'.base_url().'assets/data_table/extensions/Responsive/css/responsive.bootstrap.css">'
            )
        );

        return $resources_script;
    }

    public function index() {
        $data_send = array(
            'page_title' => ci_trans('Contract list')
        );
        $this->page_render($data_send);
    }

    public function test_submit() {
        echo 'This is test submit';
    }
   

    public function test_datatable() {
    	$draw = $this->input->get('draw');
    	$start = $this->input->get('start');
    	$length = $this->input->get('length');

    	$data1 = $this->input->get('data1');
    	$data2 = $this->input->get('data2');
    	$data3 = $this->input->get('data3');
    	$data4 = $this->input->get('data4');

    	$array_data = array();
    	for($i = $start; $i <= ($start + $length) -1; $i++) {
    		$array_data[] = array(
    			'head_column_1' => 'Row '.($i + 1).' column 1 : '.$data1.' '.$data2.' '.$data3.' '.$data4,
    			'head_column_2' => 'Row '.($i + 1).' column 2 : '.$data1.' '.$data2.' '.$data3.' '.$data4,
    			'head_column_3' => 'Row '.($i + 1).' column 3 : '.$data1.' '.$data2.' '.$data3.' '.$data4
			);
    	}

    	$data_return = array(
    		'draw' => $draw,
    		'recordsTotal' => 150,
    		'recordsFiltered' => 150,
    		'data' => $array_data
		);

    	echo json_encode($data_return);
    }

}