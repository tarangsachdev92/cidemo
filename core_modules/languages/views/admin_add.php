 <div class="contentpanel">
      <div class="panel-header clearfix">
            <?php echo anchor(get_current_section($this).'/languages', lang('languages-view'), 'title="View All Languages" class="add-link"'); ?>
       
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          
          <h4 class="panel-title"><?php echo lang('languages-add-edit'); ?></h4>
          </div>
          
        <div class="panel-body panel-body-nopadding">
          
          <?php echo form_open(get_current_section($this)."/languages/save", array('id' => 'saveform', 'name' => 'saveform', 'class' => 'form-horizontal form-bordered')); ?>
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('languages-name'), 'language_name'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php 
                                            $inputData = array(
                                                'name' => 'language_name',
                                                'id' => 'language_name',
                                                'value' => set_value('language_name', htmlspecialchars_decode($language_name)),                                               
                                                'class' => "form-control"
                                            );

                                            if(isset($id) && $id != 0){
                                                $inputData['readonly'] = 'true';
                                            }
                                            echo form_input($inputData);
                                            ?>
                                            <span class="validation_error"><?php echo form_error('language_name'); ?></span>
              </div>
            </div>
              
           
                
              
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('languages-code'), 'language-code'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                 <?php
                                        $inputData = array(
                                            'name' => 'language_code',
                                            'id' => 'language_code',
                                            'value' => set_value('language_code', htmlspecialchars_decode($language_code)),
                                             'class' => "form-control"
                                        );
                                        echo form_input($inputData);
                                        ?>
                                        <span class="validation_error"><?php echo form_error('language_code'); ?></span>
              </div>
            </div>
              
              <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('languages-direction'), 'direction'); ?><span class="asterisk">*</span></label>
                   <div class="col-sm-6">
                 <?php
                                        $dirlist = array('ltr' => 'Left', 'rtl' => 'Right');
                                        echo form_dropdown('direction', $dirlist, array($direction),'class = form-control');
                                        ?>
                                        <span class="validation_error"><?php echo form_error('direction'); ?></span>
              </div>
         </div>
              
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo form_label(lang('status'), 'Status'); ?></label>
              <div class="col-sm-6">
                <?php
                                        //var_dump($status);exit;

                                        $statuslist = array( '1' => lang('active'),'0' => lang('inactive'));
                                        echo form_dropdown('status', $statuslist, array($status), 'class = form-control');

                                        ?>
              </div>
            </div>
              
           
      
   <!-- contentpanel -->
  
     <div class="panel-footer" style="display: block;">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                  <?php
            $submit_button = array(
                'name' => 'saveLanguages',
                'id' => 'saveLanguages',
                'value' => lang('btn-save'),
                'title' => lang('btn-save'),
                'class' => 'btn btn-primary',
                'type' => 'submit',
                'content' => '<i class="fa fa-save"></i> &nbsp; Save'
            );
            echo form_button($submit_button);
         
             
                    $cancel_button = array(
                        'name' => 'cancel',
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; Cancel',
                        'value' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/languages') . "'",
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
 </div>
<script type="text/javascript">
     $(document).ready(function() {
        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                language_name: {
                    message: 'The Language Name field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Language Name field is required.'
                        }
                    }
                },
                language_code: {
                    message: 'The Language Code field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Language Code field is required.'
                        }
                    }
                },
                 direction: {
                    message: 'The Direction field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Direction field is required.'
                        }
                    }
                },
                
            }
        });

    });
</script>




    
 