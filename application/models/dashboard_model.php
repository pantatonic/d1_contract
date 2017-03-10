<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends MY_model {

    public function __construct() {
        parent::__construct();
    }

    public function get_chart_contracts_by_bank() {
    	return $this->db->select('COUNT(contracts.id) AS count_data')
    		->select('banks.name')
    		->join('banks', 'contracts.bank_id = banks.id')
    		->group_by('contracts.bank_id')
	    	->get(array('contracts'))->result_array();
    }

    public function get_chart_contracts_by_type() {
    	return $this->db->select('COUNT(contracts.id) AS count_data')
    		->select('contract_types.contract_type')
    		->join('contract_types', 'contracts.contract_type_id = contract_types.id')
    		->group_by('contracts.contract_type_id')
	    	->get(array('contracts'))->result_array();
    }

    public function get_chart_warranty_detail_each_month($start_date, $end_date) {
    	$sql = 'SELECT COUNT(contract_id) AS count_data, 
			YEAR(warranty_date) AS year_number, 
			MONTH(warranty_date) AS month_number 
			FROM contract_warranty_detail 
			WHERE warranty_date BETWEEN \''.$start_date.'\' AND \''.$end_date.'\' 
			GROUP BY YEAR(warranty_date), MONTH(warranty_date)';

    	return $this->db->query($sql)->result_array();
    }

   public function get_chart_maintenance_detail_each_month($start_date, $end_date) {
   		$sql = 'SELECT COUNT(contract_id) AS count_data, 
			YEAR(maintenance_date) AS year_number, 
			MONTH(maintenance_date) AS month_number 
			FROM contract_maintenance_detail 
			WHERE maintenance_date BETWEEN \''.$start_date.'\' AND \''.$end_date.'\' 
			GROUP BY YEAR(maintenance_date), MONTH(maintenance_date)';

		return $this->db->query($sql)->result_array();
   }
}