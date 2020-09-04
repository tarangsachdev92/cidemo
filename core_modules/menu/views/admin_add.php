<div class="contentpanel">
    <div class="panel-header clearfix">
        <?php echo anchor(get_current_section($this) . '/menu', lang('menu-view'), 'title="' . lang('menu-view') . '" class="add-link" '); ?>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('menu-add-edit'); ?></h4>
        </div>

        <?php echo form_open(get_current_section($this) . "/menu/save", array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); ?>

        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <?php echo lang('menu-name'); ?> <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $menuArr = array();
                    foreach ($menu_names as $key => $val) {
                        $menuArr[$val['m']['id']] = $val['m']['value'];
                    }
                    if ($id == "" || $id == 0) {
                        $menuArr['add-menu'] = lang("menu-add");
                    }
                    echo form_dropdown('menu_name', $menuArr, array($menu_name), 'id="menu_name" class="form-control"') . '&nbsp;&nbsp;';
                    ?>

                    <?php
                    $display = ($menu_name == 'add-menu') ? "" : " display: none;";
                    $inputData = array(
                        'name' => 'new_menu',
                        'id' => 'new_menu',
                        'value' => set_value('new_menu', isset($new_menu) ? $new_menu : ''),
                        'maxlength' => '100',
                        'style' => $display,
                        'class' => "form-control"
                    );
                    echo form_input($inputData);
                    ?>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->

                    <span class="validation_error"><?php echo form_error('new_menu'); ?> <?php echo form_error('menu_name'); ?></span>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <?php echo lang('menu-title'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $inputData = array(
                        'name' => 'title',
                        'id' => 'title',
                        'value' => set_value('title', $title),
                        'maxlength' => '100',
                        'class' => "form-control"
                    );
                    echo form_input($inputData);
                    ?>
                    <span class="validation_error"><?php echo form_error('title'); ?></span>
<!--                        <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('menu-section'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $configArr = (array) $this->theme->ci()->config;
                    $menu_section = $configArr['config']['section_name'];

                    echo form_dropdown('menu_section', $menu_section, $menu_section_arr, 'id="menu_section" class = "form-control" ') . '&nbsp;&nbsp;';
                    ?>
<!--                        <textarea id="wysiwyg" placeholder="Enter text here..." class="form-control" rows="10"></textarea>-->
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <?php echo lang('menu-link'); ?> <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                    $inputData = array(
                        'name' => 'link',
                        'id' => 'link',
                        'value' => set_value('link', $link),
                        'maxlength' => '100',
                        'class' => "form-control"
                    );
                    echo form_input($inputData);
                    ?>
                     <p class="text-primary"><?php echo lang('link-msg'); ?></p>
                    <span class="validation_error"><?php echo form_error('link'); ?></span>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('menu-parent'); ?></label>
                <div class="col-sm-6">
                    
                    <div id="parent_menu">
                    <?php
                    echo form_dropdown('parent_id', $menu_items, array($parent_id), 'id=parent_id class = "form-control" ');
                    ?>
                        </div>
                    <span class="validation_error"><?php echo form_error('parent_id'); ?></span>
<!--                    <input type="text" placeholder="Default Input" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><label><?php echo lang('menu-status'); ?></label></label>
                <div class="col-sm-6">

                    <?php
                    $statuslist = array('1' => lang('menu-active'), '0' => lang('menu-inactive'));
                    echo form_dropdown('status', $statuslist, array($status), ' class = "form-control" ');
                    ?>
                    <span class="validation_error"><?php echo form_error('status'); ?></span>

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

                    <input type="hidden" id="lang_id" name="lang_id" value ="<?php echo (isset($lang_id)) ? $lang_id : '1'; ?>" />
                    <input type="hidden" id="language_name" name="language_name" value ="<?php echo (isset($language_name)) ? strtolower($language_name) : 'en'; ?>" />
                    <input type="hidden" id="id" name="id" value ="<?php echo (isset($id)) ? $id : '0'; ?>" />

                    <?php
                    $submit_button = array(
                        'name' => 'savemenu',
                        'id' => 'savemenu',
                        'value' => lang('menu-save'),
                        'title' => 'Save',
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp;'.lang('menu-save')
                    );
                    echo form_button($submit_button);

                    $langname = (isset($language_name)) ? strtolower($language_name) : 'en';
                    $siteurl = site_url(get_current_section($this) . '/menu') . '/index/' . $langname;

                    $cancel_button = array(
                        'name' => 'button',
                        'title' => lang('menu-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . $siteurl . "'",
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; Cancel'
                    );
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo form_button($cancel_button, lang('menu-cancel'));
                    ?>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#new_menu').focus();
        $('#menu_name').on('change', function() {
            if ($(this).val() == 'add-menu')
            {
                $('#new_menu').show('slow');
                $('#parent_id').html('<option id="0"><?php echo lang('menu-root'); ?></option>');
            }
            else
            {
                $('#new_menu').val('');
                $('#new_menu').hide('slow');
                $("#saveform").data('bootstrapValidator').resetForm();
                // $('#new_menu').validationEngine('hide');
                 
                //load menu items
                getmenulist($(this).val());
            }
        });

        $('#module_name').on('change', function() {
            if ($(this).val() == 'cms') {
                getsubpages($(this).val());
                $('#link').attr('readonly', true);
            } else {
                $('#link').attr('readonly', false);
                //generate link
                $("#subpages").html('');
                $("#subpages").hide();
            }
        });

        getsubpages = function(modulename) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . get_current_section($this); ?>/menu/get_subpages',
                data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',
                    module_name: encodeURI(modulename),
                    lang_id: $('#lang_id').val()
                },
                success: function(data) {
                    if (data == '') {
                        $("#subpages").hide();
                    } else {
                        $('#link').val('');
                        $("#subpages").html(data);
                        $("#subpages").show();
                    }
                    unblockUI();
                }
            });
        };

        getmenulist = function(menu_name) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . get_current_section($this); ?>/menu/get_menulist',
                data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',
                    menu_name: encodeURI(menu_name),
                    lang_id: $('#lang_id').val(),
                    id: $('#id').val()
                },
                success: function(data) {
                    if (data == '') {
                        $("#parent_menu").hide();
                    } else {
                        $("#parent_menu").html(data);
                        $("#parent_menu").show();
                    }
                    unblockUI();
                }
            });
        };

        change_subpages = function(page) {
            if (page != '0') {
                $('#link').val(page);
            } else {
                $('#link').val('');
            }
        };

    });
</script>

<script type="text/javascript">

    $(document).ready(function() {
        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                new_menu: {
                    message: 'The Menu Name field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Menu Name field is required.'
                        }
                    }
                },
                title: {
                    message: 'The Menu Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Menu Title field is required.'
                        }
                    }
                },
                link: {
                    message: 'The Menu Link field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Menu Link field is required.'
                        }
                    }
                }
            }
        });

    });
</script>