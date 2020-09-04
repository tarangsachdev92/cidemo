<?php
$module = $this->_ci->uri->segment(2);
$method = $this->_ci->uri->segment(3);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--META SECTION-->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!--<link rel="shortcut icon" href="images/favicon.png" type="image/png" />-->

        <title>Administrator</title>



        <!--STYLE SECTION-->
        <?php echo add_css(array('style.default', 'jquery.datatables', 'bootstrap-fileupload.min', 'bootstrap-timepicker.min', 'bootstrap-timepicker.min', 'jquery.tagsinput', 'colorpicker', 'dropzone', 'developer-style', 'bootstrap-fileupload.min')); ?>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <?php echo add_js(array('jquery-1.10.2.min', 'bootstrapValidator')); ?>
        <script type="text/javascript">
        function getsiteurl()
        {
            return '<?php echo site_url(); ?>';
        }
        </script>

    </head>

    <body class="stickyheader">

        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>

        <!--Ends in Footer File-->
        <section>
            <div class="logopanel">
                    <h1><span>[</span> Company <span>]</span></h1>
                </div><!-- logopanel -->
                
<!--            <div class="leftpanel sticky-leftpanel">-->
                <div class="leftpanel">
                <div class="leftpanelinner">    

                    <!-- This is only visible to small devices -->
                    <div class="visible-xs hidden-sm hidden-md hidden-lg">   
                        <div class="media userlogged">
<!--                            <img alt="" src="images/photos/loggeduser.png" class="media-object" />-->
                            <img alt="" src="images/user-mobile-image.png" class="media-object">
                            <div class="media-body">
                                <h4><?php echo $ci->session->userdata[$ci->theme->get('section_name')]['firstname'] . ' ' . $ci->session->userdata[$ci->theme->get('section_name')]['lastname']; ?></h4>
<!--                                <span>"Life is so..."</span>-->
                            </div>
                        </div>

                        <h5 class="sidebartitle actitle">Account</h5>
                        <ul class="nav nav-pills nav-stacked nav- mb30">
                            <li><a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/users/changepassword"><i class="fa fa-unlock-alt"></i> <span>Change Password</span></a></li>
                            <li><a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/users/logout"><i class="fa fa-power-off"></i> <span>Log Out</span></a></li>
                        </ul>
                    </div>

                    <h5 class="sidebartitle">Default Navigation</h5>

                    <ul class="nav nav-pills nav-stacked nav-">

                        <li class="<?php echo $module == 'dashboard' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/dashboard/"><i class="fa fa-desktop"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="<?php echo $module == 'users' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/users/"><i class="fa fa-th-list"></i> <span>Users</span></a>
                        </li>
                        
                        <li class="<?php echo $module == 'permissions' ? 'active' : ''; ?>"><a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/permissions/"><i class="fa fa-suitcase"></i> <span>Permissions</span></a></li>
                        <li class="<?php echo ($module == 'roles' && $method != 'permission_matrix') ? 'active' : ''; ?>"><a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/roles/"><i class="fa fa-edit"></i> <span>Roles</span></a></li>
                        <li class="<?php echo $method == 'permission_matrix' ? 'active' : ''; ?>"><a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/roles/permission_matrix/"><i class="fa fa-sitemap"></i> <span>Permission Matrix</span></a></li>
                        <li class="<?php echo $module == 'modulebuilder' ? 'active' : ''; ?>"><a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/modulebuilder/generate_module/"><i class="fa fa-tachometer"></i> <span>Module Builder</span></a></li>
                        
                    </ul>
                    
                    <?php widget('menu', array('menu_name' => 'admin_menu', 'section_name' => $ci->theme->get('section_name')));?>
                    
                </div>
            </div>

            <!--Ends in Footer-->
            <div class="mainpanel">
                <div class="headerbar">
                    <a class="menutoggle"><i class="fa fa-bars"></i></a>
                    <div class="header-right">
                        <ul class="headermenu">
<!--                            <li class="full-screen">
                                <a href="#" class="tp-icon" style="height:50px; display:block;"  id="full-screen">                
                                    <i class="glyphicon glyphicon-resize-full"></i>
                                </a>
                            </li>-->
                            <li>
                                <div class="btn-group">            
                                    <button type="button" class="btn btn-default dropdown-toggle  tp-icon" data-toggle="dropdown">                
                                        <i class="glyphicon glyphicon-user"></i>
                                        <span class="user-name">

                                            <?php echo $ci->session->userdata[$ci->theme->get('section_name')]['firstname'] . ' ' . $ci->session->userdata[$ci->theme->get('section_name')]['lastname']; ?>
                                            <span class="caret"></span>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                        <li>
                                            <a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/users/changepassword"><i class="glyphicon  glyphicon-lock"></i> Change Password</a>
                                        </li>
                                        <li><a href="<?php echo site_url() . $ci->theme->get('section_name'); ?>/users/logout/"><i class="glyphicon glyphicon-off"></i> Log Out</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="pageheader">
                    <?php
                    if (isset($page_title)) {
                        echo '<h2><i class="fa fa-home"></i>' . $page_title . '</h2>';
                    }
                    ?>

                    <?php echo $ci->breadcrumb->output(); ?>
                </div>




                <div id="messages" style="display:<?php echo (($ci->theme->message() == '') ? 'none' : ''); ?>; margin: 10px 20px 0px 20px">
                    <?php echo $ci->theme->message(); ?>
                </div>
