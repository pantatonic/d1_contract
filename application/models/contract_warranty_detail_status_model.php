<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_warranty_detail_status_model extends MY_model {

	public $base_table = 'contract_warranty_detail_status';

	public function __construct() {
        parent::__construct();
    }

    public function get_contract_warranty_detail_status_list($start, $length, $search) {
    	if($search != '') {
    		$data = $this->db->limit($length, $start)
    			->like('status', $search)
    			->get($this->base_table)
    			->result_array();

    		$total_records = $this->db
    			->like('status', $search)
    			->get($this->base_table)
    			->num_rows();
    	}
    	else {
    		$total_records = $this->db->get($this->base_table)->num_rows();

    		$data = $this->db->limit($length, $start)->get($this->base_table)->result_array();
    	}

    	return array(
    		'total_records' => $total_records,
    		'data' => $data
		);
    }

}