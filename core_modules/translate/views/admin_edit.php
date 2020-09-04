 <div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-heading">
          
          <h4 class="panel-title"><?php echo lang('tr_language') . ': ' . ucfirst($trans_lang) ?></h4>
          <h5><?php echo lang('tr_translate_file') . ": $lang_file" ?></h5>
        </div>
           <?php if(isset($orig) && is_array($orig) && count($orig)) : ?>
            <?php echo form_open(current_url(), 'class="form-horizontal form-bordered"'); ?> 
        <div class="panel-body panel-body-nopadding">
          
       
            <input type="hidden" name="trans_lang" value="<?php e($trans_lang) ?>" /> 
             <?php foreach ($orig as $key => $val) : ?>
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php e($val) ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                 <input type="text" name="lang[<?php echo $key ?>]" id="lang<?php echo $key ?>" value="<?php e(isset($new[$key]) ? $new[$key] : $val) ?>" class="form-control" />                        
                                           
              </div>
            </div>
               <?php endforeach; ?>   
              
           
      
   <!-- contentpanel -->
 
     <div class="panel-footer" style="display: block;">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                        'name' => 'submit',
                       'id' => 'submit',
                        'value' => 'Save',
                        'title' => 'Save',
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
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/translate') . "'",
                    );
                    echo "&nbsp;";
                    echo form_button($cancel_button);
                    ?>
                    <!--                        <button class="btn btn-default">Cancel</button>-->
                </div>
               
                 
        </div>
        
 </div>
 
 <?php
   

             echo form_close();
    ?> <?php else : ?>
        <?php endif; ?>
            </div>
     </div>

 </div>


    
 