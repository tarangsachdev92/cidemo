<?php echo form_open_multipart(get_current_section($this) . '/modulebuilder/add/' . $count, array('id' => 'saveform', 'name' => 'saveform', "class" => "form-horizontal form-bordered")); ?>   
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('generate-module') ?></h4>
        </div>
        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <label><?php echo lang('module-name'); ?></label>  <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                    $module_data = array(
                        'name' => 'module_name',
                        'id' => 'module_name',
                        'value' => set_value('module_name', ((isset($module_name)) ? $module_name : '')),
                        'class' => 'form-control'
                    );
                    echo form_input($module_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('module_name'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <label><?php echo lang('controller-name'); ?></label> 
<!--                    <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">

                    <?php
                    $controller_data = array(
                        'name' => 'controller_name',
                        'id' => 'controller_name',
                        'value' => set_value('controller_name', ((isset($controller_name)) ? $controller_name : '')),
                        'readonly' => 'readonly',
                        'class' => 'form-control'
                    );
                    echo form_input($controller_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('controller_name'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <label><?php echo lang('model-name'); ?></label> 
<!--                    <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">
                    <?php
                    $model_data = array(
                        'name' => 'model_name',
                        'id' => 'model_name',
                        'value' => set_value('model_name', ((isset($model_name)) ? $model_name : '')),
                        'readonly' => 'readonly',
                        'class' => 'form-control'
                    );
                    echo form_input($model_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('model_name'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <label><?php echo lang('table-name'); ?></label> 
                    <span class="asterisk">*</span></label>

                <div class="col-sm-6">
                    <?php
                    $table_data = array(
                        'name' => 'table_name',
                        'id' => 'table_name',
                        'value' => set_value('table_name', ((isset($table_name)) ? $table_name : '')),
                        'class' => 'form-control'
                    );
                    echo form_input($table_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('table_name'); ?></span>
                </div>
            </div>


        </div>


    </div>

    <?php
    for ($i = 1; $i <= $count; $i++) {
        if ($i % 2 == 1) {
            ?>
            <div class="row">
            <?php } ?>

            <div class="col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">

                        <h4 class="panel-title"><?php echo lang('field-details') . " - " . $i; ?></h4>

                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo lang('label'); ?> <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
    <!--                                    <input type="text" required="" placeholder="Type your name..." class="form-control" name="name">-->
                                <?php
                                $field_label_data = array(
                                    'name' => 'field_label' . $i,
                                    'id' => 'field_label' . $i,
                                    'value' => set_value('field_label' . $i, ((isset($field_label{$i})) ? $field_label{$i} : '')),
                                    'class' => 'form-control'
                                );

                                echo form_input($field_label_data);
                                ?>
                                <span class="warning-msg"><?php echo form_error("field_label{$i}"); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo lang('name'); ?>
                                <span class="asterisk">*</span></label>
                            <div class="col-sm-9">

                                <?php
                                $field_name_data = array(
                                    'name' => 'field_name' . $i,
                                    'id' => 'field_name' . $i,
                                    'value' => set_value('field_label' . $i, ((isset($field_name{$i})) ? $field_name{$i} : '')),
                                    'class' => 'form-control'
                                );
                                echo form_input($field_name_data);
                                ?>
                                <span class="warning-msg"><?php echo form_error("field_name{$i}"); ?></span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo lang('type') ?>
                            </label>
                            <div class="col-sm-9">
                                <?php
                                $field_type_data = array(
                                    'input' => 'INPUT',
                                    'textarea' => 'TEXTAREA',
                                    'select' => 'SELECT',
                                    'radio' => 'RADIO',
                                    'checkbox' => 'CHECKBOX'
                                );

                                echo form_dropdown('field_type' . $i, $field_type_data, ((isset($field_type)) ? $field_type : ''), 'class = "form-control" ');
                                ?>
                                <span class="warning-msg"><?php echo form_error('field_type' . $i); ?></span>
                            </div>
                        </div>

                        <div class="form-group">                               
                            <label class="col-sm-3 control-label">
                                <b><?php echo lang('db-schema'); ?></b>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo lang('type'); ?>
                            </label>
                            <div class="col-sm-9">
                                <?php
                                $db_type_data = array(
                                    'VARCHAR' => 'VARCHAR',
                                    'TINYINT' => 'TINYINT',
                                    'TEXT' => 'TEXT',
                                    'DATE' => 'DATE',
                                    'SMALLINT' => 'SMALLINT',
                                    'MEDIUMINT' => 'MEDIUMINT',
                                    'INT' => 'INT',
                                    'BIGINT' => 'BIGINT',
                                    'FLOAT' => 'FLOAT',
                                    'DOUBLE' => 'DOUBLE',
                                    'DECIMAL' => 'DECIMAL',
                                    'DATETIME' => 'DATETIME',
                                    'TIMESTAMP' => 'TIMESTAMP',
                                    'TIME' => 'TIME',
                                    'YEAR' => 'YEAR',
                                    'CHAR' => 'CHAR',
                                    'TINYBLOB' => 'TINYBLOB',
                                    'TINYTEXT' => 'TINYTEXT',
                                    'BLOB' => 'BLOB',
                                    'MEDIUMBLOB' => 'MEDIUMBLOB',
                                    'MEDIUMTEXT' => 'MEDIUMTEXT',
                                    'LONGBLOB' => 'LONGBLOB',
                                    'LONGTEXT' => 'LONGTEXT',
                                    'ENUM' => 'ENUM',
                                    'SET' => 'SET',
                                    'BIT' => 'BIT',
                                    'BOOL' => 'BOOL',
                                    'BINARY' => 'BINARY',
                                    'VARBINARY' => 'VARBINARY'
                                );

                                echo form_dropdown('db_type' . $i, $db_type_data, ((isset($db_type)) ? $db_type : ''), 'class = "form-control" ');
                                ?>
                                <span class="warning-msg"><?php echo form_error('db_type' . $i); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo lang('length-value'); ?>
                                <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                                <?php
                                $db_length_data = array(
                                    'name' => 'db_length_value' . $i,
                                    'id' => 'db_length_value' . $i,
                                    'value' => set_value('db_length_value' . $i, ((isset($db_length_value)) ? $db_length_value : '')),
                                    'class' => 'form-control'
                                );
                                echo form_input($db_length_data);
                                ?>
                                <span class="warning-msg"><?php echo form_error('db_length_value' . $i); ?></span>
                            </div>
                        </div>

                        <div class="form-group">                               
                            <label class="col-sm-3 control-label">
                                <b><?php echo lang('validation-rules'); ?></b>
                            </label>
                        </div>

                        <div class="form-group">
                            
                            <label class="col-sm-3 control-label">
                            &nbsp;
                            </label>
                            
                            <div class="col-sm-9">
                                
                                <div class="checkbox block">
                                    <label><?php echo form_checkbox('validation_rules' . $i . '[]', lang('required'), ''); ?> <?php echo lang('required'); ?></label>
                                </div>
                                
                                <div class="checkbox block">
                                    <label><?php echo form_checkbox('validation_rules' . $i . '[]', lang('trim'), ''); ?> <?php echo lang('trim'); ?></label>
                                </div>
                                
                                <div class="checkbox block">
                                    <label><?php echo form_checkbox('validation_rules' . $i . '[]', lang('xss-clean'), ''); ?> <?php echo lang('xss-clean'); ?></label>
                                </div>
                                
                                <div class="checkbox block">
                                    <label><?php echo form_checkbox('validation_rules' . $i . '[]', lang('valid-email'), ''); ?> <?php echo lang('valid-email'); ?></label>
                                </div>
                                
                                <div class="checkbox block">
                                    <label><?php echo form_checkbox('validation_rules' . $i . '[]', lang('is-numeric'), ''); ?> <?php echo lang('is-numeric'); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?php if ($i == $count || $i % 2 == 0) { ?>
            </div>
            <?php
        }
    }
    ?>

    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-6">
                <?php
                $submit_button = array(
                    'name' => 'mysubmit',
                    'id' => 'mysubmit',
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
                    'onclick' => "location.href='" . site_url(get_current_section($this) . '/modulebuilder/generate_module') . "'",
                );
                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                echo form_button($cancel_button);
                ?>

            </div>
        </div>
    </div>

</div>

</form>

<script type="text/javascript">
    $('#module_name').keyup(function(e) {
    var $th = $(this);
            $th.val($th.val().replace(/[^a-zA-Z_]/g, function(str) {
            alert('You have typed " ' + str + ' ".\n\nPlease use only alphabets.');
                    return '';
            }));
            $('#controller_name').val($(this).val());
            $('#model_name').val($(this).val());
    });
            $(document).ready(function() {
    $('#saveform').bootstrapValidator({
    message: 'This value is not valid',
            fields: {
            module_name: {
            message: 'The Module Name field is required.',
                    validators: {
                    notEmpty: {
                    message: 'The Module Name field is required.'
                    }
                    }
            },
//                    controller_name: {
//                    message: 'The Controller Name field is required.',
//                            validators: {
//                            notEmpty: {
//                            message: 'The Controller Name field is required.'
//                            }
//                            }
//                    },
//                    model_name: {
//                    message: 'The Model Name field is required.',
//                            validators: {
//                            notEmpty: {
//                            message: 'The Model Name field is required.'
//                            }
//                            }
//                    },
                    table_name: {
                    message: 'The Table Name field is required.',
                            validators: {
                            notEmpty: {
                            message: 'The Table Name field is required.'
                            }
                            }
                    },
<?php for ($j = 1; $j <= $count; $j++) { ?>
                field_label<?php echo $j; ?>: {
                message: 'The Label  field is required.',
                        validators: {
                        notEmpty: {
                        message: 'The Label  field is required.'
                        }
                        }
                },
                        field_name<?php echo $j; ?>: {
                        message: 'The Name field is required.',
                                validators: {
                                notEmpty: {
                                message: 'The Name field is required.'
                                }
                                }
                        },
                        db_length_value<?php echo $j; ?>: {
                        message: 'The Length/Values field is required.',
                                validators: {
                                notEmpty: {
                                message: 'The Length/Values field is required.'
                                }
                                }
                        },
<?php } ?>
            }
    });
    });
</script>


