<div class="contentpanel">
    <div class="panel-header clearfix">
        <a class="add-link" onclick="openlink('add')" title="<?php echo lang('view-all-blog'); ?>" href="javascript:;"><?php echo lang('view-all-blog'); ?></a>
     </div>

    <div class="panel panel-default">
        <div class="panel-heading">

            <h4 class="panel-title"><?php echo lang('add-edit-blog') ?> - <?php echo $language_name; ?></h4>

        </div>

        <?php
$attributes = array('class' => 'form-horizontal form-bordered bv-form','id' => 'blogadd', 'name' => 'blogadd');
echo form_open_multipart(get_current_section($this) . '/blog/action/' . $action . "/" . $language_code . "/" . $id, $attributes);
if ($action == "edit" && isset($blog['slug_url']) && $blog['slug_url'] != '')
    echo form_hidden('old_slug_url', $blog['slug_url']);
?>
        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('blog-title'), 'blogtitle'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                     <?php
                                    $id = ((isset($id)) ? $id : 0);
                                    $blogpost_id = ((isset($blogpost_id)) ? $blogpost_id : 0);
                                    ?>
                                    <?php
                                    $blogtitle_data = array(
                                        'name' => 'blogtitle',
                                        'id' => 'blogtitle',
                                        'value' => set_value('blogtitle', ((isset($blog['title'])) ? $blog['title'] : '')),
                                        'class' => 'form-control',
                                    );
                                    
                   echo form_input($blogtitle_data); ?><span class="warning-msg"><?php echo form_error('blogtitle'); ?></span>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('slug_url'), 'slug_url'); ?>
                   
                </label>

                <div class="col-sm-6">
                   <?php
                                    $slug_url_data = array(
                                        'name' => 'slug_url',
                                        'id' => 'slug_url',
                                        'value' => set_value('slug_url', ((isset($blog['slug_url'])) ? $blog['slug_url'] : '')),
                                        'class' => 'form-control',
                                    );
                                    
                    echo form_input($slug_url_data); ?>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('category'), 'Category'); ?>
                  <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                     <?php
                                            $options = array(
                                                'name' => 'category_id',
                                                'id' => 'category_id',
                                                'value' => (isset($blog['category_id'])) ? $blog['category_id'] : '',
                                                'language_id' => $language_id,
                                                'module_id' => '3',
                                            );
                                            widget('category_dropdown', $options);
                                            ?>
                                            <span class="warning-msg"><?php echo form_error('category_id'); ?></span>
                    
                </div>
            </div>

           

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('title'); ?>
                    <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                                    $blog_image_data = array(
                                        'name' => 'blog_image',
                                        'id' => 'blog_image',
                                        //'value' => set_value('blog_image', ((isset($blog_image)) ? $blog_image : '')),
                                        
                                        'class' => 'form-control',
                                    );
                                    ?>
                    <?php echo form_upload($blog_image_data); ?>
                                            <?php echo (isset($blog['blog_image']) && isset($id) && $id != 0) ? "<p><img style='width:50px;height:50px;padding:4px' alt='' src=" . base_url() . $blog['blog_image'] . "></p>" : '' ?>
                                            <span class="warning-msg"><?php echo form_error('blog_image'); ?></span>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('blog-text'); ?>
                    <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
             
                                            $blog_text_data = array(
                                                'name' => 'blog_text',
                                                'id' => 'wysiwyg',
                                                
                                                'class' => 'form-control',
                                                'value' => set_value('blog_text', ((isset($blog['blog_text'])) ? $blog['blog_text'] : '')),                                            );
                                            echo form_textarea($blog_text_data);
                                          
                                            ?>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

             <?php
                                    $view_permission_list = array('0' => 'Registered', '1' => 'All User');
                                    ?>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                   <?php echo form_label(lang('view-permission'), 'view_permission'); ?>
                                        <span class="asterisk">*</span>

                </label>
                <div class="col-sm-6">
                     <?php
                                            echo form_dropdown('view_permission', $view_permission_list, (isset($blog['view_permission'])?$blog['view_permission']:'') , 'class="form-control"');
                                            ?>
                                            <span class="warning-msg"><?php echo form_error('view_permission'); ?></span>
<!--                    <textarea class="form-control" rows="5"></textarea>-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('status'); ?>
                     <span class="asterisk">*</span>
                    </label>
                <div class="col-sm-6">

                   <?php
                                    $statuslist = array('0' => 'Inactive', '1' => 'Active', '-1' => 'Deleted');
                                    
                  
                                            echo form_dropdown('status', $statuslist, (isset($blog['status'])?$blog['status']:'') , 'class="form-control"');
                                            ?>

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
        'name' => 'mysubmit',
        'id' => 'mysubmit',
        'value' => lang('btn-save'),
        'class' => 'btn btn-primary',
        'type' => 'submit',
        'content' => '<i class="fa fa-save"></i> &nbsp; '.lang('btn-save')
    );
    echo form_button($submit_button);
    $cancel_button = array(
        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; '.lang('btn-cancel'),
        'title' => lang('btn-cancel'),
        'class' => 'btn btn-default',
        'onclick' => "location.href='" . site_url(get_current_section($this) . '/blog') . "'",
    );
    echo "&nbsp;";
    echo form_button($cancel_button);
    ?>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


