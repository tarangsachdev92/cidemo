<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Banner of image type */
 define('AD_IMAGE', '1');
/* For Banner :: Embedded code */
define('AD_EMBEDDED', '2');
/* For Banner :: Contact Us Page */
define('CONTACT_US', '2');
/* For Banner :: About Us Page */
define('ABOUT_US', '1');
/* For Banner :: Top section */
define('TOP', '1');
/* For Banner :: bottom section */
define('BOTTOM', '2');
/* For Banner :: left section */
define('LEFT', '3');
/* For Banner :: right section */
define('RIGHT', '4');


//home banner id
define('HOME_BANNER',1);

define('AD_BANNER',2);

//width for home banner
define('HOME_BANNER_WIDTH',1000);
//height
define('HOME_BANNER_HEIGHT',300);

//* width for thumb
define('THUMB_WIDTH',75);
// height for thumb
define('THUMB_HEIGHT',50);

//front section: home banner slideshow timeout in seconds
define('TIMEOUT', 3);


//array of pages

$config['pages'] = array('About us','Contact us');

//array of position

$config['positions'] = array(
    '1' => 'Top',
    '2' => 'Bottom',
    '3' => 'Left',
    '4' => 'Right'
);

$config['ad_page']= array('banner'=>array('index'=>'1'),
                          'contact_us'=>array('index'=>'2'));
