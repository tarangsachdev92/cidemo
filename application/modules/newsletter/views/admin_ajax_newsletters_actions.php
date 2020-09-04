<div class="contentpanel">
       <div class="panel-header clearfix">
        <?php echo anchor(site_url() . get_current_section($this) . '/newsletter/all_newsletters', lang('view_newsletters'), 'title="View Newsletters" class="add-link" '); ?>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
       
          <h4 class="panel-title"><?php echo lang ('add_form_fields'); ?></h4>
         </div>
          
          <?php
$attributes = array ('class' => 'form-horizontal form-bordered bv-form', 'id' => 'newsletters_actions', 'name' => 'newsletters_actions');
echo form_open (get_current_section ($this) . '/newsletter/newsletters_actions/' . $action . '/' . $language_code . '/' . $id, $attributes);
?>
          
        <div class="panel-body panel-body-nopadding">
          
         
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('subject'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                        $subject_data = array (
                                            'name' => 'subject',
                                            'id' => 'subject',
                                            'value' => set_value ('subject', ((isset ($newsletters[0]['n']['subject'])) ? $newsletters[0]['n']['subject'] : '')),
                                            'class' => 'form-control',
                                        );
                                        echo form_input ($subject_data);
                                        ?>
                   <span class="warning-msg"><?php echo form_error ('subject'); ?></span>
              </div>
            </div>
            
           <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('category'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php 
                                        foreach ($all_category as $key => $value) {
                                            $options[$value['cn']['category_id']] = $value['cn']['category_name'];
                                        }
                                        echo form_dropdown ('category', $options, ((isset ($newsletters[0]['n']['category_id'])) ? $newsletters[0]['n']['category_id'] : '') , 'class="form-control"');
                                        ?>
                  <span class="warning-msg"><?php echo form_error ('category'); ?></span>
                 
              </div>
            </div> 
           
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('title'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                        $title_data = array (
                                            'name' => 'title',
                                            'id' => 'title',
                                            'value' => set_value ('title', ((isset ($newsletters[0]['nc']['title'])) ? $newsletters[0]['nc']['title'] : '')),
                                            'class' => 'form-control',
                                        );
                                        echo form_input ($title_data);
                                        ?>
                                       <span class="warning-msg"><?php echo form_error ('title'); ?></span>
              </div>
            </div>
         
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('content'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                         $content_data = array (
                                            'name' => 'content',
                                            'id' => 'wysiwyg',
                                             'size' => '50',
                                             "class" => "form-control",
                                             'placeholder' => "Enter text here...",
                                             'rows' => 10,
                                            'value' => set_value ('content', ((isset ($newsletters[0]['nc']['text'])) ? html_entity_decode ($newsletters[0]['nc']['text']) : '')),
                                           
                                        );
                                        echo form_textarea ($content_data);
                                        ?>
                                       <span class="warning-msg"><?php echo form_error ('content'); ?></span>
              </div>
            </div>
            
             <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('templates'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                      
                                        foreach ($all_template as $key => $value) {
                                            $options1[$value['t']['id']] = $value['t']['template_title'];
                                        }

                                        echo form_dropdown ('template', $options1, ((isset ($newsletters[0]['t']['template_id'])) ? $newsletters[0]['t']['template_id'] : '')  , 'class="form-control"');
                                        ?>
                                       <span class="warning-msg"><?php echo form_error ('template'); ?></span>
              </div>
            </div>
            <div class="form-group" id="schedule_time_tr">
              <label class="col-sm-3 control-label"><?php echo lang ('schedule'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                  
                                        $schedule_data = array (
                                            'name' => 'schedule',
                                            'id' => 'schedule',
                                            'value' => set_value ('schedule', ((isset ($newsletters[0]['n']['schedule_time'])) ? $newsletters[0]['n']['schedule_time'] : '')),
                                            'size' => '20',
                                            "class" => "form-control datepicker",
                                            "data-date-format" => "yyyy/mm/dd"
                                        );
                                        echo form_input ($schedule_data);
                                        ?>
                                       <span class="warning-msg"><?php echo form_error ('schedule'); ?></span>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('schedule_now'); ?></label>
              <div class="col-sm-6">
                <?php
                                    
                                        $options = array ('yes' => 'Yes', 'no' => 'No');
                                        $extra = 'id="schedule_now" class="form-control" onchange="schedule_setting(this.value)"';
                                        echo form_dropdown ('schedule_now', $options, 'no', $extra);
                                        ?>
                                  
              </div>
            </div>
           
             <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang ('status'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                        $options = array (
                                            'active' => lang ('active'),
                                            'inactive' => lang ('inactive')
                                        );
                                        echo form_dropdown ('status', $options, ((isset ($newsletters[0]['n']['status'])) ? $newsletters[0]['n']['status'] : ''), 'class="form-control"' );
                                        ?>
                                        <br/><span class="warning-msg"><?php echo form_error ('status'); ?></span>
              </div>
            </div>
            
            
        </div><!-- panel-body -->
        
        <div class="panel-footer">
			 <div class="row">
				<div class="col-sm-6 col-sm-offset-3">
				  <?php
$submit_button = array (
    'name' => 'save',
    'id' => 'save',
    'value' => lang ('btn-save'),
    'title' => lang ('btn-save'),
    'class' => 'btn btn-primary',
   'type' => 'submit',
   'content' => '<i class="fa fa-save"></i> &nbsp; '.lang('btn-save')
);
echo form_button ($submit_button);
$cancel_button = array (
    'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; '.lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/newsletter/all_newsletters') . "'",
);
echo "&nbsp;";
echo form_button ($cancel_button);
?>
				</div>
			 </div>
		  </div><!-- panel-footer -->
        <?php echo form_close (); ?>
      </div><!-- panel -->
      
      
    </div><!-- contentpanel -->
<script type="text/javascript">
function schedule_setting(val) {
    if (val == "yes")
    {
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var output = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        jQuery("#schedule").val(output);
        jQuery("#schedule_time_tr").hide();
        jQuery("#status").val('active');
        jQuery("#status option[value=inactive]").attr('disabled', true);

    }
    else
    {
        jQuery("#schedule").val("");
        jQuery("#schedule_time_tr").show();
        jQuery("#status").val('active');
        jQuery("#status option[value=inactive]").attr('disabled', false);
    }
} 
</script>