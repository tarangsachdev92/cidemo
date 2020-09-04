 <div class="contentpanel">
      <div class="panel-header clearfix">
        <?php echo anchor(site_url() . $this->_data['section_name'] . '/newsletter/all_subscribers/', 'View All', 'title="View All" class="add-link" '); ?>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
       
          <h4 class="panel-title"><?php echo lang ('add_form_fields'); ?></h4>
          </div>
           <?php
$attributes = array ('class' => 'form-horizontal form-bordered', 'id' => 'subscribers_actions', 'name' => 'subscribers_actions');
echo form_open ($this->_data['section_name'] . '/newsletter/subscribers_actions/' . $action . '/' . $language_code . '/' . $id, $attributes);
?>
        <div class="panel-body panel-body-nopadding">
         
          
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('first-name'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                 <?php
                                            $firstname_data = array (
                                                'name' => 'firstname',
                                                'id' => 'firstname',
                                                'value' => set_value ('firstname', $subscribers['firstname']),
                                                'size' => '50',
                                                'class' => 'form-control'
                                            );
                                            echo form_input ($firstname_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error ('firstname'); ?></span>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('last-name'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                  <?php
                                            $lastname_data = array (
                                                'name' => 'lastname',
                                                'id' => 'lastname',
                                                'value' => set_value ('lastname', $subscribers['lastname']),
                                                'size' => '50',
                                                'class' => 'form-control'
                                            );
                                            echo form_input ($lastname_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error ('lastname'); ?>
                </span>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('email'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                            if ($action == "edit") {
                                                $email_data = array (
                                                    'name' => 'email',
                                                    'id' => 'email',
                                                    'value' => set_value ('email', $subscribers['email']),
                                                    'maxlength' => '100',
                                                    'size' => '50',
                                                    'readonly' => 'readonly',
                                                    'class' => 'form-control'
                                                );
                                            } else {
                                                $email_data = array (
                                                    'name' => 'email',
                                                    'id' => 'email',
                                                    'value' => set_value ('email', $subscribers['email']),
                                                    'maxlength' => '100',
                                                    'size' => '50',
                                                    'class' => 'form-control'
                                                );
                                            }
                                            echo form_input ($email_data);
                                            ?>
                                            <br/><span class="warning-msg"><?php echo form_error ('email'); ?>
                </span>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('status'); ?></label>
              <div class="col-sm-6">
                 <?php
                                            $options = array (
                                                'active' => lang ('active'),
                                                'inactive' => lang ('inactive')
                                            );
                                            echo form_dropdown ('status', $options, $subscribers['status'] , 'class="form-control"');
                                            ?>
              </div>
            </div>
            
       
            
           
        </div>
       
                <div class="panel-footer">
			 <div class="row">
				<div class="col-sm-6 col-sm-offset-3">
				  <?php
        $submit_button = array (
            'name' => 'save',
            'id' => 'save',
            'value' => lang('btn-save'),
            'title' => lang('btn-save'),
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'content' => '<i class="fa fa-save"></i> &nbsp; '.lang('btn-save')
        );
        echo form_button ($submit_button);
        $cancel_button = array (
            'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; '.lang('btn-cancel'),
           'title' => lang('btn-cancel'),
           'class' => 'btn btn-default',
            'onclick' => "location.href='" . site_url($this->_data['section_name'] . '/newsletter/all_subscribers/') . "'",
        );
        echo "&nbsp;";
        echo form_button ($cancel_button);
        ?>
				</div>
			 </div>
		  </div><!-- panel-footer -->
                    
       <?php echo form_close (); ?>
          
        </div><!-- panel-body -->
        
    
        
      
      
    </div><!-- contentpanel -->
 <script type="text/javascript">

    $(document).ready(function() {
        $('#subscribers_actions').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                firstname: {
                    message: 'The First Name field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Slug URL field is required.'
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
                }
                 
            }
        });

    });
</script>