
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $ci_instance->get_page_item()['bank_list']['item']; ?>
                    <small><?php echo ci_trans('Bank list subtitle'); ?></small>
                </h1>
            </section>

            
            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <?php echo $common_element->get_new_button('id="new-bank"'); ?>
                        <!--<div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>-->
                    </div>
                    <div class="box-body">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-8">
                            <table id="bank-list-table" class="table table-bordered table-hover table-striped table-list-click">
                                <thead>
                                    <tr>
                                        <th><?php echo ci_trans('short_name_'); ?></th>
                                        <th><?php echo ci_trans('bank_name_'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--<tr>
                                        <td colspan="2" style="text-align: center;">
                                            <img src="<?php echo base_url('assets/dist/img/loading.gif'); ?>" style="width: 25px;">
                                            &nbsp;
                                            <?php echo ci_trans('Processing...'); ?>
                                        </td>
                                    </tr>-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        &nbsp;
                    </div>
                </div>

            </section>
        </div>

        <?php $this->load->view('layouts/contract_list/bank_list/modal_bank_edit'); ?>
