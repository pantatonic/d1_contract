<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conditions_for_maintenance_model extends MY_model {

	public $base_table = 'conditions_for_maintenance';

	public $foreign_key = 'contract_id';

	public function get_condition_for_maintenance_by_contract_id($contract_id) {
		return $this->db->where(array($this->foreign_key => $contract_id))->get($this->base_table)->result_array();
	}

}