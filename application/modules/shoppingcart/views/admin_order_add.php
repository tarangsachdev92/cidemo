<?php
echo form_open_multipart(get_current_section($this) . '/shoppingcart/action_order/' . $action . "/" . $id, array('id' => 'saveordersform', 'name' => 'saveordersform'));
?>
<div class="ship_bill">
    <table cellspacing="1" cellpadding="4" border="0" width="100%" bgcolor="#e6ecf2">
        <tbody bgcolor="#fff">
            <tr >
                <th><?php echo lang('billing_address'); ?></th>
                <th ><?php echo lang('shipping_address'); ?></th>
            </tr>
            <tr>
                <td valign="top">
                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tr><td><?php echo $billrecorddata['bill_fname'] . '&nbsp;' . $billrecorddata['bill_lname']; ?></td></tr>
                        <?php
                        if ($billrecorddata['bill_address'] != '')
                        {
                            ?>
                            <tr><td><?php echo $billrecorddata['bill_address']; ?></td></tr>
                        <?php } ?>
                        <tr><td><?php echo $billrecorddata['bill_street']; ?></td></tr>
                        <tr><td><?php echo $billrecorddata['bill_city']; ?></td></tr>
                        <tr><td><?php echo $billrecorddata['bill_state']; ?></td></tr>
                        <tr><td><?php echo $billrecorddata['bill_country']; ?></td></tr>
                        <tr><td><?php echo $billrecorddata['bill_postcode']; ?></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tr><td><?php echo $shiprecorddata['ship_fname'] . '&nbsp;' . $shiprecorddata['ship_lname']; ?></td></tr>
                        <?php
                        if ($shiprecorddata['ship_address'] != '')
                        {
                            ?>
                            <tr><td><?php echo $shiprecorddata['ship_address']; ?></td></tr>
                        <?php } ?>
                        <tr><td><?php echo $shiprecorddata['ship_street']; ?></td></tr>
                        <tr><td><?php echo $shiprecorddata['ship_city']; ?></td></tr>
                        <tr><td><?php echo $shiprecorddata['ship_state']; ?></td></tr>
                        <tr><td><?php echo $shiprecorddata['ship_country']; ?></td></tr>
                        <tr><td><?php echo $shiprecorddata['ship_postcode']; ?></td></tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
if (count($orderitemsdata))
{
    ?>
    <br>
    <div id="productinfo1" class="productinfo1" >
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
                <tr>
                    <th width="40%"><?php echo lang('prd_title'); ?></th>
                    <th width="30%"><?php echo lang('quantity'); ?></th>
                    <th width="30%"><?php echo lang('price'); ?></th>
                </tr>
                <?php
                foreach ($orderitemsdata as $orderitem)
                {
                    ?>   
                    <tr>
                        <td><?php echo $orderitem['scoi']['product_name']; ?></td>
                        <td><?php echo $orderitem['scoi']['product_qty']; ?></td>
                        <td><?php echo $orderitem['scoi']['product_price'] . '&nbsp;' . $recorddata['currency_code']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <br>
        <table cellspacing="1" cellpadding="4" border="0" width="100%" >
            <tr>
                <td width="40%"></td>
                <th width="30%" style="text-align:right;"><?php echo lang('order_amount'); ?>:</th>
                <td width="30%"><?php echo $recorddata['order_amount'] . '&nbsp;' . $recorddata['currency_code']; ?></td>
            </tr>
            <?php
            if ($recorddata['coupon_code'] != '')
            {
                ?>    
                <tr>
                    <td></td>
                    <th style="text-align:right;"><?php echo lang('coupon_code') . ':' . $recorddata['coupon_code']; ?></th>
                    <td><?php echo $recorddata['coupon_discount'] . '&nbsp;' . $recorddata['currency_code']; ?></td>
                </tr>
            <?php } ?>
        <!-- <tr>
                <td></td>
                <th style="text-align:right;"><?php // echo lang('tax');  ?>:</th>
                <td><?php // echo $recorddata['order_tax'].'&nbsp;'.$recorddata['currency_code'];  ?></td>
            </tr> -->
            <tr>
                <td></td>
                <th style="text-align:right;"><?php echo lang('total'); ?>:</th>
                <td><?php echo $recorddata['total_amount'] . '&nbsp;' . $recorddata['currency_code']; ?></td>
            </tr>
        </table>
    </div>
<?php } ?>

<br>
<div id="orderinfo" class="orderinfo" >
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th width="40%"><?php echo lang('order_id'); ?>:</th>
                <td><?php echo $recorddata['id']; ?></td>
            </tr>
            <tr>
                <th ><?php echo lang('order_date'); ?>:</th>
                <td><?php echo $recorddata['order_date']; ?></td>
            </tr>
            <?php
            $statuslist = array('0' => lang('pending'), '1' => lang('cancelled'), '2' => lang('processing')
                , '3' => lang('despatched'), '4' => lang('completed'));
            ?>
            <tr>
                <th><?php echo lang('status'); ?>:</th>
                <td><?php
                    if ($recorddata['order_status'] == 1)
                    {
                        echo lang('cancelled');
                    }
                    else if ($recorddata['order_status'] == 4)
                    {
                        echo lang('completed');
                    }
                    else
                    {
                        echo form_dropdown('order_status', $statuslist, $recorddata['order_status']);
                    }
                    $submit_button = array(
                        'name' => 'mysubmit',
                        'id' => 'mysubmit',
                        'value' => lang('btn_save'),
                        'title' => lang('btn_save'),
                        'class' => 'inputbutton',
                    );
                    echo '&nbsp;' . form_submit($submit_button);
                    $cancel_button = array(
                        'content' => lang('btn_cancel'),
                        'title' => lang('btn_cancel'),
                        'class' => 'inputbutton',
                        'onclick' => 'history.go(-1)',
                    );
                    echo '&nbsp;' . form_button($cancel_button);
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php echo form_close(); ?>