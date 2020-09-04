<link href="css/modules/banner/banner.css" rel="stylesheet" type="text/css">
<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">            
            <table width="1000">
                <tr>
                    <td></td>
                    <td colspan="3" align="center" width="1000"><div class="ad_top"> <?php
                            $array = array('language_id' => $language_id,
                                'page_id' => $page_id,
                                'position' => TOP);
                            widget('advertisement', $array);
                            ?></div>
                    </td>
                    <td></td>                   
                </tr>
                <tr>
                    <td>
                        <div class="ad_left"> <?php
                            $array = array('language_id' => $language_id,
                                'page_id' => $page_id,
                                'position' => LEFT);
                            widget('advertisement', $array);
                            ?></div>            
                    </td>
                    <td></td>
                    <td>
                        <div class="ad_right">
                            <?php
                            $array = array('language_id' => $language_id,
                                'page_id' => $page_id,
                                'position' => RIGHT);
                            widget('advertisement', $array);
                            ?></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" align="center" width="1000"> <div class="ad_bottom">
                            <?php
                            $array = array('language_id' => $language_id,
                                'page_id' => $page_id,
                                'position' => BOTTOM);
                            widget('advertisement', $array);
                            ?></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
