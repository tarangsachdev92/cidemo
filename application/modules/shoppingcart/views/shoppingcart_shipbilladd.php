<?php
echo add_css('validationEngine.jquery');
echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine'));
echo add_css(array('modules/shoppingcart/shoppingcart'));
?>
<tr class="content">
    <td>
        <div  style="box-shadow:2px 0px 4px 1px #CCCCCC;">
        <?php echo form_open('shoppingcart/savecheckoutaddress', array('id' => 'checkout_address_form', 'name' => 'checkout_address_form')); ?>
            <table cellspacing="1" cellpadding="4" border="0" width="100%">
                <tr>
                    <td width="50%">
                        <span><b><?php echo lang('please_enter_your_bill_address'); ?></b></span>
                        <span><h3><?php echo lang('billing_address'); ?></h3></span>
                        <table id="billing_content" class="billing_content" style="box-shadow:2px 0px 4px 1px #CCCCCC;">
                            <tr>
                                <td>
                                    <?php echo lang('first_name'); ?><span class="star">*&nbsp;</span>
                                </td>
                                <td>
                                    <?php
                                    $fname_billdata = array(
                                        'name' => 'bill_fname',
                                        'id' => 'bill_fname',
                                        'value' => $user_logininfo['firstname'],
                                        'size' => '50',
                                        'maxlength' => '100',
                                        'class' => 'validate[required]'
                                    );
                                    echo form_input($fname_billdata);
                                    ?>
                                    <br/><span class="warning-msg"><?php echo form_error('bill_fname'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo lang('last_name'); ?><span class="star">*&nbsp;</span></td>
                                <td><?php
                                    $lname_billdata = array(
                                        'name' => 'bill_lname',
                                        'id' => 'bill_lname',
                                        'value' => $user_logininfo['lastname'],
                                        'size' => '50',
                                        'maxlength' => '100',
                                        'class' => 'validate[required]'
                                    );
                                    echo form_input($lname_billdata);
                                    ?>
                                    <br/><span class="warning-msg"><?php echo form_error('bill_lname'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo lang('address'); ?></td>
                                <td><?php
                                    $address_billdata = array(
                                        'name' => 'bill_address',
                                        'id' => 'bill_address',
                                        'value' => '',
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
                                        'name' => 'bill_street',
                                        'id' => 'bill_street',
                                        'value' => '',
                                        'size' => '50',
                                        'maxlength' => '100',
                                        'class' => 'validate[required]'
                                    );
                                    echo form_input($street_billdata);
                                    ?>
                                    <br/><span class="warning-msg"><?php echo form_error('bill_street'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo lang('country'); ?><span class="star">*&nbsp;</span></td>
                                <td><?php
                                    $country_billdata = array(
                                        'name' => 'bill_country',
                                        'id' => 'bill_country',
                                        'value' => '',
                                        'size' => '50',
                                        'maxlength' => '100',
                                        'class' => 'validate[required]'
                                    );
                                    echo form_input($country_billdata);
                                    ?>
                                    <br/><span class="warning-msg"><?php echo form_error('bill_country'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo lang('state'); ?><span class="star">*&nbsp;</span></td>
                                <td><?php
                                    $state_billdata = array(
                                        'name' => 'bill_state',
                                        'id' => 'bill_state',
                                        'value' => '',
                                        'size' => '50',
                                        'maxlength' => '100',
                                        'class' => 'validate[required]'
                                    );
                                    echo form_input($state_billdata);
                                    ?>
                                    <br/><span class="warning-msg"><?php echo form_error('bill_state'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo lang('city'); ?><span class="star">*&nbsp;</span></td>
                                <td><?php
                                    $city_billdata = array(
                                        'name' => 'bill_city',
                                        'id' => 'bill_city',
                                        'value' => '',
                                        'size' => '50',
                                        'maxlength' => '100',
                                        'class' => 'validate[required]'
                                    );
                                    echo form_input($city_billdata);
                                    ?>
                                    <br/><span class="warning-msg"><?php echo form_error('bill_city'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo lang('postcode'); ?><span class="star">*&nbsp;</span></td>
                                <td><?php
                                    $postcode_billdata = array(
                                        'name' => 'bill_postcode',
                                        'id' => 'bill_postcode',
                                        'value' => '',
                                        'size' => '50',
                                        'maxlength' => '6',
                                        'class' => 'validate[required,custom[integer]]'
                                    );
                                    echo form_input($postcode_billdata);
                                    ?>
                                    <br/><span class="warning-msg"><?php echo form_error('bill_postcode'); ?></span>
                                </td>
                            </tr>
                        <!-- <tr>
                            <td><?php echo lang('default'); ?></td>
                            <td><?php
                                $default_billdata = array(
                                    'name' => 'bill_default',
                                    'id' => 'bill_default',
                                    'value' => '',
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($default_billdata);
                                ?>
                            </td>
                        </tr> -->
                    </table>
                </td>
                <td valign="top">
                    <span><input type="checkbox" value="1" checked="checked" id="ship_chkbox"><?php echo lang('delivered_to_my_bill_address'); ?></span>
                    <span id="span_ship_title" style="display:none;"><h3><?php echo lang('shipping_address'); ?></h3></span>
                    <table id="shipping_content" class="shipping_content" style="display:none;box-shadow:2px 0px 4px 1px #CCCCCC;" border="0">
                        <tr>
                            <td><?php echo lang('first_name'); ?><span class="star">*&nbsp;</span></td>
                            <td>
                                <?php
                                $fname_shipdata = array(
                                    'name' => 'ship_fname',
                                    'id' => 'ship_fname',
                                    'value' => $user_logininfo['firstname'],
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($fname_shipdata);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('last_name'); ?><span class="star">*&nbsp;</span></td>
                            <td>
                                <?php
                                $lname_shipdata = array(
                                    'name' => 'ship_lname',
                                    'id' => 'ship_lname',
                                    'value' => $user_logininfo['lastname'],
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($lname_shipdata);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('address'); ?></td>
                            <td><?php
                                $address_shipdata = array(
                                    'name' => 'ship_address',
                                    'id' => 'ship_address',
                                    'value' => '',
                                    'style' => 'width:198px;height:50px;',
                                );
                                echo form_textarea($address_shipdata);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('street'); ?><span class="star">*&nbsp;</span></td>
                            <td><?php
                                $street_shipdata = array(
                                    'name' => 'ship_street',
                                    'id' => 'ship_street',
                                    'value' => '',
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($street_shipdata);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('country'); ?><span class="star">*&nbsp;</span></td>
                            <td><?php
                                $country_shipdata = array(
                                    'name' => 'ship_country',
                                    'id' => 'ship_country',
                                    'value' => '',
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($country_shipdata);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('state'); ?><span class="star">*&nbsp;</span></td>
                            <td><?php
                                $state_shipdata = array(
                                    'name' => 'ship_state',
                                    'id' => 'ship_state',
                                    'value' => '',
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($state_shipdata);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('city'); ?><span class="star">*&nbsp;</span></td>
                            <td><?php
                                $city_shipdata = array(
                                    'name' => 'ship_city',
                                    'id' => 'ship_city',
                                    'value' => '',
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($city_shipdata);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('postcode'); ?><span class="star">*&nbsp;</span></td>
                            <td><?php
                                $postcode_shipdata = array(
                                    'name' => 'ship_postcode',
                                    'id' => 'ship_postcode',
                                    'value' => '',
                                    'style' => 'width:198px;',
                                    'class' => 'validate[required]'
                                );
                                echo form_input($postcode_shipdata);
                                ?>
                            </td>
                        </tr>
                        <?php /*
                        <tr>
                            <td colspan="2">

                                 $ship_submit = array(
                                    'name' => 'addshipping',
                                    'id' => 'addshipping',
                                    'value' => lang('add_address'),
                                    'title' => lang('btn_save'),
                                    'class' => 'inputbutton',
                                );
                                echo form_submit($ship_submit);

                            </td>
                        </tr>
                        */ ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <?php
                    $checkout_submit = array(
                    'name' => 'add_chkaddress',
                    'id' => 'add_chkaddress',
                    'value' => lang('btn_addaddress'),
                    'title' => lang('btn_addaddress'),
                    'class' => 'inputbutton cart-btn'
                );
                echo form_submit($checkout_submit);
             ?>   
            </td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    </div>    
</td>
</tr>
<script type="text/javascript">
    $(document).ready( function()
    {
        $("#bill_fname").change(function()
        {
            if( $('#ship_chkbox').is(":checked")==true)
            {
                $("#ship_fname").val($(this).val());
            }
        });
        $("#bill_lname").change(function()
        {
            if( $('#ship_chkbox').is(":checked")==true)
            {
                $("#ship_lname").val($(this).val());
            }
        });
        
        $("#bill_street").change(function()
        {
            if( $('#ship_chkbox').is(":checked")==true)
            {
                $("#ship_street").val($(this).val());
            }
        });
        $("#bill_country").change(function()
        {
           if( $('#ship_chkbox').is(":checked")==true)
           {
                $("#ship_country").val($(this).val());
           } 
        });
        $("#bill_state").change(function()
        {
            if( $('#ship_chkbox').is(":checked")==true)
            {
                $("#ship_state").val($(this).val());
            } 
        });
        $("#bill_city").change(function()
        {
            if( $('#ship_chkbox').is(":checked")==true)
            {
                $("#ship_city").val($(this).val());
            }
        });
        $("#bill_postcode").change(function()
        {
            if( $('#ship_chkbox').is(":checked")==true)
            {
                $("#ship_postcode").val($(this).val());
            }
        });
       
        $('#ship_chkbox').change( function()
        {
            if( $('#ship_chkbox').is(":checked")==true)
            {
                $("#ship_fname").val($("#bill_fname").val());
                $("#ship_lname").val($("#bill_lname").val());
                $("#ship_street").val($("#bill_street").val());
                $("#ship_country").val($("#bill_country").val());
                $("#ship_state").val($("#bill_state").val());
                $("#ship_city").val($("#bill_city").val());
                $("#ship_postcode").val($("#bill_postcode").val());
                $('#shipping_content').hide();
            } 
            else
            {
                $('#span_ship_title').show();
                $('#shipping_content').show();
                $("#ship_fname").val('');
                $("#ship_lname").val('');
                $("#ship_street").val('');
                $("#ship_country").val('');
                $("#ship_state").val('');
                $("#ship_city").val('');
                $("#ship_postcode").val('');
            }
        });
        jQuery("#checkout_address_form").validationEngine(
            {promptPosition : '<?php echo VALIDATION_ERROR_POSITION; ?>',validationEventTrigger: "submit"}
        );
    });
</script>