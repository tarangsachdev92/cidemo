<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<?php
echo add_css(array('modules/shoppingcart/shoppingcart'));
echo add_css(array('modules/shoppingcart/cloud-zoom'));
echo add_js(array('modules/shoppingcart/cloud-zoom.1.0.2'));
echo add_js(array('modules/shoppingcart/shoppingcart'));
$image_path = site_base_url() . 'assets/uploads/shoppingcart/';
$user_id = 0;

if (isset($frontuserdata['user_id']))
{
    if ($frontuserdata['user_id'] != 0)
    {
        $user_id = $frontuserdata['user_id'];
    }
}
?>
<tr class="content">
    <td>
        <?php
        if (count($single_record))
        {
            $attributes = array("name" => "shopping_product", "id" => "shopping_product");
            echo form_open('shoppingcart/addtocart', $attributes);
            $product_id = $single_record['scp']['product_id'];
            ?>
            <div style="float:right; padding:0 0 0px 0px;">
                <a href="javascript:window.history.back();"><?php echo lang('back_to_prd'); ?></a>
            </div>
            <br>
            <table cellspacing="2" cellpadding="2" style="box-shadow:0px 0 3px 0px #CCCCCC;"  width="100%" border="1">
                <tr>
                    <td class="content" valign="middel" width="40%" align="center" >
                        <?php
                        if ($single_record['scp']['product_image'] != '')
                        {
                            if (file_exists('assets/uploads/shoppingcart/medium/' . $single_record['scp']['product_image']))
                            {
                                ?>
                                <div id="wrap" style="text-align:center;" >
                                    <a href='<?php echo $image_path . 'main/' . $single_record['scp']['product_image']; ?>' class = 'cloud-zoom' id='zoom1' rel="adjustX: 300, adjustY:230, softFocus:true">
                                        <img src="<?php echo $image_path . 'medium/' . $single_record['scp']['product_image']; ?>" alt='' align="left" title="<?php echo ucwords($single_record['scp']['name']); ?>"   />
                                    </a>
                                </div>
                                <!--<img src="<?php echo $image_path . 'medium/' . $single_record['scp']['product_image']; ?>" border="0" >-->
                                <?php
                            }
                        }
                        ?>

                        <br />

                        <div style="clear:both;"></div>
                        <div style="float:left;">
                            <a href='<?php echo $image_path . 'main/' . $single_record['scp']['product_image']; ?>' class='cloud-zoom-gallery' title='Thumbnail 1' rel="useZoom: 'zoom1', smallImage: '<?php echo $image_path . 'medium/' . $single_record['scp']['product_image']; ?>' ">
                                <img src="<?php echo $image_path . 'thumbs/' . $single_record['scp']['product_image']; ?>" alt = "Thumbnail 1" style="border:1px solid #808080;"/>
                            </a>

                            <?php
                            if (count($product_gallery_images) > 0)
                            {
                                foreach ($product_gallery_images as $product_gallery_image)
                                {
                                    //pr($product_gallery_image);
                                    ?>
                                    <a href='<?php echo $image_path . 'gallery/main/' . $product_gallery_image['scpi']['product_image']; ?>' class='cloud-zoom-gallery' title='Thumbnail 1' rel="useZoom: 'zoom1', smallImage: '<?php echo $image_path . 'gallery/medium/' . $product_gallery_image['scpi']['product_image']; ?>' ">
                                        <img src="<?php echo $image_path . 'gallery/thumbs/' . $product_gallery_image['scpi']['product_image']; ?>" alt = "Thumbnail 1"/>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </td>
                    <td align="left" valign="top" width="60%">
                        <h2><?php echo ucwords($single_record['scp']['name']); ?></h2>
                        <?php
                        $discount_price = 0;
                        $del_start_tag = '';
                        $del_end_tag = '';

                        if ($single_record['scp']['discount_price'] > 0)
                        {
                            $discount_price = 1;
                            $del_start_tag = '<del>';
                            $del_end_tag = '</del>';
                        }
                        ?>
                        <table>
                            <tr>
                                <td>
                                    <b><?php echo lang('availability'); ?>:</b>
                                    <?php
                                    if ($single_record['scp']['stock'] > 0)
                                    {
                                        echo '<span class="green"><b>' . lang('in_stock') . '</b></span>';
                                    }
                                    else
                                    {
                                        echo '<span class="red"><b>' . lang('out_stock') . '</b></span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo '<b>' . lang('our_price') . ': </b>' . $del_start_tag . $single_record['scp']['price'] . '&nbsp;' . $single_record['scp']['currency_code'] . $del_end_tag; ?>
                                </td>
                            </tr>
                            <?php
                            if ($discount_price == 1)
                            {
                                ?>
                                <tr>
                                    <td>
                                        <b><?php echo lang('discount_price'); ?> :</b><?php echo $single_record['scp']['discount_price'] . '&nbsp;' . $single_record['scp']['currency_code']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <br />
                        <?php
                        if ($single_record['scp']['stock'] > 0)
                        {
                            $addtocart_submit = array(
                                'name' => 'product_submit',
                                'id' => 'product_submit',
                                'value' => lang('add_to_cart'),
                                'title' => lang('add_to_cart'),
                                'class' => 'inputbutton',
                                'onclick' => "product_addtocart($product_id,'shopping_product')",
                                'style' => 'background:none repeat scroll 0 0 #333333;border: 0 none;color:#FFFFFF;cursor:pointer;height:27px;font-size:12px;font-weight: bold;overflow:visible;padding: 3px 8px 5px;text-align:center'
                            );
                            echo '&nbsp;&nbsp;' . form_submit($addtocart_submit);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2">
                        <b><?php echo lang('description'); ?> :</b><br>
                        <?php echo $single_record['scp']['description']; ?>
                    </td>
                </tr>
            </table>
            <?php
            echo form_hidden('product_id', $single_record['scp']['product_id']);
            echo form_hidden('slug_url', $single_record['scp']['slug_url']);
            echo form_hidden('product_image', $single_record['scp']['product_image']);

            if ($discount_price == 1)
            {
                echo form_hidden('price', $single_record['scp']['discount_price']);
            }
            else
            {
                echo form_hidden('price', $single_record['scp']['price']);
            }

            echo form_hidden('pname', $single_record['scp']['name']);
            echo form_hidden('discount_price', $single_record['scp']['discount_price']);
            echo form_hidden('currency_code', CURRENCY_CODE);
            echo form_close();
        }
        else
        {
            ?>
            <span><?php echo lang('prd-no-records'); ?></span>
            <?php
        }
        ?>
    </td>
</tr>
<!-- # Related Products -->
<?php
if (count($related_prddata) != 0)
{
    //$image_path = site_base_url() . 'assets/uploads/shoppingcart/';
    ?>
    <tr class="content">
        <td>
            <?php
            $attributes = array("name" => "shopping_featureproduct", "id" => "shopping_featureproduct");
            echo form_open('shoppingcart/addtocart', $attributes);
            ?>
            <div id="ajax_table">
                <div class="grid-data grid-data-table">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <h3><?php echo lang('prds_related'); ?></h3>
                            </td>
                        </tr>
                        <tr>
                            <?php
                            foreach ($related_prddata AS $allrecord)
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
                                    <div  style="box-shadow:2px 0px 4px 1px #CCCCCC;">
                                        <table>
                                            <tr>
                                                <td align="center">
                                                    <a href="<?php echo $product_detail_link; ?>" style="text-decoration:none;"><?php echo $allrecord['scp']['name']; ?> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <div class="prdimg_div" style="width:190px;height:170px;">
                                                        <?php
                                                        $product_image = 'no_image.jpg';
                                                        if ($allrecord['scp']['product_image'] != '')
                                                        {
                                                            if (file_exists(FCPATH . 'assets/uploads/shoppingcart/medium/' . $allrecord['scp']['product_image']))
                                                            {
                                                                $product_image = 'medium/' . $allrecord['scp']['product_image'];
                                                            }
                                                        }
                                                        ?>
                                                        <a href="<?php echo $product_detail_link; ?>">
                                                            <img src="<?php echo $image_path . $product_image; ?>" border="0" width="168px;" height="130px" >
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $rdiscount_price = 0;
                                            $rdel_start_tag = '';
                                            $rdel_end_tag = '';

                                            if ($allrecord['scp']['discount_price'] > 0)
                                            {
                                                $rdiscount_price = 1;
                                                $rdel_start_tag = '<del>';
                                                $rdel_end_tag = '</del>';
                                            }
                                            ?>
                                            <tr>
                                                <td align="right">
                                                    <b>
                                                        <?php
                                                        echo $rdel_start_tag . $allrecord['scp']['price'] . '&nbsp;' . $allrecord['scp']['currency_code'] . $rdel_end_tag;

                                                        if ($rdiscount_price == 1)
                                                        {
                                                            echo '&nbsp; &nbsp; ' . $allrecord['scp']['discount_price'] . '&nbsp;' . $allrecord['scp']['currency_code'];
                                                        }
                                                        ?>
                                                    </b>
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
                                                                $addtocart_submit = array(
                                                                    'name' => 'product_submit',
                                                                    'value' => lang('add_to_cart'),
                                                                    'id' => 'product_submit',
                                                                    'title' => lang('add_to_cart'),
                                                                    'class' => 'inputbutton',
                                                                    'content' => lang('add_to_cart'),
                                                                    'onclick' => "product_addtocart($product_id,'shopping_featureproduct')",
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
                                                                echo form_hidden('lslug_url' . $product_id, $allrecord['scp']['slug_url'], 'lslug_url' . $product_id);
                                                                echo form_hidden('lproduct_image' . $product_id, $allrecord['scp']['product_image'], 'lproduct_image' . $product_id);
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
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <?php
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
        </td>
    </tr>
    <tr>
        <td style="clear:both;"></td>
    </tr>
    <?php
}
?>
