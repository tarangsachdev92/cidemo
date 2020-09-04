<?php
echo add_css(array('modules/shoppingcart/shoppingcart'));
echo add_js(array('modules/shoppingcart/shoppingcart'));
$image_path = site_base_url() . 'assets/uploads/shoppingcart/categories/';
?>
<tr class="content">
    <td>
        <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="content-left-sc" valign="top">
                    <div class="navigation-sub">
                        <?php echo lang('categories'); ?>
                    </div>
                    <?php widget('shoppingcart_categories', array('language_id' => $language_id, 'section_name' => $this->_data["section_name"])); ?>
                </td>
                <td width="2%">&nbsp;</td>
                <td class="content-center" valign="top" >
                    <div class="navigation-sub">
                        <?php echo lang('featured-products'); ?>
                    </div>
                    <!-- feature product -->
                    <?php
                    $image_path = site_base_url() . 'assets/uploads/shoppingcart/';
                    $attributes = array("name" => "shopping_products", "id" => "shopping_products");
                    ?>
                    <br />
                    <div id="ajax_table">
                        <?php
                        if (count($feature_products))
                        {
                            echo form_open('shoppingcart/addtocart', $attributes);
                            ?>
                            <ul class="fproduct" >
                                <?php
                                foreach ($feature_products AS $allrecord)
                                {
                                    $product_detail_link = site_url() . 'shoppingcart/products/' . $allrecord['scp']['slug_url'];
                                    $featured = 1;
                                    $product_id = $allrecord['scp']['product_id'];
                                    ?>
                                    <li>
                                        <h3>
                                            <a href="<?php echo $product_detail_link; ?>" style="text-decoration:none;"><?php echo $allrecord['scp']['name']; ?> </a>
                                        </h3>
                                        <div class="fproduct-img" >
                                            <?php
                                            $product_image = $image_path . 'no_image.jpg';

                                            if ($allrecord['scp']['product_image'] != '')
                                            {
                                                if (file_exists(FCPATH . 'assets/uploads/shoppingcart/medium/' . $allrecord['scp']['product_image']))
                                                {
                                                    $product_image = $image_path . 'medium/' . $allrecord['scp']['product_image'];
                                                }
                                            }
                                            ?>
                                            <a href="<?php echo $product_detail_link; ?>">
                                                <img src="<?php echo $product_image; ?>" border="0"  height="130px" width="165px;" >
                                            </a>
                                        </div>
                                        <div>


                                            <?php
                                            $discount_price = 0;
                                            $del_start_tag = '';
                                            $del_end_tag = '';

                                            if ($allrecord['scp']['discount_price'] > 0)
                                            {
                                                $discount_price = 1;
                                                $del_start_tag =  lang('regular_price').': <del>';
                                                $del_end_tag = '</del>';
                                            }
                                            ?>
                                            <b><?php echo $del_start_tag . $allrecord['scp']['price'] . '&nbsp;' . $allrecord['scp']['currency_code'] . $del_end_tag; ?></b>
                                            <?php
                                            if ($discount_price == 1)
                                            {
                                                ?>
                                                <b><?php echo lang('discount_price').': '.$allrecord['scp']['discount_price'] . '&nbsp;' . $allrecord['scp']['currency_code']; ?> </b>
                                                <?php
                                            }
                                            else
                                            {
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </div>  <br />
                                        <div>
                                            <?php
                                            if($allrecord['scp']['stock'] > 0)
                                            {
                                                $addtocart_submit = array(
                                                    'name' => 'product_button',
                                                    'value' => lang('add_to_cart'),
                                                    'id' => 'product_button',
                                                    'title' => lang('add_to_cart'),
                                                    'class' => 'inputbutton  cart-btn',
                                                    'content' => lang('add_to_cart'),
                                                    'onclick' => "list_addtocart($product_id)"
                                                );

                                                echo '&nbsp;&nbsp;' . form_button($addtocart_submit);
                                                echo form_hidden('lproduct_id' . $product_id, $allrecord['scp']['product_id'], 'lproduct_id' . $product_id);

                                                if ($allrecord['scp']['discount_price'] > 0)
                                                {
                                                    echo form_hidden('lprice' . $product_id, $allrecord['scp']['discount_price'], 'lprice' . $product_id);
                                                }
                                                else
                                                {
                                                    echo form_hidden('lprice' . $product_id, $allrecord['scp']['price'], 'lprice' . $product_id);
                                                }


                                                echo form_hidden('lpname' . $product_id, $allrecord['scp']['name'], 'lpname' . $product_id);
                                                echo form_hidden('ldiscount_price' . $product_id, $allrecord['scp']['discount_price'], 'ldiscount_price' . $product_id);
                                                echo form_hidden('lcurrency_code' . $product_id, CURRENCY_CODE, 'lcurrency_code' . $product_id);
                                                echo form_hidden('lslug_url' . $product_id, $allrecord['scp']['slug_url'],'lslug_url' . $product_id);
                                                echo form_hidden('lproduct_image' . $product_id, $allrecord['scp']['product_image'],'lproduct_image' . $product_id);
                                            }
                                            else
                                            {
                                               echo '<span class="red"><b>' . lang('out_stock') . '</b></span>';
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>

                            <?php
                            echo form_hidden('page_number', "", "page_number");
                            echo form_hidden('per_page_result', "", "per_page_result");

                            echo form_hidden('product_id', '', 'product_id');
                            echo form_hidden('price', '', 'price');
                            echo form_hidden('pname', '', 'pname');
                            echo form_hidden('slug_url', '', 'slug_url');
                            echo form_hidden('product_image', '', 'product_image');
                            echo form_hidden('discount_price', '', 'discount_price');
                            echo form_hidden('currency_code', '', 'currency_code');
                            echo form_hidden('product_submit', '1', 'product_submit');
                            echo form_close();
                            ?>
                        </div>
                        <div style="clear: both; height:10px;"></div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <span><?php echo lang('prd_no_records'); ?></span>
                        <?php
                    }
                    ?>
                    </div>
                    <!-- end feature product -->
                </td>
                <td width="2%">&nbsp;</td>
                <td class="content-right-sc" valign="top">
                    <div class="navigation-sub">
                        <?php echo lang('best-seller'); ?>
                        <?php widget('shoppingcart_best_seller_products', array('language_id' => $language_id)); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" width="100%">
                    <?php widget('shoppingcart_most_viewed_products', array('language_id' => $language_id)); ?>
                </td>
            </tr>
        </table>
    </td>
</tr>