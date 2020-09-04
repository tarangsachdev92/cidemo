<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('view-city'); ?> - <?php echo $language_name; ?></th>
            </tr>
            <tr>
                <td class="add-user-form-box">                    
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <?php
                                if(count($city) > 0)
                                {
                                ?>
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <tr>
                                        <td width="300" align="right"><?php echo lang('city_name'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($city['c']['city_name'])) 
                                                echo $city['c']['city_name'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo lang('state'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($city['s']['state_name'])) 
                                                echo $city['s']['state_name'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><?php echo lang('country'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($city['cnt']['country_name'])) 
                                                echo $city['cnt']['country_name'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo lang('status'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($city['c']['status']) && $city['c']['status'] == '1') 
                                                echo lang('active');
                                            if(isset($city['c']['status']) && $city['c']['status'] == '0') 
                                                echo lang('inactive');
                                            ?>
                                        </td>
                                    </tr>
                                </table> 
                                <?php
                                }
                                else
                                {
                                ?>
                                <table>
                                    <tr>
                                        <td align="right"><?php echo lang('no-city-translation');?></td>
                                    </tr>
                                </table>
                                <?
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>    
</div>
<div class="submit-btns clearfix">
        <?php       
        $cancel_button = array(
            'name' => 'cancel',
            'value' => lang('btn-cancel'),
            'title' => lang('btn-cancel'),
            'class' => 'inputbutton',
            'onclick' => "location.href='" . site_url(get_current_section($this).'/city/index/'.$language_code) . "'",
        );
        echo "&nbsp;";
        echo form_reset($cancel_button);
        ?>
</div>