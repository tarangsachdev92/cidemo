<div class="contentpanel">
    <div class="panel-header clearfix">
        <a class="add-link" onclick="openlink('add')" title="<?php echo lang('cms_list'); ?>" href="javascript:;"><?php echo lang('cms_list'); ?></a>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
<!--            <div class="panel-btns">
                <a href="#" class="panel-close">&times;</a>
                <a href="#" class="minimize">&minus;</a>
            </div>-->
            <h4 class="panel-title">Input Fields</h4>

        </div>

        <?php
        $attributes = array('class' => 'form-horizontal form-bordered bv-form', 'id' => 'cmsadd', 'name' => 'cmsadd');
        echo form_open($this->controller->section_name . '/cms/action/' . $action . "/" . $language_code . "/" . $id, $attributes);
        if ($action == "edit" && isset($cms['slug_url']) && $cms['slug_url'] != '')
            echo form_hidden('old_slug_url', $cms['slug_url']);
        ?>

        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('title'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $title_data = array(
                        'name' => 'title',
                        'id' => 'title',
                        'size' => '50',
                        'class' => 'form-control',
                        'value' => set_value('title', ((isset($cms['title'])) ? $cms['title'] : ''))
                    );
                    echo form_input($title_data);
                    ?>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('slug_url'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $slug_url_data = array(
                        'name' => 'slug_url',
                        'id' => 'slug_url',
                        'size' => '50',
                        'maxlength' => '50',
                        'class' => 'form-control',
                        'value' => set_value('slug_url', ((isset($cms['slug_url'])) ? $cms['slug_url'] : ''))
                    );
                    echo form_input($slug_url_data);
                    ?>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
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
                        "class" => "form-control",
                        'placeholder' => "Enter text here...",
                        'rows' => 10,
                        'value' => set_value('description', ((isset($cms['description'])) ? $cms['description'] : ''))
                    );
                    echo form_textarea($slug_url_data);
                    ?>
<!--                        <textarea id="wysiwyg" placeholder="Enter text here..." class="form-control" rows="10"></textarea>-->
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <h4>Meta Fields</h4>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('title'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $meta_title_data = array(
                        'name' => 'meta_title',
                        'id' => 'meta_title',
                        'size' => '50',
                        'maxlength' => '255',
                        "class" => "form-control",
                        'value' => set_value('meta_title', ((isset($cms['meta_title'])) ? $cms['meta_title'] : ''))
                    );
                    echo form_input($meta_title_data);
                    ?>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('keywords'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $meta_keywords_data = array(
                        'name' => 'meta_keywords',
                        'id' => 'meta_keywords',
                        'size' => '50',
                        'maxlength' => '255',
                        'class' => 'form-control',
                        'value' => set_value('meta_keywords', ((isset($cms['meta_keywords'])) ? $cms['meta_keywords'] : ''))
                    );
                    echo form_input($meta_keywords_data);
                    ?>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <?php echo lang('description'); ?>
                </label>
                <div class="col-sm-6">
                    <?php
                    $meta_description_data = array(
                        'name' => 'meta_description',
                        'id' => 'meta_description',
                        'size' => '50',
                        'class' => 'form-control',
                        'rows' => 5,
                        'value' => set_value('meta_description', ((isset($cms['meta_description'])) ? $cms['meta_description'] : ''))
                    );
                    echo form_textarea($meta_description_data);
                    ?>
<!--                    <textarea class="form-control" rows="5"></textarea>-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><label><?php echo lang('status'); ?></label></label>
                <div class="col-sm-6">

                    <?php
                    $options = array(
                        '1' => lang('active'),
                        '0' => lang('inactive')
                    );
                    echo form_dropdown('status', $options, (isset($cms['status'])) ? $cms['status'] : '', 'class="form-control"');
                    ?>

<!--                    <select class="form-control" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>                -->
                </div>
            </div>
        </div><!-- panel-body -->

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
<!--                    <button class="btn btn-primary">Submit</button>&nbsp;
                    <button class="btn btn-default">Cancel</button>-->
                    <?php
                    $submit_button = array(
                        'name' => 'cmssubmit',
                        'id' => 'cmssubmit',
                        'value' => lang('save'),
                        'title' => lang('save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; '.lang('save')
                    );
                    echo form_button($submit_button);
                    $cancel_button = array(
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; '.lang('cancel'),
                        'title' => lang('cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/cms/index/' . $language_code) . "'",
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


