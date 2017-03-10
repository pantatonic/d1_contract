<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_list extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('contract_list_model', 
            'conditions_for_maintenance_model',
            'contract_fine_model','status_model',
            'contract_warranty_detail_model',
            'contract_warranty_detail_status_model',
            'contract_maintenance_detail_model',
            'contract_maintenance_detail_status_model',
            'contract_payment_period_model',
            'contract_payment_period_status_model'));
    }

    public function index() {
        $this->load->model(array('bank_model','contract_type_model','common_mandatory_field_model'));

        $result_mandatory_field 
            = $this->common_mandatory_field_model
                ->get_mandatory_field_of_table($this->contract_list_model->base_table);

        $array_mandatory_field = array();
        foreach($result_mandatory_field as $rmf) {
            $array_mandatory_field[$rmf['field_name']] = $rmf['mandatory'];
        }

        $data_send = array(
            'page_title' => ci_trans('Contract list'),
            'bank_list' => $this->bank_model->get_all_bank(),
            'contract_type_list' => $this->contract_type_model->get_all_contract_type(),
            'status_list' => $this->status_model->get_all_status(),
            'contract_warranty_detail_status' => $this->contract_warranty_detail_status_model->get_all(),
            'contract_maintenance_detail_status' => $this->contract_maintenance_detail_status_model->get_all(),
            'mandatory_data' => json_encode($array_mandatory_field),
            'contract_payment_period_status' => $this->contract_payment_period_status_model->get_all()
        );

        $this->page_render($data_send);
    }

    public function get_index_contract_list() {
        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');

        $result_list = $this->contract_list_model->get_contract_list($start, $length);

        $array_data = array();
        foreach($result_list['data'] as $data) {
            $temp_array = array();

            $label_class = '';
            $status_text = '';
            $label = '';

            switch ($data['status_id']) {
                case $this->status_id_enable:
                    $label_class = 'label-primary';
                    break;
                case $this->status_id_disable:
                    $label_class = 'label-danger';
                    break;
                default :
                    $label_class = 'label-default';
                    break;
            }

            $result_status = $this->status_model->get_data_from_specify_field_value('id', $data['status_id'], 'status');
            if($result_status) {
                $status_text = $result_status['status'];
            }

            if($status_text != '') {
                $label = '<span class="label '.$label_class.'">'.$status_text.'</span>';
            }
            
            $process_type_contract = '';
            if($data['contract_type_id'] == '3') {
                $process_type_contract = common_string::_PROCESS_TYPE_CONTRACT_MA_;
            }
            else {
                $process_type_contract = common_string::_PROCESS_TYPE_CONTRACT_NORMAL_;
            }

            $temp_array['running_no'] = $data['running_no'];
            $temp_array['contract_no'] = $data['contract_no'];

            $temp_array['contract_name'] = '<span data-id="'.$data['id'].'"></span>'
                .$label.' '.$data['contract_name']
                .'<span process-type-contract="'.$process_type_contract.'"></span>';

            $temp_array['delivery_date'] = $data['delivery_date'];
            $temp_array['start_date'] = $data['start_date'];
            $temp_array['end_date'] = $data['end_date'];

            $array_data[] = $temp_array;
        }


        $data_return = array(
            'draw' => $draw,
            'recordsTotal' => $result_list['total_records'],
            'recordsFiltered' => $result_list['total_records'],
            'data' => $array_data
        );

        echo json_encode($data_return);
    }

    public function get_index_contract_list_test() {
        $result_list = $this->contract_list_model->get_contract_list(0, 10);

        $array_data = array();
        foreach($result_list['data'] as $data) {
            $temp_array = array();

            $temp_array['running_no'] = $data['running_no'];
            $temp_array['contract_no'] = $data['contract_no'];
            $temp_array['contract_name'] = $data['contract_name'];

            $array_data[] = $temp_array;
        }

        var_dump($array_data);
    }

    public function get_contract_by_id() {
        $id = $this->input->get('id');

        $result = $this->contract_list_model->get_contract_by_id($id);


        $result_conditions_for_maintenance 
            = $this->conditions_for_maintenance_model
            ->get_condition_for_maintenance_by_contract_id($id);
        $result['conditions_for_maintenance'] = $result_conditions_for_maintenance;


        $result_contract_fine = $this->contract_fine_model->get_contract_fine_by_contract_id($id);
        $result['contract_fine'] = $result_contract_fine;

        $result_contract_warranty_detail 
            = $this->contract_warranty_detail_model->get_contract_warranty_detail_by_contract_id($id);
        $result['contract_warranty_detail'] = $result_contract_warranty_detail;

        $result_contract_maintenance_detail
            = $this->contract_maintenance_detail_model->get_contract_maintenance_detail_by_contract_id($id);
        $result['contract_maintenance_detail'] = $result_contract_maintenance_detail;

        $result_contract_payment_period_hardware 
            = $this->contract_payment_period_model
            ->get_contract_payment_period_by_contract_id_and_type($id, common_string::_HARDWARE_);
        $result['contract_payment_period']['hardware'] = $result_contract_payment_period_hardware;

        $result_contract_payment_period_software 
            = $this->contract_payment_period_model
            ->get_contract_payment_period_by_contract_id_and_type($id, common_string::_SOFTWARE_);
        $result['contract_payment_period']['software'] = $result_contract_payment_period_software;

        echo json_encode($result);
    }

    public function save_contract() {
        $this->load->model(array('common_mandatory_field_model'));

        $post = $this->received_request_data('post');

        $result_mandatory_field 
            = $this->common_mandatory_field_model
                ->get_mandatory_field_of_table($this->contract_list_model->base_table);

        $array_rmf = array();
        foreach($result_mandatory_field as $rmf) {
            if($rmf['mandatory'] == '1') {
                $array_rmf[$rmf['field_name']] = ci_trans('please_complete_information').' : '.$rmf['field_name'];
            }
            
        }

        /*$data_check_for_mandatory_field = array(
            'running_no' => ci_trans('please_complete_information').' : '.ci_trans('running_no_'),
            'contract_no' => ci_trans('please_complete_information').' : '.ci_trans('contract_no_'),
            'contract_name' => ci_trans('please_complete_information').' : '.ci_trans('contract_name_')
        );*/
        $data_check_for_mandatory_field = $array_rmf;
        $check_for_mandatory_field = $this->check_for_mandatory_field_($post,$data_check_for_mandatory_field);
        if(!$check_for_mandatory_field['result']) {
            echo json_encode(array(
                common_string::_RESULT_ => common_string::_WARNING_,
                common_string::_MESSAGE_ => $data_check_for_mandatory_field[$check_for_mandatory_field['field']]
            ));
            exit;
        }

        $result_check_contract_list_is_duplicated
            = $this->contract_list_model->check_contract_list_is_duplicated($post);

        if($result_check_contract_list_is_duplicated) {
            echo json_encode(array(
                common_string::_RESULT_ => common_string::_ERROR_,
                common_string::_MESSAGE_ => ci_trans('running_no_')
                    .' '.ci_trans('or'). ' '.ci_trans('contract_no_').' '.ci_trans('duplicated_in_system')
            ));
            exit;
        }

        $result_save = $this->contract_list_model->save($post, true);

        if($result_save['result']) {
            $data_return =  array(
                common_string::_RESULT_ => common_string::_SUCCESS_,
                common_string::_MESSAGE_ => ci_trans('save_success'),
                'return_id' => $result_save['id']
            );
        }
        else {
            $data_return =  array(
                common_string::_RESULT_ => common_string::_ERROR_,
                common_string::_MESSAGE_ => ci_trans('save_failed'),
                'return_id' => $result_save['id']
            );
        }

        echo json_encode($data_return);
    }

    public function export_data_excel() {
        require_once(APPPATH.'libraries/php_excel/Classes/PHPExcel.php');

        $this->load->model(array('bank_model','contract_type_model'));

        $range_col_start = 'A';
        $range_col_end = 'X';

        //$this->load->model(array('status_model', 'conditions_for_maintenance_model'));

        $this->allow_method(['post']);
        
        $export_type = $this->input->post('export_type');

        $result_list = $this->contract_list_model->get_contract_list(null, null);

        if($this->input->post('force_export') == 'false') {
            $this->_export_data_excel_pre_check($result_list);
        }

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator('')
                                     ->setLastModifiedBy('')
                                     ->setTitle('')
                                     ->setSubject('')
                                     ->setDescription('')
                                     ->setKeywords('')
                                     ->setCategory('');


        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
            )
        ));


        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', ci_trans('running_no_'))
                    ->setCellValue('B1', ci_trans('contract_no_'))
                    ->setCellValue('C1', ci_trans('Bank and Coporate'))
                    ->setCellValue('D1', ci_trans('Contract Type'))
                    ->setCellValue('E1', ci_trans('contract_name_'))
                    ->setCellValue('F1', ci_trans('delivery_date_'))
                    ->setCellValue('G1', ci_trans('start_date_'))
                    ->setCellValue('H1', ci_trans('end_date_'))
                    ->setCellValue('I1', ci_trans('Install and Delevery'))
                    ->setCellValue('J1', ci_trans('Warranty').' ('.ci_trans('number_time_').')')
                    ->setCellValue('K1', ci_trans('every_period_').' ('.ci_trans('Month(s)').')')
                    ->setCellValue('L1', ci_trans('In warranty range').' ('.ci_trans('Month(s)').')')
                    ->setCellValue('M1', ci_trans('Warranty detail'))
                    ->setCellValue('N1', ci_trans('ma_').' ('.ci_trans('number_time_').')')
                    ->setCellValue('O1', ci_trans('every_period_').' ('.ci_trans('Month(s)').')')
                    ->setCellValue('P1', ci_trans('in_ma_range_').' ('.ci_trans('Month(s)').')')
                    ->setCellValue('Q1', ci_trans('Maintenance detail'))
                    ->setCellValue('R1', ci_trans('Conditions for Maintenance'))
                    ->setCellValue('S1', ci_trans('fine_'))
                    ->setCellValue('T1', ci_trans('after_dwp_'))
                    ->setCellValue('U1', ci_trans('status_'))
                    ->setCellValue('V1', ci_trans('remark_'))
                    ->setCellValue('W1', ci_trans('Project value'))
                    ->setCellValue('X1', ci_trans('Payment period'));

        foreach(range($range_col_start, $range_col_end) as $column_id) {
            $array_warranty_group = array('J1', 'K1', 'L1', 'M1');
            $array_maintenance_group = array('N1', 'O1', 'P1', 'Q1');

            if(in_array($column_id.'1', $array_warranty_group)) {
                $this->php_excel_set_cell_color($objPHPExcel, $column_id.'1', $this->contract_color_warranty);
            }
            else
            if(in_array($column_id.'1', $array_maintenance_group)) {
                $this->php_excel_set_cell_color($objPHPExcel, $column_id.'1', $this->contract_color_maintenance);
            }
            else {
                $this->php_excel_set_cell_color($objPHPExcel, $column_id.'1', '16365C');
            }


            $this->php_excel_set_text_color($objPHPExcel, $column_id.'1', 'FFFFFF');
            $this->php_excel_set_cell_border($objPHPExcel, $column_id.'1', '000000');
        }

        $row_ = 2;

        $status_model_primary_field = $this->status_model
                ->public_get_table_primary_field($this->status_model->base_table);

        foreach($result_list['data'] as $data_) {
            $result_status = $this->status_model
                ->get_data_from_specify_field_value($status_model_primary_field, $data_['status_id'], $this->status_model->base_table);

            $result_bank = $this->bank_model->get_bank_by_id($data_['bank_id']);
            $bank_and_corp_text = '';
            if(count($result_bank) > 0) {
                $bank_and_corp_text = $result_bank['short_name'].' '.$result_bank['name'];
            }

            $result_contract_type = $this->contract_type_model->get_contract_type_by_id($data_['contract_type_id']);
            $contract_type_text = '';
            if(count($result_contract_type) > 0) {
                $contract_type_text = $result_contract_type['contract_type'];
            }

            $result_conditions_for_maintenance = $this->conditions_for_maintenance_model
                ->get_condition_for_maintenance_by_contract_id($data_['id']);
            $conditions_for_maintenance_text 
                = $this->_collected_conditions_for_maintenance($result_conditions_for_maintenance);

            $result_contract_fine = $this->contract_fine_model->get_contract_fine_by_contract_id($data_['id']);
            $contract_fine_text = $this->_collected_contract_fine($result_contract_fine);

            $result_contract_warranty_detail 
                = $this->contract_warranty_detail_model->get_contract_warranty_detail_by_contract_id($data_['id']);
            $contract_warranty_detail_text 
                = $this->_collected_contract_warranty_detail($result_contract_warranty_detail);

            $result_contract_maintenance_detail 
                = $this->contract_maintenance_detail_model->get_contract_maintenance_detail_by_contract_id($data_['id']);
            $contract_maintenance_detail_text 
                = $this->_collected_contract_maintenance_detail($result_contract_maintenance_detail);

            $result_contract_payment_period 
                = $this->contract_payment_period_model->get_contract_payment_period_by_contract_id($data_['id']);
            $contract_payment_period_detail_text 
                = $this->_collected_contract_payment_period($result_contract_payment_period);

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row_, $data_['running_no'])
                    ->setCellValue('B'.$row_, $data_['contract_no'])
                    ->setCellValue('C'.$row_, $bank_and_corp_text)
                    ->setCellValue('D'.$row_, $contract_type_text)
                    ->setCellValue('E'.$row_, $data_['contract_name'])
                    ->setCellValue('F'.$row_, $data_['delivery_date'])
                    ->setCellValue('G'.$row_, $data_['start_date'])
                    ->setCellValue('H'.$row_, $data_['end_date'])
                    ->setCellValue('I'.$row_, $data_['install_and_delevery'])
                    ->setCellValue('J'.$row_, $data_['warranty'])
                    ->setCellValue('K'.$row_, $data_['warranty_range'])

                    ->setCellValue('L'.$row_, $data_['warranty_total_month'])

                    ->setCellValue('M'.$row_, $contract_warranty_detail_text)
                    ->setCellValue('N'.$row_, $data_['maintenance'])
                    ->setCellValue('O'.$row_, $data_['maintenance_range'])

                    ->setCellValue('P'.$row_, $data_['maintenance_total_month'])

                    ->setCellValue('Q'.$row_, $contract_maintenance_detail_text)
                    ->setCellValue('R'.$row_, $conditions_for_maintenance_text)
                    ->setCellValue('S'.$row_, $contract_fine_text)
                    ->setCellValue('T'.$row_, $data_['after_dwp'])
                    ->setCellValue('U'.$row_, $result_status['status'])
                    ->setCellValue('V'.$row_, $data_['remark'])
                    ->setCellValue('W'.$row_, number_format($data_['project_value'], 2))
                    ->setCellValue('X'.$row_, $contract_payment_period_detail_text);

            foreach(range($range_col_start, $range_col_end) as $column_id) {
                $this->php_excel_set_cell_border($objPHPExcel, $column_id.$row_, '000000');
                $this->php_excel_set_cell_wrap_text($objPHPExcel, $column_id.$row_);
            }

            $row_ = $row_ + 1;
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($export_type);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Set cell auto width 
        foreach(range($range_col_start, $range_col_end) as $column_id) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($column_id)
                ->setAutoSize(true);
        }

        $this->set_excel_document_header($export_type.'.xlsx');
        

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    private function _export_data_excel_pre_check($result_list) {
        if($result_list['total_records'] == 0) {
            $this->custom_library
                ->parent_show_notice(ci_trans('Message'), ci_trans('Data not found'), common_string::_WARNING_);
            exit;
        }
        else
        if($result_list['total_records'] >= $this->export_pre_check_over_total_record) {
            echo '
                <script type="text/javascript">
                    parent.alert_util.confirmAlert(\'<p class="text-danger">\'
                        + parent.app.translate(\'Found so many data\')
                        + parent.app.translate(\'more over than\') 
                        + \' '.$this->export_pre_check_over_total_record.'\'
                        + \'<br>\'
                        +parent.app.translate(\'Please confirm to continue.\'), function() {
                        
                        parent.export_data.excel(true);
                    },{
                        animation: false,
                        type: null
                    });
                </script>
            ';
            exit;
        }       
    }

    private function _collected_conditions_for_maintenance($result) {
        $text = '';
        $count_loop = 1;
        foreach($result as $data) {
            $text .= $count_loop.'. '.$data['detail'];

            $text .= $count_loop >= count($result) - 0 ? '':"\r\n";

            $count_loop = $count_loop + 1;
        }

        return $text;
    }

    private function _collected_contract_fine($result) {
        $text = '';
        $count_loop = 1;

        foreach($result as $data) {
            $text .= $count_loop.'. '.$data['fine_detail'].' : '.number_format($data['fine_value'], 2);

            $text .= $count_loop >= count($result) - 0 ? '':"\r\n";

            $count_loop = $count_loop + 1;
        }

        return $text;
    }

    private function _collected_contract_warranty_detail($result) {
        $text = '';
        $count_loop = 1;

        $primary_field = $this->contract_warranty_detail_status_model
            ->public_get_table_primary_field($this->contract_warranty_detail_status_model->base_table);

        foreach($result as $data) {
            $result = $this->contract_warranty_detail_status_model
                ->get_data_from_specify_field_value($primary_field, 
                    $data['contract_warranty_detail_status_id'], 
                    $this->contract_warranty_detail_status_model->base_table);

            $text .= $count_loop.'.  '.$data['warranty_date']
                .'  '.$data['warranty_remark']
                .' - '.$result['status'];

            $text .= $count_loop >= count($result) - 0 ? '':"\r\n";

            $count_loop = $count_loop + 1;
        }

        return $text;
    }

    private function _collected_contract_maintenance_detail($result) {
        $text = '';
        $count_loop = 1;

        $primary_field = $this->contract_maintenance_detail_status_model
            ->public_get_table_primary_field($this->contract_maintenance_detail_status_model->base_table);

        foreach($result as $data) {
            $result_contract_maintenance_detail_status = $this->contract_maintenance_detail_status_model
                ->get_data_from_specify_field_value($primary_field, 
                    $data['contract_maintenance_detail_status_id'], 
                    $this->contract_maintenance_detail_status_model->base_table);

            $text .= $count_loop.'.  '.$data['maintenance_date']
                .'  '.$data['maintenance_remark']
                .' - '.$result_contract_maintenance_detail_status['status'];

            $text .= $count_loop >= count($result) - 0 ? '':"\r\n";

            $count_loop = $count_loop + 1;
        }

        return $text;
    }

    private function _collected_contract_payment_period($result) {
        $text = '';
        $count_loop = 1;

        $primary_field = $this->contract_payment_period_model
            ->public_get_table_primary_field($this->contract_payment_period_status_model->base_table);

        foreach($result as $data) {
            $result_contract_payment_period_status = $this->contract_payment_period_status_model
                ->get_data_from_specify_field_value($primary_field,
                    $data['contract_payment_period_status_id'], 
                    $this->contract_payment_period_status_model->base_table);

            $text .= $count_loop.'.  '.$data['contract_payment_period_type']
                .'  '.$data['payment_date']
                .'  '.$data['percent_value'].'%'
                .'  '.number_format($data['payment_value'], 2)
                .'  '.$data['payment_period_remark']
                .' - '.$result_contract_payment_period_status['status'];

            $text .= $count_loop >= count($result) - 0 ? '':"\r\n";

            $count_loop = $count_loop + 1;
        }

        return $text;
    }

}