<?php echo add_css(array('front_testimonial'), 'testimonial', 'modules'); ?>
<?php echo add_js(array('flowplayer-3.2.12.min', 'jquery.bpopup.min'), 'testimonial', 'modules'); ?>
<table cellspacing="0" cellpadding="0" width="100%">
    <tr class="content" >
        <td class="add-new">
            <?php if (isset($user_id))
            {
                echo anchor(site_url() . 'testimonial/action/add/'.$language_code, lang('add-testimonial'), 'title="Add Testimonial" style="text-align:center;width:100%;"');
            } ?>
            <span style="padding-left: 10px;">         
            <?php echo anchor(site_url() . 'testimonial/index/' . $language_code, lang('view-all-records'), 'title="View All Testimonials" style="text-align:center;width:100%;"'); ?>
            </span>
            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="content-left" valign="top" style="" id="ajax_table">
                        <div style="border: 1px solid #999999;">
                            <table width="100%" style="margin: 0px;padding: 0px;">
                                <tr style="margin-bottom: 15px;">
                                    <td>
                                        <h2 style=" font-size: 24px;margin-bottom: 8px;">
                                            <?php echo $records['testimonial_name']; ?>
                                        </h2>
                                        by
                                        <span class="title_font">
                                            <?php echo $records['firstname'] . " " . $records['lastname']; ?>
                                        </span>
                                        in
                                        <span class="title_font" >
                                        <?php echo $records['title']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <?php if ($records['logo'] != '')
                                { ?>
                                    <tr>
                                        <td><img src="<?php echo base_url() . $records['logo']; ?>" style="width:150px;height: 150px;padding:0 20 0 20px"/>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <?php if ($records['company_name'] != '')
                                { ?>
                                    <tr>
                                        <td>
                                            <span class='title_font'><?php echo lang('company_name'); ?> : </span> <?php echo $records['company_name']; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($records['website'] != '')
                                { ?>
                                    <tr>
                                        <td>
                                            <span class="title_font"><?php echo lang('website'); ?> : </span> <a target="_blank" href="<?php echo $records['website']; ?>"><?php echo $records['website']; ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($records['position'] != '')
                                { ?>
                                    <tr>
                                        <td>
                                            <span class="title_font"><?php echo lang('position'); ?> : </span> <?php echo $records['position']; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>
                                        <span class="title_font"><?php echo lang('posted_on') ?> : </span><?php echo $records['created_on']; ?>
                                    </td>
                                </tr>
                                <?php if ($records['video_src'] != '')
                                { ?>
                                    <tr>
                                        <td>
                                        <?php if ($records['video_type'] == SRC)
                                        { ?>
                                                <a  href="<?php echo base_url(); ?><?php echo $records['video_src'] ?>"> <img src='<?php echo base_url(); ?>themes/front/images/testimonial/video-btn.png' style="border: none;" class="video_image"/></a> 
                                                <div><a href="<?php echo base_url() . $records['video_src'] ?>" id="player" class="player" style="display:none;width:520px;height:330px"></a></div>
                                            <?php }
                                            else if ($records['video_type'] == YOUTUBE)
                                            { ?>
                                                <a target="_blank" href="<?php echo $records['video_src'] ?>"> <img src='<?php echo base_url(); ?>themes/front/images/testimonial/video-btn.png' style="border: none;" /></a> 
                                                <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="background-color: #FFFFFF;padding: 5px;font: 400 14px/1.55 'Open Sans','Lucida Grande',Arial,sans-serif;color: #777777" colspan="2">
                                        <p>
                                            <?php echo $records['testimonial_description']; ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script type="text/javascript">
    $('.video_image').bind('click', function(e) {
        // Prevents the default action to be triggered. 
        e.preventDefault();
        // Triggering bPopup when click event is fired
        $('.player').bPopup();
        $f("player", "<?php echo base_url(); ?>themes/front/js/modules/testimonial/flowplayer-3.2.16.swf",
                {plugins: {
                        controls: {
                            // you do not need full path here when the plugin
                            // is in the same folder as flowplayer.swf
                            url: "<?php echo base_url(); ?>themes/front/js/modules/testimonial/flowplayer.controls-3.2.15.swf",
                        }
                    }
                }
        );
    });
</script>