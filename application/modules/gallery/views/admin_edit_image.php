<div class="contentpanel">
      <div class="panel-header clearfix">
        <?php echo anchor(site_url() . $this->_data['section_name'] . '/gallery', lang('view-gallery'), 'title="View Gallery" class="add-link" '); ?>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading">
         
          <h4 class="panel-title">Add/Edit Image</h4>
          </div>
        <div class="panel-body panel-body-nopadding">
           <?php
          echo form_open_multipart($this->_data['section_name'].'/gallery/save', array('id' => 'saveform', 'name' => 'saveform' , 'class' => 'form-horizontal form-bordered'));
        if (isset($imageDetail)){
            $id = $imageDetail['I']['id'];
            $old_image = $imageDetail['I']['image'];
        }
        echo form_hidden('id', (isset($id)) ? $id : '0' );

        ?>
    
            
           <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('title'), 'title'); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                   <?php
                                        $firstname_data = array(
                                            'name' => 'title',
                                            'id' => 'title',
                                            'value' => set_value('firstname', ((isset($imageDetail['I']['title'])) ? $imageDetail['I']['title'] : '')),                                            
                                            'class' => 'form-control'
                                        );
                                        ?>
                    <?php echo form_input($firstname_data); ?>
                    <span class="validation_error"><?php echo form_error('title'); ?></span>
<!--                        <input type="text" class="form-control" />-->
                </div>
            </div>

            
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('tag'),'tag'); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                                        $lastname_data = array(
                                            'name' => 'tag',
                                            'id' => 'tag',
                                            'value' => set_value('lastname', ((isset($imageDetail['I']['tag'])) ? $imageDetail['I']['tag'] : '')),                                            
                                            'class' => 'form-control'
                                        );
                                        ?>
                    <?php echo form_input($lastname_data); ?>
                    <span class="validation_error"><?php echo form_error('tag'); ?></span>
<!--                        <input type="text" class="form-control">-->
                </div>
            </div>
            
        <?php 
           
            foreach ($galleries as $_galleries){
                                                $galleriesArray[$_galleries['G']['category_id']] = $_galleries['G']['title'];
                                                $galleriesIdArray[] = $_galleries['G']['id'];
                                              }
                                        ?>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('gallery-name')); ?></label>
                <div class="col-sm-6">
                    <?php
                     $additional_info= ' class="form-control"';
                    ?>
                   
                    <?php echo form_dropdown('gallery_id', $galleriesArray, ((isset($imageDetail['I']['gallery_id'])) ? $imageDetail['I']['gallery_id'] : ''),$additional_info);?>
                     <span class="warning-msg"><?php echo form_error('gallery_id'); ?></span>
                    
                </div>
            </div>
          
           <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('image'), 'Image'); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                   <?php
				                            $image_data = array(
				                                'name' => 'image',
				                                'id' => 'image',
				                                'value' => set_value('image', ((isset($image)) ? $image : '')),
                                                                'class' => "form-control"
				                            );
                                                    if (isset($imageDetail)){$image = $imageDetail['I']['image'];}
				                            ?>
                    <?php echo form_upload($image_data); ?>
                    <?php echo (isset($image)) ? "<p><img style='height:50px;padding:4px' src=".base_url()."assets/uploads/gallery_images/thumb/".$image." alt=''></p>" : 'No image'?>
											
                    <span class="validation_error"><?php echo form_error('image'); ?></span>
<!--                        <input type="text" class="form-control">-->
                </div>
            </div>
            
            
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('status')); ?></label>
                <div class="col-sm-6">

                    <?php
                    $statuslist = array('1' => 'Active', '0' => 'Inactive');
 
                     $additional_info= ' class="form-control"';
                  
                   
                  echo form_dropdown('status', $statuslist, ((isset($imageDetail['I']['status'])) ? $imageDetail['I']['status'] : ''),$additional_info);
                    ?>
                </div>
            </div>
      

     
           <div class="panel-footer">
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
                        'onclick' => "location.href='" . site_url($this->_data['section_name'] . '/gallery') . "'",
                    );
                    echo "&nbsp;";
                    echo form_button($cancel_button);
                    ?>
				</div>
			 </div>
		  </div>
        </div><!-- panel-body -->
        
       <!-- panel-footer -->
         
        <?php
            echo form_hidden('id', (isset($id)) ? $id : '0' );
            echo form_hidden('old_image', (isset($old_image)) ? $old_image : '' );
            echo form_close();
        ?>
      </div><!-- panel -->
      </div>

<script type="text/javascript">

    $(document).ready(function() {
        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                title: {
                    message: 'The Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Title field is required.'
                        }
                    }
                },
                tag: {
                    validators: {
                        notEmpty: {
                            message: 'The Tag field is required.'
                        }
                    }
                }
            }
        });

    });
</script>
      
    