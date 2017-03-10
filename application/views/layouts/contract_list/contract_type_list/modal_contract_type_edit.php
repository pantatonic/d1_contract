<?php echo form_open('', array('name' => 'edit_form', 'class' => '')); ?>
    <div id="modal-contract-type-edit" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo ci_trans('Contract type Detail'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="contract_type"><?php echo ci_trans('contract_type_name_'); ?></label>
                        <input type="hidden" name="id" value="">
                        <input type="text" class="form-control required-field" id="contract_type" 
                            name="contract_type" autocomplete="off" value="">
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
