<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_type_model extends MY_model {

	public $base_table = 'contract_types';

	public function get_all_contract_type() {
		return $this->db->get($this->base_table)->result_array();
	}

	public function get_contract_type_list($start, $length, $search) {
    	if($search != '') {
    		$data = $this->db->limit($length, $start)
    			->like('contract_type', $search)
    			->get($this->base_table)
    			->result_array();

    		$total_records = $this->db
    			->like('contract_type', $search)
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

    public function get_contract_type_by_id($id) {
        $primary_field = $this->get_table_primary_field($this->base_table);
        
        return $this->db->where(array($primary_field => $id))->get($this->base_table)->row_array();
    }

}