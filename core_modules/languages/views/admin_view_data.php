<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-url-data') ?></h3>

                 <?php echo anchor(site_url().get_current_section($this).'/languages', lang('languages-view'), 'title="View All Languages" class="add-link"'); ?>
            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('languages-name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['l']['language_name']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('languages-code'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data[0]['l']['language_code']?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('languages-direction'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if(isset($data[0]['l']['direction']) && $data[0]['l']['direction']=="ltr"){ echo "Left"; } else { echo "Right"; } ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('languages-default'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if(isset($data[0]['l']['default'])){ echo ($data[0]['l']['default'] == 1)?'Yes':'No'; } ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if($data[0]['l']['status']=='1'){ echo lang('active'); }else{ echo lang('inactive'); }?></div>
                            </div>
                            
                           


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>