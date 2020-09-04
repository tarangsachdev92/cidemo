
<div class="contentpanel">
    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <?php echo anchor(site_url().$this->_data['section_name'].'/forum/' , lang('back-to-category'), 'title="View All Post" class="add-link" '); ?>
                
                

            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('post-name'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php echo $data['fp']['forum_post_title']?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('post-body'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php echo $data['fp']['forum_post_text']?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php  if($data['fp']['status']==1){ echo "active"; } else{ echo "inactive"; } ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('is_private'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php if($data['fp']['is_private']==1) { echo "Yes"; } else { echo "No"; }?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('created-by'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php echo $data['u']['firstname'].$data['u']['lastname'];?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('created-on'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php echo $data['fp']['created_on'];?>
                                </div>
                            </div>

                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>