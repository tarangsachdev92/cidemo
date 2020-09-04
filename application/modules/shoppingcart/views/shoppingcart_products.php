<?php
echo add_css(array('modules/shoppingcart/shoppingcart'));
echo add_js(array('modules/shoppingcart/shoppingcart'));
$image_path = site_base_url() . 'assets/uploads/shoppingcart/';
$attributes = array("name" => "shopping_products", "id" => "shopping_products");
?>
<tr class="content">
    <td>
        <div id="ajax_table">
            <?php
            if (count($allrecords))
            {
                ?>
                <div class="grid-data grid-data-table">
                    <?php echo form_open('shoppingcart/addtocart', $attributes); ?>
                    <table cellspacing="3" cellpadding="3" width="100%">
                        <tr>
                            <td colspan="<?php echo $per_row; ?>">
                                <h3><?php echo lang('prd_all'); ?></h3>
                                <hr />
                            </td>
                        </tr>
                        <tr>
                            <?php
                            $i = 1;
                            foreach ($allrecords AS $allrecord)
                            {
                                $product_detail_link = site_url() . 'shoppingcart/products/' . $allrecord['scp']['slug_url'];
                                if ($allrecord['scp']['featured'] == 1)
                                {
                                    $featured = 1;
                                }
                                else
                                {
                                    $featured = 0;
                                }
                                $product_id = $allrecord['scp']['product_id'];
                                ?>
                                <td class="content" valign="top" >
                                    <div class="product-div">
                                        <table>
                                            <tr>
                                                <td align="center">
                                                    <h3>
                                                        <a href="<?php echo $product_detail_link; ?>" style="text-decoration:none;">
                                                            <?php echo ucwords($allrecord['scp']['name']); ?>
                                                        </a>
                                                    </h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <div class="prdimg_div" >
                                                        <?php
                                                        $product_image = 'no_image.jpg';
                                                        if ($allrecord['scp']['product_image'] != '')
                                                        {
                                                            if (file_exists(FCPATH . 'assets/uploads/shoppingcart/medium/' . $allrecord['scp']['product_image']))
                                                            {
                                                                $product_image = $allrecord['scp']['product_image'];
                                                            }
                                                        }
                                                        ?>
                                                        <a href="<?php echo $product_detail_link; ?>">
                                                            <img src="<?php echo $image_path . 'medium/' . $product_image; ?>" border="0"  height="170px;" >
                                                        </a>
                                                    </div>         
                                                </td>
                                            </tr>
                                            <?php
                                            $discount_price = 0;
                                            $del_start_tag = '';
                                            $del_end_tag = '';
                                            if ($allrecord['scp']['discount_price'] > 0)
                                            {
                                                $discount_price = 1;
                                                $del_start_tag = lang('regular_price').': <del>';
                                                $del_end_tag = '</del>';
                                            }
                                            ?>
                                            <tr>
                                                <td align="right">
                                                    <b><?php echo $del_start_tag . $allrecord['scp']['price'] . '&nbsp;' . $allrecord['scp']['currency_code'] . $del_end_tag; ?></b>
                                                    <?php
                                                    if ($discount_price == 1)
                                                    {
                                                        ?>
                                                        <b><?php echo lang('discount_price').': '. $allrecord['scp']['discount_price'] . '&nbsp;' . $allrecord['scp']['currency_code']; ?> </b>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        echo '<br><br>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                    <table align="left" width="100%">
                                                        <tr align="left"> 
                                                            <td align="right">
                                                                <?php
                                                                if ($featured == 1)
                                                                {
                                                                    ?>
                                                                    <label style='color:#fff;font-weight:bold;background-color:#ff0000;'><?php echo lang('featured'); ?></label>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td align="right">
                                                                <?php
                                                                if($allrecord['scp']['stock'] > 0)
                                                                {
                                                                    $addtocart_submit = array(
                                                                        'name' => 'product_submit',
                                                                        'value' => lang('add_to_cart'),
                                                                        'id' => 'product_submit',
                                                                        'title' => lang('add_to_cart'),
                                                                        'class' => 'inputbutton',
                                                                        'content' => lang('add_to_cart'),
                                                                        'onclick' => "list_addtocart($product_id)",
                                                                        'style' => 'background:none repeat scroll 0 0 #333333;border: 0 none;color:#FFFFFF;cursor:pointer;height:27px;font-size:12px;font-weight: bold;overflow:visible;padding: 3px 8px 5px;text-align:center'
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
                                                            </td>
                                                        </tr>    
                                                    </table>    
                                                </td>
                                            </tr>
                                        </table>
                                    </div>    
                                </td>
                                <?php
                                if ($i % $per_row == 0)
                                {
                                    echo '</tr><tr>';
                                }
                                $i++;
                            }
                            ?>
                        </tr>
                    </table>
                    <?php
                    echo form_hidden('page_number', "", "page_number");
                    echo form_hidden('per_page_result', "", "per_page_result");
                    echo form_hidden('product_id', '', 'product_id');
                    echo form_hidden('price', '', 'price');
                    echo form_hidden('pname', '', 'pname');
                    echo form_hidden('discount_price', '', 'discount_price');
                    echo form_hidden('currency_code', '', 'currency_code');
                    echo form_hidden('slug_url', '', 'slug_url');
                    echo form_hidden('product_image', '', 'product_image');
                    echo form_hidden('product_submit', '1', 'product_submit');
                    echo form_close();
                    ?>
                </div>        
                <div style="clear: both; height:10px;"></div>
                <?php
                $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash());
                if (isset($post_url))
                {
                    $post_url = $post_url;
                }
                else
                {
                    $post_url = base_url() . "/shoppingcart/products/" . $language_code;
                }

                $options = array(
                    'total_records' => $total_records,
                    'page_number' => $page_number,
                    'isAjaxRequest' => 1,
                    'base_url' => $post_url,
                    'params' => $querystr,
                    'element' => 'ajax_table'
                );
                widget('custom_pagination', $options);
            }
            else
            {
                ?>
                <span><?php echo lang('prd_no_records'); ?></span>
                <?php
            }
            ?>
        </div>
    </td>
</tr>