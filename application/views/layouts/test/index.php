
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $page_title; ?>
                    <small><?php echo ci_trans('Contract list subtitle'); ?></small>
                </h1>
            </section>

            
            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="sum_total_month">&nbsp;</h3>
                        <!--<div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>-->
                    </div>
                    <div class="box-body">
                        <?php
                            echo form_open($controller_name.'/test_submit', array(
                                'name' => 'search_form',
                                'class' => 'form-horizontal'
                            ));
                            ?>
                            <!--<div class="form-group">
                                <label for="txt1" class="col-sm-1 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txt" 
                                        name="txt1" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-10">
                                    <?php echo $common_element->get_search_button('data-loading-text=" '.ci_trans('Processing...').'"'); ?>
                                    <?php echo $common_element->get_reset_button(); ?>
                                </div>
                            </div>-->
                            <table id="search-table" class="table table-bordered table-odd-even-color">
                                <tr>
                                    <td><label>Data 1</label></td>
                                    <td>
                                        <div class="input-group date dtpicker">
                                            <input type="text" class="form-control" id="data1" name="data1"
                                                   value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td><label>Data 2</label></td>
                                    <td>
                                        <div class="input-group date dtpicker">
                                            <input type="text" class="form-control" id="data2" name="data2"
                                                   value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Data 3</label></td>
                                    <td><input type="text" id="data1" name="data3" class="form-control"></td>
                                    <td><label>Data 4</label></td>
                                    <td><input type="text" id="data1" name="data4" class="form-control"></td>
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

                        <table id="table-list" class="table table-bordered table-striped table-hover table-dark-bordered">
                            <thead>
                                <tr>
                                    <th>Head column 1</th>
                                    <th>Head column 2</th>
                                    <th>Head column 3</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        &nbsp;
                    </div>
                </div>

            </section>
        </div>