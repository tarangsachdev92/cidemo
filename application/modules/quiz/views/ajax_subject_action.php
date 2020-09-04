<?php
$attributes = array('class' => '', 'id' => 'form', 'name' => 'form');
echo form_open($this->_data['section_name'].'/quiz/subject_action/' . $action . "/" . $language_code . "/" . $id, $attributes);
?>
<table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
    <tbody bgcolor="#fff">
        <tr>
            <td class="add-user-form-box">
                <table cellspacing="1" cellpadding="5" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td align="right">
                                <span class="star">*&nbsp;</span>
                                <label for="subject_name"><?php echo lang('subject_name'); ?></label>:
                            </td>

                            <td>
                                <?php
                                $inputData = array(
                                    'name' => 'subject_name',
                                    'id' => 'subject_name',
                                    'value' => set_value('subject_name', $details['subject_name']),
                                    'maxlength' => '500',
                                    'style' => 'width:198px',
                                    'class' => "validate[required,maxSize[500]]"
                                );
                                echo form_input($inputData);
                                ?>
                                <br/><span class="warning-msg"><?php echo form_error('subject_name'); ?></span>
                            </td>
                        </tr>

                        <tr>
                            <td align="right">
                                <span class="star">*&nbsp;</span>
                                <label for="category_id"><?php echo lang('category_name'); ?></label>:
                            </td>

                            <td>
                                <?php
                                $options = array('' => 'Select');
                                foreach ($categories_list as $key => $val)
                                {
                                    $options[$val['c']['category_id']] = $val['c']['title'];
                                }

                                echo form_dropdown('category_id', $options, $details['category_id'], 'id="category_id" class="validate[required]"') . '&nbsp;&nbsp;';
                                ?>
                                <br><span class="warning-msg"><?php echo form_error('category_id'); ?></span>
                            </td>

                        </tr>

                        <tr>
                            <td align="right"><label for="status">Status</label>:</td>
                            <td>
                                <?php
                                $statuslist = array('1' => lang('active'), '0' => lang('inactive'));
                                echo form_dropdown('status', $statuslist, $details['status'], '');
                                ?>
                            </td>
                        </tr>
                </table>

            </td>
        </tr>
    </tbody>
</table>
<div class="submit-btns clearfix">
    <input type="hidden" id="lang_id" name="lang_id" value ="<?php echo (isset($lang_id)) ? $lang_id : '1'; ?>" />
    <input type="hidden" id="language_name" name="language_name" value ="<?php echo (isset($language_name)) ? strtolower($language_name) : 'en'; ?>" />
    <!--<input type="hidden" id="id" name="id" value ="<?php echo (isset($id)) ? $id : '0'; ?>" />-->
    <?php
    $submit_button = array(
        'name' => 'save',
        'id' => 'save',
        'value' => lang('btn_save_subject'),
        'title' => 'Save',
        'class' => 'inputbutton',
    );
    echo form_submit($submit_button);

    $siteurl = base_url($this->_data['section_name'].'/quiz/subjects') . '/' . $language_code;

    $cancel_button = array(
        'name' => 'button',
        'title' => lang('btn_cancel'),
        'class' => 'inputbutton',
        'onclick' => "location.href='" . $siteurl . "'"
    );
    echo "&nbsp;";
    echo form_button($cancel_button, lang('btn_cancel'));
    ?>
</div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function(){
        jQuery("#form").validationEngine();
    });
</script>