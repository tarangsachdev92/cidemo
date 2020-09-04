<?php echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine'));
echo add_css(array('modules/shoppingcart/shoppingcart'));?>
<tr class="content">
    <td>
        <div style="box-shadow:2px 0px 4px 1px #CCCCCC;">
            <?php echo form_open('shoppingcart/userlogin', array('id' => 'shopping_login_form', 'name' => 'shopping_login_form')); ?>
            <h3><?php echo lang('login_page_msg');?></h3>
            <table cellspacing="1" cellpadding="4" border="0" >
                <tr>
                    <td valign="top" class="content">
                        <label for="Email">Email :</label>
                    </td>
                    <td>
                        <input type="text" class="validate[required,custom[email]]" id="email_w" value="" name="email_w">
                        <br><span class="warning-msg"><?php echo form_error('email'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="Password">Password:</label></td>
                    <td>
                        <input type="password" class="validate[required]" id="password_w" value="" name="password_w">
                        <br><span class="warning-msg"><?php echo form_error('password'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Login" name="Login" class="cart-btn"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <a title="Create new account?" href="<?php echo site_url(); ?>users/registration"<?php echo lang('create_new_account');?></a>  &nbsp; &nbsp; &nbsp;
                        <a title="Forgot Password" href="<?php echo site_url(); ?>users/forgot_password"><?php echo lang('ci_forgot_password');?></a>
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
    </td>
</tr>
<script type="text/javascript">
$(document).ready(function()
{
    jQuery("#shopping_login_form").validationEngine(
    {
        promptPosition : '<?php echo VALIDATION_ERROR_POSITION; ?>',validationEventTrigger: "submit"
    }
    );
});
</script>