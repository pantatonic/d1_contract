        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $ci_instance->get_page_item()['dashboard']['item']; ?>
                    <small><?php echo ci_trans('dashboard_subtitle_'); ?></small>
                </h1>
            </section>

            
            <section class="content">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box" id="box-warranty-maintenance-chart">
                            <div class="box-header with-border">
                                <h3 class="box-title">&nbsp;</h3>
                                <div class="col-xs-2">
                                    <div class="input-group date year-picker">
                                        <input type="text" class="form-control text-center" id="year_" name="year_"
                                               value="<?php echo date('Y'); ?>" autocomplete="off">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool refresh-chart-data" 
                                        target-operation="chart_.render.warranty_maintenance_detail_in_year" 
                                        title="<?php echo ci_trans('Refresh data'); ?>">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body force-xs-none-padding">
                                <div class="col-xs-12 force-xs-none-padding">
                                    <div id="warranty-maintenance-detail-chart"></div>
                                </div>
                            </div>
                            <div class="box-footer">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">&nbsp;</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool refresh-chart-data" 
                                        target-operation="chart_.render.contracts_by_bank" 
                                        title="<?php echo ci_trans('Refresh data'); ?>">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body force-xs-none-padding">
                                <div class="col-xs-12 force-xs-none-padding">
                                    <div id="contract-by-bank-chart"></div>
                                </div>
                            </div>
                            <div class="box-footer">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">&nbsp;</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool refresh-chart-data" 
                                        target-operation="chart_.render.contracts_by_type" 
                                        title="<?php echo ci_trans('Refresh data'); ?>">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body force-xs-none-padding">
                                <div class="col-xs-12 force-xs-none-padding">
                                    <div id="contract-by-type-chart"></div>
                                </div>
                            </div>
                            <div class="box-footer">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
