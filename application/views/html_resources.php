    <script type="text/javascript">
        var _LOCALE_ = '<?php echo $ci_language; ?>';
        var _LOCALE_SHORT_ = function(locale) {
            switch (locale) {
                case 'thai' :
                    return 'th';
                    break;
                case 'english' :
                    return 'en';
                    break;
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font_awesome/css/font-awesome.css">

    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->

    <!-- animate css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/animate_css/animate.css">

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css">
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var bootstrapButton = $.fn.button.noConflict();
        $.fn.bootstrapBtn = bootstrapButton;

        /*var bootstrapTooltip = $.fn.tooltip.noConflict();
        $.fn.bootstrapTooltip = bootstrapTooltip;*/
    </script>

    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.css">

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-datetimepicker/js/moment-with-locales.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

    <!-- pnotify -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/pnotify/pnotify.custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/pnotify/pnotify.override.css?v=<?php echo time(); ?>">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/pnotify/pnotify.custom.js"></script>

    <!-- mask -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery.mask.min.js"></script>  

    <!-- data table -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/data_table/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/data_table/extensions/Responsive/css/responsive.bootstrap.css">

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/data_table/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/data_table/media/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/data_table/extensions/Responsive/js/dataTables.responsive.js"></script>

    <!-- table auto row -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-table-auto-row.js"></script>

    <!-- sweet alert 2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/sweetalert2/sweetalert2.min.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert2/promise.min.js"></script>
  

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/view_resources/css/custom_css.css?v=<?php echo time(); ?>">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/view_resources/js/custom_js.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/view_resources/js/app.js?v=<?php echo time(); ?>"></script>


    <script type="text/javascript" src="<?php echo base_url(); ?>assets/view_resources/js/alert_util.js?v=<?php echo time(); ?>"></script>

    <?php echo form_hidden('site_url',site_url()); ?>
	<?php echo form_hidden('base_url',base_url()); ?>
