<?php echo add_js(array('jquery.placeholder')); ?>
<noscript>
<div style="color: red; position: fixed; top:0; background:#ccc; width:100%; text-align: center; padding-top:5px; padding-bottom: 5px; font-size:16px;">
    This site requires javascript enabled.
</div>
</noscript>

<section>
    <div class="signinpanel login-fix">
        <div class="row">
            <div class="col-md-12">

                <div class="logo">
                    <a href="#"><em>
<!--                            <img title="" alt="" src="images/logo.png" />-->
                        </em><span>Company Logo</span></a>
                </div>

                <div class="login-column">

                    <div class="header clearfix">
                        <h4 class="login-title"><i class="fa fa-sign-in"></i> Sign In</h4>
                    </div>

                    <div class="login-form">

                        <?php
                        echo form_open($this->_data['section_name'] . "/users/login", array('id' => 'login_form_inner', 'name' => 'login_form_inner'));


                        $email_data = array(
                            'name' => 'email',
                            'id' => 'email',
                            'value' => set_value('email', ""),
                            'maxlength' => '150',
                            'value' => set_value('address', ((isset($email)) ? $email : '')),
                            'class' => 'form-control nomargin',
                            'placeholder' => 'Email Address'
                        );
                        $password_data = array(
                            'name' => 'password',
                            'id' => 'password',
                            'value' => '',
                            'maxlength' => '50',
                            'class' => 'form-control',
                            'placeholder' => 'Password'
                        );
                        ?>

                        
                            <?php echo $this->message(); ?>

                        <div class="login-content">
                            <div class="form-group">
                                <?php echo form_input($email_data); ?>
                                <span class="warning-msg"><?php echo form_error('email'); ?></span>
                            </div>
                            <div class="form-group">
                                <?php echo form_password($password_data); ?>
                                <span class="warning-msg"><?php echo form_error('password'); ?></span>
                            </div> 
                            <?php
                            if (isset($back_url)) {
                                echo form_hidden('back_url', $back_url);
                            }
                            ?>

                            <!--                                <div class="form-group">
                                                                <div class="ckbox ckbox-success">
                                                                    <input type="checkbox" id="checkbox1">
                                                                    <label for="checkbox1"></label>
                                                                </div> 
                                                                <small class="remember">Remember me</small>
                                                            </div>  -->
                            <div class="box-footer">

                                <!--                                <button type="submit" class="btn btn-success btn-block">Sign in</button>-->


                                <?php
                                $data = array(
                                    'name' => 'Login',
                                    'id' => 'Login',
                                    'value' => 'Login',
                                    'type' => 'submit',
                                    'content' => 'Sign in',
                                    'class' => 'btn btn-success btn-block'
                                );

                                echo form_button($data);
                                ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </div>

                <div class="box-extra clearfix">
                    <!--                    <a href="#" class="pull-right btn btn-xs">Forgotten Password?</a>-->
                </div>

            </div><!-- col-sm-5 -->
        </div><!-- row -->
        <div class="signup-footer"> Copyright &copy; <?php echo date('Y'); ?>.</div>
    </div><!-- signin -->
</section>

<?php
echo add_js(array
    ('jquery-migrate-1.2.1.min',
    'bootstrap.min',
    'modernizr.min',
    'jquery.sparkline.min',
    'toggles.min',
    'retina.min',
    'jquery.cookies',
    'screenfull',
    'custom',
    'bootstrapValidator'));
?>

<script type="text/javascript">
$(function() {
        $('input, textarea').placeholder();
    });
    $(document).ready(function() {
        $('#login_form_inner').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                email: {
                    message: 'The Email field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Email field is required.'
                        },
                        emailAddress: {
                            message: 'Invalid Email Address.'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The Password field is required.'
                        }
                    }
                }
            }
        });

    });
</script>




