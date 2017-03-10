<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_fine_model extends MY_model {

	public $base_table = 'contract_fine';

	public $foreign_key = 'contract_id';

	public function get_contract_fine_by_contract_id($contract_id) {
		return $this->db->where(array($this->foreign_key => $contract_id))->get($this->base_table)->result_array();
	}

}