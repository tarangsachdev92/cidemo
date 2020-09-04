<?php
$attributes = array('class' => '', 'id' => 'paymentadd', 'name' => 'paymentadd');
echo form_open_multipart('' . $this->section_name . '/shoppingcart/action_payments/' . $action . "/" . $id, $attributes);
?>
<div class="grid-data">
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
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('title'), 'title'); ?>:</td>
                                        <td>
                                            <?php
                                            $title_data = array(
                                                'name' => 'payment_title',
                                                'id' => 'payment_title',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '50',
                                                'class' => 'validate[required]',
                                                'value' => set_value('payment_title', ((isset($result[0]['scpm']['title'])) ? $result[0]['scpm']['title'] : ''))
                                            );
                                            echo form_input($title_data);
                                            ?>
                                            <br/>
                                            <span class="warning-msg"><?php echo form_error('payment_title'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('payment_username'), 'payment_username'); ?>:</td>
                                        <td>
                                            <?php
                                            $meta_keywords_data = array(
                                                'name' => 'payment_username',
                                                'id' => 'payment_username',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'class' => 'validate[required]',
                                                'value' => set_value('payment_username', ((isset($result[0]['scpm']['username'])) ? $result[0]['scpm']['username'] : ''))
                                            );
                                            echo form_input($meta_keywords_data);
                                            ?>
                                            <br/>
                                            <span class="warning-msg"><?php echo form_error('payment_username'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"></span><?php echo form_label(lang('payment_password'), 'payment_password'); ?>:</td>
                                        <td>
                                            <?php
                                            $meta_keywords_data = array(
                                                'name' => 'payment_password',
                                                'id' => 'payment_password',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'value' => set_value('payment_password', ((isset($result[0]['scpm']['password'])) ? $result[0]['scpm']['password'] : ''))
                                            );
                                            echo form_input($meta_keywords_data);
                                            ?>
                                            <br/>
                                            <span class="warning-msg"><?php echo form_error('payment_password'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"></span><?php echo form_label(lang('payment_key'), 'payment_key'); ?>:</td>
                                        <td>
                                            <?php
                                            $meta_keywords_data = array(
                                                'name' => 'payment_key',
                                                'id' => 'payment_key',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'value' => set_value('payment_key', ((isset($result[0]['scpm']['key'])) ? $result[0]['scpm']['key'] : ''))
                                            );
                                            echo form_input($meta_keywords_data);
                                            ?>
                                            <br/>
                                            <span class="warning-msg"><?php echo form_error('payment_key'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('payment_mode'), 'payment_mode'); ?>:</td>
                                        <td>
                                            <?php
                                            $options = array(
                                                '0' => lang('test_mode'),
                                                '1' => lang('live_mode')
                                            );
                                            echo form_dropdown('payment_mode', $options, (isset($result[0]['scpm']['mode'])) ? $result[0]['scpm']['mode'] : '');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('status'), 'status'); ?>:</td>
                                        <td>
                                            <?php
                                            $options = array(
                                                '1' => lang('active'),
                                                '0' => lang('inactive')
                                            );
                                            echo form_dropdown('payment_status', $options, (isset($result[0]['scpm']['status'])) ? $result[0]['scpm']['status'] : '');
                                            ?>
                                        </td>
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
            'name' => 'paymentsubmit',
            'id' => 'paymentsubmit',
            'value' => lang('ci_action_save'),
            'title' => lang('ci_action_save'),
            'class' => 'inputbutton',
        );
        echo form_submit($submit_button);

        $cancel_button = array(
            'content' => lang('ci_action_cancel'),
            'title' => lang('ci_action_cancel'),
            'class' => 'inputbutton',
            'onclick' => 'history.go(-1)',
        );
        echo "&nbsp;";
        echo form_button($cancel_button);
        ?>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#paymentadd").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );
    });
</script>