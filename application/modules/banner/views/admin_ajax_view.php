<div class="contentpanel">
    <div class="row">        
        <div class="col-md-12">
            
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-banner'); ?> - <?php echo $language_name; ?></h3>
                <a class="add-link" title="<?php echo lang('banner_list'); ?>" href="<?php echo site_url().get_current_section($this) ?>/banner/index/<?php echo $language_code; ?>"><?php echo lang('banner_list'); ?></a>
            </div>
            
            <div class="panel table-panel viewdata-user">
                <div class="panel-body">
                    <div class="userview-data">
                        <div class="row">
                            <?php if (count($banner) > 0) {?>
                                <div class="viewdata-column">
                                    <div class="col-md-2 viewdata-title"><?php echo lang('section'); ?></div>
                                    <div class="col-md-10 viewdata-detail">
                                        <?php
                                        if (isset($banner['ad']['section_id'])) {
                                            if (array_key_exists($banner['ad']['section_id'], $banner_data['sections']))
                                                echo $banner_data['sections'][$banner['ad']['section_id']];
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="viewdata-column">
                                    <div class="col-md-2 viewdata-title"><?php echo lang('title'); ?></div>
                                    <div class="col-md-10 viewdata-detail">
                                        <?php
                                        if (isset($banner['ad']['title']))
                                            echo $banner['ad']['title'];
                                        ?>
                                    </div>
                                </div>

                                <div class="viewdata-column">
                                    <div class="col-md-2 viewdata-title"><?php echo lang('description'); ?></div>
                                    <div class="col-md-10 viewdata-detail">
                                        <?php
                                        if (isset($banner['ad']['description']))
                                            echo $banner['ad']['description'];
                                        ?>
                                    </div>
                                </div>

                                <?php if ($banner['ad']['section_id'] == '2' && isset($banner['ad']['banner_type'])) { ?>
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('type'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            if (array_key_exists($banner['ad']['banner_type'], $banner_data['types']))
                                                echo $banner_data['types'][$banner['ad']['banner_type']];
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if (isset($banner['ad']['section_id']) && ( $banner['ad']['section_id'] == '1' || ($banner['ad']['section_id'] == '2' && $banner['ad']['banner_type'] == '1'))) {
                                    ?>

                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('image'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            if (isset($banner['ad']['image_url'])) {
                                                ?>
                                                <img src='<?php echo base_url(); ?>assets/uploads/banner_ad_images/main/<?php echo $banner['ad']['image_url']; ?>' class="img-responsive" />
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                <?php } ?>


                                <?php
                                if (isset($banner['ad']['link']) && $banner['ad']['link'] != '') {
                                    ?>
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('link'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            echo $banner['ad']['link'];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($banner['ad']['section_id'] == '2' && isset($banner['ad']['banner_type']) && $banner['ad']['banner_type'] == '2') {
                                    ?> 
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('code'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            echo $banner['ad']['embedded_code'];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($banner['ad']['section_id'] == '2' && isset($banner['ad']['page_id'])) {
                                    ?>
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('page'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            if (array_key_exists($banner['ad']['page_id'], $banner_data['pages']))
                                                echo $banner_data['pages'][$banner['ad']['page_id']];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($banner['ad']['section_id'] == '2' && isset($banner['ad']['position'])) {
                                    ?>  
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('position'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            if (array_key_exists($banner['ad']['position'], $banner_data['positions']))
                                                echo $banner_data['positions'][$banner['ad']['position']];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($banner['ad']['section_id'] == '1' && isset($banner['ad']['order'])) {
                                    ?>
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('order'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            echo $banner['ad']['order'];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if (isset($banner['c']['city_name'])) {
                                    ?>
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('city'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            echo $banner['c']['city_name'];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if (isset($banner['s']['state_name'])) {
                                    ?>
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('state'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            echo $banner['s']['state_name'];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if (isset($banner['cnt']['country_name'])) {
                                    ?>
                                    <div class="viewdata-column">
                                        <div class="col-md-2 viewdata-title"><?php echo lang('country'); ?></div>
                                        <div class="col-md-10 viewdata-detail">
                                            <?php
                                            echo $banner['cnt']['country_name'];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="viewdata-column">
                                    <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?></div>
                                    <div class="col-md-10 viewdata-detail">
                                        <?php
                                        if (isset($banner['ad']['status']) && $banner['ad']['status'] == '1')
                                            echo lang('active');
                                        if (isset($banner['ad']['status']) && $banner['ad']['status'] == '0')
                                            echo lang('inactive');
                                        ?>
                                    </div>
                                </div>
                                <?php
                            } else {
                                echo lang('no-banner-translation');
                            }
                            ?>
                        </div>		     
                    </div>
                </div>
            </div>
        </div><!-- col-md-6 -->
    </div>
</div>