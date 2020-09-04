<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-url-data') ?></h3>

                 <?php echo anchor(site_url().get_current_section($this).'/urls', lang('view-all-url'), 'title="View All URLs" class="add-link"'); ?>
            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo form_label(lang('slug-url'), 'slug_url'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['u']['slug_url']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo form_label(lang('module-name'), 'module_name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['u']['module_name']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo form_label(lang('core-url'), 'core_url'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if(isset($data[0]['u']['core_url'])){ echo $data[0]['u']['core_url']; } ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo form_label(lang('status'), 'Status'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if($data[0]['u']['status']=='1'){ echo lang('active'); }else{ echo lang('inactive'); }?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo form_label(lang('order'), 'Order'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['u']['order'];?></div>
                            </div>
                            
                           


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>