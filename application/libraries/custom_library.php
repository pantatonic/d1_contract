<?php

class Custom_library {

    public function get_iframe_submit($iframe_name) {
        echo '<iframe name="'.$iframe_name.'" id="'.$iframe_name.'" frameborder="0" width="0" height="0"></iframe>';
    }

    public function test_parent_pnotify($title,$text,$type) {
        $CI =& get_instance();
        echo "
			<script type='text/javascript'>
				new parent.parent.PNotify({
						title: '".$title."',
						text: '".$text."',
						type: '".$type."'
				});
			</script>
		";
    }

    public function parent_js_alert($title,$text,$type) {
        $CI =& get_instance();
        echo "
			<script type='text/javascript'>
				new parent.parent.PNotify({
						title: '".$title."',
						text: '".$text."',
						type: '".$type."'
				});
			</script>
		";
    }

    public function parent_show_notice($title, $text, $type) {
        $CI =& get_instance();
        echo '
            <script type="text/javascript">
                new parent.app.show_notice({
                        type: "'.$type.'", 
                        message: "'.$text.'"
                });
            </script>
        ';
    }

    public function parent_set_focus($html_element) {
        echo '<script type="text/javascript">parent.jQuery(\''.$html_element.'\').focus();</script>';
    }

    public function parent_button_reset_loading($html_element) {
        echo '<script type="text/javascript">parent.jQuery(\''.$html_element.'\').button(\'reset\');</script>';
    }

    public function parent_redirect_url($url) {
        echo '<script type="text/javascript">parent.window.location.href="'.$url.'"</script>';
    }

    public function empty_to_null($data) {
        return trim($data) == '' ? null : trim($data);
    }

    public function null_to_empty($data) {
        return $data == null ? '' : $data;
    }

    public static function remove_comma($data) {
        return str_replace(',', '', $data);
    }

}

?>