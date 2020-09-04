<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $ci->theme->get_page_title('Cidemo');?></title>
        <?php echo display_meta();?>
        <?php
        echo add_js(array('jquery-1.9.1.min','jquery.blockUI','common'));


        echo add_js('common');
		echo add_js('jquery.blockUI');
        if ($ci->session->userdata[$ci->theme->_data['section_name']]['site_direction'] == 'rtl')
        {
            echo add_css(array('stylesheet_rtl'));
        }
        else
        {
            echo add_css(array('stylesheet'));
        }
        ?>
        <script type="text/javascript">
            //Function to hide message
            function hide_msg(){
                $('#error_msg').hide();
            }
        </script>

    </head>
    <body>

        <noscript><div style="color: red; position: fixed; top:0; background:#ccc; width:100%; text-align: center; padding-top:5px; padding-bottom: 5px; font-size:16px;">This site requires javascript enabled</div><br>
        </noscript>
        <table width="1000" cellspacing="0" cellpadding="0" align="center">
            <tr class="header">
                <td class="logo">Company Logo
                    <div style="color:#fff;font-size: 12px;float: right;padding:0px 10px 0px 0px;">
                    <?php
                    if (isset($ci->session->userdata[$ci->theme->_data['section_name']]['user_id']) && !empty($ci->session->userdata[$ci->theme->_data['section_name']]['user_id']))
                    {
                        echo lang('welcome') ." ". $ci->session->userdata[$ci->theme->_data['section_name']]['firstname'] . " " . $ci->session->userdata[$ci->theme->_data['section_name']]['lastname'];
                        echo "&nbsp;&nbsp;&nbsp;";
                        echo anchor(base_url().'users/logout', lang('logout'), "style='color:#fff'");
                        echo "<br/>";
                        echo anchor(base_url()."users/change_password", lang("change-password"), "style='color:#fff'");
                    }
                    else
                    {
                        widget('login');
                    }
                    ?>
                    </div>
                </td>

            </tr>

            <!--check for multi language option-->
            <?php if ($ci->config->config['multilang_option'] == 1) { ?>
                <tr>
                    <td height="5"><?php widget('language', array('section_name' => $ci->theme->get('section_name'))); ?></td>
                </tr>
            <?php } else {
                ?>
                <tr><td height="5">&nbsp;&nbsp;</td></tr>
            <?php } ?>
            <!--check for multi language option-->
            
            <tr>
                <td>
                    <div id="menu" class="navigation">
                        <?php
                        widget('front_menu', array('menu_name' => 'front_menu', 'section_name' => $ci->theme->get('section_name')));
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td height="5">
                    <?php echo $this->message(); ?>
                </td>
            </tr>
            <tr class="content">
                <td>
