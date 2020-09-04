<?php echo lang('total_category');?> : <b><?php echo $total_categories; ?></b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo lang('total_product');?> : <b><?php echo $total_products; ?></b>
<br />
<br />
<h3><?php echo lang('store_info');?></h3>
<br />
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr>
    <th><?php echo lang('status');?></th>
    <th style=" text-align: center !important;"><?php echo lang('today');?></th>
    <th style=" text-align: center !important;"><?php echo lang('this_week');?></th>
    <th style=" text-align: center !important;"><?php echo lang('this_month');?></th>
</tr>
<tr class="odd-row">
    <td><?php echo lang('pending');?></td>
    <td align="center"><?php echo $today_pending_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $week_pending_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $current_pending_month_order_details[0]['custom']['cnt'];?></td>
</tr>
<tr class="even-row">
    <td><?php echo lang('processing');?></td>
    <td align="center"><?php echo $today_processing_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $week_processing_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $current_month_processing_order_details[0]['custom']['cnt'];?></td>
</tr>
<tr class="odd-row">
    <td><?php echo lang('cancelled');?></td>
    <td align="center"><?php echo $today_cancelled_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $week_cancelled_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $current_month_cancelled_order_details[0]['custom']['cnt'];?></td>
</tr>
<tr class="even-row">
    <td><?php echo lang('dispatched');?></td>
    <td align="center"><?php echo $today_dispatched_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $week_dispatched_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $current_month_dispatched_order_details[0]['custom']['cnt'];?></td>
</tr>
<tr class="odd-row">
    <td><?php echo lang('completed');?></td>
    <td align="center"><?php echo $today_completed_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $week_completed_order_details[0]['custom']['cnt'];?></td>
    <td align="center"><?php echo $current_month_completed_order_details[0]['custom']['cnt'];?></td>
</tr>
<tr class="even-row">
    <td><b><?php echo lang('gross_total');?></b></td>
    <td align="center"><b><?php echo $today_order_total_cost_details[0]['custom']['gross_total'];?></b></td>
    <td align="center"><b><?php echo $week_order_total_cost_details[0]['custom']['gross_total'];?></b></td>
    <td align="center"><b><?php echo $current_month_order_total_cost_details[0]['custom']['gross_total'];?></b></td>
</tr>
</table>

<br />
<br />

<table width="100%" cellpadding="3" cellspacing="3" >
    <tr>
        <td width="50%" style="vertical-align:top;">
            <h3><?php echo lang('best-seller');?></h3>
            <br />
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <th><?php echo lang('prd_name');?></th>
                    <th style=" text-align: center !important;"><?php echo lang('status');?></th>
                    <th style=" text-align: center !important;"><?php echo lang('price');?></th>
                    <th style=" text-align: center !important;"><?php echo lang('quantity_ordered');?></th>
                </tr>
                <?php
                if(count($best_seller_products) > 0)
                {
                    $i = 0;
                    foreach($best_seller_products as $best_seller_product)
                    {
                        if($i%2==0)
                        {
                            $trclass = "odd-row";
                        }
                        else
                        {
                            $trclass = "even-row";
                        }

                        $i++;
                        ?>
                        <tr class="<?php echo $trclass;?>">
                            <td>
                                <?php echo ucwords($best_seller_product['scp']['name']);?>
                            </td>
                            <td align="center">
                                <?php
                                if($best_seller_product['scp']['status'] == 0)
                                {
                                    echo lang('inactive');
                                }
                                elseif($best_seller_product['scp']['status'] == 1)
                                {
                                    echo lang('active');
                                }
                                else
                                {
                                    echo lang('deleted');
                                }
                                ?>
                            </td>
                            <td align="center">
                                <?php echo $best_seller_product['scp']['price'];?>
                            </td>
                            <td align="center">
                                <?php echo $best_seller_product['custom']['c'];?>
                            </td>
                        </tr>
                       <?php
                    }
                }
                else
                {
                    ?>
                    <tr class="odd-row">
                        <td colspan="4" align="center">
                            <?php echo lang('no_record_found');?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </td>
        <td width="50%" style="vertical-align:top;">
            <h3><?php echo lang('most_vieved_items');?></h3>
            <br />
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <th><?php echo lang('prd_name');?></th>
                    <th style=" text-align: center !important;"><?php echo lang('price');?></th>
                    <th style=" text-align: center !important;"><?php echo lang('noof_view');?></th>
                </tr>
                <?php
                if(count($most_viewed_products) > 0)
                {
                    $i = 0;
                    foreach($most_viewed_products as $most_viewed_product)
                    {
                        if($i%2==0)
                        {
                            $trclass = "odd-row";
                        }
                        else
                        {
                            $trclass = "even-row";
                        }

                        $i++;
                        ?>
                        <tr class="<?php echo $trclass;?>">
                            <td>
                                <?php echo ucwords($most_viewed_product['scp']['name']);?>
                            </td>
                            <td align="center">
                                <?php echo $most_viewed_product['scp']['price'];?>
                            </td>
                            <td align="center">
                                <?php echo $most_viewed_product['scp']['visiters'];?>
                            </td>
                        </tr>
                       <?php
                    }
                }
                else
                {
                    ?>
                    <tr class="odd-row">
                        <td colspan="3"  align="center">
                            <?php echo lang('no_record_found');?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </td>
    </tr>
</table>
<br />
<br />