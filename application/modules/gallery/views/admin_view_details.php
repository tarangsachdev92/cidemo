<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-user-data') ?></h3>

               <?php echo anchor(site_url().$this->_data['section_name'].'/gallery/', lang('image-view-list-view'), 'title="'.lang('image-view-list-view').'" class="add-link"'); ?>
            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('image-view-gallery_title'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['G']['title']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('image-view-image-title'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['I']['title']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('image-view-tag'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['I']['tag']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('image-view-name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['I']['image']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('image-view-thumb'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if(file_exists("assets/uploads/gallery_images/thumb/".$data['I']['image'])) { ?><img src="<?php echo site_url()."assets/uploads/gallery_images/thumb/".$data['I']['image']; ?>"/><?php } ?></div>
                            </div>
                            
                          


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>