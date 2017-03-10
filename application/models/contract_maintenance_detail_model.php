<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_maintenance_detail_model extends MY_model {

	public $base_table = 'contract_maintenance_detail';

	public $foreign_key = 'contract_id';

	public function __construct() {
        parent::__construct();
    }

    public function get_contract_maintenance_detail_by_contract_id($contract_id) {
    	return $this->db->where(array($this->foreign_key => $contract_id))->get($this->base_table)->result_array();
    }

    public function get_contract_maintenance_detail_and_status_by_contract_id($contract_id) {
        return $this->db->select([
            'contract_maintenance_detail.contract_id',
            'contract_maintenance_detail.maintenance_date',
            'contract_maintenance_detail.maintenance_remark',
            'contract_maintenance_detail.contract_maintenance_detail_status_id',
            'contract_maintenance_detail_status.status'
        ])->where(array($this->foreign_key => $contract_id))
        ->join('contract_maintenance_detail_status', 
                'contract_maintenance_detail.contract_maintenance_detail_status_id = contract_maintenance_detail_status.id', 'left')
        ->get($this->base_table)->result_array();
    }

    public function get_contract_id_maintenance_between_date_range() {
    	$maintenance_date_start = trim($this->input->get('maintenance_date_start'));
    	$maintenance_date_end = trim($this->input->get('maintenance_date_end'));
    	$contract_maintenance_detail_status_id 
    		= trim($this->input->get('contract_maintenance_detail_status_id'));
    	

    	$sql = 'SELECT DISTINCT(contract_id) AS contract_id FROM '.$this->base_table.' WHERE 1=1 ';

    	$sql .= 'AND maintenance_date BETWEEN \''.$maintenance_date_start.'\' AND \''.$maintenance_date_end.'\' ';

    	if($contract_maintenance_detail_status_id != '') {
    		$sql .= 'AND contract_maintenance_detail_status_id = '.$contract_maintenance_detail_status_id;
    	}

    	return $this->db->query($sql)->result_array();
    }

    public function get_contract_maintenance_detail_by_date_range($start, $end) {
        return $this->db->where('maintenance_date >=', $start)
            ->where('maintenance_date <=', $end)
            ->get($this->base_table)->result_array();
    }

    public function update_detail_status_id(Array $data_array) {
        return $this->db->where('contract_id', $data_array['contract_id'])
            ->where('maintenance_date', $data_array['maintenance_date'])
            ->update($this->base_table, array(
                'contract_maintenance_detail_status_id' => 
                    $this->custom_library->empty_to_null($data_array['contract_maintenance_detail_status_id'])
            ));
    }

}