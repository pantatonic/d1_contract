
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $ci_instance->get_page_item()['contract_mandatory_field']['item']; ?>
                    <small><?php echo ci_trans('contract_mandatory_field_sub_title'); ?></small>
                </h1>
            </section>

            
            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <br>
                        <!--<div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>-->
                    </div>
                    <div class="box-body">

                        <div class="col-md-8 col-md-offset-2">
                            <?php echo form_open('', array('name' => 'edit_form', 'class' => '')); ?>
                                <?php echo $common_element->get_submit_loading_button('style="float: right;"'); ?>
                                <table id="list-table" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo ci_trans('input_field'); ?></th>
                                            <th><?php echo ci_trans('is_mandatory'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $array_except = array('id', 'dwp', 'fine');

                                            foreach($data_set as $ds) {
                                                if(in_array($ds['field_name'], $array_except)) { continue; }
                                            ?>
                                            <tr>
                                                <td><?php echo ci_trans('cmf_'.$ds['field_name']); ?></td>
                                                <td>
                                                    <input type="hidden" name="field_name[]" value="<?php echo $ds['field_name']; ?>">
                                                    <input type="checkbox" class="chk-box" 
                                                        <?php echo $ds['mandatory'] == '1' ? ' checked="checked" ':'' ?>>
                                                    <input type="hidden" name="mandatory[]">
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <?php echo $common_element->get_submit_loading_button('style="float: right;"'); ?>
                            <?php echo form_close(); ?>
                        </div>
                        
                    </div>
                    <div class="box-footer">
                        &nbsp;
                    </div>
                </div>

            </section>
        </div>
