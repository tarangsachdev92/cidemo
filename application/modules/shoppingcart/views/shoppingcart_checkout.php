<?php
echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine'));
echo add_css(array('modules/shoppingcart/shoppingcart'));

$cart_amount = $cart_total;
$coupon_discount = '0';
$coupon_ocode = '';
$order_tax = '0';

if (isset($coupon_session))
{
    if ($coupon_session['coupon_code'] != '')
    {
        $cart_total = $cart_total - $coupon_session['coupon_discount_price'];
        $coupon_ocode = $coupon_session['coupon_code'];
        $coupon_discount = $coupon_session['coupon_discount_price'];
    }
}
?>
<tr class="content">
    <td>
        <?php echo form_open('shoppingcart/checkout', array('id' => 'checkout_form', 'name' => 'checkout_form')); ?>
        <table width="100%" >
            <tr>
                <td>
                    <div  style="box-shadow:2px 0px 4px 1px #CCCCCC;">
                        <table width="100%" border="0">
                            <tr>
                                <td width="50%">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <h3><?php echo lang('billing_address'); ?></h3>
                                            </td>
                                        </tr>
                                        <?php
                                        $i = 1;
                                        foreach ($billaddress_data as $bill_content)
                                        {
                                            $tr_bstyle = 'style="display:none";';
                                            $radio_bchecked = '';

                                            if ($i == 1)
                                            {
                                                $radio_bchecked = 'checked="checked"';
                                                $tr_bstyle = 'style="display:";';
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="radio" name="chose_bill" class="chose_billcls" value="<?php echo $bill_content['id']; ?>" <?php echo $radio_bchecked; ?> >
                                                    <b><?php echo lang('use_this_address'); ?></b>
                                                </td>
                                            </tr>
                                            <tr <?php echo $tr_bstyle; ?> class="billaddress_data" id="billaddress_tr<?php echo $bill_content['id']; ?>" >
                                                <td style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td><?php echo $bill_content['bill_fname'] .' ' . $bill_content['bill_lname']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $bill_content['bill_street']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $bill_content['bill_city']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $bill_content['bill_state']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $bill_content['bill_country']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $bill_content['bill_postcode']; ?>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="<?php echo site_url() . 'shoppingcart/address/billaddress/' . $bill_content['id'] ?>">Edit Address</a></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><h3><?php echo lang('shipping_address'); ?></h3></td>
                                        </tr>
                                        <?php
                                        $j = 1;
                                        foreach ($shipaddress_data as $ship_content)
                                        {
                                            if ($j == 1)
                                            {
                                                $radio_checked = 'checked="checked"';
                                                $tr_style = 'style="display:";';
                                            }
                                            else
                                            {
                                                $tr_style = 'style="display:none";';
                                                $radio_checked = '';
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="radio" name="chose_ship" class="chose_shipcls" value="<?php echo $ship_content['id']; ?>" <?php echo $radio_checked; ?> ><b><?php echo lang('use_this_address'); ?></b>
                                                </td>
                                            </tr>
                                            <tr <?php echo $tr_style; ?> class="shipaddress_data" id="shipaddress_tr<?php echo $ship_content['id']; ?>" >
                                                <td  style="padding-left:30px;">
                                                    <table>
                                                        <tr>
                                                            <td><?php echo $ship_content['ship_fname'] . ' ' . $ship_content['ship_lname']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $ship_content['ship_street']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $ship_content['ship_city']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $ship_content['ship_state']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $ship_content['ship_country']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $ship_content['ship_postcode']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="<?php echo site_url() . 'shoppingcart/address/shipaddress/' . $ship_content['id'] ?>">Edit Address</a></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                            $j++;
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    $checkout_txtdata = array(
                        'name' => 'coupon_code',
                        'id' => 'coupon_code',
                        'value' => '',
                        'style' => 'width:100px;'
                    );

                    $coupon_submit = array(
                        'name' => 'coupon_submit',
                        'id' => 'coupon_submit',
                        'value' => lang('btn_redeem'),
                        'title' => lang('btn_redeem'),
                        'class' => 'inputbutton cart-btn',
                        'onclick' => 'checkoutpage(); return false;'
                    );
                    ?>
                    <span>
                        <h3><?php echo lang('discount_coupon'); ?></h3>
                    </span>
                    <div  style="box-shadow:2px 0px 4px 1px #CCCCCC;width:300px;">
                        <table>
                            <tr>
                                <td><?php echo lang('enter_coupon_code'); ?> </td>
                                <td><?php echo form_input($checkout_txtdata); ?></td>
                                <td><?php echo form_submit($coupon_submit); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="content">
                <td >
                    <div class="order_title">
                        <div style="float:left;margin-top: 25px;">
                            <b><?php echo lang('your_order'); ?></b>
                        </div>
                        <div style="float: right; margin-top: 14px;">
                            <?php
                            $ordconfirm_button = array(
                                'content' => lang('btn_continue_shopping'),
                                'title' => lang('btn_continue_shopping'),
                                'class' => 'inputbutton cart-btn',
                                'onclick' => "location.href='" . site_url() . "shoppingcart'"
                            );
                            echo form_button($ordconfirm_button);
                            ?>
                        </div>
                    </div>
                    </br>
                    </br>
                    </br>
                    <div  style="box-shadow:2px 0px 4px 1px #CCCCCC;">
                        <?php
                        if (count($cart_data))
                        {
                            ?>
                            <table cellpadding="6" cellspacing="1" style="width:100%" border="0">
                                <tr style="background-color:#404040; height:30px;color:#FFFFFF;">
                                    <td><b><?php echo lang('item'); ?></b></td>
                                    <td width="30%"><b><?php echo lang('quantity'); ?></b></td>
                                    <td width="15%" style="text-align:right"><b><?php echo lang('price'); ?></b></td>
                                    <td width="15%" style="text-align:right"><b><?php echo lang('sub_total'); ?></b></td>
                                </tr>
                                <?php
                                $i = 1;
                                $back_color = 'EEEEEE';

                                foreach ($cart_data as $items)
                                {
                                    if ($i % 2 == 0)
                                    {
                                        $back_color = 'F8F8F8';
                                    }
                                    else
                                    {
                                        $back_color = 'EEEEEE';
                                    }
                                    ?>
                                    <tr style="background-color:#<?php echo $back_color; ?>;">
                                        <td>
                                            <?php
                                            if (file_exists('assets/uploads/shoppingcart/thumbs/' . $items['product_image']))
                                            {
                                                ?>
                                                <a href="<?php echo site_url() . 'shoppingcart/products/' . $items['slug_url']; ?>">
                                                    <img src="<?php echo site_base_url() . 'assets/uploads/shoppingcart/thumbs/' . $items['product_image']; ?>" alt='' align="left"  />
                                                </a>
                                                <?php
                                            }
                                            ?>
                                            <br />
                                            <b>&nbsp; &nbsp; &nbsp; &nbsp; <?php echo ucfirst($items['name']); ?></b>
                                        </td>
                                        <td>
                                            <?php
                                            echo form_open('shoppingcart/updatecartitem');
                                            echo form_hidden($i . '[rowid]', $items['rowid']);
                                            echo $items['qty'];
                                            echo form_close();
                                            ?>
                                        </td>
                                        <td style="text-align:right">
                                            <?php echo $items['price'] . '&nbsp;' . CURRENCY_CODE; ?>
                                        </td>
                                        <td style="text-align:right">
                                            <?php echo number_format($items['subtotal'], 2) . '&nbsp;' . CURRENCY_CODE; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                if ($back_color == 'EEEEEE')
                                {
                                    $total_background = 'F8F8F8';
                                }
                                else
                                {
                                    $total_background = 'EEEEEE';
                                }
                                ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td  style="text-align:right;background-color:#<?php echo $total_background; ?>;">
                                        <b><?php echo lang('sub_total'); ?></b>
                                    </td>
                                    <td  style="text-align:right;background-color:#<?php echo $total_background; ?>;">
                                        <?php echo number_format($cart_gross_total, 2) . '&nbsp;' . CURRENCY_CODE; ?>
                                    </td>
                                </tr>

                                <?php
                                if (isset($coupon_session))
                                {
                                    if ($coupon_session['coupon_code'] != '')
                                    {
                                        ?>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="text-align:right">
                                                <b><?php echo lang('coupon_code'); ?></b>
                                                <br>
                                                <?php echo $coupon_session['coupon_code']; ?>
                                            </td>
                                            <td style="text-align:right">
                                                <?php echo '- ' . $coupon_session['coupon_discount_price'] . '&nbsp;' . CURRENCY_CODE; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align:right;background-color:#<?php echo $total_background; ?>;">
                                        <b><?php echo lang('total'); ?></b>
                                    </td>
                                    <td style="text-align:right;background-color:#<?php echo $total_background; ?>;">
                                        <b><?php echo number_format($cart_total, 2) . '&nbsp;' . CURRENCY_CODE; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <b>Customer notes:</b><br />
                                        <?php
                                        $data = array(
                                            'name' => 'notes',
                                            'id' => 'notes',
                                            'cols' => '50',
                                            'rows' => '3'
                                        );
                                        echo form_textarea($data);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <input type="checkbox" name="shoppingcart_tc_ps" id="shoppingcart_tc_ps" class="validate[required]"   /> I accept the <a href="<?php echo site_url(); ?> terms-and-conditions" target="_blank">"Terms & Conditions"</a> and <a href="<?php echo site_url(); ?>privacy-statement"  target="_blank">"Privacy statement"</a>
                                        <br>
                                        <span class="warning-msg"><?php echo form_error('shoppingcart_tc_ps'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td align="right">
                                        <?php
                                        $back_button = array(
                                            'content' => lang('btn_back'),
                                            'title' => lang('btn_back'),
                                            'class' => 'inputbutton cart-btn',
                                            'onclick' => "location.href='" . site_url() . 'shoppingcart/cart' . "'"
                                        );
                                        echo form_button($back_button);
                                        ?>
                                    </td>
                                    <td align="right">
                                        <?php
                                        $checkout_submit = array(
                                            'name' => 'checkout_submit',
                                            'id' => 'checkout_submit',
                                            'value' => lang('btn_confirm_order'),
                                            'title' => lang('btn_confirm_order'),
                                            'class' => 'inputbutton cart-btn'
                                        );
                                        echo form_submit($checkout_submit);
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <?php
                        }
                        else
                        {
                            ?>
                            <p><?php echo lang('no_cart_item'); ?></p>
                            <?php
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <?php
        echo form_hidden('order_amount', $cart_amount, 'order_amount');
        echo form_hidden('total_amount', $cart_total, 'total_amount');
        echo form_hidden('coupon_discount', $coupon_discount, 'coupon_discount');
        echo form_hidden('coupon_ocode', $coupon_ocode, 'coupon_ocode');
        echo form_hidden('order_tax', $order_tax, 'order_tax');
        echo form_close();
        ?>
    </td>
</tr>
<script type="text/javascript">
    $(".chose_shipcls").change(function() {
        $('.shipaddress_data').hide();
        // $('#shipaddress_tr'+$(this).val()).show();
        $('#shipaddress_tr' + $(this).val()).fadeToggle("slow", 'swing');
    });

    $(".chose_billcls").change(function() {
        $('.billaddress_data').hide();
        // $('#billaddress_tr'+$(this).val()).show();
        $('#billaddress_tr' + $(this).val()).fadeToggle("slow", 'swing');
    });

    $("#coupon_submit").click(function() {
        $('#checkout_form').attr('action', 'checkoutaddress');
        $('#checkout_form').submit();
    });

    $("#checkout_submit").click(function() {
        if ($('#shoppingcart_tc_ps').is(':checked') == false)
        {
            alert('You must accept the terms and conditions to be able to place orders.');
            return false;
        }
    });
</script>