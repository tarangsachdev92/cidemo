<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-data') ?></h3>

              <?php echo anchor(site_url().get_current_section($this).'/roles', lang('view-all-role'), 'title="View All Roles" class="add-link"'); ?>
       </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('role-name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['role_name']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('role-description'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['role_description']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo form_label(lang('status'), 'Status'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if($data['status']=='1'){ echo lang('active'); }else{ echo lang('inactive'); }?></div>
                            </div>
                            
                            
                            
                           


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>