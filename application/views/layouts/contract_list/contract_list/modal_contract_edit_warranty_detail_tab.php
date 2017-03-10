<div class="col-xs-12 force-min-width">
	<label><?php echo ci_trans('delivery_date_'); ?></label>
	&nbsp;:&nbsp;
	<span class="delivery-date-show-text"></span>

	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><?php echo ci_trans('Warranty'); ?></label>
	&nbsp;:&nbsp;
	<span id="warranty-range-show-text"></span>
	<?php echo ci_trans('number_time_'); ?>

	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><?php echo ci_trans('every_period_'); ?></label>
	&nbsp;:&nbsp;
	<span class="warranty-year-month-show"></span>

	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><?php echo ci_trans('In warranty range'); ?></label>
	&nbsp;&nbsp;
	<span class="warranty-total-month-show"></span>

	<br><br>

	<table id="table-calculate-warranty" class="table table-hover table-striped force-min-width">
		<thead>
			<tr>
				<th colspan="3"><?php echo ci_trans('Warranty detail'); ?></th>
				<th class="parent-warranty-maintenance-status-id">
					<select id="parent-warranty-detail-status-id" class="form-control">
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

	<textarea id="template-calculate-warranty" class="hide">
		<tr>
			<td style="width: 70px; text-align: center;"></td>
			<td style="width: 140px;">
				<div class="col-xs-12">
					<span class="warranty-date-display-text"></span>
	                <div class="input-group date dtpicker-warranty-detail" style="width: 130px; display: none;">
	                    <input type="text" class="form-control" name="warranty_date[]"
	                           value="" autocomplete="off">
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
			</td>
			<td>
				<input type="text" name="warranty_remark[]" class="form-control" 
					placeholder="<?php echo ci_trans('Remark'); ?>">
			</td>
			<td style="width: 300px;">
				<select name="contract_warranty_detail_status_id[]" class="form-control">
					<option value=""><?php echo ci_trans('Please select warranty process status'); ?></option>
					<?php  
						foreach($contract_warranty_detail_status as $cwds) {
							echo '<option value="'.$cwds['id'].'">'
								.$cwds['status']
							.'</option>'; 
						}
					?>
				</select>
			</td>
		</tr>
	</textarea>
</div>