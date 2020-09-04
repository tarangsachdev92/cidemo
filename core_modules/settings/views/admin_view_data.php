<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-data'); ?></h3>

                <?php echo anchor(get_current_section($this).'/settings', lang('view-settings'), 'title="' . lang('view-settings') . '" class="add-link"'); ?>
        </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('setting-title'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['s']['setting_label']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('setting-label'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['s']['setting_title']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('setting-value'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if(isset($data[0]['s']['setting_value'])){ echo $data[0]['s']['setting_value']; } ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('setting-comment'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['s']['comment']; ?></div>
                            </div>
                            
                                                 


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>