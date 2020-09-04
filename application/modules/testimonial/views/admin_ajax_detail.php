<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('testimonial-view'); ?> - <?php echo $language_name; ?></h3>
            <a title="<?php echo lang('testimonial_list');?>" href="<?php echo site_url($this->section_name.'/testimonial') ?>" class="add-link"><?php echo lang('testimonial_list');?></a>
           </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">
        <?php
                                if (count($records) > 0)
                                {
                                    ?>
                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('testimonial_name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php
                                                if (isset($records['testimonial_name']))
                                                    echo $records['testimonial_name'];
                                                ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('slug'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                                if (isset($records['testimonial_slug']))
                                                    echo $records['testimonial_slug'];
                                                ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('description'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php
                                                if (isset($records['testimonial_description']))
                                                    echo html_entity_decode($records['testimonial_description']);
                                                ?> </div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('logo'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                                                                                                             
                                            
                                                
                                            if (!empty($records['logo']) && file_exists(FCPATH.$records['logo']))
                                            {                                            
                                                  $logo_image  = $records['logo'];
                                                    
                                                ?>                                      
                                                
                                                    <img src="<?php echo base_url(); ?><?php echo $logo_image; ?>" height ="50px"/>
                                         
                                      <?php } 
                                            else
                                                {
                                               
                                                       $logo = 'logo.jpg';   
                                                       $styles = array(
                                                         'width' => 100,
                                                          'height' =>100,
                                                       );
                                                      echo add_image(array($logo),'testimonial','modules',$styles); 
                                                      ?>
                                               
                                                <?php
                                                }
                                                ?>
                                </div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('company_name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                                if (isset($records['company_name']))
                                                    echo $records['company_name'];
                                                ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('website'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                                if (isset($records['website']))
                                                    echo $records['website'];
                                                ?>
                                </div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('video_source'); ?>:</div>
                                <div class="col-md-10 viewdata-detail">
                                            <?php
                                            if (isset($records['video_src']))
                                                
                                
                                               ?>
                                     <a class="facybox" href="<?php echo $records['video_src']; ?>"> <?php echo basename($records['video_src']); ?></a> 
                                           
                                </div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('position'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                          
                                                if (isset($records['is_published']) && $records['is_published'] == PUBLISH)
                                                    echo lang('publish');
                                                if (isset($records['is_published']) && $records['is_published'] == UNPUBLISH)
                                                    echo lang('unpublish');
                                                ?>
                                </div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                                if (isset($records['position']))
                                                    echo $records['position'];
                                                ?>
                                </div>
                            </div>

                        </div>		     
                    </div>

                    <?php
                                }
                                
                                    ?>

                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>