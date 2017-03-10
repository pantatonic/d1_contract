<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_list_model extends MY_model {

    public $base_table = 'contracts';

    public function __construct() {
        parent::__construct();
    }

    public function get_contract_list($start, $length) {
    	$total_records = $this->db->get($this->base_table)->num_rows();
    	$data = $this->db->limit($length, $start)->get($this->base_table)->result_array();

        $request_method = strtolower($this->input->server('REQUEST_METHOD'));

        if($request_method == 'get') {
            $id = trim($this->input->get('id'));

            $contract_id_set = trim($this->input->get('contract_id_set'));

            $running_no = trim($this->input->get('running_no'));
            $contract_no = trim($this->input->get('contract_no'));
            $bank_id = trim($this->input->get('bank_id'));
            $contract_name = trim($this->input->get('contract_name'));
            $delivery_date_start = trim($this->input->get('delivery_date_start'));
            $delivery_date_end = trim($this->input->get('delivery_date_end'));
            $start_date_start = trim($this->input->get('start_date_start'));
            $start_date_end = trim($this->input->get('start_date_end'));
            $end_date_start = trim($this->input->get('end_date_start'));
            $end_date_end = trim($this->input->get('end_date_end'));    
        }
        else 
        if($request_method == 'post') {
            $id = trim($this->input->post('id'));

            $contract_id_set = trim($this->input->post('contract_id_set'));

            $running_no = trim($this->input->post('running_no'));
            $contract_no = trim($this->input->post('contract_no'));
            $bank_id = trim($this->input->post('bank_id'));
            $contract_name = trim($this->input->post('contract_name'));
            $delivery_date_start = trim($this->input->post('delivery_date_start'));
            $delivery_date_end = trim($this->input->post('delivery_date_end'));
            $start_date_start = trim($this->input->post('start_date_start'));
            $start_date_end = trim($this->input->post('start_date_end'));
            $end_date_start = trim($this->input->post('end_date_start'));
            $end_date_end = trim($this->input->post('end_date_end'));    
        }

    	$sql = 'SELECT * FROM '.$this->base_table.' WHERE 1=1 ';

        if($id != '') {
            $sql .= 'AND id = '.$id.' ';
        }

        if($contract_id_set != '') {
            $sql .= 'AND id IN ('.$contract_id_set.') ';
        }

    	if($running_no != '') {
    		$sql .= 'AND running_no LIKE \'%'.$running_no.'%\' ';
    	}

    	if($contract_no != '') {
    		$sql .= 'AND contract_no LIKE \'%'.$contract_no.'%\' ';
    	}

        if($bank_id != '') {
            $sql .= 'AND bank_id = '.$bank_id.' ';
        }

    	if($contract_name != '') {
    		$sql .= 'AND contract_name LIKE \'%'.$contract_name.'%\' ';
    	}

    	if($delivery_date_start != '' || $delivery_date_end != '') {
    		if($delivery_date_start != '' && $delivery_date_end == '') {
    			$sql .= 'AND delivery_date >= \''.$delivery_date_start.'\' ';
    		}
    		else if($delivery_date_start == '' && $delivery_date_end != '') {
    			$sql .= 'AND delivery_date <= \''.$delivery_date_end.'\' ';
    		}
    		else {
    			$sql .= 'AND delivery_date BETWEEN \''.$delivery_date_start.'\' ';
    			$sql .= 'AND \''.$delivery_date_end.'\' ';
    			$sql .= 'AND delivery_date IS NOT NULL ';	
    		}
    	}

    	if($start_date_start != '' || $start_date_end != '') {
    		if($start_date_start != '' && $start_date_end == '') {
    			$sql .= 'AND start_date >= \''.$start_date_start.'\' ';
    		}
    		else if($start_date_start == '' && $start_date_end != '') {
    			$sql .= 'AND start_date <= \''.$start_date_end.'\' ';
    		}
    		else {
    			$sql .= 'AND start_date BETWEEN \''.$start_date_start.'\' ';
    			$sql .= 'AND \''.$start_date_end.'\' ';
    			$sql .= 'AND start_date IS NOT NULL ';	
    		}
    	}

    	if($end_date_start != '' || $end_date_end != '') {
    		if($end_date_start != '' && $end_date_end == '') {
    			$sql .= 'AND end_date >= \''.$end_date_start.'\' ';
    		}
    		else if($end_date_start == '' && $end_date_end != '') {
    			$sql .= 'AND end_date <= \''.$end_date_end.'\' ';
    		}
    		else {
    			$sql .= 'AND end_date BETWEEN \''.$end_date_start.'\' ';
    			$sql .= 'AND \''.$end_date_end.'\' ';
    			$sql .= 'AND end_date IS NOT NULL ';	
    		}
    	}

    	$total_records = $this->db->query($sql)->num_rows();

        $sql .= 'ORDER BY delivery_date DESC ';

        if($start != null || $length != null) {
            $sql .= 'LIMIT '.$start.','.$length;
        }

    	$data = $this->db->query($sql)->result_array();

    	return array(
    		'total_records' => $total_records,
    		'data' => $data
		);
    }

    public function get_contract_by_id($id) {
        $primary_field = $this->get_table_primary_field($this->base_table);
        
        return $this->db->where(array($primary_field => $id))->get($this->base_table)->row_array();
    }

    public function check_contract_list_is_duplicated($post) {
        $primary_field = $this->get_table_primary_field($this->base_table);

        if($post['id'] != '') {
            $num_row = $this->db->where('(running_no = \''.$post['running_no'].'\' OR contract_no = \''.$post['contract_no'].'\')')
                ->where($primary_field.' != ', $post['id'])
                ->get($this->base_table)->num_rows();
        }
        else {
            $num_row = $this->db->where('(running_no = \''.$post['running_no'].'\' OR contract_no = \''.$post['contract_no'].'\')')
                ->get($this->base_table)->num_rows();
        }

        if($num_row > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function save($post, $set_blank_to_null = false) {
        $primary_field = $this->get_table_primary_field($this->base_table);

        $post['project_value'] = Custom_library::remove_comma($post['project_value']);

        $result_parent_save = parent::save($post, true);
                
        if($post[$primary_field] == '') {
            $post[$primary_field] = $this->db->insert_id();
        }

        if($result_parent_save) {
            $this->_save_conditions_for_maintenance($post);

            $this->_save_contract_fine($post);

            $this->_save_contract_warranty_detail($post);

            $this->_save_contract_maintenance_detail($post);

            $this->_save_contract_payment_period($post);
        }
        else {
            return array(
                common_string::_RESULT_ => false,
                'id' => $post[$primary_field]
            );
        }

        return array(
            common_string::_RESULT_ => true,
            'id' => $post[$primary_field]
        );
    }

    private function _save_conditions_for_maintenance($post) {
        $conditions_for_maintenance = $this->input->post('conditions_for_maintenance');
        $conditions_for_maintenance_table = 'conditions_for_maintenance';

        $this->db->delete($conditions_for_maintenance_table, array('contract_id' => $post['id'])); 
        $this->db->query('OPTIMIZE TABLE '.$conditions_for_maintenance_table);

        foreach($conditions_for_maintenance as $cfm) {
            $cfm = trim($cfm);

            if($cfm != '') {
                $this->db->insert($conditions_for_maintenance_table, array(
                    'contract_id' => $post['id'],
                    'detail' => $cfm
                ));
            }
        }
    }

    private function _save_contract_fine($post) {
        $fine_detail = $this->input->post('fine_detail');
        $fine_value = $this->input->post('fine_value');
        $contract_fine_table = 'contract_fine';

        $this->db->delete($contract_fine_table, array('contract_id' => $post['id'])); 
        $this->db->query('OPTIMIZE TABLE '.$contract_fine_table);
        
        for($i = 0; $i <= count($fine_detail) - 1; $i++) {
            if($fine_detail[$i] != '') {
                $fv = str_replace(',', '', $fine_value[$i]);
                
                $this->db->insert($contract_fine_table, array(
                    'contract_id' => $post['id'],
                    'fine_detail' => $fine_detail[$i],
                    'fine_value' => $fv
                ));
            }
        }
    }

    private function _save_contract_warranty_detail($post) {
        $warranty_date = $this->input->post('warranty_date');
        $contract_warranty_detail_status_id = $this->input->post('contract_warranty_detail_status_id');
        $warranty_remark = $this->input->post('warranty_remark');

        $table = 'contract_warranty_detail';

        $this->db->delete($table, array('contract_id' => $post['id']));
        $this->db->query('OPTIMIZE TABLE '.$table);

        for($i = 0; $i <= count($warranty_date) - 1; $i++) {
            //echo $warranty_date[$i].' , '.$contract_warranty_detail_status_id[$i].' , '.$warranty_remark[$i]."\r\n";
            if(trim($warranty_date[$i]) != '') {
                $this->db->insert($table, array(
                    'contract_id' => $post['id'],
                    'warranty_date' => trim($warranty_date[$i] == '') ? null : trim($warranty_date[$i]),
                    'contract_warranty_detail_status_id' => $this->custom_library->empty_to_null($contract_warranty_detail_status_id[$i]),
                    'warranty_remark' => $this->custom_library->empty_to_null($warranty_remark[$i])
                ));
            }
        }
    }

    private function _save_contract_maintenance_detail($post) {
        $maintenance_date = $this->input->post('maintenance_date');
        $contract_maintenance_detail_status_id = $this->input->post('contract_maintenance_detail_status_id');
        $maintenance_remark = $this->input->post('maintenance_remark');

        $table = 'contract_maintenance_detail';

        $this->db->delete($table, array('contract_id' => $post['id']));
        $this->db->query('OPTIMIZE TABLE '.$table);

        for($i = 0; $i <= count($maintenance_date) - 1; $i++) {
            if(trim($maintenance_date[$i]) != '') {
                $this->db->insert($table, array(
                    'contract_id' => $post['id'],
                    'maintenance_date' => trim($maintenance_date[$i] == '') ? null : trim($maintenance_date[$i]),
                    'contract_maintenance_detail_status_id' => $this->custom_library->empty_to_null($contract_maintenance_detail_status_id[$i]),
                    'maintenance_remark' => $this->custom_library->empty_to_null($maintenance_remark[$i])
                ));
            }
        }
    }

    private function _save_contract_payment_period($post) {
        $contract_payment_period_type = $this->input->post('contract_payment_period_type');
        $percent_value = $this->input->post('percent_value');
        $payment_value = $this->input->post('payment_value');
        $payment_date = $this->input->post('payment_date');
        $payment_period_remark = $this->input->post('payment_period_remark');
        $contract_payment_period_status_id = $this->input->post('contract_payment_period_status_id');
        $invoice_no = $this->input->post('invoice_no');

        $table = 'contract_payment_period';

        $this->db->delete($table, array('contract_id' => $post['id']));
        $this->db->query('OPTIMIZE TABLE '.$table);

        for($i = 0; $i <= count($percent_value) - 1; $i++) {
            if(trim($payment_date[$i]) != '') {
                $payment_value[$i] = Custom_library::remove_comma($payment_value[$i]);

                $this->db->insert($table, array(
                    'contract_id' => $post['id'],
                    'contract_payment_period_type' => $contract_payment_period_type[$i],
                    'payment_date' => $this->custom_library->empty_to_null($payment_date[$i]),
                    'percent_value' => $this->custom_library->empty_to_null($percent_value[$i]),
                    'payment_value' => $this->custom_library->empty_to_null($payment_value[$i]),
                    'payment_period_remark' => $this->custom_library->empty_to_null($payment_period_remark[$i]),
                    'contract_payment_period_status_id' 
                        => $this->custom_library->empty_to_null($contract_payment_period_status_id[$i]),
                    'invoice_no' => $this->custom_library->empty_to_null($invoice_no[$i])
                ));
            }
            
        }
    }

    public function get_contract_by_contract_id_set($start, $length, Array $contract_id_set) {
        $primary_field = $this->get_table_primary_field($this->base_table);

        $total_records = $this->db->where_in($primary_field, $contract_id_set)
            ->get($this->base_table)->num_rows();

        $data = $this->db->where_in($primary_field, $contract_id_set)->limit($length, $start)
            ->get($this->base_table)->result_array();

        return array(
            'total_records' => $total_records,
            'data' => $data
        );
    }

}