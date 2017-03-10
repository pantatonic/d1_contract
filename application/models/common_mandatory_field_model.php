<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_mandatory_field_model extends MY_model {

    public $base_table = 'common_mandatory_field';

    public function get_fields_of_table($table_name) {
    	return $this->db->list_fields($table_name);
    }

    public function get_mandatory_field_of_table($table_name) {
    	return $this->db->where(array('table_name' => $table_name))
    		->get($this->base_table)->result_array();
    }

    public function save_contract_mandatory_field() {
    	$field_of_table = 'contracts';
    	$field_name = $this->input->post('field_name');
    	$mandatory = $this->input->post('mandatory');

    	$this->db->delete($this->base_table, array('table_name' => $field_of_table)); 
        $this->db->query('OPTIMIZE TABLE '.$this->base_table);

        $count_success = 0;

    	for($i = 0; $i <= count($field_name) - 1; $i++) {
    		$result = $this->db->insert($this->base_table, array( 
    			'table_name' => $field_of_table,
    			'field_name' => $field_name[$i],
    			'mandatory' => $mandatory[$i]
			));

    		if($result) {
    			$count_success = $count_success + 1;
    		}
    	}

    	return $count_success == count($field_name) ? true : false;
    }

}