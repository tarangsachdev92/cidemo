<div class="contentpanel">
    <div class="panel-header clearfix">
        <?php echo anchor(site_url() . 'admin/products/index/', lang('Product_list'), 'title="' . lang('Product_list') . '" class="add-link" '); ?>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <?php
                if ($action == "edit")
                    echo lang('edit_form_fields');
                else
                    echo lang('add_form_fields')
                    ?>
            </h4>
        </div>

        <?php
        $attributes = array('class' => 'form-horizontal form-bordered', 'id' => 'add', 'name' => 'add');
        echo form_open_multipart($this->controller->section_name . '/products/action/' . $action . "/" . $language_code . "/" . $id, $attributes);

        if ($action == "edit" && isset($result[0]['p']['slug']) && $result[0]['p']['slug'] != '')
            echo form_hidden('old_slug_url', $result[0]['p']['slug']);

        $hdn = array(
            'type' => 'hidden',
            'value' => (isset($result[0]['p']['product_image'])) ? $result[0]['p']['product_image'] : ''
        );

        echo form_hidden('hdnphoto', (isset($result[0]['p']['product_image'])) ? $result[0]['p']['product_image'] : '');
        ?>

        <div class="panel-body panel-body-nopadding">
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('name'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $name_data = array(
                        'name' => 'name',
                        'id' => 'name',
                        'class' => 'form-control',
                        'value' => set_value('name', ((isset($result[0]['p']['name'])) ? $result[0]['p']['name'] : ((isset($result['name'])) ? $result['name'] : '')))
                    );
                    echo form_input($name_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('name'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('slug'); ?>
                </label>

                <div class="col-sm-6">
                    <?php
                    $slug_url_data = array(
                        'name' => 'slug',
                        'id' => 'slug',
                        'class' => 'form-control',
                        'value' => set_value('slug', ((isset($result[0]['p']['slug'])) ? $result[0]['p']['slug'] : ((isset($result['slug'])) ? $result['slug'] : '')))
                    );
                    echo form_input($slug_url_data);
                    ?>   
                    <span class="warning-msg"><?php echo form_error('slug'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('description'); ?></label>
                <div class="col-sm-9">
                    <?php
                    $slug_url_data = array(
                        'name' => 'description',
                        'id' => 'wysiwyg',
                        'size' => '50',
                        'class' => 'form-control',
                        'value' => set_value('description', ((isset($result[0]['p']['description'])) ? $result[0]['p']['description'] : ((isset($result['description'])) ? $result['description'] : '')))
                    );
                    echo form_textarea($slug_url_data);
                    ?>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('status'); ?></label>
                <div class="col-sm-6">

                    <?php
                    $options = array(
                        '1' => lang('active'),
                        '0' => lang('inactive')
                    );
                    echo form_dropdown('status', $options, ((isset($result[0]['p']['status'])) ? $result[0]['p']['status'] : ((isset($result['status'])) ? $result['status'] : '')), 'class="form-control"');
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('price'); ?>
                    <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                    $price_data = array(
                        'name' => 'price',
                        'id' => 'price',
                        'class' => 'form-control',
                        'value' => set_value('price', ((isset($result[0]['p']['price'])) ? $result[0]['p']['price'] : ((isset($result['price'])) ? $result['price'] : '')))
                    );
                    echo form_input($price_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('price'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('product_image'); ?>
                    <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                    $image_data = array(
                        'name' => 'product_image',
                        'id' => 'product_image',
                        'value' => '',
                    );
                    if (empty($result[0]['products']['product_image'])) {
                        $image_data['class'] = 'form-control';
                    } else {
                        $image_data['class'] = 'form-control';
                    }
                    echo form_upload($image_data);
                    ?>
                    <p class="text-primary"><?php echo lang('img_limit'); ?></p>
                    <span class="warning-msg"><?php echo form_error('product_image'); ?></span>
                </div>
            </div>

            <?php if (!empty($result[0]['p']['product_image']) && file_exists(FCPATH . "assets/uploads/products/thumbs/" . $result[0]['p']['product_image'])) {
                ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <img src="<?php echo base_url() . "assets/uploads/products/thumbs/" . $result[0]['p']['product_image'] ?>"  />
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="checkbox"><?php echo lang('featured'); ?>

                </label>
                <div class="col-sm-6">
                    <?php
                    $featured = array(
                        'name' => 'featured',
                        'id' => 'featured',
                        'value' => '1',
                        'value' => set_value('featured', ((isset($result[0]['p']['featured'])) ? $result[0]['p']['featured'] : ((isset($result['featured'])) ? $result['featured'] : '1')))
                    );
                    ?>
                    <div class="checkbox block"><label><input type="checkbox"> <?php echo form_checkbox('featured', '1', (isset($result[0]['p']['featured'])) ? TRUE : ((isset($result['featured'])) ? TRUE : FALSE), $extra = '');
                    ?></label></div>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('category'); ?>
                    <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                    $options = array(
                        'name' => 'category_id',
                        'id' => 'category_id',
                        'value' => ((isset($result[0]['p']['category_id'])) ? $result[0]['p']['category_id'] : ((isset($result['category_id'])) ? $result['category_id'] : '')),
                        'language_id' => $language_id,
                        'module_id' => PRODUCT_MODULE_NO
                    );
                    widget('category_dropdown', $options);
                    ?>         
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <h4>Meta Fields</h4>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('keywords'); ?>

                </label>
                <div class="col-sm-6">

                    <?php
                    $meta_keywords_data = array(
                        'name' => 'meta_keywords',
                        'id' => 'meta_keywords',
                        'class' => 'form-control',
                        'value' => set_value('meta_keywords', ((isset($result[0]['p']['meta_keywords'])) ? $result[0]['p']['meta_keywords'] : ((isset($result['meta_description'])) ? $result['meta_description'] : '')))
                    );
                    echo form_input($meta_keywords_data);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('description'); ?>

                </label>
                <div class="col-sm-6">
                    <?php
                    $meta_description_data = array(
                        'name' => 'meta_description',
                        'id' => 'meta_description',
                        'class' => 'form-control',
                        'value' => set_value('meta_description', ((isset($result[0]['p']['meta_description'])) ? $result[0]['p']['meta_description'] : ((isset($result['meta_description'])) ? $result['meta_description'] : '')))
                    );
                    echo form_textarea($meta_description_data);
                    ?>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                        'name' => 'submit',
                        'id' => 'submit',
                        'value' => lang('save'),
                        'title' => lang('save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; ' . lang('save')
                    );

                    echo form_button($submit_button);

                    $cancel_button = array(
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; ' . lang('cancel'),
                        'title' => lang('cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/products/index/' . $language_code) . "'",
                    );
                    echo "&nbsp; &nbsp; &nbsp;";
                    echo form_button($cancel_button);
                    ?>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>