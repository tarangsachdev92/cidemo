<?php
$attributes = array('class' => '', 'id' => 'cityadd', 'name' => 'cityadd');
echo form_open($this->controller->section_name.'/city/action/' . $action . "/" . $language_code . "/" . $id, $attributes);
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
                                        <td width="300" align="right"><span class="star">*&nbsp;</span><?php echo lang('city_name'); ?>:</td>
                                        <td>
                                            <?php
                                            $city_name = array(
                                                'name' => 'city_name',
                                                'id' => 'city_name',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '50',
                                                'class' => 'validate[required]',
                                                'value' => set_value('city_name', ((isset($city['city_name'])) ? $city['city_name'] : '')),                                                
                                            );
                                            echo form_input($city_name);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('city_name'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo lang('country'); ?>:</td>
                                        <td>
                                            <?php
                                            echo form_dropdown('country_id', $country_list, (isset($country['country_id']))? $country['country_id']: 0, 'class=validate[required] onchange = load_state(this.value);');
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('country_id'); ?></span>
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo lang('state'); ?>:</td>
                                        <td id="related_field">
                                            <?php
                                            echo form_dropdown('state_id', $state_list, (isset($state['state_id']))? $state['state_id']: '','class=validate[required]');
                                            ?>
                                            <span class="warning-msg"><?php echo form_error('state_id'); ?></span>
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <td align="right"><span class="star">&nbsp;</span><?php echo lang('status'); ?>:</td>
                                        <td>
                                            <?php
                                            $options = array(
                                                '1' => lang('active'),
                                                '0' => lang('inactive')
                                            );
                                            echo form_dropdown('status', $options, (isset($city['status'])) ? $city['status'] : '');
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
            'name' => 'citysubmit',
            'id' => 'citysubmit',
            'value' => lang('save'),
            'title' => lang('save'),
            'class' => 'inputbutton',
        );
        echo form_submit($submit_button);
        $cancel_button = array(
            'content' => lang('cancel'),
            'title' => lang('cancel'),
            'class' => 'inputbutton',
            'onclick' =>  "location.href='" . site_url(get_current_section($this).'/city/index/'.$language_code) . "'",
        );
        echo "&nbsp;";
        echo form_button($cancel_button);
        ?>        
    </div>
</div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        jQuery("#cityadd").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );
        $("input:visible:first").focus();
    });
    
    function load_state(id)
    {
        lang_id = '<?php echo $language_id ?>';
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().get_current_section($this); ?>/city/get_related_state',
            data:{<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',country_id:id,lang_id:lang_id},
            success: function(data) {
                    $("#related_field").html(data); 
            }
        });
    }
</script>