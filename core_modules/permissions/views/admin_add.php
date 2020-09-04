<div class="contentpanel">
    <div class="panel-header clearfix">
        <?php echo anchor(site_url() . get_current_section($this) . '/permissions', lang('view-all-permission'), 'title="View All Permissions" class="add-link" '); ?>

    </div>
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('add-edit-permission') ?></h4>
        </div>

        <?php echo form_open_multipart(get_current_section($this) . '/permissions/save/', array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); ?>
        <div class="panel-body panel-body-nopadding" style="display: block;">

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('permission-label'), 'permission_label'); ?>  <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $permission_lable_data = array(
                        'name' => 'permission_label',
                        'id' => 'permission_label',
                        'value' => set_value('permission_label', ((isset($permission_label)) ? $permission_label : '')),
                        'class' => 'form-control',
                        'maxlength' => '250'
                    );
                    ?>
                    <?php echo form_input($permission_lable_data); ?>
                    <span class="validation_error"><?php echo form_error('permission_label'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('permission-title'), 'permission-title'); ?>  <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $permission_title_data = array(
                        'name' => 'permission_title',
                        'id' => 'permission_title',
                        'value' => set_value('permission_title', ((isset($permission_title)) ? $permission_title : '')),
                        'class' => 'form-control',
                        'maxlength' => '250'
                    );
                    ?>
                    <?php echo form_input($permission_title_data); ?>
                    <span class="validation_error"><?php echo form_error('permission_title'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('parent')); ?></label>
                <div class="col-sm-6">

                    <?php
                    echo form_dropdown('parent_id', $parent_list, ((isset($parent_id)) ? $parent_id : ''), ' class="form-control"');
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('status')); ?></label>
                <div class="col-sm-6">

                    <?php
                    $statuslist = array('1' => 'Active', '0' => 'Inactive');


                    echo form_dropdown('status', $statuslist, $status, ' class="form-control"');
                    ?>
                </div>
            </div>
        </div>

        <div class="panel-footer" style="display: block;">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                        'name' => 'mysubmit',
                        'id' => 'mysubmit',
                        'value' => lang('btn-save'),
                        'title' => lang('btn-save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; Save'
                    );
                    echo form_button($submit_button);
                    ?>
                    <!--                        <button class="btn btn-primary">Submit</button>-->
                    &nbsp;
                    <?php
                    $cancel_button = array(
                        'name' => 'cancel',
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; Cancel',
                        'value' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/permissions') . "'",
                    );
                    echo "&nbsp;";
                    echo form_button($cancel_button);
                    ?>
                    <!--                        <button class="btn btn-default">Cancel</button>-->
                </div>
            </div>
        </div>

        <?php
        echo form_hidden('id', (isset($id)) ? $id : '0' );
        echo form_close();
        ?>

    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        jQuery("#permission_label").focus();

        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                permission_label: {
                    message: 'The Permission Label is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The Permission Label is required.'
                        }
                    }
                },
                permission_title: {
                    validators: {
                        notEmpty: {
                            message: 'The Permission Title is required.'
                        }
                    }
                }
            }
        });

    });
</script>



