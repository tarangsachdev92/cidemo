
<div class="contentpanel">
    <div class="panel-header clearfix">
        <a class="add-link" onclick="openlink('add')" title="<?php echo lang('view_all_category'); ?>" href="javascript:;"><?php echo lang('view_all_category'); ?></a>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
       
            <h4 class="panel-title"><?php echo lang('add_form_fields') ?> - <?php echo $language_name; ?></h4>

        </div>

        <?php
        $attributes = array('class' => 'form-horizontal form-bordered bv-form', 'id' => 'categoryadd', 'name' => 'categoryadd');
        echo form_open(''.$this->section_name.'/categories/action/' . $action . "/" . $language_code . "/" . $id, $attributes);
        if ($action == "edit" && isset($category['slug_url']) && $category['slug_url'] != '')
           echo form_hidden('old_slug_url', $category['slug_url']);
       
?>

        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('parent_category'), 'parent_id'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                                            $options = array(
                                                'name' => 'parent_id',
                                                'id' => 'parent_id',
                                                'value' => (isset($category['parent_id'])) ? $category['parent_id'] : '',
                                                'language_id' => $language_id,
                                                'first_option' => lang('root'),
                                                
                                            );
                                            widget('category_dropdown', $options);
                                            ?>
                    <span class="warning-msg"><?php echo form_error('parent_id'); ?></span>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('module'), 'module'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                  
                                            echo form_dropdown('module_id', $category_module_list, (isset($category['module_id'])) ? $category['module_id'] : '' , 'class="form-control"'); ?>
                                       
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('title'), 'title'); ?><span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                                            $title_data = array(
                                                'name' => 'title',
                                                'id' => 'title',
                                                'value' => '',
                                               'class' => 'form-control',
                                                'value' => set_value('title', ((isset($category['title'])) ? $category['title'] : ''))
                                            );
                                            echo form_input($title_data);
                                            ?>
                                            <span class="warning-msg"><?php echo form_error('title'); ?></span>
<!--                        <textarea id="wysiwyg" placeholder="Enter text here..." class="form-control" rows="10"></textarea>-->
                </div>
            </div>

          

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('slug_url'), 'slug_url'); ?><span class="asterisk">*</span></label>
                <div class="col-sm-6">
                     <?php
                                            $slug_url_data = array(
                                                'name' => 'slug_url',
                                                'id' => 'slug_url',
                                                'value' => '',
                                                'class' => 'form-control',
                                                'value' => set_value('slug_url', ((isset($category['slug_url'])) ? $category['slug_url'] : ''))
                                            );
                                            echo form_input($slug_url_data);
                                            ?>
                                            <span class="warning-msg"><?php echo form_error('slug_url'); ?>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('description'), 'description'); ?></label>
                <div class="col-sm-6">
                   <?php
                                            $description_data = array(
                                                'name' => 'description',
                                                'id' => 'wysiwyg',
                                                 'size' => '50',
                                                 "class" => "form-control",
                                                'placeholder' => "Enter text here...",
                                                'rows' => 10,
                                                'value' => set_value('description', ((isset($category['description'])) ? $category['description'] : ''))
                                            );
                                            echo form_textarea($description_data);
                                            
                                            ?>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>


           
           

            <div class="form-group">
                <label class="col-sm-3 control-label"><label><?php echo form_label(lang('status'), 'status'); ?></label></label>
                <div class="col-sm-6">
                 <?php
                                            $options = array(
                                                '1' => lang('active'),
                                                '0' => lang('inactive')
                                            );
                                            echo form_dropdown('status', $options, (isset($category['status'])) ? $category['status'] : '', 'class="form-control"');
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
                        'name' => 'categorysubmit',
                        'id' => 'categorysubmit',
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
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/categories/index/' . $language_code) . "'",
                    );
                    echo "&nbsp; &nbsp; &nbsp;";
                    echo form_button($cancel_button);
                    ?>
                </div>
            </div>
        </div>
       
    </div>
     <?php echo form_close(); ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
  
     $('#parent_id').addClass('form-control');
   
});

</script>


