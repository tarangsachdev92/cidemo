<div class="contentpanel">
    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view_product'); ?> - <?php echo $language_name; ?></h3>

<!--                <a onclick="openlink('add')" class='add-link' title="<?php echo lang('Product_list'); ?>" href="#"><?php echo lang('Product_list'); ?></a>-->
                
                <a class='add-link' title="<?php echo lang('Product_list'); ?>" href="<?php echo site_url().'admin/products/'?>"><?php echo lang('Product_list'); ?></a>
                
            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('category'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['c']['title']))
                                        echo $result[0]['c']['title'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('name'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['p']['name']))
                                        echo $result[0]['p']['name'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('slug'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['p']['slug']))
                                        echo $result[0]['p']['slug'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('description'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['p']['description']))
                                        echo $result[0]['p']['description'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('status'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['p']['status']) && $result[0]['p']['status'] == '1')
                                        echo lang('active');
                                    if (isset($result[0]['p']['status']) && $result[0]['p']['status'] == '0')
                                        echo lang('inactive');
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('price'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php if (!empty($result[0]['p']['product_image']) && file_exists(FCPATH . "assets/uploads/products/thumbs/" . $result[0]['p']['product_image'])) {
                                        ?>

                                        <img src="<?php echo base_url() . "assets/uploads/products/thumbs/" . $result[0]['p']['product_image'] ?>" width="100" />

<?php } ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title">
<?php echo lang('featured'); ?>
                                </div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['p']['featured']))
                                        echo $result[0]['p']['featured'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title">
<?php echo lang('meta_fields'); ?>
                                </div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['p']['meta_keywords']))
                                        echo $result[0]['p']['meta_keywords'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title">
<?php echo lang('description'); ?>
                                </div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($result[0]['p']['meta_description']))
                                        echo $result[0]['p']['meta_description'];
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