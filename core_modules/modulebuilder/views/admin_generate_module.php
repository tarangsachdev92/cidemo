<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('generate-module') ?></h4>
            <p><?php echo lang('notice'); ?> : [ <?php echo lang('id-field-notice'); ?> ]</p>
        </div>

        <?php echo form_open_multipart(get_current_section($this) . '/modulebuilder/generate_module', array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); ?>
        <div class="panel-body panel-body-nopadding">
            <div class="form-group option-dropdown">
                <label class="col-sm-3 control-label">
                    <label><?php echo lang('select-fields'); ?></label>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $field_number_data = array(
                        '' => 'Select',
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '5' => '5',
                        '6' => '6',
                        '8' => '8',
                        '10' => '10',
                        '15' => '15',
                        '20' => '20'
                    );

                    echo form_dropdown('count', $field_number_data, ((isset($field_number)) ? $field_number : ''), 'id="field_number" class = "form-control" ');
                    ?>
                    <span class="warning-msg"><?php echo form_error('field_type'); ?></span>
                </div>
            </div>

            <div class="form-group option-text">

                <label class="col-sm-3 control-label">
                    <label><?php echo lang('select-fields'); ?></label>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">

                    <?php
                    $field_text_data = array(
                        'name' => 'count',
                        'id' => 'count',
                        'value' => set_value('count', ((isset($count)) ? $count : '')),
                        'class' => 'form-control'
                    );

                    echo form_input($field_text_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('count'); ?></span>
                </div>
            </div>

        </div><!-- panel-body -->

        <div class="panel-footer option-dropdown">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">

                    <?php
                    $cancel_button = array(
                        'content' => '<i class = "fa fa-pencil" ></i> &nbsp; ' . lang('change'),
                        'title' => lang('change'),
                        'class' => 'btn btn-default',
                        'onclick' => "hide_dropdown()",
                    );

                    echo form_button($cancel_button);
                    ?>
                </div>
            </div>
        </div>

        <div class="panel-footer option-text">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">

                    <?php
                    $submit_button = array(
                        'name' => 'mysubmit',
                        'id' => 'mysubmit',
                        'value' => lang('btn-save'),
                        'title' => lang('btn-save'),
                        'class' => 'btn btn-primary',
                        'content' => '<i class = "fa fa-save" ></i> &nbsp; ' . lang('btn-save'),
                        'type' => 'submit'
                    );
                    
                    echo form_button($submit_button)."&nbsp;&nbsp;&nbsp;";

                    $cancel_button = array(
                        'content' => '<i class = "fa fa-pencil" ></i> &nbsp; ' . lang('change'),
                        'title' => lang('change'),
                        'class' => 'btn btn-default',
                        'onclick' => "hide_text()",
                    );

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
        $('.option-text').hide();
        
        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                count: {
                    message: 'The Fields is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Fields is required.'
                        }
                    }
                }
            }
        });
    });

    $('#field_number').change(function() {
        window.location = "<?php echo base_url() . get_current_section($this); ?>/modulebuilder/add/" + $(this).val();
    });

    function hide_text()
    {
        $('.option-text').hide();
        $('.option-dropdown').show();
    }
    function hide_dropdown()
    {
        $('.option-dropdown').hide();
        $('.option-text').show();
    }
</script>


