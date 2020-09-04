<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-data') ?></h3>
                
                <?php echo anchor(base_url().get_current_section($this).'/permissions', lang('view-all-permission'), 'title="View All Permissions" class="add-link"'); ?>
                
            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('permission-label'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['permission_label'] ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('permission-title'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['permission_title'] ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('parent'); ?>:</div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php if($data['title']==""){ echo "Root"; }else { echo $data['title']; } ?>
                                </div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?>:</div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php if($data['status']==1) { echo lang('active'); }else { echo lang('inactive'); }  ?>
                                </div>
                            </div>
                            
                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>