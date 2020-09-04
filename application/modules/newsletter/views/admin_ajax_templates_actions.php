<div class="contentpanel">
    <div class="panel-header clearfix">
        <?php echo anchor(site_url() . get_current_section($this) . '/newsletter/all_templates', lang('view_templates'), 'title="View Templates" class="add-link" '); ?>
    </div>
    <div class="panel-header clearfix">
        <a class="add-link" onclick="openlink('add')" title="<?php echo lang('cms_list'); ?>" href="javascript:;"><?php echo lang('cms_list'); ?></a>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <!--            <div class="panel-btns">
                            <a href="#" class="panel-close">&times;</a>
                            <a href="#" class="minimize">&minus;</a>
                        </div>-->
            <h4 class="panel-title"><?php echo lang('add_form_fields'); ?></h4>

        </div>

        <?php
       $attributes = array ('class' => 'form-horizontal form-bordered', 'id' => 'templates_actions', 'name' => 'templates_actions');
echo form_open (get_current_section ($this) . '/newsletter/templates_actions/' . $action . '/' . $language_code . '/' . $id, $attributes);
        ?>

        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('template-title'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $template_title_data = array(
                        'name' => 'template_title',
                        'id' => 'template_title',
                        'value' => set_value('template_title', ((isset($template[0]['tn']['template_title'])) ? $template[0]['tn']['template_title'] : '')),
                        'size' => '50',
                        'class' => 'form-control'
                    );
                    echo form_input($template_title_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('template_title'); ?></span>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('template-view-file'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $template_view_file_data = array(
                        'name' => 'template_view_file',
                        'id' => 'template_view_file',
                        'value' => set_value('template_view_file', ((isset($template[0]['tn']['template_view_file'])) ? $template[0]['tn']['template_view_file'] : '')),
                        'size' => '50',
                        'class' => 'form-control',
                    );
                    echo form_input($template_view_file_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('template_view_file'); ?></span>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
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
                        'name' => 'save',
                        'id' => 'save',
                        'value' => lang('btn-save'),
                        'title' => lang('btn-save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; ' . lang('btn-save')
                    );

                    echo form_button($submit_button);


                    $cancel_button = array(
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; ' . lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "history.go(-1)",
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

<script type="text/javascript">
    $(document).ready(function() {
         $('#templates_actions').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                template_title: {
                    message: 'The Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Title field is required.'
                        }
                    }   
                },
                template_view_file: {
                    message: 'The View file field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The View file field is required.'
                        }
                    }
                }
            }
        });
    });
</script>