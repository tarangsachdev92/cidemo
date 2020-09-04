<?php echo add_js(array('jquery-1.9.1.min', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('view_product'); ?> - <?php echo $language_name; ?></th>
            </tr>
            <?php
            if (count($result))
            {
                ?>
                <tr>
                    <td class="add-user-form-box">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="100%" valign="top">
                                    <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('name'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['name']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><?php echo lang('slug'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['slug_url']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('category'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['c']['title']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('price'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['price'] . '&nbsp;' . $result[0]['products']['currency_code']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('discount_price'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['discount_price'] . '&nbsp;' . $result[0]['products']['currency_code']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('stock'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['stock']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right" valign="top"><?php echo lang('image'); ?>:</td>
                                            <td>
                                                <?php
                                                $image_path = site_url() . 'assets/uploads/shoppingcart/thumbs/';
                                                if (isset($result[0]['products']['product_image']) && $result[0]['products']['product_image'] != '')
                                                {
                                                    echo '<img src="' . $image_path . $result[0]['products']['product_image'] . '">';
                                                }
                                                else
                                                {
                                                    echo 'No Image';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top"></span><?php echo lang('description'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['description']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><?php echo lang('status'); ?>:</td>
                                            <td>
                                                <?php
                                                if ($result[0]['products']['status'] == 1)
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
                                            <td width="300" align="right"><?php echo lang('featured'); ?>:</td>
                                            <td>
                                                <?php
                                                if ($result[0]['products']['featured'] == 1)
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
                                            <td width="300" align="right"><?php echo lang('related_products'); ?>:</td>
                                            <td>
                                                <?php
                                                $rel_products = '';
                                                foreach ($related_products as $related_product)
                                                {
                                                    $rel_products .= $related_product['scp']['name'] . ',';
                                                }
                                                $rel_products = substr($rel_products, 0, strlen($rel_products) - 1);
                                                echo $rel_products;
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><strong><?php echo lang('meta_fields'); ?></strong></td>
                                            <td>&nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><span class="star"></span><?php echo lang('keywords'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['meta_keywords']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top"><span class="star"></span><?php echo lang('description'); ?>:</td>
                                            <td>
                                                <?php echo $result[0]['products']['meta_description']; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
            }
            else
            {
                ?>
                <tr><td><?php echo lang('no_record_found') ?></td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="submit-btns clearfix">
        <?php
        $cancel_button = array(
            'content' => lang('btn_cancel'),
            'title' => lang('btn_cancel'),
            'class' => 'inputbutton',
            'onclick' => 'history.go(-1)',
        );
        echo "&nbsp;";
        echo form_button($cancel_button);
        ?>
    </div>
</div>