 <div class="contentpanel">
      <div class="panel-header clearfix">
          <?php echo anchor(site_url() . 'admin/products/image_index/'.$product_id, lang('product_image_list'), 'title="View All Product Images" class="add-link"'); ?>
    
          </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          
          <h4 class="panel-title"><?php if ($action == "edit") echo lang('edit_form_fields');
else echo lang('add_form_fields') ?></h4>
          </div>
          
        <div class="panel-body panel-body-nopadding">
          <?php
$attributes = array('class' => 'form-horizontal form-bordered', 'id' => 'add', 'name' => 'add');
echo form_open_multipart($this->controller->section_name.'/products/image_action/' . $action . "/" . $product_id . "/" . $id, $attributes);
if ($action == "edit" && isset($result[0]['product_images']['slug']) && $result[0]['product_images']['slug'] != '')
    echo form_hidden('old_slug_url', $result[0]['product_images']['slug']);


$hdn = array(
    'type' => 'hidden',
    'value' => (isset($result[0]['product_images']['product_image'])) ? $result[0]['product_images']['product_image'] : ''
);
echo form_hidden('hdnphoto', (isset($result[0]['product_images']['product_image'])) ? $result[0]['product_images']['product_image'] : '');
?>
      
            
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang('product_image'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <?php
                                            $image_data = array(
                                                'name' => 'product_image',
                                                'id' => 'product_image',
                                                'value' => '',
                                                'class' => 'form-control',
                                                'value' => set_value('product_image', ((isset($result[0]['product_images']['product_image'])) ? $result[0]['product_images']['product_image'] : ''))
                                            );
                                            if (empty($result[0]['product_images']['product_image']))
                                            {
                                                $image_data['class'] = 'form control validate[required]';
                                            }
                                            else
                                            {
                                                $image_data['class'] = 'form-control';
                                            }
                                            echo form_upload($image_data);
                                            ?>
                 <span style="color: grey"><?php echo lang('img_limit');?></span>
                                          <span class="warning-msg"><?php echo form_error('product_image'); ?></span>
              </div>
            </div>
       
                 <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo lang('status'); ?><span class="asterisk">*</span></label>
              <div class="col-sm-6">
                 <?php
                                            $options = array(
                                                '1' => lang('active'),
                                                '0' => lang('inactive')
                                            );
                                            echo form_dropdown('status', $options, (isset($result[0]['product_images']['status'])) ? $result[0]['product_images']['status'] : '' , 'class="form-control"');
                                            ?>
                                         <span class="warning-msg"><?php echo form_error('status'); ?></span>
              </div>
            </div>
              
           
          <div class="panel-footer" style="display: block;">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                         'name' => 'submit',
                        'id' => 'submit',
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
                        'onclick' => "location.href='" . site_url(get_current_section($this).'/products/image_index/'.$product_id) . "'",
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
    ?>
   <!-- contentpanel -->
  </div>
 
         
 </div>
 </div>
