<?php

function GetCurrentDate() {
    return date("Y-m-d");
}

function GetCurrentDateTime() {
    return date("Y-m-d H:i:s");
}

function encriptsha1($string = "") {
    $CI = & get_instance();
    return $CI->encrypt->sha1($string);
}

if (!function_exists('buildMenu')) {

    function buildMenu($parentId, $menuData) {


        $ci = &get_instance();
        $html = '';

        $chieldicon = '';
        $parent_icon = '<i class="fa fa-folder"></i>';

        if (isset($menuData['parents'][$parentId])) {
            if ($parentId == 0)
                $html = '<h5 class="sidebartitle">Custom - Navigation</h5><ul class="menu clearfix nav nav-pills nav-stacked nav-">';
            elseif ($menuData['items'][$parentId]['m']['parent_id'] == 0) {
                $html = '<ul class="children">';
                $chieldicon = '<i class="fa fa-caret-right"></i>';
                $parent_icon = '';
            } else
                $html = '<ul>';


            foreach ($menuData['parents'][$parentId] as $itemId) {

                // For Front Menu
                if ($menuData['items'][$itemId]['m']['menu_name'] == 'front_menu') {

                    $seluri = $ci->uri->segment(1);
                    $link = implode('/', array_slice(explode('/', $menuData['items'][$itemId]['m']['link']), 0, 1));

                    global $CFG;
                    if ($CFG->item('multilang_option') == 1) {
                        $seluri_temp = $ci->uri->segment(2);

                        // GET MULTI LANGUAGE .....
                        $ci->db->select('GROUP_CONCAT(cms.slug_url) AS slug');
                        $ci->db->from('cms');
                        $ci->db->where('status', '1');

                        $result_multilang = $ci->db->get();
                        $row_multilang = $result_multilang->result();
                        // GET MULTI LANGUAGE .....


                        if (strpos($row_multilang[0]->slug, $seluri_temp) !== FALSE) {
                            $seluri = $ci->uri->segment(2);
                            $link = implode('/', array_slice(explode('/', $menuData['items'][$itemId]['m']['link']), 1, 2));
                        }
                    }
                }
                // For Admin Menu
                else if ($menuData['items'][$itemId]['m']['menu_name'] == 'admin_menu') {

                    $seluri = $ci->uri->segment(2);
                    $link = implode('/', array_slice(explode('/', $menuData['items'][$itemId]['m']['link']), 1, 1));

                    if (isset($menuData['parents'][$itemId]) && ($seluri === $link)) {

                        $seluri_temp = $ci->uri->segment(3);
                        $link_temp = implode('/', array_slice(explode('/', $menuData['items'][$itemId]['m']['link']), 2, 1));

                        if ($seluri_temp == $link_temp) {

                            $seluri = $ci->uri->segment(3);
                            $link = implode('/', array_slice(explode('/', $menuData['items'][$itemId]['m']['link']), 2, 1));
                        }
                    }
                }

                if (isset($menuData['parents'][$itemId])) {

                    $selected = ($seluri == $link || ($seluri == "" && $menuData['items'][$itemId]['m']['id'] == 17)) ? 'active' : '';

                    $menulink = ($menuData['items'][$itemId]['m']['link'] == '/') ? '' : $menuData['items'][$itemId]['m']['link'];

                    $html .= '<li class="nav-parent ' . $selected . '" id="menu' . $menuData['items'][$itemId]['m']['id'] . '"><a href="javascript:;"><i class="fa fa-folder"></i><span>' . $menuData['items'][$itemId]['m']['title'] . "</span></a>";
                } else {
                    $selected = ($seluri == $link || ($seluri == "" && $menuData['items'][$itemId]['m']['id'] == 17)) ? 'active' : '';

                    if (!empty($parent_icon)) {
                        if ($selected == 'active') {
                            $parent_icon = '<i class="fa fa-folder-open"></i>';
                        } else {
                            $parent_icon = '<i class="fa fa-folder"></i>';
                        }
                    }

                    $menulink = ($menuData['items'][$itemId]['m']['link'] == '/') ? '' : $menuData['items'][$itemId]['m']['link'];

                    if ($menuData['items'][$itemId]['m']['id'] != 271) {
                        $html .= '<li class="' . $selected . '" id="menu' . $menuData['items'][$itemId]['m']['id'] . '"><a href="' . site_base_url() . $menulink . '">' . $parent_icon . '<span>' . $chieldicon . $menuData['items'][$itemId]['m']['title'] . "</span></a>";
                    } else if (!empty($ci->session->userdata['front']['user_id']) && ($menuData['items'][$itemId]['m']['id'] == 271)) {

                        $html .= '<li class="' . $selected . '" id="menu' . $menuData['items'][$itemId]['m']['id'] . '"><a href="' . site_base_url() . $menulink . '">' . $parent_icon . '<span>' . $menuData['items'][$itemId]['m']['title'] . "</span></a>";
                    }
                }

                $html .= buildMenu($itemId, $menuData);
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

}

/**
 * $name should be widgetname,modulename or theme name
 * $type should be modules,themes,widgets
 * all js located in assets folder
 * @param type $filename
 * @param type $name
 * @param type $type
 */
if (!function_exists('add_js')) {

    function add_js($filename, $name = "", $type = "") {
        global $CFG;
        $cfgArr = $CFG->config;
        $theme = $cfgArr['theme']['theme'];

        $script = "";
        switch (strtolower($type)) {
            case 'modules':
            case 'widgets':
                $basepath = site_base_url() . 'themes/' . $theme . '/js/' . $type . '/' . $name . '/';
                break;
            default:
                $basepath = site_base_url() . 'themes/' . $theme . '/js/';
                break;
        }

        if (is_array($filename)) {
            foreach ($filename as $sname) {
                $filepath = $basepath . $sname . '.js';
                $script .= '<script type="text/javascript" src="' . $filepath . '" charset="' . $cfgArr['charset'] . '"></script>' . "\r\n";
            }
        } else {
            $basepath = $basepath . $filename . '.js';
            $script .= '<script type="text/javascript" src="' . $basepath . '" charset="' . $cfgArr['charset'] . '"></script>' . "\r\n";
        }
        return $script;
    }

}
/**
 * $name should be widgetname,modulename or theme name
 * $type should be modules,themes,widgets
 * all css located in assets folder
 * @param type $filename
 * @param type $name
 * @param type $type
 */
if (!function_exists('add_css')) {

    function add_css($filename, $name = "", $type = "", $media = 'screen') {
        global $CFG;
        $cfgArr = $CFG->config;
        $theme = $cfgArr['theme']['theme'];

        $style = "";
        switch (strtolower($type)) {
            case 'modules':
            case 'widgets':
                $basepath = site_base_url() . 'themes/' . $theme . '/css/' . $type . '/' . $name . '/';
                break;
            default:
                $basepath = site_base_url() . 'themes/' . $theme . '/css/';
                break;
        }
        if (is_array($filename)) {
            foreach ($filename as $sname) {
                $filepath = $basepath . $sname . '.css';
                $style .= '<link type="text/css" rel="stylesheet" href="' . $filepath . '" media="' . $media . '" />' . "\r\n";
            }
        } else {
            $basepath = $basepath . $filename . '.css';
            $style .= '<link type="text/css" rel="stylesheet" href="' . $basepath . '" media="' . $media . '" />' . "\r\n";
        }

        return $style;
    }

}
/**
 * $name should be widgetname,modulename or theme name
 * $type should be modules,themes,widgets
 * all images located in assets folder
 * @param type $filename
 * @param type $name
 * @param type $type
 */
if (!function_exists('add_image')) {

    function add_image($filename, $name = "", $type = "", $options = array()) {

        global $CFG;
        $cfgArr = $CFG->config;
        $theme = $cfgArr['theme']['theme'];
        $attributes = "";

        //var_dump($options); exit;
        if (isset($options) && !empty($options)) {
            foreach ($options as $key => $value) {
                $attributes.= $key . '="' . $value . '"';
                $attributes.= " ";
            }
        }


        $image = "";
        $basepath = "";

        switch (strtolower($type)) {
            case 'modules':
            case 'widgets':
                $basepath = site_base_url() . 'themes/' . $theme . '/images/' . $type . '/' . $name . '/';
                break;
            default:
                $basepath = site_base_url() . 'themes/' . $theme . '/images/';
                break;
        }

        if (is_array($filename)) {
            foreach ($filename as $sname) {

                $filepath = $basepath . $sname;

                //$title = (isset($options['title']))? $options['title']:'';
                //echo $attributes; exit;
                $image .= '<img src="' . $filepath . '" ' . $attributes . ' />';
                //$image .= '<img src="' . $filepath . '" title="'.$title.'" />';
//                $image .= '<img src="' . $filepath . '"' ;
//                foreach($options as $attKey => $attVal)
//                {
//                    $image .= $attKey." = ".$attVal." ";
//                }
//                $image .= ' />';
            }
        } else {
            $basepath = $basepath . $filename;
            $image .= '<img src="' . $basepath . '" ' . $attributes . '  />';
        }
        return $image;
    }

}
/**
 * Lang
 *
 * Fetches a language variable and optionally outputs a form label
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */
if (!function_exists('lang')) {

    function lang($line, $id = '') {
        $CI = & get_instance();
        $line = $CI->lang->line($line);

        if ($id != '') {
            $line = '<label for="' . $id . '">' . $line . "</label>";
        }

        return $line;
    }

}

if (!function_exists('custom_filter_input')) {

    function custom_filter_input($type, $string, $message = "Invalid input") {
        $flag = 0;
        switch ($type) {
            case 'integer' : {
                    if (filter_var($string, FILTER_VALIDATE_INT) !== false) {
                        $flag = 1;
                    }
                }
                break;
            case 'float' : {
                    if (filter_var($string, FILTER_VALIDATE_FLOAT) !== false) {
                        $flag = 1;
                    }
                }
                break;
            case 'ip' : {
                    if (filter_var($string, FILTER_VALIDATE_IP) !== false) {
                        $flag = 1;
                    }
                }
                break;
            case 'url' : {
                    if (filter_var($string, FILTER_VALIDATE_URL) !== false) {
                        $flag = 1;
                    }
                }
                break;
            case 'email' : {
                    if (filter_var($string, FILTER_VALIDATE_EMAIL) !== false) {
                        $flag = 1;
                    }
                }
                break;
            case 'default': {
                    $flag = 0;
                }
                break;
        }

        if ($flag == 1) {
            return true;
        } else if ($flag == 0) {
            show_error($message);
            exit;
        }
    }

}


if (!function_exists('getmodulelist')) {

    function getmodulelist() {
        $ci = &get_instance();
        $dir = APPPATH . '/modules';
        $dirlist = opendir($dir);
        while ($file = readdir($dirlist)) {
            if ($file != '.' && $file != '..' && $file != '.DS_Store') {
                $modules[$file] = $file;
            }
        }
        return array_diff($modules, $ci->config->item('admin.modules'));
    }

}

/**
 * Lang
 *
 * Fetches a language variable and optionally outputs a form label
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */
if (!function_exists('display_meta')) {

    function display_meta() {
        $ci = &get_instance();
        $meta_array = $ci->theme->get_meta();
        $meta = '';
        foreach ($meta_array as $key => $val) {
            if (is_array($val)) {
                $meta .= '<meta ';
                foreach ($val as $attribute_name => $value) {
                    $meta .= $attribute_name . '="' . $value . '" ';
                }
                $meta .='>';
            }
        }
        return $meta;
    }

}

/**
 * Error Handler
 *
 * This function lets us invoke the exception class and
 * display errors using the standard error template located
 * in application/errors/errors.php
 * This function will send the error page directly to the
 * browser and exit.
 *
 * @access	public
 * @return	void
 */
if (!function_exists('show_permission_error')) {

    function show_permission_error($message, $status_code = 500, $heading = 'An Error Was Encountered') {
        $_error = & load_class('Exceptions', 'core');
        echo $_error->show_error($heading, $message, 'error_permission', $status_code);
        exit;
    }

}
?>