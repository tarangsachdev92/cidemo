<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-blog'); ?> - <?php echo $language_name; ?></h3>

               <?php echo anchor(site_url(). get_current_section($this) . '/blog', lang('view-all-blog'), 'title="'.lang('view-all-blog').'" class="add-link"'); ?>
        </div>
      
            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('title'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                          if(isset($blog_detail[0]['b']['slug_url'])) 
                                                echo $blog_detail[0]['b']['title'];
                                            ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('slug_url'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php
                                            if(isset($blog_detail[0]['b']['slug_url'])) 
                                                echo $blog_detail[0]['b']['slug_url'];
                                            ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('blog-text'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                            if(isset($blog_detail[0]['b']['blog_text']))
                                            {
                                                echo html_entity_decode($blog_detail[0]['b']['blog_text']);
                                            }
                                            ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('blog-image'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"> <?php
                                            if(isset($blog_detail[0]['b']['blog_image'])&& $blog_detail[0]['b']['blog_image']!="")
                                            {
                                                echo "<p><img style='width:50px;height:50px;padding:4px' alt='' src=".base_url().$blog_detail[0]['b']['blog_image']."></p>";
                                            }
                                            else
                                            {
                                                echo "&nbsp;";
                                            }
                                            ?>                   </div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?>:</div>
                                <div class="col-md-10 viewdata-detail">
                                           <?php
                                            if(isset($blog_detail[0]['b']['status']) && $blog_detail[0]['b']['status'] == '1') 
                                                echo lang('active');
                                            if(isset($blog_detail[0]['b']['status']) && $blog_detail[0]['b']['status'] == '0') 
                                                echo lang('inactive');
                                            ?></div>
                            </div>
                            
                            


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>