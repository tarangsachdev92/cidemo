<div class="main-container">
    <?php
    $attributes = array('class' => '', 'id' => 'stateadd', 'name' => 'stateadd');
    echo form_open($this->controller->section_name . '/states/action/' . $action . "/" . $language_code . "/" . $id, $attributes);
    ?>
    <div class="grid-data">
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
                <tr>
                    <th><?php echo lang('add_form_fields') ?>-<?php echo $language_name; ?></th>
                </tr>
                <tr>
                    <td class="add-user-form-box">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%" valign="top">
                                    <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                        <?php
                                        $state_name = array(
                                            'name' => 'state_name',
                                            'id' => 'state_name',
                                            'value' => set_value('state_name', ((isset($state[0]['s']['state_name'])) ? $state[0]['s']['state_name'] : '')),
                                            'style' => 'width:198px;',
                                            'class' => 'validate[required]'
                                        );
                                        ?>
                                        <tr>
                                            <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('state_name'), 'state_name'); ?>:</td>
                                            <td><?php echo form_input($state_name); ?><br/><span class="warning-msg"><?php echo form_error('state_name'); ?></span></td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><span class="star">*&nbsp;</span><?php echo lang('country_name'); ?>:</td>
                                            <td>
                                                <?php
                                                echo form_dropdown('country_id', $country_list, (isset($state[0]['c']['countryid'])) ? $state[0]['c']['countryid'] : 0, 'id=country_id class=validate[required]');                                                
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('country_id'); ?></span>
                                            </td>
                                        </tr>
                                        <?php $statuslist = array('1' => lang('active'), '0' => lang('inactive')); ?>
                                        <tr>
                                            <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('status'), 'status'); ?>:</td>
                                            <td>
                                                <?php
                                                echo form_dropdown('status', $statuslist, ((isset($status)) ? $status : ''));
                                                $lang_code = array(
                                                    'name' => 'lang_code',
                                                    'id' => 'lang_code',
                                                    'value' => set_value('lang_code', ((isset($language_code)) ? $language_code : '')),
                                                );
                                                echo form_hidden($lang_code);
                                                ?>
                                                <span class="warning-msg"><?php echo form_error('status'); ?></span>
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
    </div>
    <div class="submit-btns clearfix">
<?php
$submit_button = array(
    'name' => 'addstate',
    'id' => 'addstate',
    'value' => lang('btn-save'),
    'title' => lang('btn-save'),
    'class' => 'inputbutton',
);
echo form_submit($submit_button);
$cancel_button = array(
    'content' => lang('btn-cancel'),
    'title' => lang('btn-cancel'),
    'class' => 'inputbutton',
    'onclick' => "location.href='" . site_url(get_current_section($this) . '/states/index/' . $language_code) . "'",
);
echo "&nbsp;";
echo form_button($cancel_button);
?>
</div>
    <?php
    echo form_hidden('id', (isset($state[0]['s']['state_id'])) ? ($state[0]['s']['state_id']) : '0' );
    echo form_close();
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#stateadd").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );
    });
</script>


