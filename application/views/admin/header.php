<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?php echo get_header_tag_data();?></title>
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery-ui.custom.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/chosen.min.css" />
        <!-- text fonts -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/fonts.googleapis.com.css" />

 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap-editable.min.css" />
        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/ace-skins.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/ace-rtl.min.css" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

        <!--<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />-->
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap-datepicker3.min.css" />
        <!--<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />-->

        <!-- basic scripts -->


        <!--[if !IE]> -->
        <script src="<?php echo base_url(); ?>assets/admin/js/jquery-2.1.4.min.js"></script>
        <!-- <![endif]-->

        <!--[if IE]>
        <script src="assets/js/jquery-1.11.3.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='<?php echo base_url(); ?>assets/admin/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="<?php echo base_url(); ?>assets/admin/js/ace-extra.min.js"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="skin-3 no-skin">
        <div id="navbar" class="navbar navbar-default          ace-save-state">
            <div class="navbar-container ace-save-state" id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <div class="navbar-header pull-left">
                    <a href="<?php echo base_url(); ?>admin/dashboard" class="navbar-brand">
                        <small>
                            
                            <?php echo APP_NAME?> Admin
                        </small>
                    </a>
                </div>

                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">

                        <?php
                        $user_data = get_admin_user_details();
                        (isset($user_data)) ? $user_data : '';
                        ?>
                        <li class="new-gray dropdown-modal">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="<?php echo base_url(); ?>assets/admin/images/profile.png" alt="Jason's Photo" />
                                <span class="user-info">
                                    <small>Welcome,</small>
                                    <?php echo $user_data['full_name']; ?>
                                </span>

                                <i class = "ace-icon fa fa-caret-down"></i>
                            </a>

                            <ul class = "user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href = "<?php echo base_url(); ?>admin/users/change_password">
                                        <i class = "ace-icon fa fa-cog"></i>
                                        Settings
                                    </a>
                                </li>

                               

                                <li class = "divider"></li>

                                <li>
                                    <a href = "<?php echo base_url(); ?>admin/dashboard/logout">
                                        <i class = "ace-icon fa fa-power-off"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!--/.navbar-container -->
        </div>
