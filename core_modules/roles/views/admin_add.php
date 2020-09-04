 <div class="contentpanel">
      <div class="panel-header clearfix">
        <?php echo anchor(site_url().get_current_section($this).'/roles', lang('view-all-role'), 'title="View All Roles" class="add-link"'); ?>
       
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          
          <h4 class="panel-title"><?php echo lang('add-edit-role') ?></h4>
          </div>
          
        <div class="panel-body panel-body-nopadding">
          
        <?php echo form_open_multipart(get_current_section($this).'/roles/save', array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); 
        echo form_hidden('id', (isset($id)) ? $id : '0' );
        ?>
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('role-name'), 'role_name'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                 <?php
                                        $role_data = array(
                                            'name' => 'role_name',
                                            'id' => 'role_name',
                                            'value' => set_value('role_name', ((isset($role_name)) ? htmlspecialchars_decode($role_name) : '')),
                                            'class' => 'form-control'
                                         
                                        );
                                        ?>
               <?php echo form_input($role_data); ?><span class="validation_error"><?php echo form_error('role_name'); ?></span>
              </div>
            </div>
              
              <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('role-description'), 'role_description'); ?></label>
              <div class="col-sm-6">
                
              <?php
                                        $role_description_data = array(
                                            'name' => 'role_description',
                                            'id' => 'role_description',
                                            'value' => set_value('role_description', ((isset($role_description)) ? htmlspecialchars_decode($role_description) : '')),
                                            'class' => 'form-control'
                                        );
                                        ?>
                  <?php echo form_textarea($role_description_data); ?>
<!--                  <span class="validation_error"><?php echo form_error('role_description'); ?></span>-->
              </div>
            </div>
                
              
           
         
              
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('status'), 'Status'); ?></label>
              <div class="col-sm-6">
                
                <?php $statuslist = array('1' => lang('active'), '0' => lang('inactive')); ?>
                <?php
                                                echo form_dropdown('status', $statuslist, ((isset($status)) ? $status : ''),'class = form-control');
                                                ?>
<!--                                                <span class="validation_error"><?php echo form_error('status'); ?></span>-->
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
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/roles') . "'",
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
    

    echo form_close();
    ?>
 </div>
 </div>


<script type="text/javascript">

    $(document).ready(function() {
        
        jQuery("#role_name").focus();
        
        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                role_name: {
                    message: 'The Role Name field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Role Name field is required.'
                        }
                    }
                }
            }
        });

    });
</script>




    
 