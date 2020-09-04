<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-cms'); ?> - <?php echo $language_name; ?></h3>

                <?php echo anchor(site_url() . 'admin/cms/index/' . $language_code, lang('cms_list'), 'title="' . lang('cms_list') . '" class="add-link" '); ?>

            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('title'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($cms['title']))
                                        echo $cms['title'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('slug_url'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($cms['slug_url']))
                                        echo $cms['slug_url'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('description'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($cms['description']))
                                        echo $cms['description'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('title'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($cms['meta_title']))
                                        echo $cms['meta_title'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('keywords'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($cms['meta_keywords']))
                                        echo $cms['meta_keywords'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('description'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($cms['meta_description']))
                                        echo $cms['meta_description'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title">
                                    <?php echo lang('status'); ?>
                                </div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($cms['status']) && $cms['status'] == '1')
                                        echo lang('active');
                                    if (isset($cms['status']) && $cms['status'] == '0')
                                        echo lang('inactive');
                                    ?>
                                </div>
                            </div>


                        </div>		     
                    </div>



                </div>
            </div>




        </div><!-- col-md-6 -->
    </div>


</div>