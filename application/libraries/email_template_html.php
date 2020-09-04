<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/** 
 * Widget 
 * Class is use for build widget. 
 *
 * @package CIDemoApplication
 * @subpackage widget
 * @copyright (c) 2013, TatvaSoft
 * @author Pankit Mehta <pankit.mehta@sparsh.com>
 * 
 */
class email_template_html
{

    var $htmltemplate = '';
    /* create an instance */
    function __construct()
    {
        $this->_ci = & get_instance();
            
    }

    public function build($data)
    {
        $htmltemplate ='
        <html>
            <head>
                <meta http-equiv="Content-type" content="text/html; charset=utf-8">
            </head>
            <body style="font-family: Arial, Helvetica, sans-serif;  color: #414141;  font-size: 15px;  line-height: 22px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"  style="font-family: Arial, Helvetica, sans-serif;  color: #414141;  font-size: 15px;  line-height: 22px;" >
                <tbody>
                    <tr>
                        <td class="border_cs" valign="top" style="border: 5px solid #000000;  padding: 20px 28px;  background-color: #FFF;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td><img alt="" src="'.site_base_url().'themes/default/images/logo.jpg"  /></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td><hr></td>
                                </tr>
                                <tr style="line-height: 25px;  font-size: 13px;">'.$data.'</tr>
                                <tr><td align="center" colspan="2" valign="center"><span style="font-size: 10pt;">&copy; Copyright '.date('Y').' '.SITE_NAME.' All rights reserved.</span></td>
</tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
            </body>
        </html>';

        return $htmltemplate;

    }

}
?>