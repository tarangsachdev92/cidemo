<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
//default controller to set
$route['default_controller'] = "cms/defaultpage";
$route['404_override'] = '';

//URL Management
include_once( APPPATH .'config/custom_routes'. EXT );

//mapping of manual urls for admin section from modules folder
$route['admin/(.+?)/((.+))'] = '$1/$1_admin/$2';
$route['admin/(:any)'] = '$1/$1_admin';
$route['admin'] = "users/users_admin/login";


//map all urls with core routing by their name which are not mapped above



//$route['^(en|es|ar)/(.+)$'] = "$2";
//$route['^(en|es|ar)$'] = $route['default_controller'];


global $CFG;
if ($CFG->item('multilang_option') == 1) {

    $languages_list = get_languages(); // Fn defines in functions.php in core folder

    $route['^(' . $languages_list . ')/(.+)$'] = "$2";
    $route['^(' . $languages_list . ')$'] = $route['default_controller'];
} else if ($CFG->item('multilang_option') == 0) {
    $route['/(:any)'] = "/$1";
}



//
//    // '/en', '/de', '/fr' and '/nl' URIs -> use default controller
//    $route['^(en|es|ar|nl)$'] = $route['default_controller'];
/* End of file routes.php */
/* Location: ./application/config/routes.php */