<!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li class="header"></li>

                    <?php 
                        $array_1st_1_level_menu = [
                            'contract_list','bank_list',
                            'contract_list_status',
                            'contract_type_list',
                            'contract_warranty_detail_status',
                            'contract_maintenance_detail_status',
                            'contract_payment_period_status',
                            'contract_mandatory_field',
                            'info_contract_warranty_between_date_range',
                            'info_contract_maintenance_between_date_range',
                            'info_contract_payment_period_between_date_range',
                            'work_calendar',
                            'dashboard'
                        ];

                        $_1st_1_level_menu_class = in_array($controller_name, $array_1st_1_level_menu) 
                            ? 'active':''
                    ?> 

                    <li class="treeview <?php echo $_1st_1_level_menu_class; ?>">
                        <a href="#">
                            <i class="fa fa-share text-aqua"></i> <span><?php echo ci_trans('contract_system_'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php $ci_instance->check_sidebar_active('dashboard'); ?>">
                                <a href="<?php echo $ci_instance->get_page_item()['dashboard']['link']; ?>"> 
                                    <?php echo $ci_instance->get_page_item()['dashboard']['item']; ?>
                                </a>
                            </li>
                            <li class="<?php $ci_instance->check_sidebar_active('contract_list'); ?>">
                                <a href="<?php echo $ci_instance->get_page_item()['contract_list']['link']; ?>"> 
                                    <?php echo $ci_instance->get_page_item()['contract_list']['item']; ?>
                                </a>
                            </li>
                            <li class="<?php $ci_instance->check_sidebar_active('work_calendar'); ?>">
                                <a href="<?php echo $ci_instance->get_page_item()['work_calendar']['link']; ?>"> 
                                    <?php echo $ci_instance->get_page_item()['work_calendar']['item']; ?>
                                </a>
                            </li>


                            <?php
                                $array_2nd_1_level_menu = [
                                    'bank_list',
                                    'contract_type_list',
                                    'contract_list_status',
                                    'contract_warranty_detail_status',
                                    'contract_maintenance_detail_status',
                                    'contract_payment_period_status'
                                ];
                                $_2nd_1_level_menu_class = in_array($controller_name, $array_2nd_1_level_menu) 
                                    ? 'active':'';
                            ?>
                            <li class="<?php echo $_2nd_1_level_menu_class; ?>">
                                <a href="#">
                                    <i class="fa fa fa-cog"></i> <?php echo ci_trans('basic_information_'); ?> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="<?php $ci_instance->check_sidebar_active('bank_list'); ?>">
                                        <a href="<?php echo $ci_instance->get_page_item()['bank_list']['link']; ?>">
                                            <?php echo $ci_instance->get_page_item()['bank_list']['item']; ?>
                                        </a>
                                    </li>
                                    <li class="<?php $ci_instance->check_sidebar_active('contract_type_list'); ?>">
                                        <a href="<?php echo $ci_instance->get_page_item()['contract_type_list']['link']; ?>">
                                            <?php echo $ci_instance->get_page_item()['contract_type_list']['item']; ?>
                                        </a>
                                    </li>
                                    <!--<li class="<?php $ci_instance->check_sidebar_active('contract_list_status'); ?>">
                                        <a href="<?php echo $ci_instance->get_page_item()['contract_list_status']['link']; ?>">
                                            <i class="fa fa-circle-o"></i> 
                                            <?php echo ci_trans('contract_list_status_'); ?>
                                        </a>
                                    </li>-->

                                    <?php
                                        $array_3rd_1_level_menu = [
                                            'contract_list_status',
                                            'contract_warranty_detail_status',
                                            'contract_maintenance_detail_status',
                                            'contract_payment_period_status'
                                        ];
                                        $_3nd_1_level_menu_class = in_array($controller_name, $array_3rd_1_level_menu) 
                                            ? 'active':'';
                                    ?>
                                    <li rel="<?php echo $_3nd_1_level_menu_class; ?>" class="<?php echo $_3nd_1_level_menu_class; ?>">
                                        <a href="#">
                                            <i class="fa fa-circle-o"></i> <?php echo ci_trans('Status'); ?> 
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li class="<?php $ci_instance->check_sidebar_active('contract_list_status'); ?>">
                                                <a href="<?php echo $ci_instance->get_page_item()['contract_list_status']['link']; ?>">
                                                    <?php echo $ci_instance->get_page_item()['contract_list_status']['item']; ?>
                                                </a>
                                            </li>
                                            <li class="<?php $ci_instance->check_sidebar_active('contract_warranty_detail_status'); ?>">
                                                <a href="<?php echo $ci_instance->get_page_item()['contract_warranty_detail_status']['link']; ?>">
                                                    <?php echo $ci_instance->get_page_item()['contract_warranty_detail_status']['item']; ?>
                                                </a>
                                            </li>
                                            <li class="<?php $ci_instance->check_sidebar_active('contract_maintenance_detail_status'); ?>">
                                                <a href="<?php echo $ci_instance->get_page_item()['contract_maintenance_detail_status']['link']; ?>">
                                                    <?php echo $ci_instance->get_page_item()['contract_maintenance_detail_status']['item']; ?>
                                                </a>
                                            </li>
                                            <li class="<?php $ci_instance->check_sidebar_active('contract_payment_period_status'); ?>">
                                                <a href="<?php echo $ci_instance->get_page_item()['contract_payment_period_status']['link']; ?>">
                                                    <?php echo $ci_instance->get_page_item()['contract_payment_period_status']['item']; ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <?php
                                $array_2nd_2_level_menu = ['contract_mandatory_field'];
                                $_2nd_2_level_menu_class = in_array($controller_name, $array_2nd_2_level_menu) ? 'active':'';
                            ?>
                            <li class="<?php echo $_2nd_2_level_menu_class; ?>">
                                <a href="#">
                                    <i class="fa fa fa-cog"></i> <?php echo ci_trans('Settings'); ?> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="<?php $ci_instance->check_sidebar_active('contract_mandatory_field'); ?>">
                                        <a href="<?php echo $ci_instance->get_page_item()['contract_mandatory_field']['link']; ?>">
                                            <?php echo $ci_instance->get_page_item()['contract_mandatory_field']['item']; ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <?php
                                $array_2nd_3_level_menu = [
                                    'info_contract_warranty_between_date_range',
                                    'info_contract_maintenance_between_date_range',
                                    'info_contract_payment_period_between_date_range'
                                ];
                                $_2nd_3_level_menu_class = in_array($controller_name, $array_2nd_3_level_menu) ? 'active':'';
                            ?>

                            <li class="<?php echo $_2nd_3_level_menu_class; ?>">
                                <a href="#">
                                    <i class="fa fa fa-info-circle"></i> <?php echo ci_trans('info_'); ?> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="<?php $ci_instance->check_sidebar_active('info_contract_warranty_between_date_range'); ?>">
                                        <a href="<?php echo $ci_instance->get_page_item()['info_contract_warranty_between_date_range']['link']; ?>">
                                            <?php echo $ci_instance->get_page_item()['info_contract_warranty_between_date_range']['item']; ?>
                                        </a>
                                    </li>
                                    <li class="<?php $ci_instance->check_sidebar_active('info_contract_maintenance_between_date_range'); ?>">
                                        <a href="<?php echo $ci_instance->get_page_item()['info_contract_maintenance_between_date_range']['link']; ?>">
                                            <?php echo $ci_instance->get_page_item()['info_contract_maintenance_between_date_range']['item']; ?>
                                        </a>
                                    </li>
                                    <li class="<?php $ci_instance->check_sidebar_active('info_contract_payment_period_between_date_range'); ?>">
                                        <a href="<?php echo $ci_instance->get_page_item()['info_contract_payment_period_between_date_range']['link']; ?>">
                                            <?php echo $ci_instance->get_page_item()['info_contract_payment_period_between_date_range']['item']; ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <?php
                                $array_2nd_4_level_menu = [];
                                $_2nd_4_level_menu_class = in_array($controller_name, $array_2nd_4_level_menu) ? 'active':'';
                            ?>

                            <!--<li class="<?php echo $_2nd_4_level_menu_class; ?>">
                                <a href="#">
                                    <i class="fa fa fa-file-text"></i> <?php echo ci_trans('report_'); ?> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="">
                                        <a href="#">
                                            <i class="fa fa-file-text-o"></i> 
                                            ทดสอบ รายงาน
                                        </a>
                                    </li>
                                </ul>
                            </li>-->
                        </ul>
                    </li>

                    <!--
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-share text-aqua"></i> <span>Multilevel</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                            <li>
                                <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                                    <li>
                                        <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul class="treeview-menu">
                                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                        </ul>
                    </li>
                    -->
                    
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>