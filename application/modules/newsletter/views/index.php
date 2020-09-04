<tr>
    <td> 
        <h1>Subscribe, Now</h1>
    </td>
</tr>
<tr>
    <td id="error_msg"></td><br/>
</tr>
<tr class="content">
    <td>
        <?php
        $attributes = array ("name" => "newsletterForm", "id" => "newsletterForm");
        echo form_open ('newsletter', $attributes);
        ?>
        <table cellspacing="0" cellpadding="0">
            <tr>
                <th>
                    <?php echo lang('first-name'); ?>
                </th>
                <td>&nbsp; : &nbsp;</td>
                <td>
                    <?php
                    $inputData = array (
                        'name' => 'firstname',
                        'id' => 'firstname',
                        'value' => set_value ('firstname', $firstname),
                        'maxlength' => '100',
                        'style' => 'width:198px',
                        'class' => "validate[required]"
                    );
                    echo form_input ($inputData);
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <th>
                    <?php echo lang('last-name'); ?>
                </th>
                <td>&nbsp; : &nbsp;</td>
                <td>
                    <?php
                    $inputData = array (
                        'name' => 'lastname',
                        'id' => 'lastname',
                        'value' => set_value ('lastname', $firstname),
                        'maxlength' => '100',
                        'style' => 'width:198px',
                        'class' => "validate[required]"
                    );
                    echo form_input ($inputData);
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <th>
                    <?php echo lang('email'); ?>
                </th>
                <td>&nbsp; : &nbsp;</td>
                <td>
                    <?php
                    $inputData = array (
                        'name' => 'email',
                        'id' => 'email',
                        'value' => set_value ('email', $email),
                        'maxlength' => '100',
                        'style' => 'width:198px',
                        'class' => "validate[required,custom[email]]"
                    );
                    echo form_input ($inputData);
                    ?>
                    <br/><span class="warning-msg"><?php echo form_error ('email'); ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo form_submit ('newsletterSubmit', 'Subscribe'); ?></td>
            </tr>
        </table>
    </td>
</tr>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#newsletterForm").validationEngine();
    });
    $('#newsletterForm').submit(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url (); ?>/newsletter/ajax_check_unique_email',
            data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', email: $('#email').val()},
            success: function(data) {
                //set responce message 
                if (data != "")
                {
                    $("#error_msg").show();
                    $("#error_msg").html(data);
                    return false;
                }
                else
                {
                    return true;
                }
            }
        });
    });
</script>