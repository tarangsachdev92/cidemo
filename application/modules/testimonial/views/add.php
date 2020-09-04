<?php echo add_css(array('validationEngine.jquery')); ?>
<?php echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<?php echo add_css(array('front_testimonial'), 'testimonial', 'modules'); ?>
<?php echo add_js(array('jquery.slugify', 'flowplayer-3.2.12.min', 'jquery.bpopup.min'), 'testimonial', 'modules'); ?>
<?php
  $ckeditor = array(
      //ID of the textarea that will be replaced
      'id' => 'testimonial_description',
      'path' => 'assets/ckeditor',
      //Optionnal values
      'config' => array(
          'toolbar' => "Full", //Using the Full toolbar
          'width' => "700px", //Setting a custom width
          'height' => '300px',
      ////Setting a custom height
      ),
  );
?>
<div class="main-container">
      <?php echo form_open_multipart('testimonial/save/' . $language_code, array('id' => 'saveform', 'name' => 'saveform')); ?>
      <div class="grid-data">
            <div class="add-new">
                  <?php echo anchor(site_url() . 'testimonial/index/' . $language_code, lang('view-all-records'), 'title="View All Testimonials" style="text-align:center;width:100%;"'); ?>
            </div>
            <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
                  <tbody bgcolor="#fff">
                        <tr>
                              <th><?php echo lang('add-edit-record') ?></th>
                        </tr>
                        <tr>
                              <td class="add-user-form-box">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                                <td width="100%" valign="top">
                                                      <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                                            <tr>
                                                                  <td width="300" align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('category'), 'parent_id'); ?>:</td>
                                                                  <td>
                                                                        <?php
                                                                          $options = array(
                                                                              'name' => 'category_id',
                                                                              'id' => 'category_id',
                                                                              'value' => (isset($category_id)) ? $category_id : '',
                                                                              'language_id' => $language_id,
                                                                              'module_id' => TESTIMONIAL_MODULE_NO,
                                                                              'class' => 'validate[required]',
                                                                          );
                                                                          widget('category_dropdown', $options);
                                                                        ?><br/><span class="warning-msg"><?php echo form_error('parent_id'); ?></span>
                                                                  </td>
                                                            </tr>

                                                            <?php
                                                              $id = ((isset($id)) ? $id : 0);
                                                              $testimonial_name_data = array(
                                                                  'name' => 'testimonial_name',
                                                                  'id' => 'testimonial_name',
                                                                  'value' => set_value('testimonial_name', ((isset($testimonial_name)) ? html_entity_decode($testimonial_name) : '')),
                                                                  'style' => 'width:198px;',
                                                                  'maxlength' => '100',
                                                                  'class' => 'validate[required]'
                                                              );
                                                            ?>
                                                            <tr>
                                                                  <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('testimonial_name'), 'testimonial_name'); ?>:</td>
                                                                  <td><?php echo form_input($testimonial_name_data); ?><br/><span class="warning-msg"><?php echo form_error('testimonial_name'); ?></span></td>
                                                            </tr>
                                                            <?php
                                                              $testimonial_slug_data = array(
                                                                  'name' => 'testimonial_slug',
                                                                  'id' => 'testimonial_slug',
                                                                  'value' => set_value('testimonial_slug', ((isset($testimonial_slug)) ? html_entity_decode($testimonial_slug) : '')),
                                                                  'style' => 'width:198px;',
                                                                  'maxlength' => '100',
                                                                  'class' => 'validate[required]'
                                                              );
                                                            ?>
                                                            <tr>
                                                                  <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('slug'), 'testimonial_slug'); ?>:</td>
                                                                  <td><?php echo form_input($testimonial_slug_data); ?><br/><span class="warning-msg"><?php echo form_error('testimonial_slug'); ?></span></td>
                                                            </tr>
                                                            <?php
                                                              $testimonial_description_data = array(
                                                                  'name' => 'testimonial_description',
                                                                  'id' => 'testimonial_description',
                                                                  'value' => set_value('testimonial_description', ((isset($testimonial_description)) ? html_entity_decode($testimonial_description) : '')),
                                                                  'size' => '50',
                                                                  'class' => 'validate[required]'
                                                              );
                                                            ?>
                                                            <tr>
                                                                  <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('description'), 'testimonial_description'); ?>:</td>
                                                                  <td><?php echo form_textarea($testimonial_description_data); ?>
                                                                        <?php echo display_ckeditor($ckeditor); ?><br/><span class="warning-msg"><?php echo form_error('testimonial_description'); ?></span></td>
                                                            </tr>
                                                            <?php
                                                              $logo_data = array(
                                                                  'name' => 'logo',
                                                                  'id' => 'logo',
                                                                  'value' => set_value('logo', ((isset($logo)) ? $logo : '')),
                                                                  'size' => '50',
                                                                  'maxlength' => '255'
                                                              );
                                                            ?>
                                                            <tr>
                                                                  <td align="right"><?php echo form_label(lang('logo'), 'logo'); ?>:</td>
                                                                  <td><?php echo form_upload($logo_data); ?><span style="color: grey"><?php echo lang('img_limit');?></span><br/><span class="warning-msg"><?php echo form_error('logo'); ?></span>
                                                                  </td>

                                                            </tr>                                             
                                                            <tr>
                                                              <td>
                                                                    <?php echo lang('image'); ?>
                                                              </td>
                                                              <?php                                                                                                                                                                                                                         
                                                                if (!empty($records['logo']) && file_exists(FCPATH.$records['logo']))
                                                                {                                            
                                                                      $logo_image  = $records['logo'];

                                                                    ?>                                      
                                                                    <td>
                                                                        <img src="<?php echo base_url(); ?><?php echo $logo_image; ?>" height ="50px"/>
                                                                    </td>
                                                                <?php } 
                                                                else
                                                                    {
                                                                    ?>
                                                                    <td>
                                                                        <?php
                                                                           $logo = 'logo.jpg';   
                                                                          echo add_image(array($logo),'testimonial','modules'); 
                                                                          ?>
                                                                    </td>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                            </tr>
                                                            <?php
                                                              $company_name_data = array(
                                                                  'name' => 'company_name',
                                                                  'id' => 'company_name',
                                                                  'value' => set_value('company_name', ((isset($company_name)) ? html_entity_decode($company_name) : '')),
                                                                  'style' => 'width:198px;'
                                                              );
                                                            ?>
                                                            <tr>
                                                                  <td align="right"><?php echo form_label(lang('company_name'), 'company_name'); ?>:</td>
                                                                  <td><?php echo form_input($company_name_data); ?><br/><span class="warning-msg"><?php echo form_error('company_name'); ?></span></td>
                                                            </tr>
                                                            <?php
                                                              $website_data = array(
                                                                  'name' => 'website',
                                                                  'id' => 'website',
                                                                  'value' => set_value('website', ((isset($website)) ? $website : '')),
                                                                  'style' => 'width:198px;',
                                                                  'class' => 'validate[custom[url]]'
                                                              );
                                                            ?>
                                                            <tr>
                                                                  <td align="right"><?php echo form_label(lang('website'), 'website'); ?>:</td>
                                                                  <td><?php echo form_input($website_data); ?><span style="color: grey"><?php echo lang('i.e.');?></span><br/><span class="warning-msg"><?php echo form_error('website'); ?></span></td>
                                                            </tr>
                                                            <?php
                                                              $position_data = array(
                                                                  'name' => 'position',
                                                                  'id' => 'position',
                                                                  'value' => set_value('position', ((isset($position)) ? html_entity_decode($position) : '')),
                                                                  'style' => 'width:198px;'
                                                              );
                                                            ?>
                                                            <tr>
                                                                  <td align="right"><?php echo form_label(lang('position'), 'position'); ?>:</td>
                                                                  <td><?php echo form_input($position_data); ?><br/><span class="warning-msg"><?php echo form_error('position'); ?></span></td>
                                                            </tr>
                                                            <tr>
                                                                  <td align="right"><?php echo form_label(lang('video_type'), 'video_type'); ?>:</td>
                                                                  <?php
                                                                    $video_type_data = array(
                                                                        '' => 'Select',
                                                                        SRC => 'File',
                                                                        YOUTUBE => 'You Tube',
                                                                    );
                                                                    if (isset($video_type))
                                                                    {
                                                                          $video_type_val = $video_type;
                                                                    }
                                                                    else
                                                                    {
                                                                          $video_type_val = ' ';
                                                                    }
                                                                  ?>
                                                                  <td><?php echo form_dropdown('video_type', $video_type_data, $video_type_val, 'id=change onchange = change_type(this.value);'); ?><br/><span class="warning-msg"><?php echo form_error('video_src'); ?></span></td>
                                                            </tr>
                                                              <?php
                                                            if(!empty($video_src))
                                                            {

                                                               $video_src_data = array(
                                                                'name' => 'video_src',
                                                                'id' => 'video_src',
                                                                'value' => set_value('video_src', ((isset($video_src)) ? $video_src : '')),
                                                                'style' => 'width:198px;'                                        
                                                            ); 
                                                            }
                                                            else
                                                            {

                                                                $video_src_data = array(
                                                                'name' => 'video_src',
                                                                'id' => 'video_src',
                                                                'value' => set_value('video_src', ((isset($video_src)) ? $video_src : '')),
                                                                'style' => 'width:198px;',
                                                                'class' => 'validate[required]'
                                                            );
                                                            }

                                                            ?>
                                                           
                                                            <?php
                                                              $video_link_data = array(
                                                                  'name' => 'video_link',
                                                                  'id' => 'video_link',
                                                                  'value' => set_value('video_link', ((isset($video_link)) ? $video_link : '')),
                                                                  'style' => 'width:198px;',
                                                                  'class' => 'validate[required,custom[url]]'
                                                              );
                                                            ?>
                                                            <tr id="src" style="display: none">
                                                                  <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('file_source'), 'video_src'); ?>:</td><td><?php echo form_upload($video_src_data) ?><span style="color: #696969"><?php echo lang('video_limit');?></td>
                                                            </tr>
                                                            <tr id="youtube" style="display: none">
                                                                  <td align="right" ><span class="star">*&nbsp;</span><?php echo form_label(lang('video_source'), 'video_src'); ?>:</td><td><?php echo form_input($video_link_data) ?><span style="color: grey;"><?php echo lang('i.e.'); ?></span><span class="warning-msg"><?php echo form_error('video_link'); ?></span></td>  
                                                            </tr>
                                                            <?php
                                                              if (isset($video_type) == SRC)
                                                              {
                                                                    ?>
                                                                    <tr>
                                                                          <td></td>
                                                                          <td>
                                                                                <a href="<?php echo base_url(); ?><?php echo $video_src ?>" class="video_image"> <?php echo basename($video_src); ?></a>
                                                                                <div><a href="<?php echo base_url() . $video_src ?>" id="player" class="player" style="display:none;width:520px;height:330px"></a></div>
                                                                          </td>
                                                                    </tr>
                                                                    <?php
                                                              }
                                                              else if (isset($video_type) == YOUTUBE)
                                                              {
                                                                    ?>
                                                                    <tr>
                                                                          <td></td>
                                                                          <td>
                                                                                <a target="_blank" href="<?php echo $video_src ?>"> <?php echo basename($video_src); ?></a> 
                                                                          </td>
                                                                    </tr>
                                                              <?php } ?>
                                                            <?php
                                                              if (CAPTCHA_SETTING)
                                                              {
                                                                    ?>
                                                                    <tr>
                                                                          <td align="right">
                                                                                <?php echo lang("enter_letters"); ?>
                                                                          </td>
                                                                          <td>
                                                                                <div style="display: none;">
                                                                                      <?php
                                                                                      $data1 = array(
                                                                                          'name' => 'data1',
                                                                                          'id' => 'data1',
                                                                                          'value' => $word
                                                                                      );
                                                                                      echo form_input($data1);
                                                                                      ?>
                                                                                </div>
                                                                                <?php
                                                                                $inputData = array(
                                                                                    'name' => 'captcha',
                                                                                    'id' => 'captcha',
                                                                                    'value' => "",
                                                                                    'style' => 'width:198px;',
                                                                                    'class' => "validate[required,equals[data1]]"
                                                                                );
                                                                                ?>   
                                                                                <span><?php echo form_input($inputData); ?></span>
                                                                                <span id="change_captcha"> <?php echo $captcha; ?></span><span><a href="javascript:;" id="new_captcha"><?php echo add_image(array('refresh_captcha.png')); ?></a></span>
                                                                                <span class="warning-msg"><?php echo form_error('captcha'); ?></span>
                                                                          </td>
                                                                    </tr>
                                                              <?php } ?>
                                                      </table>        
                                                </td>
                                          </tr>
                                    </table>
                              </td>
                        </tr>
                  </tbody>
            </table>
      </div>
      <div class="submit-btns clearfix">
            <?php
              $submit_button = array(
                  'name' => 'mysubmit',
                  'id' => 'mysubmit',
                  'value' => lang('btn-save'),
                  'title' => lang('btn-save'),
                  'class' => 'inputbutton',
              );
              echo form_submit($submit_button);
              $cancel_button = array(
                  'name' => 'cancel',
                  'value' => lang('btn-cancel'),
                  'title' => lang('btn-cancel'),
                  'class' => 'inputbutton',
                  'onclick' => "location.href='" . base_url(). "testimonial/index'",
              );
              echo "&nbsp;";
              echo form_reset($cancel_button);
            ?>
      </div>
      <?php
       if(isset($id) && $id!= '')
        {
            if (isset($testimonial_slug) && $testimonial_slug != '')
            echo form_hidden('old_slug_url', $testimonial_slug);   
         }   
        echo form_hidden('id', (isset($id)) ? $id : '0' );
        echo form_hidden('testimonial_id', (isset($testimonial_id)) ? $testimonial_id : '0' );
        echo form_hidden('logo', (isset($logo)) ? $logo : '0' );
        if (isset($video_type) == SRC)
        {
              echo form_hidden('video_src', (isset($video_src)) ? $video_src : '0' );
        }
        echo form_close();
      ?>
</div>
<script type="text/javascript">
      $(document).ready(function() {
            jQuery("#saveform").validationEngine(
                    {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
            );

            $('saveform').bind('submit', function(){
  if (typeof CKEDITOR != "undefined"){
    for (instance in CKEDITOR.instances){
      CKEDITOR.instances[instance].updateElement();
    }
  }
});

            $('#new_captcha').click(function() {
                  $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>testimonial/recaptcha',
                        data: {<?php echo $ci->security->get_csrf_token_name(); ?>: '<?php echo $ci->security->get_csrf_hash(); ?>'},
                        success: function(data) {
                              $("#change_captcha").html(data);
                        }
                  });
            });
      });
      $('#testimonial_slug').slugify('#testimonial_name');
      function change_type(id)
      {
            if (id == '1')
            {
                  $("#src").show();              
                  $("#youtube").hide();
            }
            if (id == '2')
            {
                  $("#youtube").show();             
                  $("#src").hide();
            }
            if (id == '')
            {
                  $("#src").hide();
                  $("#youtube").hide();
            }
      }
      change_type($("#change").val());
      $('.video_image').bind('click', function(e) {
            // Prevents the default action to be triggered. 
            e.preventDefault();
            // Triggering bPopup when click event is fired
            $('.player').bPopup();
            $f("player", "<?php echo base_url(); ?>themes/front/js/modules/testimonial/flowplayer-3.2.16.swf",
                    {plugins: {
                                controls: {
                                      // you do not need full path here when the plugin
                                      // is in the same folder as flowplayer.swf
                                      url: "<?php echo base_url(); ?>themes/front/js/modules/testimonial/flowplayer.controls-3.2.15.swf",
                                }
                          }
                    }
            );
      });
</script>