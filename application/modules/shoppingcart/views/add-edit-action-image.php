<?php
$attributes = array('class' => '', 'id' => 'add', 'name' => 'add');
echo form_open_multipart(get_current_section($this) . '/shoppingcart/action_image/' . $action . "/" . $product_id . "/" . $id, $attributes);
if ($action == "edit" && isset($result[0]['product_images']['slug']) && $result[0]['product_images']['slug'] != '')
{
    echo form_hidden('old_slug_url', $result[0]['product_images']['slug']);
}
$hdn = array(
    'type' => 'hidden',
    'value' => (isset($result[0]['product_image'])) ? $result[0]['product_image'] : ''
);
echo form_hidden('hdnphoto', (isset($result[0]['product_image'])) ? $result[0]['product_image'] : '');
if (isset($result['0']['shoppingcart_products_image']))
{
    $product_image = $result['0']['shoppingcart_products_image'];
}
else
{
    $product_image = array();
}
?>
<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('add_form_fields'); ?> </th>
            </tr>
            <tr>
                <td class="add-user-form-box">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <tr>
                                        <td width="300" align="right"><span class="star">*&nbsp;</span><?php echo lang('product_image'); ?>:</td>

                                        <td>
                                            <?php
                                            $image_data = array(
                                                'name' => 'product_image',
                                                'id' => 'product_image',
                                                'value' => '',
                                                'value' => set_value('product_image', ((isset($product_image['product_image'])) ? $product_image['product_image'] : ''))
                                            );
                                            if (empty($product_image['product_image']))
                                            {
                                                $image_data['class'] = 'validate[required]';
                                            }
                                            else
                                            {
                                                $image_data['class'] = '';
                                            }
                                            echo form_upload($image_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('product_image'); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if (isset($product_image['product_image']) && isset($id) && $id != 0)
                                    {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <img src="<?php echo base_url() . "assets/uploads/shoppingcart/thumbs/" . $product_image['product_image']; ?>"  />
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo lang('status'); ?>:</td>
                                        <td>
                                            <?php
                                            $options = array(
                                                '1' => lang('active'),
                                                '0' => lang('inactive')
                                            );
                                            echo form_dropdown('status', $options, (isset($product_image['status'])) ? $product_image['status'] : '');
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('status'); ?>
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
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        $('#slug').slugify('#name');
        jQuery("#add").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );
    });
</script>