<table id="table-modal-contract-edit" class="table table-bordered table-odd-even-color force-min-width">
    <tr>
        <td nowrap><label><?php echo ci_trans('running_no_'); ?></label></td>
        <td colspan="2">
            <input type="hidden" name="id" value="">
            <input type="text" name="running_no" class="form-control" value="" autocomplete="off">
        </td>
        <td nowrap><label><?php echo ci_trans('contract_no_'); ?></label></td>
        <td colspan="2">
            <input type="text" name="contract_no" class="form-control" value="" 
                autocomplete="off">
        </td>
    </tr>
    <tr>
        <td nowrap><label><?php echo ci_trans('Bank and Coporate'); ?></label></td>
        <td colspan="2">
            <select name="bank_id" class="form-control">
                <option value=""><?php echo ci_trans('please_select_'); ?></option>
                <?php
                    foreach($bank_list as $data) {
                        echo '<option value="'.$data['id'].'">['.$data['short_name'].'] '.$data['name'].'</option>';
                    }
                ?>
            </select>
        </td>
        <td nowrap><label><?php echo ci_trans('Contract Type'); ?></label></td>
        <td colspan="2">
            <select name="contract_type_id" class="form-control">
                <option value=""><?php echo ci_trans('please_select_'); ?></option>
                <?php
                    foreach($contract_type_list as $data) {
                        echo '<option value="'.$data['id'].'">'.$data['contract_type'].'</option>';
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td nowrap><label><?php echo ci_trans('contract_name_'); ?></label></td>
        <td colspan="5">
            <input type="text" name="contract_name" class="form-control" value="" 
                autocomplete="off">
        </td>
    </tr>
    <tr>

        <td nowrap><label><?php echo ci_trans('start_date_'); ?></label></td>
        <td style="width: 300px;">
            <div class="col-xs-12">
                <div class="input-group date dtpicker">
                    <input type="text" class="form-control" name="start_date"
                           value="" autocomplete="off">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <br><br>
            <span id="start-date-notice" class="col-xs-12 label label-primary">
                <i class="fa fa-info-circle"></i>
                <?php echo ci_trans('start_date_notice_'); ?>
            </span>
        </td>

        <td nowrap><label><?php echo ci_trans('end_date_'); ?></label></td>
        <td>
            <div class="col-xs-12">
                <div class="input-group date dtpicker">
                    <input type="text" class="form-control" name="end_date"
                           value="" autocomplete="off">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </td>

        <td nowrap><label><?php echo ci_trans('delivery_date_'); ?></label></td>
        <td style="width: 300px !important;">
            <div class="col-xs-12">
                <div class="input-group date dtpicker">
                    <input type="text" class="form-control" name="delivery_date"
                           value="" autocomplete="off">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <input type="hidden" id="_delivery_date_temp" value="">
            <span class="caution-text">
                <?php echo ci_trans('This change take effect to warranty calculate.'); ?>
                <br>
                <?php echo ci_trans('Warranty calculate will calculate all again.'); ?>
                <br>
                <?php echo ci_trans('remark_and_status_will_be_clear_'); ?>
            </span>
        </td>
    </tr>
    <tr>
        <td><label><?php echo ci_trans('Install and Delevery'); ?></label></td>
        <td colspan="5">
            <textarea name="install_and_delevery" class="form-control" rows="3"></textarea>
        </td>
    </tr>
    <tr>
        <td><label><?php echo ci_trans('Warranty'); ?></label></td>
        <td>
            <div class="col-xs-12 input-group">
                <input type="text" name="warranty" class="form-control integer-only" 
                    autocomplete="off" readonly="readonly" maxlength="2" value="1">
                <span class="input-group-addon"><?php echo ci_trans('number_time_'); ?></span>
            </div>
            <!--<span class="caution-text">
                <?php echo ci_trans('This change take effect to warranty calculate.'); ?>
                <br>
                <?php echo ci_trans('Warranty calculate will calculate all again.'); ?>
                <br>
                <?php echo ci_trans('remark_and_status_will_be_clear_'); ?>
            </span>-->
        </td>
        <td><label><?php echo ci_trans('every_period_'); ?></label></td>
        <td>
            <div class="col-xs-12 input-group">
                <input type="text" name="warranty_range" class="form-control integer-only" maxlength="2" value="" autocomplete="off">
                <span class="input-group-addon">
                    <?php echo ci_trans('Month(s)'); ?>
                    &nbsp;
                    <!--<span class="warranty-year-month-show"></span>-->
                </span>
            </div>
            <span class="caution-text">
                <?php echo ci_trans('This change take effect to warranty calculate.'); ?>
                <br>
                <?php echo ci_trans('Warranty calculate will calculate all again.'); ?>
                <br>
                <?php echo ci_trans('remark_and_status_will_be_clear_'); ?>
            </span>
        </td>
        <td><label><?php echo ci_trans('In warranty range'); ?></label></td>
        <td>
            <div class="col-xs-12 input-group">
                <input type="text" name="warranty_total_month" 
                    class="form-control integer-only" maxlength="2" value="" autocomplete="off">
                <span class="input-group-addon">
                    <?php echo ci_trans('Month(s)'); ?>
                </span>
            </div>
            <span class="caution-text">
                <?php echo ci_trans('This change take effect to warranty calculate.'); ?>
                <br>
                <?php echo ci_trans('Warranty calculate will calculate all again.'); ?>
                <br>
                <?php echo ci_trans('remark_and_status_will_be_clear_'); ?>
            </span>
        </td>
    </tr>
    <tr>
        <td><label><?php echo ci_trans('ma_'); ?></label></td>
        <td>
            <div class="col-xs-12 input-group">
                <input type="text" name="maintenance" readonly="readonly" 
                    autocomplete="off" class="form-control integer-only" maxlength="2" value="1" autocomplete="off">
                <span class="input-group-addon"><?php echo ci_trans('number_time_'); ?></span>
            </div>
            <!--<span class="caution-text">
                <?php echo ci_trans('This change take effect to warranty calculate.'); ?>
                <br>
                <?php echo ci_trans('Warranty calculate will calculate all again.'); ?>
                <br>
                <?php echo ci_trans('remark_and_status_will_be_clear_'); ?>
            </span>-->
        </td>
        <td><label><?php echo ci_trans('every_period_'); ?></label></td>
        <td >
            <div class="col-xs-12 input-group">
                <input type="text" name="maintenance_range" class="form-control integer-only" maxlength="2" value="" autocomplete="off">
                <span class="input-group-addon">
                    <?php echo ci_trans('Month(s)'); ?>
                    &nbsp;
                    <!--<span class="maintenance-year-month-show"></span>-->
                </span>
            </div>
            <span class="caution-text">
                <?php echo ci_trans('This change take effect to warranty calculate.'); ?>
                <br>
                <?php echo ci_trans('Warranty calculate will calculate all again.'); ?>
                <br>
                <?php echo ci_trans('remark_and_status_will_be_clear_'); ?>
            </span>
        </td>
        <td><label><?php echo ci_trans('in_ma_range_'); ?></td>
        <td>
            <div class="col-xs-12 input-group">
                <input type="text" name="maintenance_total_month" 
                    class="form-control integer-only" maxlength="2" value="" autocomplete="off">
                <span class="input-group-addon">
                    <?php echo ci_trans('Month(s)'); ?>
                </span>
            </div>
            <span class="caution-text">
                <?php echo ci_trans('This change take effect to warranty calculate.'); ?>
                <br>
                <?php echo ci_trans('Warranty calculate will calculate all again.'); ?>
                <br>
                <?php echo ci_trans('remark_and_status_will_be_clear_'); ?>
            </span>
        </td>
    </tr>
    <tr>
        <td><label><?php echo ci_trans('Conditions for Maintenance'); ?></label></td>
        <td colspan="5" id="td-conditions-for-maintenance">
            <!--<textarea name="conditions_for_maintenance[]" class="form-control" rows="1"></textarea>-->
        </td>
    </tr>
    <tr>
        <td><label><?php echo ci_trans('fine_') ?></label></td>
        <td colspan="3">
            <table id="contract-fine-table" class="table">
                <tbody>
                    
                </tbody>
            </table>
        </td>
        <td colspan="2"></td>
    </tr>
    <!--<tr>
        <td><label><?php echo ci_trans('dwp_') ?></label></td>
        <td colspan="5">
            <input type="text" name="dwp" class="form-control" value="">
        </td>
    </tr>-->
    <tr>
        <td><label><?php echo ci_trans('after_dwp_') ?></label></td>
        <td colspan="5">
            <input type="text" name="after_dwp" class="form-control" value="" autocomplete="off">
        </td>
    </tr>
    <tr>
        <td><label><?php echo ci_trans('status_') ?></label></td>
        <td>
            <select name="status_id" class="form-control">
                <option value=""><?php echo ci_trans('please_select_'); ?></option>
                <?php
                    foreach($status_list as $data) {
                        echo '<option value="'.$data['id'].'">'.$data['status'].'</option>';
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label><?php echo ci_trans('remark_') ?></label></td>
        <td colspan="5">
            <textarea name="remark" class="form-control" rows="1"></textarea>
        </td>
    </tr>
</table>


<script type="text/javascript">

jQuery(document).ready(function() {
    var obj_mandatory = app.convert_to_json_object('<?php echo $mandatory_data; ?>');

    for(var iom in  obj_mandatory) {
        if(obj_mandatory[iom] == '1') {
            var this_input_element = jQuery('#modal-contract-edit').find('[name="'+ iom +'"]');
            var _set_redstar = function() {
                var previous_td = this_input_element.closest('td').prev('td');

                previous_td.find('label').append(' <span class="redstar-mandatory">*</span>');
            };

            this_input_element.addClass(_REQUIRED_CLASS_);
            _set_redstar();
        }
    }
});

</script>