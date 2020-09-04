<?php 
###################################################################
##
##	Banner Config Variable File
##
##	Last Edit:
##	14/10/2013
##
##	Description:
##	Banner config class for load config variable
##
##	Author:
##	By KS
##
##################################################################

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//array of banner type
$config['banner']['sections'] = array(
    '1' => 'Home Banner',
    '2' => 'Ad Banner',
);

//array of pages
$config['banner']['pages'] = array('1' => 'About us','2' => 'Contact us');

//array of position
$config['banner']['positions'] = array(
    '1' => 'Top',
    '2' => 'Bottom',
    '3' => 'Left',
    '4' => 'Right'
);

//array of banner type
$config['banner']['types'] = array(
    '1' => 'Image',
    '2' => 'Embedded code',

);

