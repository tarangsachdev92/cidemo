<div class="main-content">
    <div class="grid-data info-content">
        <div class="add-new">
            <?php echo anchor(site_url() . $this->_data['section_name'] . '/shoppingcart/coupons', lang('view_all_coupons'), 'title="View All Coupons" style="text-align:center;width:100%;"'); ?>
        </div>
        <div class="profile-content-box" id="shoppingcart_coupons_form">
            <div id="one" class="grid-data">
                <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
                    <tbody bgcolor="#fff">
                        <tr>
                            <th><?php echo lang('view_coupon') ?></th>
                        </tr>
                        <tr>
                            <td class="add-user-form-box">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td width="100%" valign="top">
                                            <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                                <tr>
                                                    <td width="300" align="right"><?php echo form_label(lang('coupon_name'), 'coupon_name'); ?>:</td>
                                                    <td>
                                                        <?php echo $recorddata['coupon_name']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><?php echo form_label(lang('coupon_code'), 'coupon_code'); ?>:</td>
                                                    <td>
                                                        <?php echo $recorddata['coupon_code']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><?php echo form_label(lang('price'), 'coupon_price'); ?>:</td>
                                                    <td>
                                                        <?php
                                                        $price_percent = '';
                                                        $currency_code = CURRENCY_CODE;
                                                        if ($recorddata['coupon_percentage'] == 1)
                                                        {
                                                            $price_percent = '%';
                                                            $currency_code = '';
                                                        }
                                                        echo $recorddata['coupon_price'] . $price_percent . '&nbsp;' . $currency_code;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><?php echo form_label(lang('is_price_in_percentage'), 'coupon_percentage'); ?>:</td>
                                                    <td>
                                                        <?php
                                                        if ($recorddata['coupon_percentage'] == 1)
                                                        {
                                                            echo lang('yes');
                                                        }
                                                        else
                                                        {
                                                            echo lang('no');
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><?php echo form_label(lang('coupon_maxuse'), 'coupon_maxuse'); ?>:</td>
                                                    <td>
                                                        <?php echo $recorddata['coupon_maxuse']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><?php echo form_label(lang('status'), 'status'); ?>:</td>
                                                    <td>
                                                        <?php
                                                        if ($recorddata['status'] == 1)
                                                        {
                                                            echo lang('active');
                                                        }
                                                        else
                                                        {
                                                            echo lang('inactive');
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><?php echo form_label(lang('start_date'), 'coupon_sdate'); ?>:</td>
                                                    <td><?php echo $recorddata['coupon_sdate']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><?php echo form_label(lang('end_date'), 'coupon_edate'); ?>:</td>
                                                    <td><?php echo $recorddata['coupon_edate']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>