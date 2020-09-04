<?php
echo add_css(array('modules/shoppingcart/shoppingcart'));
$admin_image_path = 'assets/admin_image/';
$user_id = 0;

if (isset($data['front_user']['user_id']))
{
    if ($data['front_user']['user_id'] != 0)
    {
        $user_id = $data['front_user']['user_id'];
    }
}
?>
<tr class="content">
    <td>
        <div class="order_title">
            <div style="float:left;margin-top: 10px;">
                <b><?php echo lang('cart'); ?></b>
            </div>
            <div style="float:right;">
                <?php
                $ordconfirm_button = array(
                    'content' => lang('btn_continue_shopping'),
                    'title' => lang('btn_continue_shopping'),
                    'class' => 'inputbutton  cart-btn',
                    'onclick' => "location.href='" . site_url() . "shoppingcart'"
                );
                echo form_button($ordconfirm_button);
                ?>
            </div>
        </div>
        <br>
        <br>
        <div  style="box-shadow:2px 0px 4px 1px #CCCCCC;">
            <?php
            if (count($cart_data))
            {
                // echo form_open('shoppingcart/updatecart');  ?>
                <table cellpadding="6" cellspacing="1" border="0"  style="width:100%;">
                    <tr style="background-color:#404040;color:#FFFFFF;">
                        <td style="height:25px;2"><b><?php echo lang('item'); ?></b></td>
                        <td width="30%" ><b><?php echo lang('quantity'); ?></b></td>
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
                            <td valign="middle">
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
                                echo form_input(array('name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '4', 'style' => 'height:22px;'));
                                $remove_button = array(
                                    'content' => lang('remove'),
                                    'title' => lang('remove'),
                                    'class' => 'inputbutton cart-btn',
                                    'onclick' => "location.href='" . site_url() . "shoppingcart/removecartitem/" . $items['rowid'] . "'"
                                );
                                $cartupdate_submit = array(
                                    'name' => 'updcartitem',
                                    'id' => 'updcartitem',
                                    'value' => lang('update'),
                                    'title' => lang('update'),
                                    'class' => 'inputbutton cart-btn'
                                );
                                echo '&nbsp;' . form_submit($cartupdate_submit);
                                echo '&nbsp;' . form_button($remove_button);
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
                    ?>
                    <tr>
                        <?php
                        if ($back_color == 'EEEEEE')
                        {
                            $total_background = 'F8F8F8';
                        }
                        else
                        {
                            $total_background = 'EEEEEE';
                        }
                        ?>
                        <td colspan="2"> </td>
                        <td style="text-align:right;background-color:#<?php echo $total_background; ?>;height:25px;">
                            <b><?php echo lang('total'); ?></b>
                        </td>
                        <td style="text-align:right;background-color:#<?php echo $total_background; ?>;height:25px;">
                            <b><?php echo number_format($cart_total, 2) . '&nbsp;' . CURRENCY_CODE; ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td > </td>
                        <td></td>
                        <td align="right">
                            <?php
                            // echo form_submit('updatecart', lang('update_cart'));
                            $emptycart_button = array(
                                'content' => lang('empty_cart'),
                                'title' => lang('empty_cart'),
                                'class' => 'inputbutton cart-btn',
                                'onclick' => "location.href='" . site_url() . "shoppingcart/emptycart'"
                            );
                            echo '&nbsp;&nbsp;' . form_button($emptycart_button);
                            ?>
                        </td>
                        <td align="right">
                            <?php
                            // echo form_submit('updatecart', lang('update_cart'));
                            $checkout_button = array(
                                'content' => lang('btn_checkout'),
                                'title' => lang('btn_checkout'),
                                'class' => 'inputbutton cart-btn',
                                'onclick' => "return checkuser()"
                            );
                            echo '&nbsp;&nbsp;' . form_button($checkout_button);
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
            }
            else
            {
                ?>
                <span><?php echo lang('no_cart_item'); ?></span>
                <?php
            }
            // echo form_close();
            ?>
       </div>
    </td>
</tr>
<script type="text/javascript">
function checkuser()
{
    var user_id = <?php echo $user_id; ?>;
    if (user_id != 0)
    {
        location.href = "<?php echo site_url() . 'shoppingcart/checkoutaddress' ?>";
    }
    else
    {
        location.href = "<?php echo site_url() . 'shoppingcart/login' ?>";
    }
}
</script>