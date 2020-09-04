<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*Recored per page for pagination */
 define('RECORD_PER_PAGE','5');
/*settings for captcha */
 define('CAPTCHA_SETTING','1');
/*contact us email id */
 define('CONTACT_US_EMAIL','test@compaydomain.com');
/*from email address */
 define('SITE_FROM_EMAIL','info@compaydomain.com');
/*smtp host setting */
 define('SMTP_HOST','192.168.10.2');
/*set smtp port */
 define('SMTP_PORT','25');
/*set smtp password */
 define('SMTP_PASSWORD','tatva123');
/*set smtp username */
 define('SMTP_USERNAME','vijay.vaishnav@sparsh.com');
/*Default CMS Page */
 define('DEFAULT_CMS_PAGE','cms3');
/*Exclude Keys in Data Variable assignment in Theme's View function to render as it is */
 define('EXCLUDE_KEYS_FILTEROUTPUT','captcha,content,description,search_term');
/*Enable activity log. 1 for enable and 0 for disable */
 define('ACTIVITY_LOG','1');
/*site name */
 define('SITE_NAME','Site Name');
/*Default currency code for all products */
 define('CURRENCY_CODE','USD');
/*Paypal mode if sandbox then it will go to testing site if you left blank then it will go to the live paypal site */
 define('PAYPAL_TEST_MODE','true');
/* */
 define('PAYPAL_API_USERNAME','PAYPAL_API_USERNAME');
/* */
 define('PAYPAL_API_PASSWORD','PAYPAL_API_PASSWORD');
?>