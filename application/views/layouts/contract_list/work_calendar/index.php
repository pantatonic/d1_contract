        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $ci_instance->get_page_item()['work_calendar']['item']; ?>
                    <small><?php echo ci_trans('work_calendar_subtitle_'); ?></small>
                    <input type="hidden" id="contract_color_warranty" value="<?php echo $contract_color_warranty; ?>">
                    <input type="hidden" id="contract_color_maintenance" value="<?php echo $contract_color_maintenance; ?>">
                </h1>
            </section>

            
            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <div id="warranty-block" class="color-block-explain"></div>
                        <?php echo ci_trans('Warranty'); ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <div id="maintenance-block" class="color-block-explain"></div>
                        <?php echo ci_trans('ma_'); ?>

                        <!--<div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>-->
                    </div>
                    <div class="box-body">
                        <div id="calendar"></div>
                    </div>
                    <div class="box-footer">
                        &nbsp;
                    </div>
                </div>

            </section>
        </div>

        <select id="template-warranty-detail-status" class="hide">
            <option value=""><?php echo ci_trans('Please select warranty process status'); ?></option>
            <?php  
                foreach($contract_warranty_detail_status as $cwds) {
                    echo '<option value="'.$cwds['id'].'">'
                        .$cwds['status']
                    .'</option>'; 
                }
            ?>
        </select>

        <select id="template-maintenance-detail-status" class="hide">
            <option value=""><?php echo ci_trans('Please select maintenance process status'); ?></option>
            <?php  
                foreach($contract_warranty_detail_status as $cwds) {
                    echo '<option value="'.$cwds['id'].'">'
                        .$cwds['status']
                    .'</option>'; 
                }
            ?>
        </select>

        <?php $this->load->view('layouts/contract_list/work_calendar/modal_contract_detail') ?>
