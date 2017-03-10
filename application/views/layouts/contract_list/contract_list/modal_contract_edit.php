<?php echo form_open('', array('name' => 'edit_form', 'class' => 'form-horizontal')); ?>
<div id="modal-contract-edit" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <?php echo ci_trans('Contract Detail'); ?>
                    <button type="button" id="calculate-warranty" class="btn btn-warning btn-flat" 
                        data-loading-text="<?php echo ci_trans('Processing...'); ?>">
                        <i class="fa fa-microchip"></i>
                        <?php echo ci_trans('Calculate warranty and maintenance'); ?>
                    </button>
                    <div id="detail-dropdown-export" class="dropdown group-button-dropdown">
                        <button class="btn btn-default btn-flat bg-olive dropdown-toggle" type="button" id="ddt1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php echo ci_trans('export_'); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="ddt1">
                            <!--<li id="export-data-detail-pdf">
                                <a href="javascript:void(0);">
                                    <i class="fa fa-file-pdf-o pdf-icon"></i> <?php echo ci_trans('pdf_'); ?>
                                </a>
                            </li>-->
                            <li id="export-data-detail-excel">
                                <a href="javascript:void(0);">
                                    <i class="fa fa-file-excel-o excel-icon"></i> <?php echo ci_trans('excel_'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </h4>
            </div>
            <div class="modal-body">
                <div>
                    <ul class="nav nav-tabs force-min-width" role="tablist" id="contract-list-tab">
                        <li role="presentation" class="active">
                            <a href="#contract-detail-tab" aria-controls="contract-detail-tab" 
                                role="tab" data-toggle="tab">
                                <?php echo ci_trans('Contract detail'); ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#warranty-detail-tab" aria-controls="contract-delivery-set-tab" 
                                role="tab" data-toggle="tab">
                                <?php echo ci_trans('Warranty detail'); ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#maintenance-detail-tab" aria-controls="contract-delivery-set-tab" 
                                role="tab" data-toggle="tab">
                                <?php echo ci_trans('Maintenance detail'); ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#payment-period-tab" aria-controls="contract-payment-set-tab" 
                                role="tab" data-toggle="tab">
                                <?php echo ci_trans('Payment period'); ?>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="contract-detail-tab">
                            <?php $this->load->view('layouts/contract_list/contract_list/modal_contract_edit_contract_detail_tab'); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="warranty-detail-tab">
                            <?php $this->load->view('layouts/contract_list/contract_list/modal_contract_edit_warranty_detail_tab'); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="maintenance-detail-tab">
                            <?php $this->load->view('layouts/contract_list/contract_list/modal_contract_edit_maintenance_detail_tab'); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="payment-period-tab">
                        <?php $this->load->view('layouts/contract_list/contract_list/modal_contract_edit_payment_period_tab'); ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <span id="change-without-calculate-text-caution" 
                    class="label label-danger caution-text"></span>
                <?php echo $common_element->get_close_modal_button(); ?>
                <?php echo $common_element->get_submit_loading_button(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>