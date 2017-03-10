<?php echo form_open('', array('name' => 'edit_form', 'class' => '')); ?>
    <div id="modal-bank-edit" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo ci_trans('Bank Detail'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="short_name"><?php echo ci_trans('short_name_'); ?></label>
                        <input type="hidden" name="id" value="">
                        <input type="text" class="form-control required-field" id="short_name" 
                            name="short_name" autocomplete="off" value="">
                    </div>
                    <div class="form-group">
                        <label for="name"><?php echo ci_trans('bank_name_'); ?></label>
                        <input type="text" class="form-control required-field" id="name" 
                            name="name" autocomplete="off" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo $common_element->get_close_modal_button(); ?>
                    <?php echo $common_element->get_submit_loading_button(); ?>
                </div>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
