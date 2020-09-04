<div class="contentpanel">
    <div class="panel-header clearfix">
        <a class="add-link" title="<?php echo lang('page-title');?>" href="<?php echo site_url().get_current_section($this);?>/email_template/index/<?php echo $language_code;?>"><?php echo lang('page-title');?></a> 
        
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('add_form_fields'); ?> - <?php echo $language_name; ?></h4>
        </div>

        <?php
        $attributes = array('class' => 'form-horizontal form-bordered', 'id' => 'email_template_add', 'name' => 'email_template_add');
        echo form_open(get_current_section($this) . '/email_template/action/' . $action . "/" . $language_code . "/" . $id, $attributes);

        if ($action == "edit" && isset($template[0]['c']['template_name']) && $template[0]['c']['template_name'] != '')
            echo form_hidden('old_template_name', $template[0]['c']['template_name']);
        ?>

        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('template-name'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $title_data = array(
                        'name' => 'template_name',
                        'id' => 'template_name',
                        'size' => '50',
                        'maxlength' => '100',
                        'class' => 'form-control',
                        'value' => set_value('template_name', ((isset($template[0]['c']['template_name'])) ? $template[0]['c']['template_name'] : ''))
                    );
                    echo form_input($title_data);
                    ?>
                    <span class="validation_error"><?php echo form_error('template_name'); ?></span>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('template-subject'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $title_data = array(
                        'name' => 'template_subject',
                        'id' => 'template_subject',
                        'size' => '50',
                        'maxlength' => '100',
                        'class' => 'form-control',
                        'value' => set_value('template_subject', ((isset($template[0]['c']['template_subject'])) ? $template[0]['c']['template_subject'] : ''))
                    );
                    echo form_input($title_data);
                    ?>
                    <span class="validation_error"><?php echo form_error('template_subject'); ?></span>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('template-body'); ?></label>
                <div class="col-sm-9">
                    <?php
                    $template_body_data = array(
                        'name' => 'template_body',
                        'id' => 'template_body',
                        'size' => '50',
                        'maxlength' => '100',
                        'class' => 'form-control',
                        'value' => set_value('template_body', ((isset($template[0]['c']['template_body'])) ? $template[0]['c']['template_body'] : $template_body))
                    );
                    echo form_textarea($template_body_data);
                    ?>
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
                    echo form_dropdown('status', $options, (isset($template[0]['c']['status'])) ? $template[0]['c']['status'] : $status, 'class="form-control"');
                    ?>
                </div>
            </div>
        </div><!-- panel-body -->

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">                   
                    <?php
                    $submit_button = array(
                        'name' => 'email_template_submit',
                        'id' => 'email_template_submit',
                        'value' => lang('save'),
                        'title' => lang('save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; Save'
                    );
                    echo form_button($submit_button);
                    $cancel_button = array(
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; '.lang('cancel'),
                        'title' => lang('cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/email_template/index/' . $language_code) . "'"
                    );
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo form_button($cancel_button);
                    ?>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


