<div class="contentpanel">

    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <h3 class="mb15"><?php echo lang('view-email-template'); ?> - <?php echo $language_name; ?></h3>

                <?php echo anchor(get_current_section($this) . '/email_template/index/' . $language_code, lang('email-template-list'), 'title="' . lang('email-template-list') . '" class="add-link" '); ?>

            </div>

            <div class="panel table-panel viewdata-user">
                <div class="panel-body">

                    <div class="userview-data">
                        <div class="row">
                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('template-name'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($template[0]['c']['template_name']))
                                        echo $template[0]['c']['template_name'];
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title"><?php echo lang('template-body'); ?></div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($template[0]['c']['template_body']))
                                        echo nl2br($template[0]['c']['template_body']);
                                    ?>
                                </div>
                            </div>

                            <div class="viewdata-column">
                                <div class="col-md-2 viewdata-title">
                                    <?php echo lang('status'); ?>
                                </div>
                                <div class="col-md-10 viewdata-detail">
                                    <?php
                                    if (isset($template[0]['c']['status']) && $template[0]['c']['status'] == '1')
                                        echo lang('active');
                                    if (isset($template[0]['c']['status']) && $template[0]['c']['status'] == '0')
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