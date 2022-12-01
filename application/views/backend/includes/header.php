<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>condopi - <?php echo (@$title_page != null) ? " | ".$title_page : "";?></title>

    <!-- Bootstrap -->
    <link href="<?php echo skin_url('backend/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo skin_url('backend/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo skin_url('backend/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo skin_url('backend/vendors/iCheck/skins/flat/green.css');?>" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo skin_url('backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css');?>" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo skin_url('backend/vendors/jqvmap/dist/jqvmap.min.css');?>" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo skin_url('backend/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo skin_url('backend/build/css/custom.min.css');?>" rel="stylesheet">
    <link href="<?php echo skin_url('backend/vendors/switchery/dist/switchery.min.css');?>" rel="stylesheet">
    <link href="<?php echo skin_url('backend/css/style.css');?>" rel="stylesheet">
    <script src="<?php echo skin_url('backend/vendors/jquery/dist/jquery.min.js');?>"></script>
  </head>
  <body class="nav-md <?php echo @$body_class;?>">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo backend_url();?>" class="site_title"><i class="fa fa-paw"></i> <span>ADMIN</span></a>
            </div>

            <div class="clearfix"></div>
            	
            <br>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section active">
                <h3>General</h3>
                <?php echo @$_menu;?>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php if(@$admin_info["User_Avatar"] == ""):?>
                      <img src="<?php echo skin_url('backend/images/img.jpg');?>" alt="">
                    <?php else:?>
                      <img src="<?php echo base_url(@$admin_info["User_Avatar"]);?>" alt="">
                    <?php endif;?>
                    <?php echo @$admin_info["User_Name"];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo backend_url("profile");?>"> Profile</a></li>
                    <li><a href="<?php echo backend_url("acounts/logout");?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <div class="right_col" role="main">
        <div class="row"><div class="col-md-12"><?php echo breadcrumb();?></div></div>