<?php
echo add_css('validationEngine.jquery');
echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine'));
echo add_css(array('modules/shoppingcart/shoppingcart'));
?>
<tr class="content">
    <td>
        <span>
            <h3><?php
                echo lang('edit') . '&nbsp;';
                if ($address_type == 'billaddress')
                {
                    echo lang('billing_address');
                }
                else
                {
                    echo lang('shipping_address');
                }
                ?>
            </h3>     
        </span>    
        <div  style="box-shadow:2px 0px 4px 1px #CCCCCC;">
            <?php echo form_open('shoppingcart/address/' . $address_type . '/' . $address_data['id'], array('id' => 'shipbill_address_form', 'name' => 'shipbill_address_form')); ?>
            <table cellspacing="1" cellpadding="4" border="0" width="100%">
                <tr>
                    <td><?php echo lang('first_name'); ?><span class="star">*&nbsp;</span></td>
                    <td><?php
                        $fname_billdata = array(
                            'name' => 'fname',
                            'id' => 'fname',
                            'value' => $address_data['fname'],
                            'size' => '50',
                            'maxlength' => '100',
                            'class' => 'validate[required]'
                        );
                        echo form_input($fname_billdata);
                        ?>
                        <br/><span class="warning-msg"><?php echo form_error('fname'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('last_name'); ?><span class="star">*&nbsp;</span></td>
                    <td><?php
                        $lname_billdata = array(
                            'name' => 'lname',
                            'id' => 'lname',
                            'value' => $address_data['lname'],
                            'size' => '50',
                            'maxlength' => '100',
                            'class' => 'validate[required]'
                        );
                        echo form_input($lname_billdata);
                        ?>
                        <br/><span class="warning-msg"><?php echo form_error('lname'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('address'); ?></td>
                    <td><?php
                        $address_billdata = array(
                            'name' => 'address',
                            'id' => 'address',
                            'value' => $address_data['address'],
                            'cols' => '37',
                            'rows' => '3'
                        );
                        echo form_textarea($address_billdata);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('street'); ?><span class="star">*&nbsp;</span></td>
                    <td><?php
                        $street_billdata = array(
                            'name' => 'street',
                            'id' => 'street',
                            'value' => $address_data['street'],
                            'size' => '50',
                            'maxlength' => '100',
                            'class' => 'validate[required]'
                        );
                        echo form_input($street_billdata);
                        ?>
                        <br/><span class="warning-msg"><?php echo form_error('street'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('country'); ?><span class="star">*&nbsp;</span></td>
                    <td><?php
                        $country_billdata = array(
                            'name' => 'country',
                            'id' => 'country',
                            'value' => $address_data['country'],
                            'size' => '50',
                            'maxlength' => '100',
                            'class' => 'validate[required]'
                        );
                        echo form_input($country_billdata);
                        ?>
                        <br/><span class="warning-msg"><?php echo form_error('country'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('state'); ?><span class="star">*&nbsp;</span></td>
                    <td><?php
                        $state_billdata = array(
                            'name' => 'state',
                            'id' => 'state',
                            'value' => $address_data['state'],
                            'size' => '50',
                            'maxlength' => '100',
                            'class' => 'validate[required]'
                        );
                        echo form_input($state_billdata);
                        ?>
                        <br/><span class="warning-msg"><?php echo form_error('state'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('city'); ?><span class="star">*&nbsp;</span></td>
                    <td><?php
                        $city_billdata = array(
                            'name' => 'city',
                            'id' => 'city',
                            'value' => $address_data['city'],
                            'size' => '50',
                            'maxlength' => '100',
                            'class' => 'validate[required]'
                        );
                        echo form_input($city_billdata);
                        ?>
                        <br/><span class="warning-msg"><?php echo form_error('city'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('postcode'); ?><span class="star">*&nbsp;</span></td>
                    <td><?php
                        $postcode_billdata = array(
                            'name' => 'postcode',
                            'id' => 'postcode',
                            'value' => $address_data['postcode'],
                            'size' => '50',
                            'maxlength' => '6',
                            'class' => 'validate[required,custom[integer]]'
                        );
                        echo form_input($postcode_billdata);
                        ?>
                        <br/><span class="warning-msg"><?php echo form_error('postcode'); ?></span>
                    </td>
                </tr>

                <tr><td colspan="2" >
                        <?php
                        $checkout_submit = array(
                            'name' => 'address_submit',
                            'id' => 'address_submit',
                            'value' => lang('btn_save'),
                            'title' => lang('btn_save'),
                            'class' => 'inputbutton cart-btn'
                        );
                        echo form_submit($checkout_submit);

                        $back_button = array(
                            'content' => lang('btn_cancel'),
                            'title' => lang('btn_cancel'),
                            'class' => 'inputbutton cart-btn',
                            'onclick' => "location.href='" . site_url().'shoppingcart/checkoutaddress' . "'"
                        );
                        echo '&nbsp;&nbsp;&nbsp;' . form_button($back_button);
                        ?>
                    </td>
                </tr>

            </table>
            <?php
            echo form_hidden('address_type', $address_type, 'address_type');
            echo form_hidden('user_id', $address_data['user_id'], 'user_id');
            echo form_hidden('id', $address_data['id'], 'id');
            ?>
            <?php echo form_close(); ?>
        </div>    
    </td>
</tr>

<script type="text/javascript">
$(document).ready( function()
{
    jQuery("#shipbill_address_form").validationEngine(
        {promptPosition : '<?php echo VALIDATION_ERROR_POSITION; ?>',validationEventTrigger: "submit"}
    );
});
</script>