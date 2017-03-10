<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_payment_period_model extends MY_model {

	public $base_table = 'contract_payment_period';

	public $foreign_key = 'contract_id';

	public function __construct() {
        parent::__construct();
    }

    public function get_contract_payment_period_by_contract_id($contract_id) {
    	return $this->db->where(array($this->foreign_key => $contract_id))->get($this->base_table)->result_array();
    }

    public function get_contract_payment_period_and_status_by_contract_id($contract_id) {
        return $this->db->select([
            'contract_payment_period.contract_id',
            'contract_payment_period.contract_payment_period_type',
            'contract_payment_period.payment_date',
            'contract_payment_period.percent_value',
            'contract_payment_period.payment_value',
            'contract_payment_period.payment_period_remark',
            'contract_payment_period.contract_payment_period_status_id',
            'contract_payment_period.invoice_no',
            'contract_payment_period_status.status'
        ])->where(array($this->foreign_key => $contract_id))
        ->join('contract_payment_period_status', 
                'contract_payment_period.contract_payment_period_status_id = contract_payment_period_status.id', 'left')
        ->get($this->base_table)->result_array();
    }

    public function get_contract_payment_period_by_contract_id_and_type($contract_id, $type) {
    	return $this->db->where('contract_payment_period_type', $type)
    		->where($this->foreign_key, $contract_id)
    		->get($this->base_table)->result_array();
    }

    public function get_contract_id_payment_period_between_date_range() {
        $payment_date_start = trim($this->input->get('payment_date_start'));
        $payment_date_end = trim($this->input->get('payment_date_end'));
        $contract_payment_period_status_id 
            = trim($this->input->get('contract_payment_period_status_id'));
        

        $sql = 'SELECT DISTINCT(contract_id) AS contract_id FROM '.$this->base_table.' WHERE 1=1 ';

        $sql .= 'AND payment_date BETWEEN \''.$payment_date_start.'\' AND \''.$payment_date_end.'\' ';

        if($contract_payment_period_status_id != '') {
            $sql .= 'AND contract_payment_period_status_id = '.$contract_payment_period_status_id;
        }

        return $this->db->query($sql)->result_array();
    }

}