<?php

class Common_element {

	public function get_search_button($optional = '') {
        return '<button type="submit" class="btn btn-primary bg-navy btn-flat '
                .'btn-submit" '.$optional.'><i class="fa fa-search"></i> '.ci_trans('search_').'</button>';
    }
	
	public function get_submit_button($optional = '') {
        return '<button type="submit" class="btn btn-primary bg-navy btn-flat '
                .'btn-submit" '.$optional.'><i class=" fa fa-save"></i> '.ci_trans('save_').'</button>';
    }

    public function get_submit_loading_button($optional = '') {
        return '<button type="submit" class="btn btn-primary bg-navy btn-flat '
                .'btn-submit btn-submit-loading" '
                .'data-loading-text="'.ci_trans('Processing...').'" '.$optional.'><i class=" fa fa-save"></i> '.ci_trans('save_').'</button>';
    }

    public function get_save_loading_button($optional = '') {
        return '<button type="button" class="btn btn-primary bg-navy btn-flat btn-save-loading"' 
                .'data-loading-text="'.ci_trans('Processing...').'" '.$optional.'><i class=" fa fa-save"></i> '.ci_trans('save_').'</button>';
    }

    public function get_reset_button($optional = '') {
        return '<button type="reset" class="btn btn-danger btn-flat" '.$optional.'>'
            .'<i class="fa fa-file-o"></i> '.ci_trans('reset_data_').'</button>';
    }

    public function get_cancel_button($optional = '') {
        return '<button type="button" class="btn btn-danger btn-flat" '.$optional.'>'
            .'<i class="fa fa-power-off"></i> '.ci_trans('cancel_').'</button>';
    }

    public function get_new_button($optional = '') {
        return '<button type="button" class="btn btn-warning bg-orange btn-flat" '.$optional.'>'
            .'<i class="fa fa-plus"></i> '.ci_trans('add_').'</button>';
    }

    public function get_close_modal_button($optional = '') {
        return '<button type="button" class="btn btn-default btn-flat" data-dismiss="modal" '.$optional.'>'
            .'<i class="fa fa-window-close-o"></i> '.ci_trans('close_').'</button>';
    }

    public function get_detail_button($optional = '') {
        return '<button type="button" class="btn btn-warning bg-orange btn-flat btn-detail" '.$optional.'>'
            .'<i class="fa fa-search"></i> </button>';
    }

    public function get_temporary_form($iframe = true) {
        return form_open('', array(
            'id' => 'temporary-form',
            'name' => 'temporary_form',
            'target' => 'iframe_temporary_form'
        )).form_close()
        /*.'<iframe id="iframe_temporary_form" name="iframe_temporary_form"></frame>'*/;
    }

}

?>