 <div class="contentpanel">
      <div class="panel-header clearfix">
        <?php //echo anchor(get_current_section($this) . '/urls', lang('view-all-url'), 'title="View All Url" class="add-link" '); ?>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          
          <h4 class="panel-title"><?php echo lang('edit-comment') ?></h4>
          </div>
          
        <div class="panel-body panel-body-nopadding">
          
          <?php echo form_open_multipart($this->_data['section_name'].'/blog/edit_comment', array('id' => 'saveform', 'class' => 'form-horizontal form-bordered' , 'name' => 'saveform')); 
           
            ?>
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('comment-name'), 'commentname'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
          	
										<?php
                                                                                $name_data = array(
							                       'name' => 'name',
							                       'id' => 'name',
							                       'value' => set_value('name', ((isset($name)) ? $name : '')),
							                       'class' => 'form-control',
                                                                               'readonly'=>'readonly',
							                   );
                                        ?>
                  <?php echo form_input($name_data); ?><br/><span class="warning-msg"><?php echo form_error('commentname'); ?></span>
									
              </div>
            </div>
              
              <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('comment-email'), 'commentemail'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                
              <?php
								                $email_data = array(
								                    'name' => 'email',
								                    'id' => 'email',
								                    'value' => set_value('email', ((isset($email)) ? $email : '')),
								                     'class' => 'form-control',
                                                                                    'readonly'=>'readonly',
								                );
							            ?>
                  <?php echo form_input($email_data); ?><br/><span class="warning-msg"><?php echo form_error('commentemail'); ?></span>
              </div>
            </div>
            
            <div class="form-group"> 
              <label class="col-sm-3 control-label"><?php echo form_label(lang('comment-website'), 'commentwebsite'); ?></label>
              <div class="col-sm-6">
                
            <?php
							                   $website_data = array(
							                       'name' => 'website',
							                       'id' => 'website',
							                       'value' => set_value('website', ((isset($website)) ? $website : '')),
							                        'class' => 'form-control',
							                       'readonly'=>'readonly',
							                   );
							            ?>
                  <?php echo form_input($website_data); ?><br/><span class="warning-msg"><?php echo form_error('commentwebsite'); ?></span>
              </div>
            </div>
                
              
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('comment'), 'comment'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                 <?php
							                 $comment_data = array(
							                     'name' => 'comment_data',
							                     'id' => 'comment_data',
							                     'value' => set_value('comment_data', ((isset($comment)) ? $comment : '')),
							                     'class' => 'form-control',
							                 );
							            ?>
              <?php echo form_textarea($comment_data); ?><br/><span class="warning-msg"><?php echo form_error('comment'); ?></span>
              </div>
            </div>
             
              
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('status'), 'Status'); ?></label>
              <div class="col-sm-6">
             <?php
							    			$statuslist = array('0' => 'Inactive', '1' => 'Active','-1' => 'Deleted');
							            ?> 
                <?php
                                                echo form_dropdown('status', $statuslist, ((isset($status)) ? $status : ''),'class = form-control');
                                                ?>
                                                <span class="validation_error"><?php echo form_error('status'); ?></span>
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
                        'onclick' => "location.href='" . site_url($this->_data['section_name'].'/blog/comment') . "'",
                    );
                    echo "&nbsp;";
                    echo form_button($cancel_button);
                    ?>
                    <!--                        <button class="btn btn-default">Cancel</button>-->
                </div>
            </div>
        </div>
   <!-- contentpanel -->
  </div>
    
          <?php
    echo form_hidden('id', (isset($id)) ? $id : '0' );

    echo form_close();
    ?>
 </div>
 </div>





    
 