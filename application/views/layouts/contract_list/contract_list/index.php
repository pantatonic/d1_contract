
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $ci_instance->get_page_item()['contract_list']['item']; ?>
                    <small><?php echo ci_trans('Contract list subtitle'); ?></small>
                </h1>
            </section>

            
            <section class="content">

                <input type="hidden" id="process-type-contract-normal" 
                    value="<?php echo common_string::_PROCESS_TYPE_CONTRACT_NORMAL_; ?>">
                <input type="hidden" id="process-type-contract-ma" 
                    value="<?php echo common_string::_PROCESS_TYPE_CONTRACT_MA_; ?>">


                <div class="box">
                    <div class="box-header with-border">
                        <!--<?php echo $common_element->get_new_button('id="new-contract"'); ?>-->
                        <div id="new-contract" class="dropdown group-button-dropdown">
                            <button class="btn btn-default btn-flat bg-orange  dropdown-toggle" type="button" id="ddt-new-contract" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?php echo ci_trans('add_'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="ddt1">
                                <li id="new-contract-ma" class="to-new-contract" 
                                    process-type-contract="<?php echo common_string::_PROCESS_TYPE_CONTRACT_NORMAL_; ?>">
                                    <a href="javascript:void(0);">
                                        <i class="fa fa-file-text-o"></i> <?php echo ci_trans('contract_'); ?>
                                    </a>
                                </li>
                                <li id="new-contract-ma-only" class="to-new-contract" 
                                    process-type-contract="<?php echo common_string::_PROCESS_TYPE_CONTRACT_MA_; ?>">
                                    <a href="javascript:void(0);">
                                        <i class="fa fa-file-text"></i> <?php echo ci_trans('contract_ma_only_'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="box-tools pull-right">
                            <div class="btn-group group-button-dropdown">
                                <button type="button" class="btn btn-flat bg-olive btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="glyphicon glyphicon-save-file"></i>
                                    <?php echo ci_trans('export_'); ?>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <!--<li>
                                        <a href="#">
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
                        
                        <!--<div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>-->
                    </div>
                    <div class="box-body">
                        <?php
                            echo form_open('', array(
                                'name' => 'search_form',
                                'class' => 'form-horizontal'
                            ));
                            ?>

                            <table id="search-table" class="table table-bordered table-odd-even-color" style="min-width: 768px;">
                                <tr>
                                    <td nowrap><label><?php echo ci_trans('running_no_'); ?></label></td>
                                    <td colspan="2">
                                        <input type="text" class="form-control" name="running_no" value="" autocomplete="off">
                                    </td>
                                    <td nowrap><label><?php echo ci_trans('contract_no_'); ?></label></td>
                                    <td colspan="2">
                                        <input type="text" class="form-control" name="contract_no" value="" autocomplete="off">
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
                                    <td></td>
                                    <td colspan="2"></td>
                                </tr>

                                <tr>
                                    <td nowrap><label><?php echo ci_trans('contract_name_'); ?></label></td>
                                    <td colspan="5"><input type="text" id="data1" name="contract_name" class="form-control" autocomplete="off"></td>
                                </tr>

                                <tr>
                                    <td nowrap><label><?php echo ci_trans('start_date_'); ?></label></td>
                                    <td colspan="2">
                                        <div class="col-xs-6">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="start_date_start" name="start_date_start"
                                                       value="" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="start_date_end" name="start_date_end"
                                                       value="" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td nowrap><label><?php echo ci_trans('end_date_'); ?></label></td>
                                    <td colspan="2">
                                        <div class="col-xs-6">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="end_date_start" name="end_date_start"
                                                       value="" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="end_date_end" name="end_date_end"
                                                       value="" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap><label><?php echo ci_trans('delivery_date_'); ?></label></td>
                                    <td colspan="2">
                                        <div class="col-xs-6">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="delivery_date_start" name="delivery_date_start"
                                                       value="" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group date dtpicker">
                                                <input type="text" class="form-control" id="delivery_date_end" name="delivery_date_end"
                                                       value="" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td colspan="2"></td>
                                </tr>

                            </table>
                            
                            <div class="text-center">
                                <?php echo $common_element->get_search_button('data-loading-text=" '.ci_trans('Processing...').'"'); ?>
                                <?php echo $common_element->get_reset_button(); ?>
                            </div>
                            <?php
                            echo form_close();
                        ?>

                        <br>

                        <div class="table-responsive">
                            <table id="table-list" class="table table-bordered table-striped 
                                table-hover table-list-click">
                                <thead>
                                    <tr>
                                        <th nowrap><?php echo ci_trans('running_no_'); ?></th>
                                        <th nowrap><?php echo ci_trans('contract_no_'); ?></th>
                                        <th nowrap><?php echo ci_trans('contract_name_'); ?></th>
                                        <th nowrap><?php echo ci_trans('delivery_date_'); ?></th>
                                        <th nowrap><?php echo ci_trans('start_date_'); ?></th>
                                        <th nowrap><?php echo ci_trans('end_date_'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        
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

        <?php $this->load->view('layouts/contract_list/contract_list/modal_contract_edit'); ?>