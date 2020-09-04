<script type="text/javascript">
    (function($) {
    $.fn.maxlength = function() {
    $("textarea[maxlength]").keypress(function(event) {
    var key = event.which;
            //all keys including return.
            if (key >= 33 || key == 13 || key == 32) {
    var maxLength = $(this).attr("maxlength");
            var length = this.value.length;
            if (length >= maxLength) {
    event.preventDefault();
    }
    }
    });
    };
    })(jQuery);
            $(document).ready(function($) {
    //Set maxlength of all the textarea (call plugin)
    $().maxlength();
    });</script>

<div class="contentpanel">

    <div class="panel-header clearfix">
        <?php echo anchor(site_url() . $this->_data['section_name'] . '/users', lang('view-all-user'), 'title="View All Users" class="add-link" '); ?>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <!--            <div class="panel-btns">
                            <a class="panel-close" href="#">×</a>
                            <a class="minimize" href="#">−</a>
                        </div>-->
            <h4 class="panel-title">Add/Edit User</h4>

        </div>


        <?php echo form_open($this->_data['section_name'] . '/users/save', array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); ?>

        <?php $id = ((isset($id)) ? $id : 0); ?>

        <div class="panel-body panel-body-nopadding" style="display: block;">
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('first-name')); ?>  <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $firstname_data = array(
                        'name' => 'firstname',
                        'id' => 'firstname',
                        'value' => set_value('firstname', ((isset($firstname)) ? htmlspecialchars_decode($firstname) : '')),
                        'maxlength' => 50,
                        'class' => 'form-control validate[required,maxSize[50]]'
                    );
                    ?>
                    <?php echo form_input($firstname_data); ?>
                    <span class="validation_error"><?php echo form_error('firstname'); ?></span>
<!--                        <input type="text" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('last-name')); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $lastname_data = array(
                        'name' => 'lastname',
                        'id' => 'lastname',
                        'maxlength' => 50,
                        'value' => set_value('lastname', ((isset($lastname)) ? htmlspecialchars_decode($lastname) : '')),
                        'class' => 'form-control validate[required,maxSize[50]]'
                    );
                    ?>
                    <?php echo form_input($lastname_data); ?>
                    <span class="validation_error"><?php echo form_error('lastname'); ?></span>
<!--                        <input type="text" class="form-control">-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('email')); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $email_data = array(
                        'name' => 'email',
                        'id' => 'email',
                        'value' => set_value('email', ((isset($email)) ? htmlspecialchars_decode($email) : '')),
                        'maxlength' => '150',
                        'class' => 'form-control validate[required,custom[email],maxSize[150]]'
                    );
                    ?>
                    <?php echo form_input($email_data); ?>
                    <span class="validation_error"><?php echo form_error('email'); ?></span>
<!--                        <input type="text" class="form-control" />-->
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('address')); ?></label>
                <div class="col-sm-6">
                    <?php
                    $address_data = array(
                        'name' => 'address',
                        'id' => 'address',
                        'value' => set_value('address', ((isset($address)) ? htmlspecialchars_decode($address) : '')),
                        'class' => 'form-control',
                        "rows" => "5"
                    );
                    ?>
                    <?php echo form_textarea($address_data); ?>
<!--                        <textarea rows="5" class="form-control"></textarea>-->
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('gender')); ?></label>
                <?php
                $gender = ((isset($gender)) ? $gender : 'M');
                if ($gender == 'F') {
                    $female_sel = 'checked="checked"';
                    $male_sel = '';
                } else {
                    $male_sel = 'checked="checked"';
                    $female_sel = '';
                }
                ?>
                <div class="col-sm-6">
                    <div class="radio">
                        <label>
                            <?php echo form_radio('gender', 'M', $male_sel); ?> <?php echo lang('male') ?>
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <?php echo form_radio('gender', 'F', $female_sel); ?> <?php echo lang('female') ?>
                        </label>
                    </div>
                    <span class="validation_error"><?php echo form_error('gender'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <?php
                $password_data['name'] = 'password';
                $password_data['id'] = 'password';
                $password_data['maxlength'] = '40';
                $password_data['value'] = set_value('password', ((isset($password)) ? $password : ''));

                $passconf_data['class'] = 'form-control';

                if ($id == "" || $id == 0) {
                    $password_data['class'] = 'form-control';
                } else {
                    $password_data['class'] = 'form-control';
                    // $password_data['onblur'] = 'addClassforemail(this);';
                }
                $passconf_data['name'] = 'passconf';
                $passconf_data['id'] = 'passconf';
                $passconf_data['maxlength'] = '40';
                $passconf_data['value'] = set_value('passconf', ((isset($passconf)) ? $passconf : ''));
                if ($id == "" || $id == 0)
                    $passconf_data['class'] = 'form-control validate[required]';
                ?>
                <label class="col-sm-3 control-label"><?php echo form_label(lang('password')); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php echo form_password($password_data); ?>
                    <span class="validation_error"><?php echo form_error('password'); ?></span>
<!--                        <input type="text" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('c-password')); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php echo form_password($passconf_data); ?>
                    <span class="validation_error"><?php echo form_error('passconf'); ?></span>
<!--                        <input type="text" class="form-control" />-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('role')); ?></label>
                <div class="col-sm-6">
                    <?php
                    if ($user_id == 1) {
                        $disable = "disabled='disabled'";
                    } else {
                        $disable = "";
                    }

                    $additional_info = $disable;
                    $additional_info.= ' class="form-control"';

                    echo form_dropdown('role_id', $role_list, ((isset($role_id)) ? $role_id : 0), $additional_info);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="checkbox" class="col-sm-3 control-label"><?php echo form_label(lang('hobbies')); ?></label>
                <div class="col-sm-6">
                    <?php
                    $Sport = $Movie = $Travelling = FALSE;
                    $hobbies = ((isset($hobbies)) ? $hobbies : '');
                    if ($hobbies != "") {
                        $Hobbies = explode(",", $hobbies);
                        if (in_array(lang('sport'), $Hobbies))
                            $Sport = TRUE;
                        if (in_array(lang('movies'), $Hobbies))
                            $Movie = TRUE;
                        if (in_array(lang('travelling'), $Hobbies))
                            $Travelling = TRUE;
                    }
                    ?>
                    <div class="checkbox block">
                        <label>
                            <?php
                            echo form_checkbox('hobbies[]', lang('sport'), $Sport);
                            echo lang('sport');
                            ?>
                        </label>
                    </div>
                    <div class="checkbox block">
                        <label>
                            <?php
                            echo form_checkbox('hobbies[]', lang('movies'), $Movie);
                            echo lang('movies');
                            ?>
                        </label>
                    </div>
                    <div class="checkbox block">
                        <label>
                            <?php
                            echo form_checkbox('hobbies[]', lang('travelling'), $Travelling);
                            echo lang('travelling');
                            ?>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('status')); ?></label>
                <div class="col-sm-6">

                    <?php
                    $statuslist = array('1' => 'Active', '0' => 'Inactive');

                    if ($user_id == 1) {
                        $disable = "disabled='disabled'";
                    } else {
                        $disable = "";
                    }
                    echo form_dropdown('status', $statuslist, $status, $disable . ' class="form-control"');
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
                        'onclick' => "location.href='" . site_url($this->_data['section_name'] . '/users') . "'",
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

            $(document).ajaxComplete(function() {
    // Chosen Select
    jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
    });
            function addClassforemail() {
            var email_text = $('#password').val();
                    if (email_text != "") {
            // $('#passconf').addClass("validate[required]");
            } else {

            alert("Here ....");
                    // $('#passconf').removeClass();

                    // Remove Validator ......
                    $('#saveform').bootstrapValidator(passconf, false, 'notEmpty');
                    // $('#saveform').bootstrapValidator('enableFieldValidators', 'passconf', 'notEmpty');
            }
            }

    $(document).ready(function() {

    $("input:text:visible:first").focus().val($('input:text:visible:first').val());
            $('#saveform').bootstrapValidator({
    message: 'This value is not valid',
            fields: {
            firstname: {
            message: 'The First Name field is required.',
                    validators: {
                    notEmpty: {
                    message: 'The First Name field is required.'
                    }
                    }
            },
                    lastname: {
                    message: 'The Last Name field is required.',
                            validators: {
                            notEmpty: {
                            message: 'The Last Name field is required.'
                            }
                            }
                    },
                    email: {
                    message: 'The Email field is required.',
                            validators: {
                            notEmpty: {
                            message: 'The Email field is required.'
                            },
                                    emailAddress: {
                                    message: 'Invalid Email.'
                                    }
                            }
                    },
                    password: {
<?php if ($id == "" || $id == 0) { ?>
                        enabled: true,
<?php } else { ?>
                        enabled: false,
<?php } ?>
                    message: 'The Password field is required.',
                            validators: {
                            notEmpty: {
                            message: 'The Password field is required.'
                            }
                            }
                    },
                    passconf: {
<?php if ($id == "" || $id == 0) { ?>
                        enabled: true,
<?php } else { ?>
                        enabled: false,
<?php } ?>
                    message: 'The Confirm Password field is required.',
                            validators: {
                            notEmpty: {
                            message: 'The Confirm Password field is required.'
                            },
                                    identical: {
                                    field: 'password',
                                            message: 'The Password and Confirm Password are not the same.'
                                    }
                            }
                    }
            }});
<?php if ($action == 'edit') { ?>

        $('#saveform').find('[name="password"]').on('keyup', function() {
        var isEmpty = $(this).val() == '';
                $('#saveform').bootstrapValidator('enableFieldValidators', 'password', !isEmpty)
                .bootstrapValidator('enableFieldValidators', 'passconf', !isEmpty);
                if ($(this).val().length == 1) {
        $('#saveform').bootstrapValidator('validateField', 'password')
                .bootstrapValidator('validateField', 'passconf');
        }
        });
        
                $('#saveform').find('[name="passconf"]').on('keyup', function() {
        var isEmpty = $(this).val() == '';
                $('#saveform').bootstrapValidator('enableFieldValidators', 'passconf', !isEmpty)
                .bootstrapValidator('enableFieldValidators', 'password', !isEmpty);
                if ($(this).val().length == 1) {
        $('#saveform').bootstrapValidator('validateField', 'passconf')
                .bootstrapValidator('validateField', 'password'); }
        });
<?php } ?>

    });

</script>




