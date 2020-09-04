<?php
$ckeditor = array(
    //ID of the textarea that will be replaced
    'id' => 'description',
    'path' => 'assets/ckeditor',
    //Optionnal values
    'config' => array(
        'toolbar' => "Full", //Using the Full toolbar
        'width' => "550px", //Setting a custom width
        'height' => '100px', //Setting a custom height
    ),
);
$attributes = array('class' => '', 'id' => 'add', 'name' => 'add');
echo form_open_multipart(get_current_section($this) . '/shoppingcart/action/' . $action . "/" . $language_code . "/" . $id, $attributes);
if ($action == "edit" && isset($result[0]['products']['slug_url']) && $result[0]['products']['slug_url'] != '')
{
    echo form_hidden('old_slug_url', $result[0]['products']['slug_url']);
}


echo form_hidden('default_language', $default_language);
?>
<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('add_form_fields'); ?> - <?php echo $language_name; ?></th>
            </tr>
            <tr>
                <td class="add-user-form-box">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <tr>
                                        <td width="300" align="right"><span class="star">*&nbsp;</span><?php echo lang('name'); ?>:</td>
                                        <td>
                                            <?php
                                            $name_data = array(
                                                'name' => 'name',
                                                'id' => 'name',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'class' => 'validate[required]',
                                                'value' => set_value('name', isset($result[0]['products']['name']) ? $result[0]['products']['name'] : '')
                                            );
                                            echo form_input($name_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('title'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo lang('slug'); ?>:</td>
                                        <td>
                                            <?php
                                            $slug_url_data = array(
                                                'name' => 'slug_url',
                                                'id' => 'slug_url',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '50',
                                                'class' => 'validate[required]',
                                                'value' => set_value('slug_url', isset($result[0]['products']['slug_url']) ? $result[0]['products']['slug_url'] : '')
                                            );
                                            echo form_input($slug_url_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('slug_url'); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($default_language == 1)
                                    {
                                        ?>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('category'); ?>:</td>
                                            <td>
                                                <?php
                                                $options = array();
                                                $value = (isset($result[0]['products']['category_id'])) ? $result[0]['products']['category_id'] : 0;

                                                if (!empty($category_data))
                                                {
                                                    foreach ($category_data as $cat_ids)
                                                    {
                                                        $cat_data = explode("=>", $cat_ids);
                                                        if (isset($cat_data[0]) && isset($cat_data[1]))
                                                        {
                                                            $temp_array = array();
                                                            $temp_array = array($cat_data[0] => $cat_data[1]);
                                                            $options = $options + $temp_array;
                                                        }
                                                    }
                                                }

                                                echo form_dropdown('category_id', $options, $value);
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('category_id'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><span class="star">*&nbsp;</span><?php echo lang('price'); ?>:</td>
                                            <td>
                                                <?php
                                                $price_data = array(
                                                    'name' => 'price',
                                                    'id' => 'price',
                                                    'size' => '15',
                                                    'maxlength' => '255',
                                                    'class' => 'validate[required]',
                                                    'value' => set_value('price', isset($result[0]['products']['price']) ? $result[0]['products']['price'] : '')
                                                );
                                                echo form_input($price_data) . '&nbsp;' . CURRENCY_CODE;
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('price'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('discount_price'); ?>:</td>
                                            <td>
                                                <?php
                                                $price_data = array(
                                                    'name' => 'discount_price',
                                                    'id' => 'discount_price',
                                                    'size' => '15',
                                                    'maxlength' => '255',
                                                    'value' => set_value('discount_price', ((isset($result[0]['products']['discount_price'])) ? $result[0]['products']['discount_price'] : ''))
                                                );
                                                echo form_input($price_data) . '&nbsp;' . CURRENCY_CODE;
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('discount_price'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><span class="star">*&nbsp;</span><?php echo lang('stock'); ?>:</td>
                                            <td>
                                                <?php
                                                $stock_data = array(
                                                    'name' => 'stock',
                                                    'id' => 'stock',
                                                    'size' => '15',
                                                    'maxlength' => '255',
                                                    'class' => 'validate[required,custom[number]]',
                                                    'value' => set_value('stock', ((isset($result[0]['products']['stock'])) ? $result[0]['products']['stock'] : ''))
                                                );
                                                echo form_input($stock_data);
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('title'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right" valign="top"><span class="star">*&nbsp;</span><?php echo lang('image'); ?>:</td>
                                            <td>
                                                <?php
                                                if (isset($result[0]['products']['product_image']) && $result[0]['products']['product_image'] != '')
                                                {
                                                    $image_class = '';
                                                    $image_path = site_url() . 'assets/uploads/shoppingcart/thumbs/';
                                                }
                                                else
                                                {
                                                    $image_class = 'validate[required]';
                                                }
                                                $upload_data = array(
                                                    'name' => 'product_image',
                                                    'id' => 'product_image',
                                                    'class' => $image_class
                                                );
                                                echo form_upload($upload_data);
                                                 echo '&nbsp; ' . lang('image_min_size');

                                                if (isset($result[0]['products']['product_image']) && $result[0]['products']['product_image'] != '')
                                                {
                                                    echo '<br><img src="' . $image_path . $result[0]['products']['product_image'] . '">';
                                                }
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('title'); ?></span>
                                                <br /><center style="color:red; float:left;"><?php echo $message; ?></center>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td align="right" valign="top"></span><?php echo lang('description'); ?>:</td>
                                        <td>
                                            <?php
                                            $slug_url_data = array(
                                                'name' => 'description',
                                                'id' => 'description',
                                                'size' => '50',
                                                'value' => set_value('description', ((isset($result[0]['products']['description'])) ? $result[0]['products']['description'] : ''))
                                            );
                                            echo form_textarea($slug_url_data);
                                            echo display_ckeditor($ckeditor);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($default_language == 1)
                                    {
                                        ?>
                                        <tr>
                                            <td align="right"><span class="star">*&nbsp;</span><?php echo lang('status'); ?>:</td>
                                            <td>
                                                <?php
                                                $options = array(
                                                    '1' => lang('active'),
                                                    '0' => lang('inactive')
                                                );
                                                echo form_dropdown('status', $options, (isset($result[0]['products']['status'])) ? $result[0]['products']['status'] : '');
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('featured'); ?>:</td>
                                            <td>
                                                <?php
                                                $featured = array(
                                                    'name' => 'featured',
                                                    'id' => 'featured',
                                                    'value' => '1',
                                                    'value' => set_value('featured', ((isset($result[0]['products']['featured'])) ? $result[0]['products']['featured'] : ''))
                                                );
                                                echo form_checkbox('featured', '1', (isset($result[0]['products']['featured'])) ? TRUE : FALSE, $extra = '');
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('title'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="300" align="right"><?php echo lang('related_products'); ?>:</td>
                                            <td><?php echo form_multiselect('related_prdid[]', $rprd_multidropdown, $rprd_selectdata); ?>
                                                <br/><span class="warning-msg"><?php echo form_error('title'); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td align="right"><strong><?php echo lang('meta_fields'); ?></strong></td>
                                        <td>&nbsp; </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><span class="star"></span><?php echo lang('keywords'); ?>:</td>
                                        <td>
                                            <?php
                                            $meta_keywords_data = array(
                                                'name' => 'meta_keywords',
                                                'id' => 'meta_keywords',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'value' => set_value('meta_keywords', ((isset($result[0]['products']['meta_keywords'])) ? $result[0]['products']['meta_keywords'] : ''))
                                            );
                                            echo form_input($meta_keywords_data);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><span class="star"></span><?php echo lang('description'); ?>:</td>
                                        <td>
                                            <?php
                                            $meta_description_data = array(
                                                'name' => 'meta_description',
                                                'id' => 'meta_description',
                                                'size' => '50',
                                                'value' => set_value('meta_description', ((isset($result[0]['products']['meta_description'])) ? $result[0]['products']['meta_description'] : ''))
                                            );
                                            echo form_textarea($meta_description_data);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="submit-btns clearfix">
        <?php
        $submit_button = array(
            'name' => 'submit',
            'id' => 'submit',
            'value' => lang('btn_save'),
            'title' => lang('btn_save'),
            'class' => 'inputbutton',
        );
        echo form_submit($submit_button);
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
<?php
echo form_hidden('old_product_image', (isset($result[0]['products']['product_image'])) ? $result[0]['products']['product_image'] : '' );
echo form_hidden('currency_code', CURRENCY_CODE);
?>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        $('#slug_url').slugify('#name');

        jQuery("#add").validationEngine(
                {
                    promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"
                }
        );
    });
</script>