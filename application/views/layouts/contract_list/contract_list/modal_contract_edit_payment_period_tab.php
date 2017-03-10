<div class="col-xs-12 force-min-width">
	<label><?php echo ci_trans('Project value'); ?></label>
	&nbsp;&nbsp;
	<input type="text" name="project_value" 
			class="form-control number-digit-2" value="" autocomplete="off">
	&nbsp;&nbsp;
	<label><?php echo ci_trans('Baht'); ?></label>
	<br><br>
	<?php echo ci_trans('Total payment percent'); ?> : <span id="total-payment-percent-text"></span> %
	<br>
	<?php echo ci_trans('Total payment value'); ?> : <span id="total-payment-value-text"></span>

	<br><br>

	<table id="table-payment-period-hardware" class="table table-hover table-bordered table-striped table-payment-period" 
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

	<table id="table-payment-period-software" class="table table-hover table-bordered table-striped table-payment-period" 
		data-peyment-period-type="<?php echo common_string::_SOFTWARE_; ?>">
		<thead>
			<tr style="background-color: #dddddd;">
				<th colspan="8">
					<i class="fa fa-window-maximize"></i> 
					<?php echo ci_trans('Software'); ?>
				</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
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

	<textarea id="template-payment-period" class="hide">
		<tr>
			<td></td>
			<td><i class="fa fa-trash delete-icon"></i></td>
			<td>
				<div class="input-group date dtpicker-payment-period" style="width: 130px;">
                    <input type="text" class="form-control" name="payment_date[]"
                           value="" autocomplete="off">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
			</td>
			<td>
				<input type="hidden" name="contract_payment_period_type[]" 
					class="ignore-input" value="">
				<div class="col-xs-12 input-group">
					<input type="text" name="percent_value[]" 
						class="form-control number-digit-2" maxlength="6" value="" autocomplete="off">
					<span class="input-group-addon">%</span>
				</div>
			</td>
			<td>
				<input type="text" name="payment_value[]" 
					class="form-control number-digit-2" value="" autocomplete="off">
			</td>
			<td>
				<input type="text" name="payment_period_remark[]" 
					class="form-control" value="" autocomplete="off">
			</td>
			<td>
				<select name="contract_payment_period_status_id[]" class="form-control">
					<option value=""><?php echo ci_trans('Please select process status'); ?></option>
					<?php  
						foreach($contract_payment_period_status as $cpps) {
							echo '<option value="'.$cpps['id'].'">'
								.$cpps['status']
							.'</option>'; 
						}
					?>
				</select>
			</td>
			<td>
				<input type="text" name="invoice_no[]" 
					class="form-control" value="" autocomplete="off">
			</td>
		</tr>
	</textarea>
</div>