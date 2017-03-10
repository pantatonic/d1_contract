<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('ci_trans')) {
    function ci_trans($label) {
        $CI =& get_instance();
        $result = $CI->lang->line($label);

        return ($result ? $result:$label);
    }
}
