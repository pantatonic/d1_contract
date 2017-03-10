
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $ci_instance->get_page_item()['info_contract_payment_period_between_date_range']['item']; ?>
                    <small><?php //echo ci_trans('Contract type list subtitle'); ?></small>
                </h1>
            </section>

            
            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <br>
                        <div class="box-tools pull-right">
                            <div class="btn-group group-button-dropdown">
                                <button type="button" class="btn btn-flat bg-olive btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="glyphicon glyphicon-save-file"></i>
                                    <?php echo ci_trans('export_'); ?>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <!--<li>
                                        <a href="javascript:void(0);">
                                            <i class="fa fa-file-pdf-o pdf-icon"></i> <?php echo ci_trans('pdf_'); ?>
                                        </a>
                                    </li>-->
                                    <li id="export-data-excel">
                                        <a href="javascript:void(0);">
                                            <i class="fa fa-file-excel-o excel-icon"></i> <?php echo ci_trans('excel_'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('', array('name' => 'search_form', 'class' => 'form-horizontal')); ?>
                        <table id="inquiry-table" class="table">
                            <tbody>
                                <tr>
                                    <td align="right"><label><?php echo ci_trans('payment_period_start_date_'); ?></label></td>
                                    <td class="td-date">
                                        <div class="col-xs-12 col-no-padding">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="payment_date_start" 
                                                    name="payment_date_start" 
                                                    value="<?php echo $default_date_search['begin']; ?>" 
                                                    autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td align="right"><label><?php echo ci_trans('payment_period_end_date_'); ?></label></td>
                                    <td class="td-date">
                                        <div class="col-xs-12 col-no-padding">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="payment_date_end" 
                                                    name="payment_date_end" 
                                                    value="<?php echo $default_date_search['end']; ?>" 
                                                    autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right"><label><?php  echo ci_trans('Payment period status'); ?></label></td>
                                    <td colspan="3">
                                        <select name="contract_payment_period_status_id" class="form-control">
                                            <option value=""><?php echo ci_trans('Please select process status'); ?></option>
                                            <?php  
                                                foreach($contract_payment_period_status as $cpp) {
                                                    echo '<option value="'.$cpp['id'].'">'
                                                        .$cpp['status']
                                                    .'</option>'; 
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" id="td-search-button">
                                        <?php echo $common_element
                                            ->get_search_button('data-loading-text=" '.ci_trans('Processing...').'"'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php echo form_close(); ?>

                        <br>

                        <table id="table-list" class="table table-bordered table-striped table-hover hide">
                            <thead>
                                <tr>
                                    <th><?php echo ci_trans('running_no_'); ?></th>
                                    <th><?php echo ci_trans('contract_no_'); ?></th>
                                    <th><?php echo ci_trans('contract_name_'); ?></th>
                                    <th><?php echo ci_trans('delivery_date_'); ?></th>
                                    <th><?php echo ci_trans('start_date_'); ?></th>
                                    <th><?php echo ci_trans('end_date_'); ?></th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        &nbsp;
                        <?php echo form_open('contract_list/contract_list/', array(
                            'id' => 'temp_form',
                            'name' => 'temp_form',
                            'target' => 'iframe_temp_form'
                        )); ?>

                        <?php echo form_close(); ?>
                        <iframe name="iframe_temp_form" class="hide"></iframe>
                    </div>
                </div>

            </section>
        </div>

        <?php $this->load->view('layouts/contract_list/info_contract_payment_period_between_date_range/modal_payment_period'); ?>
