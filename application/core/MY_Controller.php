<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $language_cookie_name = 'ci_lang';

    public $export_pre_check_over_total_record = 1000;

    public $contract_color_warranty = '006699';
    public $contract_color_maintenance = 'bf7505';

    public $status_id_enable = 1;
    public $status_id_disable = 2;

    public function __construct() {
        date_default_timezone_set('Asia/Bangkok');
        parent::__construct();
        $this->load_language();
    }

    public function load_language() {
        $language_switch = $this->get_current_language();
        $this->lang->load($language_switch,$language_switch);
    }

    public function get_current_language() {
        $language_switch = get_cookie($this->language_cookie_name);
        if(!$language_switch) { $language_switch = 'thai'; }

        return $language_switch;
    }

    private function get_language_path() {
        return APPPATH.'language';
    }

    public function generate_js_language_string() {
        $current_language = $this->get_current_language();
        $language_path = $this->get_language_path();

        if(file_exists($language_path.'/'.$current_language)) {
            include($language_path.'/'.$current_language.'/'.$current_language.'_lang.php');
            //$js_language_string = (isset($js_lang) ? json_encode($js_lang):json_encode(array('no_js_lang'=>'no_js_lang')));
            $js_language_string = (isset($lang) ? json_encode($lang):json_encode(array('no_js_lang'=>'no_js_lang')));
        }

        return $js_language_string;
    }

    public function get_view_resources($controller,$method) {
        $arr_resources = array('css','js');

        $html_script_resources = '';

        foreach($arr_resources as $resource_type) {

            $file_view_path = 'assets/view_resources/'.$this->router->directory.$controller.'/'.$method.'/'.$resource_type;

            if(file_exists($file_view_path)) {
                $file_scans = scandir($file_view_path);
                foreach($file_scans as $file_scan) {
                    if($file_scan == '.' || $file_scan == '..') {
                        continue;
                    }
                    if($resource_type == 'css') {
                        $html_script_resources .= '<link rel="stylesheet" href="'.base_url().$file_view_path.'/'.$file_scan.'?'.time().'">'."\r\n";
                    }
                    elseif($resource_type == 'js') {
                        $html_script_resources .= '<script type="text/javascript" src="'.base_url().$file_view_path.'/'.$file_scan.'?'.time().'"></script>'."\r\n";
                    }
                }
            }
        }

        echo $html_script_resources;
    }

    public function addition_resources_script() {

    }

    protected function page_render($data_send=null) {
        $addition_resources_script = $this->addition_resources_script();

        $data_send['addition_resources_script'] = $addition_resources_script;

        $data_send['ci_instance'] =& get_instance();
        $data_send['controller_name'] = $this->router->fetch_class();
        $data_send['method_name'] = $this->router->fetch_method();
        $data_send['common_element'] = $this->common_element;
        $data_send['ci_language'] = $this->get_current_language();

        $this->load->view('html_top',$data_send);
        $this->load->view('html_header',$data_send);
        $this->load->view('html_aside_left',$data_send);

        /** load controller view */
        $this->load->view('layouts/'.$this->router->directory.$data_send['controller_name'].'/'.$data_send['method_name'],$data_send);

        $this->load->view('html_footer',$data_send);
        $this->load->view('html_panel_aside',$data_send);
        $this->load->view('html_bottom',$data_send);
    }

    /*protected function check_email_format($data_array) {
        foreach($data_array as $field => $value) {
            if(!filter_var(trim($value), FILTER_VALIDATE_EMAIL)) {
                $this->custom_library->parent_js_alert(ci_trans('Message'), ci_trans('Invalid e-mail format'),'error');
                $this->custom_library->parent_set_focus('#'.$field);
                return false;
            }
        }
        return true;
    }*/

    protected function check_for_mandatory_field($data_request,$data_array) {
        foreach($data_request as $key => $val) {
            if(array_key_exists($key, $data_array)) {
                if(trim($val) == '') {
                    $this->custom_library->parent_js_alert(ci_trans('Message'),$data_array[$key],'error');
                    $this->custom_library->parent_set_focus('#'.$key);
                    return false;
                }
            }
        }
        return true;
    }

    protected function check_for_mandatory_field_($data_request,$data_array) {
        foreach($data_request as $key => $val) {
            if(array_key_exists($key, $data_array)) {
                if(trim($val) == '') {
                    return array(
                        'result'=>false,
                        'field'=>$key
                    );
                }
            }
        }
        return array(
            'result'=>true,
        );
    }

    protected function received_request_data($method,$arr_except=array()) {
        $arr_excepts[] = 'submit';
        $arr_excepts = array_merge($arr_excepts,$arr_except);
        $arr_excepts_data_type = ['array'];

        if($method == 'post') {
            foreach ($this->input->post() as $key => $value) {
                if(in_array($key, $arr_excepts)) { continue; }
                if(in_array(gettype($value), $arr_excepts_data_type)) { continue; }
                
                $data_return[$key] = trim($value);
            }
        }
        elseif($method == 'get') {

        }
        else {

        }

        return $data_return;
    }

    public function check_sidebar_active($controller_name) {
        //echo 'yyy '. $controller_name .' : '.$this->router->fetch_class();
        echo ($controller_name == $this->router->fetch_class() ? 'active':'');
    }

    public function get_page_item() {
        $aside_item = array(
            'dashboard'=>array(
                'link'=>site_url('contract_list/dashboard'),
                'item'=>'<i class="fa fa-dashboard"></i> <span>'.ci_trans('Dashboard').'</span>'
            ),
            'contract_list'=>array(
                'link'=>site_url('contract_list/contract_list'),
                'item'=>'<i class="fa fa-list-alt"></i> <span>'.ci_trans('Contract list').'</span>'
            ),
            'work_calendar'=>array(
                'link'=>site_url('contract_list/work_calendar'),
                'item'=>'<i class="fa fa-calendar"></i> <span>'.ci_trans('work_calendar_').'</span>'
            ),
            'bank_list'=>array(
                'link'=>site_url('contract_list/bank_list'),
                'item'=>'<i class="fa fa-file-o"></i> <span>'.ci_trans('Bank and Coporate').'</span>'
            ),
            'contract_type_list'=>array(
                'link'=>site_url('contract_list/contract_type_list'),
                'item'=>'<i class="fa fa-file-o"></i> <span>'.ci_trans('Contract type list').'</span>'
            ),
            'contract_list_status'=>array(
                'link'=>site_url('contract_list/contract_list_status'),
                'item'=>'<i class="fa fa-file-o"></i> <span>'.ci_trans('contract_list_status_').'</span>'
            ),
            'contract_warranty_detail_status'=>array(
                'link'=>site_url('contract_list/contract_warranty_detail_status'),
                'item'=>'<i class="fa fa-file-o"></i> <span>'.ci_trans('Contract warranty status').'</span>'
            ),
            'contract_maintenance_detail_status'=>array(
                'link'=>site_url('contract_list/contract_maintenance_detail_status'),
                'item'=>'<i class="fa fa-file-o"></i> <span>'.ci_trans('Contract maintenance status').'</span>'
            ),
            'contract_payment_period_status'=>array(
                'link'=>site_url('contract_list/contract_payment_period_status'),
                'item'=>'<i class="fa fa-file-o"></i> <span>'.ci_trans('Payment period status').'</span>'
            ),
            'contract_mandatory_field'=>array(
                'link'=>site_url('contract_list/contract_mandatory_field'),
                'item'=>'<i class="fa fa-file-o"></i> <span>'.ci_trans('contract_mandatory_field').'</span>'
            ),
            'info_contract_warranty_between_date_range'=>array(
                'link'=>site_url('contract_list/info_contract_warranty_between_date_range'),
                'item'=>'<i class="fa fa-info"></i> <span>'.ci_trans('info_warranty_between_date_range').'</span>'
            ),
            'info_contract_maintenance_between_date_range'=>array(
                'link'=>site_url('contract_list/info_contract_maintenance_between_date_range'),
                'item'=>'<i class="fa fa-info"></i> <span>'.ci_trans('info_maintenance_between_date_range').'</span>'
            ),
            'info_contract_payment_period_between_date_range'=>array(
                'link'=>site_url('contract_list/info_contract_payment_period_between_date_range'),
                'item'=>'<i class="fa fa-info"></i> <span>'.ci_trans('info_contract_payment_period_between_date_range').'</span>'
            )
        );

        return $aside_item;
    }

    protected function allow_method(Array $allow_method = null) {
        $request_method = strtolower($this->input->server('REQUEST_METHOD'));
        $result_allow = true;

        if($allow_method != null) {
            if(!in_array($request_method, $allow_method)) {
                $result_allow = false;
            }
        }
        
        if($result_allow == false) {
            echo common_string::_NOT_ALLOW_THIS_FOR_THIS_METHOD_;
            exit;
        }
    }

    protected function set_excel_document_header($file_name) {
        if($file_name == null || $file_name == '') {
            throw new Exception('File name must not empty.');
            exit;
        }

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
    }

    protected function php_excel_set_cell_color($objPHPExcel, $cells, $color){
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => $color
            )
        ));
    }

    protected function php_excel_set_text_color($objPHPExcel, $cells, $color){
        $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
            'font'  => array(
                'color' => array('rgb' => 'FFFFFF')
            )
        ));
    }

    protected function php_excel_set_cell_border($objPHPExcel, $cell, $color) {
        $objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => $color)
                )
            )
        ));
    }

    protected function php_excel_set_cell_wrap_text($objPHPExcel, $cell) {
        $objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setWrapText(true);
    }

}