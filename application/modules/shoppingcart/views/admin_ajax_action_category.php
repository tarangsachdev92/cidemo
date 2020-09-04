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

$attributes = array('class' => '', 'id' => 'categoryadd', 'name' => 'categoryadd');
echo form_open_multipart('' . $this->section_name . '/shoppingcart/action_category/' . $action . "/" . $language_code . "/" . $id, $attributes);

if ($action == "edit" && isset($category['slug_url']) && $category['slug_url'] != '')
{
    echo form_hidden('old_slug_url', $category['slug_url']);
}
echo form_hidden('default_language', $default_language);
?>
<div class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <th><?php echo lang('add_form_fields') ?> - <?php echo $language_name; ?></th>
            </tr>
            <tr>
                <td class="add-user-form-box">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <?php
                                    if ($default_language == 1)
                                    {
                                        ?>
                                        <tr>
                                            <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('parent_category'), 'parent_id'); ?>:</td>
                                            <td>
                                                <?php
                                                $options = array("0" => "Root");
                                                $value = (isset($category['parent_id'])) ? $category['parent_id'] : 0;

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
                                                echo form_dropdown('parent_id', $options, $value);
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('parent_id'); ?></span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('title'), 'title'); ?>:</td>
                                        <td>
                                            <?php
                                            $title_data = array(
                                                'name' => 'title',
                                                'id' => 'title',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'class' => 'validate[required]',
                                                'value' => set_value('title', ((isset($category['title'])) ? $category['title'] : ''))
                                            );
                                            echo form_input($title_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('title'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('slug_url'), 'slug_url'); ?>:</td>
                                        <td>
                                            <?php
                                            $slug_url_data = array(
                                                'name' => 'slug_url',
                                                'id' => 'slug_url',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '50',
                                                'class' => 'validate[required]',
                                                'value' => set_value('slug_url', ((isset($category['slug_url'])) ? $category['slug_url'] : ''))
                                            );
                                            echo form_input($slug_url_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('slug_url'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('description'), 'description'); ?>:</td>
                                        <td>
                                            <?php
                                            $description_data = array(
                                                'name' => 'description',
                                                'id' => 'description',
                                                'value' => set_value('description', ((isset($category['description'])) ? $category['description'] : ''))
                                            );
                                            echo form_textarea($description_data);
                                            echo display_ckeditor($ckeditor);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($default_language == 1)
                                    {
                                        ?>
                                        <tr>
                                            <td align="right"><?php echo lang('category_image'); ?>:</td>
                                            <td>
                                                <?php
                                                $image_data = array(
                                                    'name' => 'category_image',
                                                    'id' => 'category_image',
                                                    'value' => ''
                                                );
                                                echo form_upload($image_data);
                                                ?>
                                                <br/><span class="warning-msg"><?php echo form_error('category_image'); ?>
                                            </td>
                                        </tr>
                                        <?php
                                        if (isset($category['category_image']) && isset($id) && $id != 0 && $category['category_image'] != '')
                                        {
                                            ?>
                                            <tr id="old_image">
                                                <td></td>
                                                <td>
                                                    <img src="<?php echo base_url() . "assets/uploads/shoppingcart/categories/thumbs/" . $category['category_image']; ?>"  />
                                                    <br />
                                                    <a href="javascript:void(0)" onclick="deleteShoppingCartCategoryImage('<?php echo $category['category_image']; ?>');">Delete</a>
                                                    <input type="hidden" name="category_old_image" id="category_old_image" value="<?php echo $category['category_image']; ?>"  />
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td align="right"></span><?php echo form_label(lang('meta_keywords'), 'meta_keywords'); ?>:</td>
                                        <td>
                                            <?php
                                            $meta_keywords_data = array(
                                                'name' => 'meta_keywords',
                                                'id' => 'meta_keywords',
                                                'value' => '',
                                                'size' => '50',
                                                'maxlength' => '255',
                                                'value' => set_value('meta_keywords', ((isset($category['meta_keywords'])) ? $category['meta_keywords'] : ''))
                                            );
                                            echo form_input($meta_keywords_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error('meta_keywords'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><?php echo form_label(lang('meta_description'), 'meta_description'); ?>:</td>
                                        <td>
                                            <?php
                                            $meta_description_data = array(
                                                'name' => 'meta_description',
                                                'id' => 'meta_description',
                                                'size' => '50',
                                                'cols' => '110',
                                                'value' => set_value('meta_description', ((isset($category['meta_description'])) ? $category['meta_description'] : ''))
                                            );
                                            echo form_textarea($meta_description_data);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($default_language == 1)
                                    {
                                        ?>
                                        <tr>
                                            <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('status'), 'status'); ?>:</td>
                                            <td>
                                                <?php
                                                $options = array(
                                                    '1' => lang('active'),
                                                    '0' => lang('inactive')
                                                );
                                                echo form_dropdown('status', $options, (isset($category['status'])) ? $category['status'] : '');
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
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
            'name' => 'categorysubmit',
            'id' => 'categorysubmit',
            'value' => lang('ci_action_save'),
            'title' => lang('ci_action_save'),
            'class' => 'inputbutton',
        );
        echo form_submit($submit_button);

        $cancel_button = array(
            'content' => lang('ci_action_cancel'),
            'title' => lang('ci_action_cancel'),
            'class' => 'inputbutton',
            'onclick' => 'history.go(-1)',
        );
        echo "&nbsp;";
        echo form_button($cancel_button);
        ?>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
                                                $(document).ready(function() {
                                                    $('#slug_url').slugify('#title');
                                                    jQuery("#categoryadd").validationEngine(
                                                            {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
                                                    );
                                                });

                                                function deleteShoppingCartCategoryImage(image_name)
                                                {
                                                    if (window.confirm('Are you sure you want to delete this image?', 'Delete the picture') == true)
                                                    {
                                                        blockUI();
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '<?php echo base_url() . $this->section_name; ?>/shoppingcart/action_category/deleteImage/<?php echo $language_code; ?>/<?php echo $id; ?>',
                                                            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', 'image_name': image_name},
                                                            error: function() {
                                                                alert("Server problem. Please try again.");
                                                                return false;
                                                            },
                                                            complete: function() {
                                                                unblockUI();
                                                            },
                                                            success: function() {
                                                                $("#old_image").hide();
                                                            }
                                                        });
                                                    }
                                                    return false;
                                                }
</script>