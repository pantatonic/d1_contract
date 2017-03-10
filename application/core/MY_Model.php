<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public $base_table = null;

    public function __construct() {
        parent::__construct();
    }

    public function public_get_table_primary_field($table) {
        return $this->get_table_primary_field($table);
    }

    protected function get_table_primary_field($table) {
        $fields = $this->db->field_data($table);
        foreach($fields as $field) {
            if($field->primary_key == 1) {
                $primary_field = $field->name;
                break;
            }
        }
        return $primary_field;
    }

    public function get_all() {
        return $this->db->get($this->base_table)->result_array();
    }

    public function get_data_from_record_no($record_no,$table) {
        $primary_field = $this->get_table_primary_field($table);
        if($record_no != 'none') {
            $sql = $this->db->where($primary_field, $record_no)->get($table);
            $num_row_sql = $sql->num_rows();
            if($num_row_sql == 0) { exit('Can not find data.'); }
            $data_return = $sql->row_array();
        }
        else {
            $fields = $this->db->field_data($table);
            foreach($fields as $field) {
                $data_return[$field->name] = '';
            }
        }

        return $data_return;
    }

    public function get_data_from_specify_field_value($field_name,$field_value,$table) {
        $sql = $this->db->where($field_name, $field_value)->get($table);
        $num_row_sql = $sql->num_rows();

        return ($num_row_sql > 0 ? $sql->row_array():false);
    }

    public function simple_check_is_duplicated($primary_field_value,$array_field_value) {
        $primary_field = $this->get_table_primary_field($this->base_table);

        if($primary_field_value != '') {
            $num_row = $this->db->where($array_field_value)
                ->where($primary_field.' !=', $primary_field_value)
                ->get($this->base_table)->num_rows();
        }
        else {
            $num_row = $this->db->where($array_field_value)
                ->get($this->base_table)->num_rows();
        }

        if($num_row > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function save(Array $data_array, $set_blank_to_null = false) {
        if($this->base_table == null) {
            exit('Must declare property $base_table in model');
        }

        $fields = $this->db->list_fields($this->base_table);
        $data_save = array();

        foreach($fields as $field) {
            if(array_key_exists($field,$data_array)) {
                if($set_blank_to_null) {
                    if($data_array[$field] == '') {
                        $data_array[$field] = null;

                        $data_save[$field] = $data_array[$field];
                    }
                    else {
                        $data_save[$field] = $data_array[$field];
                    }
                }
                else {
                    $data_save[$field] = $data_array[$field];
                }

                //$data_save[$field] = $data_array[$field];
            }
        }

        $primary_field = $this->get_table_primary_field($this->base_table);

        if($data_array[$primary_field] != '') {
            if($this->db->where($primary_field,$data_save[$primary_field])->update($this->base_table,$data_save)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            unset($data_array[$primary_field]);

            if($this->db->insert($this->base_table,$data_save)) {
                return true;
            }
            else {
                return false;
            }
        }
    }

}