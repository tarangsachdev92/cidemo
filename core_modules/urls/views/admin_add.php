 <div class="contentpanel">
      <div class="panel-header clearfix">
        <?php echo anchor(get_current_section($this) . '/urls', lang('view-all-url'), 'title="View All Url" class="add-link" '); ?>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          
          <h4 class="panel-title"><?php echo lang('add-edit-url') ?></h4>
          </div>
          
        <div class="panel-body panel-body-nopadding">
          
         <?php echo form_open_multipart(get_current_section($this).'/urls/save/', array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); ?>
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('slug-url'), 'slug_url'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                        $slug_url_data = array(
                                            'name' => 'slug_url',
                                            'id' => 'slug_url',
                                            'value' => set_value('slug_url', ((isset($slug_url)) ? $slug_url : '')),
                                             'class' => 'form-control'
                                        );
                                        ?>
                  <?php echo form_input($slug_url_data); ?><span class="validation_error"><?php echo form_error('slug_url'); ?>
              </div>
            </div>
              
              <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('module-name'), 'module_name'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                
                <?php
                                                echo form_dropdown('module_name', $modules_list, ((isset($module_name)) ? $module_name : ''), ' onChange = change_module(this.value); class = form-control');
                                                ?>
                  
              </div>
            </div>
            
            <div class="form-group" style="display: none;" id="related_row"> 
              <label class="col-sm-3 control-label"><?php echo form_label(lang('module-pages'), 'related_id'); ?></label>
              <div class="col-sm-6" id="related_field">
                
               <?php
               
                                                echo form_dropdown('related_id', $related_list, ((isset($related_id)) ? $related_id : ''));
                                                ?>
                  <span class="validation_error"><?php echo form_error('related_id'); ?></span>
              </div>
            </div>
                
              
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('core-url'), 'core_url'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                  <?php
                                        $core_url_data = array(
                                            'name' => 'core_url',
                                            'id' => 'core_url',
                                            'value' => set_value('core_url', ((isset($core_url)) ? $core_url : '')),
                                            'class' => 'form-control',
                                            
                                        );
                                        ?>
                <?php echo form_input($core_url_data); ?><span class="validation_error"><?php echo form_error('core_url'); ?></span>
              </div>
            </div>
              
              <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang('order') ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                        $order_data = array(
                                            'name' => 'order',
                                            'id' => 'order',
                                            'value' => set_value('order', ((isset($order)) ? $order : '0')),
                                            'class' => 'form-control',
                                            
                                        );
                                        ?>
               <?php echo form_input($order_data); ?><span class="validation_error"><?php echo form_error('order'); ?>
              </div>
            </div>
              
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('status'), 'Status'); ?></label>
              <div class="col-sm-6">
                
                <?php $statuslist = array('1' => lang('active'), '0' => lang('inactive')); ?>
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
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/urls') . "'",
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#slug_url').focus();
    

    });

    function checkPinteger(field, rules, i, options)
    {
        if(field.val() < 0)
            return 'Enter a positive number.';
    }

<?php if ($id != '' || $id != 0)
{
    ?>
        change_module("<?php Print($module_name); ?>",'<?php print($related_id); ?>');
<?php } ?>
    //Function to update related dropdown
    function change_module(module_name,related_id){
        $("#core_url").removeAttr('readonly');
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().get_current_section($this); ?>/urls/get_related',
            data:{<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',module_name:module_name},
            success: function(data) {
                if(data == ''){
                    $("#related_row").hide();
                }else{
                    $("#related_row").show();
                    $("#related_field").html(data);
                    $('#related_id').val(related_id);
                    $('#related_id').addClass( "form-control" );
                }
            }
        });
    }

    //Function to update slug & Core URL
    function change_related(){
        var module_name = $("#related_id :selected").text();

        if (module_name.length != 0)
        {
            $('#core_url').attr("readonly","readonly");
            $("#slug_url").val(module_name);
            $("#core_url").val('index/'+module_name);
        }
        else
        {
            $("#core_url").removeAttr('readonly');
            $("#slug_url").val(module_name);
            $("#core_url").val('index/'+module_name);
        }
    }
</script>

<script type="text/javascript">

    $(document).ready(function() {
        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                slug_url: {
                    message: 'The Slug URL field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Slug URL field is required.'
                        }
                    }
                },
                core_url: {
                    message: 'The Core URL field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Core URL field is required.'
                        }
                    }
                },
                 module_name: {
                    message: 'The Module Name field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Module Name field is required.'
                        }
                    }
                },
                 order: {
                    message: 'The Order field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Oreder field is required.'
                        }
                    }
                }
            }
        });

    });
</script>




    
 