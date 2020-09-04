 <div class="contentpanel">
      
      <div class="panel panel-default">
        <div class="panel-heading">
          
          <h4 class="panel-title"><?php echo lang("change-password"); ?></h4>
          </div>
          
        <div class="panel-body panel-body-nopadding">
         <?php
$attributes = array('name' => 'forgot_password', 'id' => 'forgot_password' , 'class' => 'form-horizontal form-bordered');

       
        $current_password_data = array(
    'name' => 'current_password',
    'id' => 'current_password',
    'value' => set_value('current_password',$cur_pass),
    "class" => "form-control",
);
$password_data = array(
    'name' => 'password',
    'id' => 'password',
    'value' => set_value('password', ""),
    "class" => "form-control",
    
);
$passconf_data = array(
    'name' => 'passconf',
    'id' => 'passconf',
    'value' => set_value('passconf', ""),
   "class" => "form-control",
    
);
echo form_open($this->_data['section_name']."/users/changepassword", $attributes);
?>
            
            <div class="form-group">
              <label class="col-sm-3 control-label"> <?php echo form_label(lang('current-password') , 'password'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                
                <?php
            echo form_password($current_password_data); ?><span class="validation_error"><?php echo form_error('current_password'); ?></span>
              </div>
            </div>
            
                  <div class="form-group">
              <label class="col-sm-3 control-label">  <?php echo form_label(lang('password'), 'password'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                
               <?php
            echo form_password($password_data);?>
                                              <span class="validation_error"><?php echo form_error('password'); ?></span>
              </div>
            </div>
              
              <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('c-password') , 'passconf'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
             
              <?php      echo form_password($passconf_data);
              ?>
              <span class="validation_error"><?php echo form_error('passconf'); ?></span>
              </div>
            </div>
                
              
           
         
              
      
              
           
          <div class="panel-footer" style="display: block;">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                         'name' => 'Submit',
                         'id' => 'Submit',
                         'value' => lang('btn-save'),
                         'title' => lang('btn-save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; Save'
                    );
                    echo form_button($submit_button);
                    ?>
                    <!--                        <button class="btn btn-primary">Submit</button>-->
                                        <!--                        <button class="btn btn-default">Cancel</button>-->
                </div>
            </div>
        </div>
   <!-- contentpanel -->
  </div>
 
          <?php
    

    echo form_close();
    ?>
 </div>
 </div>


<script type="text/javascript">

    $(document).ready(function() {
        
       jQuery("#current_password").focus();
        
        $('#forgot_password').bootstrapValidator({
           
            fields: {
                current_password: {
                  
                    validators: {
                        notEmpty: {
                            message: 'The Current Password field is required.'
                        }
                    }
                },
                password: {
                  
                    validators: {
                        notEmpty: {
                            message: 'The Password field is required.'
                        }
                    }
                },
                passconf: {
                  
                    validators: {
                        notEmpty: {
                            message: 'The Confirm Password field is required.'
                        }
                    }
                }
            }
        });

    });
</script>




    
 