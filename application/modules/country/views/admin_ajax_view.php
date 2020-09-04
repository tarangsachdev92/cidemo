<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('view-country'); ?> - <?php echo $language_name; ?></th>
            </tr>
            <tr>
                <td class="add-user-form-box">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <?php
                                if(count($country) > 0)
                                {
                                ?>
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <tr>
                                        <td width="300" align="right"><?php echo lang('country_name'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($country['country_name']))
                                                echo $country['country_name'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo lang('country_iso'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($country['country_iso']))
                                                echo $country['country_iso'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo lang('status'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($country['status']) && $country['status'] == '1')
                                                echo lang('active');
                                            if(isset($country['status']) && $country['status'] == '0')
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
                                        <td align="right"><?php echo lang('no-country-translation');?></td>
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
            'onclick' =>  "location.href='" . site_url(get_current_section($this).'/country/index/'.$language_code) . "'",
       );
        echo "&nbsp;";
        echo form_reset($cancel_button);
        ?>
</div>