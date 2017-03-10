<div class="col-xs-12 force-min-width">
	<label><?php echo ci_trans('delivery_date_'); ?></label>
	&nbsp;:&nbsp;
	<span class="delivery-date-show-text"></span>

	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><?php echo ci_trans('ma_'); ?></label>
	&nbsp;:&nbsp;
	<span id="maintenance-range-show-text"></span>
	<?php echo ci_trans('number_time_'); ?>

	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><?php echo ci_trans('every_period_'); ?></label>
	&nbsp;:&nbsp;
	<span class="maintenance-year-month-show"></span>

	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><?php echo ci_trans('in_ma_range_'); ?></label>
	&nbsp;&nbsp;
	<span class="maintenance-total-month-show"></span>

	<br><br>

	<table id="table-calculate-maintenance" class="table table-hover table-striped force-min-width">
		<thead>
			<tr>
				<th colspan="3"><?php echo ci_trans('Maintenance detail'); ?></th>
				<th class="parent-warranty-maintenance-status-id">
					<select id="parent-maintenance-detail-status-id" class="form-control">
						<option value=""><?php echo ci_trans('Please select warranty process status'); ?></option>
						<?php  
							foreach($contract_warranty_detail_status as $cwds) {
								echo '<option value="'.$cwds['id'].'">'
									.$cwds['status']
								.'</option>'; 
							}
						?>
					</select>
				</th>
			</tr>
		</thead>
		<tbody>		
			
		</tbody>
	</table>

	<textarea id="template-calculate-maintenance" class="hide">
		<tr>
			<td style="width: 70px; text-align: center;"></td>
			<td style="width: 140px;">
				<div class="col-xs-12">
					<span class="maintenance-date-display-text"></span>
	                <div class="input-group date dtpicker-maintenance-detail" style="width: 130px; display: none;">
	                    <input type="text" class="form-control" name="maintenance_date[]"
	                           value="" autocomplete="off">
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
			</td>
			<td>
				<input type="text" name="maintenance_remark[]" class="form-control" 
					placeholder="<?php echo ci_trans('Remark'); ?>">
			</td>
			<td style="width: 300px;">
				<select name="contract_maintenance_detail_status_id[]" class="form-control">
					<option value=""><?php echo ci_trans('Please select maintenance process status'); ?></option>
					<?php  
						foreach($contract_maintenance_detail_status as $cmds) {
							echo '<option value="'.$cmds['id'].'">'
								.$cmds['status']
							.'</option>'; 
						}
					?>
				</select>
			</td>
		</tr>
	</textarea>
</div>