<?php echo add_css('jquery_ui/themes/base/jquery-ui'); ?>
<?php echo add_js('jquery-ui'); ?>
<?php
echo form_open_multipart(get_current_section($this) . '/shoppingcart/action_coupon/' . $action . "/" . $id, array('id' => 'savecouponform', 'name' => 'savecouponform'));
?>
<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('add_form_fields') ?></th>
            </tr>
            <tr>
                <td class="add-user-form-box">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <?php
                                    $role_data = array(
                                        'name' => 'coupon_name',
                                        'id' => 'coupon_name',
                                        'value' => set_value('coupon_name', ((isset($recorddata['coupon_name'])) ? $recorddata['coupon_name'] : '')),
                                        'style' => 'width:198px;',
                                        'class' => 'validate[required]'
                                    );
                                    ?>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('coupon_name'), 'coupon_name'); ?>:</td>
                                        <td><?php echo form_input($role_data); ?><br/><span class="warning-msg"><?php echo form_error('coupon_name'); ?></span></td>
                                    </tr>
                                    <?php
                                    $ccode_data = array(
                                        'name' => 'coupon_code',
                                        'id' => 'coupon_code',
                                        'value' => set_value('coupon_code', ((isset($recorddata['coupon_code'])) ? $recorddata['coupon_code'] : '')),
                                        'style' => 'width:198px;'
                                    );
                                    ?>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('coupon_code'), 'coupon_code'); ?>:</td>
                                        <td>
                                            <?php echo form_input($ccode_data); ?>
                                            <br><span class="warning-msg" ><?php echo lang('coupon_code_desc'); ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                    $cprice_data = array(
                                        'name' => 'coupon_price',
                                        'id' => 'coupon_price',
                                        'value' => set_value('coupon_price', ((isset($recorddata['coupon_price'])) ? $recorddata['coupon_price'] : '')),
                                        'style' => 'width:198px;',
                                        'class' => 'validate[required,custom[number]]'
                                    );
                                    ?>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('price'), 'coupon_price'); ?>:</td>
                                        <td><?php echo form_input($cprice_data); ?><br/><span class="warning-msg"><?php echo form_error('coupon_price'); ?></span></td>
                                    </tr>
                                    <?php $coupon_percentagelist = array('0' => lang('no'), '1' => lang('yes')); ?>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('is_price_in_percentage'), 'coupon_percentage'); ?>:</td>
                                        <td><?php echo form_dropdown('coupon_percentage', $coupon_percentagelist, ((isset($recorddata['coupon_percentage'])) ? $recorddata['coupon_percentage'] : '')); ?>
                                            <span class="warning-msg"><?php echo form_error('coupon_percentage'); ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                    $cmaxuse_data = array(
                                        'name' => 'coupon_maxuse',
                                        'id' => 'coupon_maxuse',
                                        'value' => set_value('coupon_maxuse', ((isset($recorddata['coupon_maxuse'])) ? $recorddata['coupon_maxuse'] : '')),
                                        'style' => 'width:198px;',
                                        'class' => 'validate[required,custom[integer]]'
                                    );
                                    ?>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('coupon_maxuse'), 'coupon_maxuse'); ?>:</td>
                                        <td>
                                            <?php echo form_input($cmaxuse_data); ?>
                                            <!-- <br><span class="warning-msg" ><?php echo lang('coupon_maxuse_desc'); ?></span> -->
                                        </td>
                                    </tr>
                                    <?php $statuslist = array('1' => lang('active'), '0' => lang('inactive')); ?>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('status'), 'status'); ?>:</td>
                                        <td><?php echo form_dropdown('status', $statuslist, ((isset($recorddata['status'])) ? $recorddata['status'] : '')); ?>
                                            <span class="warning-msg"><?php echo form_error('status'); ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($action == 'add')
                                    {
                                        $recorddata['coupon_sdate'] = date('Y-m-d');
                                    }
                                    $coupon_sdate_data = array(
                                        'name' => 'coupon_sdate',
                                        'id' => 'coupon_sdate',
                                        'value' => set_value('coupon_sdate', ((isset($recorddata['coupon_sdate'])) ? $recorddata['coupon_sdate'] : '')),
                                        'style' => 'width:198px;'
                                    );
                                    ?>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('start_date'), 'coupon_sdate'); ?>:</td>
                                        <td><?php echo form_input($coupon_sdate_data); ?></td>
                                    </tr>
                                    <?php
                                    if ($action == 'add')
                                    {
                                        $recorddata['coupon_edate'] = date('Y-m-d', strtotime(date('Y-m-d') . ' + 10 days'));
                                    }
                                    $coupon_edate_data = array(
                                        'name' => 'coupon_edate',
                                        'id' => 'coupon_edate',
                                        'value' => set_value('coupon_edate', ((isset($recorddata['coupon_edate'])) ? $recorddata['coupon_edate'] : '')),
                                        'style' => 'width:198px;'
                                    );
                                    ?>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('end_date'), 'coupon_edate'); ?>:</td>
                                        <td><?php echo form_input($coupon_edate_data); ?></td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="submit-btns clearfix">
        <?php
        $submit_button = array(
            'name' => 'mysubmit',
            'id' => 'mysubmit',
            'value' => lang('btn_save'),
            'title' => lang('btn_save'),
            'class' => 'inputbutton',
        );
        echo form_submit($submit_button);
        $cancel_button = array(
            'content' => lang('btn_cancel'),
            'title' => lang('btn_cancel'),
            'class' => 'inputbutton',
            'onclick' => 'history.go(-1)',
        );
        echo "&nbsp;";
        echo form_button($cancel_button);
        ?>
    </div>
</div>    
<?php
echo form_close();
?>

<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#savecouponform").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );
        $("#coupon_sdate").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>themes/default/images/calendar/calendar.gif",
            buttonImageOnly: true,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
        $("#coupon_edate").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>themes/default/images/calendar/calendar.gif",
            buttonImageOnly: true,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
    });
</script>