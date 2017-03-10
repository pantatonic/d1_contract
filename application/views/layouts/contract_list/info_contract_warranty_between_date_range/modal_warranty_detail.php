<div id="modal-warranty-detail" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                    <div class="force-min-width">
                        <label><?php echo ci_trans('running_no_'); ?> : </label>
                        <span id="running-no-text"></span>
                        &nbsp;&nbsp;&nbsp;
                        <label><?php echo ci_trans('contract_no_'); ?> :</label>
                        <span id="contract-no-text"></span>
                        <br><br>
                        <label><?php echo ci_trans('contract_name_'); ?> :</label>
                        <span id="contract-name-text"></span>
                        <br><br>
                        <label><?php echo ci_trans('delivery_date_'); ?> :</label>
                        <span id="delivery-date-text"></span>
                        &nbsp;&nbsp;&nbsp;
                        <label><?php echo ci_trans('Warranty'); ?> :</label>
                        <span id="warranty-text"></span> <?php echo ci_trans('number_time_'); ?>
                        &nbsp;&nbsp;&nbsp;
                        <label><?php echo ci_trans('every_period_'); ?> :</label>
                        <span id="warranty-range-text"></span>
                        &nbsp;&nbsp;&nbsp;
                        <label><?php echo ci_trans('In warranty range'); ?> :</label>
                        <span id="warranty-total-month-text"></span>
                    </div>
                    <hr>
                    <table id="table-warranty-detail" class="table table-hover table-striped force-min-width">
                        <thead>
                            <tr>
                                <th colspan="4"><?php echo ci_trans('Warranty detail'); ?></th>
                            </tr>
                        </thead>
                        <tbody>     
                            
                        </tbody>
                    </table>
                
            </div>
            <div class="modal-footer">
                <span id="change-without-calculate-text-caution" 
                    class="label label-danger caution-text"></span>
                <?php echo $common_element->get_close_modal_button(); ?>
            </div>
        </div>
    </div>
</div>