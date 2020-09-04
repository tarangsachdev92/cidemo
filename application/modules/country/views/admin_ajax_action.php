<?php
$ckeditor = array(
    //ID of the textarea that will be replaced
    'id' => 'description',
    'path' => 'assets/ckeditor',
    //Optionnal values
    'config' => array(
        'toolbar' => "Full", //Using the Full toolbar
        'width' => "550px", //Setting a custom width
        'height' => '100px', //Setting a custom height
    ),
);
$attributes = array('class' => '', 'id' => 'countryadd', 'name' => 'countryadd');
echo form_open($this->controller->section_name . '/country/action/' . $action . "/" . $language_code . "/" . $id, $attributes);
?>
<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('add_form_fields'); ?> - <?php echo $language_name; ?></th>
            </tr>
            <tr>
                <td class="add-user-form-box">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <tr>
                                        <td width="300" align="right"><span class="star">*&nbsp;</span><?php echo lang('country_name'); ?>:</td>
                                        <td>
                                            <?php
                                            $country_name = array(
                                                'name' => 'country_name',
                                                'id' => 'country_name',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'class' => 'validate[required]',
                                                'value' => set_value('country_name', ((isset($country['country_name'])) ? $country['country_name'] : ''))
                                            );
                                            echo form_input($country_name);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('country_name'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo lang('country_iso'); ?>:</td>
                                        <td>
                                            <?php
                                            $country_iso = array(
                                                'name' => 'country_iso',
                                                'id' => 'country_iso',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '50',
                                                'class' => 'validate[required]',
                                                'value' => set_value('country_iso', ((isset($country['country_iso'])) ? $country['country_iso'] : ''))
                                            );
                                            echo form_input($country_iso);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('country_iso'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo lang('status'); ?>:</td>
                                        <td>
                                            <?php
                                            $options = array(
                                                '1' => lang('active'),
                                                '0' => lang('inactive')
                                            );
                                            echo form_dropdown('status', $options, (isset($country['status'])) ? $country['status'] : '');

                                            $lang_code = array(
                                                'name' => 'lang_code',
                                                'id' => 'lang_code',
                                                'value' => set_value('lang_code', ((isset($language_code)) ? $language_code : ''))
                                            );
                                            echo form_hidden($lang_code);
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
            'name' => 'countrysubmit',
            'id' => 'countrysubmit',
            'value' => lang('save'),
            'title' => lang('save'),
            'class' => 'inputbutton',
        );
        echo form_submit($submit_button);
        $cancel_button = array(
            'content' => lang('cancel'),
            'title' => lang('cancel'),
            'class' => 'inputbutton',
            'onclick' => "location.href='" . site_url(get_current_section($this) . '/country/index/' . $language_code) . "'",
        );
        echo "&nbsp;";
        echo form_button($cancel_button);
        ?>
    </div>
</div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        jQuery("#countryadd").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );
    });
</script>