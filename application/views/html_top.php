<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ci_trans('Contract_').' '.ci_trans('list_') ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.ico" type="image/x-icon" />

    <?php $this->load->view('html_resources'); ?>

    <?php
    if(count($addition_resources_script) > 0) {
        foreach($addition_resources_script as $type => $script_path_files) {
            if($type == 'css') {
                foreach($script_path_files as $script_path_file) { echo $script_path_file."\r\n"; }
            }
            elseif($type == 'js') {
                foreach($script_path_files as $script_path_file) { echo $script_path_file."\r\n"; }
            }
        }
    }
    ?>

    <?php $ci_instance->get_view_resources($controller_name,$method_name); ?>

    <!-- final override -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/view_resources/css/final_override.css?v=<?php echo time(); ?>">

    <?php echo form_hidden('csrf_name', $this->security->get_csrf_token_name()); ?>
    <?php echo form_hidden('csrf_value', $this->security->get_csrf_hash()); ?>

</head>
<body class="skin-dark-blue sidebar-mini" style="min-width:1024px; overflow-x:auto !important;">
    <!-- js_lang -->
    <div id="js_language_strings" style="display: none;"><?php echo $ci_instance->generate_js_language_string(); ?></div>

    <!-- Site wrapper -->
    <div class="wrapper">
