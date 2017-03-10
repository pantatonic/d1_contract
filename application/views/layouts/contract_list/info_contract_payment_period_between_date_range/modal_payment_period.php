<div id="modal-payment-period-detail" class="modal fade" tabindex="-1" role="dialog">
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
                        <label><?php echo ci_trans('Project value'); ?> :</label>
                        <span id="project-value-text"></span> <?php echo ci_trans('Baht'); ?>
                        
                    </div>
                    <hr>
                    <table id="table-payment-period-hardware" class="table table-bordered table-hover table-striped" 
                        data-peyment-period-type="<?php echo common_string::_HARDWARE_; ?>">
                        <thead>
                            <tr style="background-color: #dddddd;">
                                <th colspan="8">
                                    <i class="fa fa-wrench"></i> 
                                    <?php echo ci_trans('Hardware'); ?>
                                </th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <th><?php echo ci_trans('Payment date'); ?></th>
                                <th><?php echo ci_trans('Percent'); ?></th>
                                <th><?php echo ci_trans('Value').' ('.ci_trans('Baht').') '; ?></th>
                                <th><?php echo ci_trans('Description'); ?></th>
                                <th><?php echo ci_trans('Payment period status'); ?></th>
                                <th><?php echo ci_trans('Invoice no'); ?></th>
                            </tr>
                        </thead>
                        <tbody>     
                            
                        </tbody>
                    </table>
                
                    <table id="table-payment-period-software" class="table table-bordered table-hover table-striped" 
                        data-peyment-period-type="<?php echo common_string::_SOFTWARE_; ?>">
                        <thead>
                            <tr style="background-color: #dddddd;">
                                <th colspan="8">
                                    <i class="fa fa-wrench"></i> 
                                    <?php echo ci_trans('Software'); ?>
                                </th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <th><?php echo ci_trans('Payment date'); ?></th>
                                <th><?php echo ci_trans('Percent'); ?></th>
                                <th><?php echo ci_trans('Value').' ('.ci_trans('Baht').') '; ?></th>
                                <th><?php echo ci_trans('Description'); ?></th>
                                <th><?php echo ci_trans('Payment period status'); ?></th>
                                <th><?php echo ci_trans('Invoice no'); ?></th>
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