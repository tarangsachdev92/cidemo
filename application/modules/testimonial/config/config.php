<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

define('TBL_TESTIMONIAL', 'testimonial');

/* Vedio Type - You tube*/
define('YOUTUBE', '2');
/* Vedio Type - You tube*/
define('SRC', '1');
/* Module id for  display category */
define("TESTIMONIAL_MODULE_NO", 9);
/* Publihsed Testimonial */
define("PUBLISH", 1);
/* Unpublihsed Testimonial */
define('UNPUBLISH', '0');
// define('SMTP_HOST_EVENT','smtp.gmail.com');
  define('SMTP_HOST_TEST','192.168.10.2');
/*set smtp port */
// define('SMTP_PORT_EVENT','465');
  define('SMTP_PORT_TEST','25');
/*set smtp password */
// define('SMTP_PASSWORD_EVENT','36Tatva_2010_#@$89');
  define('SMTP_PASSWORD_TEST','tatva123');
/*set smtp username */
// define('SMTP_USERNAME_EVENT','tatva36@gmail.com');
 define('SMTP_USERNAME_TEST','dipak.patel@sparsh.com');
 /*set ffmpeg path */
 define('FFMPEG_PATH',APPPATH.'modules/testimonial/ffmpeg/');
 /* video path */
 define('VIDEOPATH','assets/uploads/testimonial_video/');
 /* IMAGE PATH */
 define('VIDEOIMAGEPATH','assets/uploads/testimonial_logo/');
 
?>