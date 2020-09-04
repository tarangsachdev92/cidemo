<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view_categories'); ?> - <?php echo $language_name; ?></h3>

                <?php echo anchor(site_url() . 'admin/categories/index/' . $language_code, lang('categories_list'), 'title="' . lang('categories_list') . '" class="add-link" '); ?>

            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">
                      <?php  
                                if(count($categories) > 0)
                                {
                                ?>
                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('title'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                            if(isset($categories['title']))
                                                echo $categories['title'];
                                            ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('slug_url'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                   <?php
                                            if(isset($categories['slug_url'])) 
                                                echo $categories['slug_url'];
                                            ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('description'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                            if(isset($categories['description'])) 
                                                echo $categories['description'];
                                            ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('module_title'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                  <?php
                                            if(isset($categories['module_title'])) 
                                                echo $categories['module_title'];
                                            ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title">
                                    <?php echo lang('status'); ?>
                                </div>
                                <div class="col-md-10 viewdata-detail">
                                  <?php
                                            if(isset($categories['status']) && $categories['status'] == '1') 
                                                echo lang('active');
                                            if(isset($categories['status']) && $categories['status'] == '0') 
                                                echo lang('inactive');
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