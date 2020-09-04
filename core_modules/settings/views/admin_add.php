
<div class="contentpanel">
    <div class="panel-header clearfix">
        <?php echo anchor(site_url() . get_current_section($this) . '/settings', lang('view-settings'), 'title="View All Users" class="add-link" '); ?>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">

            <h4 class="panel-title"><?php echo lang('add-edit-settings'); ?></h4>
        </div>
        <?php echo form_open(get_current_section($this) . "/settings/save", array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); ?>
        <div class="panel-body panel-body-nopadding">

            <form class="form-horizontal form-bordered">

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('setting-title'); ?><span class="asterisk">*</span></label>
                    <div class="col-sm-6">
                        <?php
                        $inputData = array(
                            'name' => 'setting_title',
                            'id' => 'setting_title',
                            'value' => set_value('setting_title', htmlspecialchars_decode($setting_title)),
                            'class' => "form-control",
                        );
                        echo form_input($inputData);
                        ?>
                        <span class="validation_error"><?php echo form_error('setting_title'); ?></span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('setting-label'); ?><span class="asterisk">*</span></label>
                    <div class="col-sm-6">
                        <?php
                        $inputData = array(
                            'name' => 'setting_label',
                            'id' => 'setting_label',
                            'value' => set_value('setting_label', htmlspecialchars_decode($setting_label)),
                            'class' => "form-control",
                        );
                        echo form_input($inputData);
                        ?>
                        <span class="validation_error"><?php echo form_error('setting_label'); ?></span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('setting-value'); ?><span class="asterisk">*</span></label>
                    <div class="col-sm-6">
                        <?php
                        $inputData = array(
                            'name' => 'setting_value',
                            'id' => 'setting_value',
                            'value' => set_value('setting_value', htmlspecialchars_decode($setting_value)),
                            'class' => "form-control",
                        );
                        echo form_input($inputData);
                        ?>
                        <span class="validation_error"><?php echo form_error('setting_value'); ?></span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('setting-comment'); ?></label>
                    <div class="col-sm-6">

                        <?php
                        $inputData = array(
                            'name' => 'comment',
                            'id' => 'comment',
                            'value' => set_value('comment', htmlspecialchars_decode($comment)),
                            'class' => "form-control",
                        );
                        echo form_input($inputData);
                        ?>
                    </div>
                </div>


        </div><!-- panel-body -->

        <div class="panel-footer">
            <div class="row">
                <input type="hidden" id="id" name="id" value ="<?php echo (isset($id)) ? $id : '0'; ?>" />
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                        'name' => 'saveSettings',
                        'id' => 'saveSettings',
                        'value' => lang('btn-save'),
                        'title' => lang('btn-save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; Save'
                    );
                    echo form_button($submit_button);

                    $cancel_button = array(
                        'name' => 'button',
                        'title' => lang('setting-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/settings') . "'",
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; Cancel'
                    );
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo form_button($cancel_button, lang('setting-cancel'));
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div><!-- panel-footer -->

    </div><!-- panel -->



</div><!-- contentpanel -->
<script type="text/javascript">

    $(document).ready(function() {

        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                setting_title: {
                    message: 'The Setting Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Setting Title field is required.'
                        }

                    }
                },
                setting_label: {
                    message: 'The Setting Label field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Setting Title field is required.'
                        }

                    }
                },
                setting_value: {
                    message: 'The Setting Value field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Setting Value field is required.'
                        }

                    }
                }
            }
        });

    });
</script>