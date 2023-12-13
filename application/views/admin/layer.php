<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo $page_title ?> | SUNU Groupe</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="SUNU Group admin app" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url(); ?>assets/admin/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo base_url(); ?>assets/admin/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/layouts/layout/css/themes/sunu-light.css" rel="stylesheet" type="text/css" id="style_color" />
        
        <?php 
            // Add any css
            if(isset($css) ){
                foreach($css as $style){
                    echo '<link rel="stylesheet" href="'.site_url('assets/admin/').$style.'" />' . "\n";
                }
            }
        ?>
        
        <link href="<?php echo base_url(); ?>assets/admin/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/layouts/layout/css/loader.scss" rel="stylesheet/scss" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed page-footer-fixed">
       
        <!-- access to base url from js script -->
        <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url(); ?>" />
        
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="<?php echo base_url(); ?>">
<!--                            <img src="<?php //echo base_url(); ?>assets/admin/images/logo.png" alt="logo monetablissement.com" class="logo-default" />-->
                            <span class="text-logo logo-default"><span class="font-red-thunderbird">SUNU Groupe</span></span>
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="<?php echo base_url(); ?>assets/admin/images/<?php echo $logged_in['photo']; ?>" alt="photo profil" />
                                    <span class="username username-hide-on-mobile"> <?php echo $logged_in['name']; ?> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
<!--                                    <li>-->
<!--                                        <a href="<?php //echo site_url('profile'); ?>">-->
<!--                                            <i class="icon-user"></i> Mon profil </a>-->
<!--                                    </li>-->
                                    <li>
                                        <a href="<?php echo site_url('admin/Login/logout'); ?>">
                                            <i class="icon-lock"></i> Déconnexion </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <?php echo $menu; ?>
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <?php echo $content; ?>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner">
                    &copy; <span class="current-year"><?php echo date('Y'); ?></span><span class="text-bold text-uppercase"> SUNU Groupe</span>. <span>Tous droits reserv&eacute;s </span>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/excanvas.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/admin/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url(); ?>assets/admin/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/admin/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/admin/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        
        <?php 
            // Add any javascripts
            if(isset($javascripts) ){
                foreach($javascripts as $js){
                    echo '<script src="'.site_url('assets/admin/').$js.'"></script>' . "\n";
                }
            }
        ?>
        
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function() {
                $('#clickmewow').click(function() {
                    $('#radio1003').attr('checked', 'checked');
                });
                
                // Hide the multiple actions buttons on default
                $('.actions').each(function () {
                    $(this).hide(0);
                });
                
                try {
                    Dropzone.options.dropzoneForm = {
                        paramName: "picture", // The name that will be used to transfer the file
                        maxFilesize: 200, // MB
                        dictDefaultMessage: "<h3>Déposer les fichiers ici ou cliquer pour les sélectionner</h3>",
                        init: function() {
                            this.on("uploadprogress", function(file, progress) {
                                console.log("File progress", progress);
                            });
                        }
                    };
                } catch(e){}
                
                try {
                    load_articlePhoto();
                } catch(e){}
            })
        </script>
    </body>

</html>