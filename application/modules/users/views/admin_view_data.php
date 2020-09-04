<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-user-data') ?></h3>

                <?php echo anchor(site_url() . $this->_data['section_name'] . '/users', lang('view-all-user'), 'title="View All Users" class="add-link"'); ?>
            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('first-name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['firstname'] ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('last-name'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['lastname'] ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('email'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['email'] ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('address'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['address'] ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('gender'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if(isset($data['gender']) && $data['gender']=='M'){ echo lang('male'); }else if(isset($data['gender']) && $data['gender']=='F'){ echo lang('female'); }?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('role'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php echo $data['role_name'] ?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('hobbies'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if(isset($data['hobbies'])) { echo str_replace(',', ', ', $data['hobbies']); }?></div>
                            </div>
                            
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?>:</div>
                                <div class="col-md-10 viewdata-detail"><?php if($data['status']=='1'){ echo lang('active'); }else{ echo lang('inactive'); }?></div>
                            </div>


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>