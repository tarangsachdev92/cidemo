<!---------------------------------------------ckeditor data(start)----------------------------------------------------->
<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jquery.validate')); ?>
<?php

$ckeditor = array(
    //ID of the textarea that will be replaced
    'id' => 'topic_text',
    'path' => 'assets/ckeditor',
    //Optionnal values
    'config' => array(
        'toolbar' => "Full", //Using the Full toolbar
        'width' => "100%", //Setting a custom width
        'height' => '100px', //Setting a custom height
    ),
);
?>
<!---------------------------------------------ckeditor data(complete)----------------------------------------------------->

<!---------------------------------------------html(start)----------------------------------------------------->
<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jquery-1.9.1.min', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<?php echo add_js('jquery.slugify'); ?>
<div id="ajax_table">
    <?php
    if(!empty($category_name))
    {
    ?>
    <div class="main-container">
        <div class="content-center">
            <?php echo anchor(site_url() . 'forum/forum_listing/' . $category_name , lang('back-to-listing'), 'title="Back to listing" style="text-align:center;width:100%;"');
            ?>
            <div class="grid-data grid-data-table">
                <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%" style="text-align: left">
                    <tbody bgcolor="#fff">
                        <tr style="height: 50px">
                            <th>
                                <?php echo lang('author'); ?>
                            </th>
                            <th>
                                <?php echo lang('comment'); ?>
                            </th>
                            <th style="width: 300px">
                                <?php echo lang('reply'); ?>
                            </th>
                        </tr>
                        <?php
                        if (isset($page_number) && $page_number > 1) {
                            $i = ($this->_ci->session->userdata[$section_name]['record_per_page']  * ($page_number - 1)) + 1;
                        } else {
                            $i = 1;
                        }

                        if ($i % 2 != 0) {
                            $class = "odd-row";
                        } else {
                            $class = "even-row";
                        }

                        ?>

                        <tr style="border: none" class="odd-row rows" >
                            <td valign="top" width="100px;"><?php echo add_image(array('default_pic.jpg')); ?>
                               <br/><?php echo $forum_first_post['u']['firstname'] . "&nbsp;" . $forum_first_post['u']['lastname']; ?>
                                <br/><?php echo lang('posted_on'); ?><br/><?php echo $forum_first_post['fp']['created_on']; ?>
                            </td>
                            <td valign="top" ><b><?php echo $forum_first_post['fp']['forum_post_title']; ?></b>
                                <br/><br/><?php echo $forum_first_post['fp']['forum_post_text']; ?>
                            </td>
                            <td valign="top">
                                <table>
                                    <tr>
                                        <td><h3><?php echo lang('main_post'); ?></h3>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h4><?php echo lang('total_comment'); ?></h4>
                                        </td>
                                        <td><?php echo $total_records; ?></td>
                                    </tr>
                                    <tr>
                                        <td><h4><?php echo lang('total_view'); ?></h4>
                                        </td>

                                        <td><?php echo ($view_count['custom']['total']); ?></td>
                                    </tr>
                                    <?php
                                    if (isset($last_post['custom']['lastupdate']) && $last_post['custom']['lastupdate'] != "") {
                                        ?>
                                        <tr>

                                            <td><h4><?php echo lang('last_comment_on'); ?></h4>
                                            </td>
                                            <td><?php
                                                echo $last_post['custom']['lastupdate'];
                                                ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>

                        </tr>
                        <?php
                        if (isset($page_number) && $page_number > 1) {
                            $i = ($this->_ci->session->userdata[$section_name]['record_per_page']* ($page_number - 1)) + 1;
                        } else {
                            $i = 1;
                        }
                        if (isset($forum_post_comments) && $forum_post_comments != "") {
                            foreach ($forum_post_comments as $forum_post_comment) {
                                ?>
                                <tr style="border: none; background: #dedede">
                                    <td valign="top"><?php echo add_image(array('default_pic.jpg')); ?>
                                        <br/><?php echo $forum_post_comment['u']['firstname'] . "&nbsp;" . $forum_post_comment['u']['lastname']; ?>
                                        <br/><?php echo lang('posted_on'); ?><br/><?php echo $forum_post_comment['ft']['created_on']; ?>
                                    </td>
                                    <td valign="top" ><b><?php echo $forum_post_comment['ft']['topic_title']; ?></b>
                                        <br/><br/><?php echo $forum_post_comment['ft']['topic_text']; ?>


                                        <?php if (isset($forum_post_comment['ft']['attachment']) && $forum_post_comment['ft']['attachment'] != "") { ?> <?php echo lang('attachment'); ?>: <a target="_blank" href="<?php echo site_url(); ?>assets/uploads/forum_files/<?php echo $forum_post_comment['ft']['attachment']; ?>"> <?php echo $forum_post_comment['ft']['attachment']; ?> </a><?php }
                                        ?>
                                    </td>
                                    <td valign="top">
                                        <br/><h4>#<?php echo lang('reply'); ?> <?php
                                            echo $i;
                                            $topic_id = $forum_post_comment['ft']['id'];
                                            ?></h4>


                                    </td>


                                </tr>
                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                        <table>
                            <tr>
                                <td><?php echo lang('no_records_found'); ?></td>
                            </tr>
                        </table>
                        <?php
                    }
                    echo form_hidden('search_text', (isset($search_text)) ? $search_text : '' );
                    echo form_hidden('page_number', "", "page_number");
                    echo form_hidden('per_page_result', "", "per_page_result");
                    ?>

                          <tr>
                          <td colspan="3">
                          <?php
                          $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
                          $options = array(
                              'total_records' => $total_records,
                              'page_number' => $page_number,
                              'isAjaxRequest' => 1,
                              'base_url' => base_url() . "/forum/forum_post/" . $slug_url,
                              'params' => $querystr,
                              'element' => 'ajax_table'
                          );
                          widget('custom_pagination', $options);
                          ?>
                          </td>
                          </tr>
                </tbody>
                    <?php echo form_close(); ?>
            </table>
        </div>
        </div>

    </div>
    <?php
    if (isset($logged_in))
    {
        ?>
        <div class="grid-data grid-data-table">
                <?php
                $attributes = array('name' => 'add_forum_post', 'id' => 'add_forum_post');
                echo form_open_multipart("", $attributes);
                ?>
                <table cellspacing="1" cellpadding="3" border="0" bgcolor="#e6ecf2" width="100%" style="text-align: left">
                <tbody bgcolor="#fff">
                    <tr style="height: 50px">
                        <th>
                            Reply to this post
                        </th>
                    </tr>
                    <?php
                    $title_data = array(
                        'name' => 'topic_title',
                        'id' => 'topic_title',
                        'value' => set_value('forum_title', ((isset($forum_name)) ? $forum_name : '')),
                        //'style' => 'width:198px;',
                        'class' => "validate[required]"
                    );
                    ?>
                    <tr>
                        <td><span class="star">*&nbsp;</span><?php echo form_label(lang('reply_title'), 'Forum title'); ?>:
                            <?php echo form_input($title_data); ?><br/><span class="warning-msg"><?php echo form_error('Reply title'); ?></span></td>
                    </tr>

                    <tr>
                        <div id="ck_validation" style="display: none;">
                            <div class="topic_textformError parentFormadd_forum_post formError" style="opacity: 0.87; position: absolute; top: 700px; left: 75px; margin-top: 0px;">
                            <div class="formErrorContent">
                                    * This field is required
                            <br></div></div>
                        </div>
                            <?php
                            $reply_data = array(
                                'name' => 'topic_text',
                                'id' => 'topic_text',
                                'value' => '',
                                'style' => 'width:198px;',
                                'class' => "validate[required]"
                            );
                            ?>
                            <td><span class="star">*&nbsp;</span><?php echo form_label(lang('topic_text'), 'Reply text'); ?>:
                            <?php
                            echo form_textarea($reply_data);
                            echo display_ckeditor($ckeditor);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <?php
                            $attachment = array(
                                'name' => 'attachment',
                                'id' => 'attachment',
                                'value' => lang('attachment'),
                                'title' => lang('attachment')
                            );
                            echo form_label(lang('attachment'), 'Attachment');?>:<?php
                            echo form_upload($attachment);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" > <?php
                            $submit_button = array(
                                'name' => 'mysubmit',
                                'id' => 'mysubmit',
                                'value' => lang('Reply'),
                                'title' => lang('Reply'),
                                'class' => 'inputbutton',
                            );
                            echo form_submit($submit_button);
                            $cancel_button = array(
                                'name' => 'cancel',
                                'value' => lang('btn-cancel'),
                                'title' => lang('btn-cancel'),
                                'class' => 'inputbutton',
                                'onclick' => "location.href='" . site_url('forum/forum_post/' . $id . "/" . $language_code) . "'",
                            );
                            echo "&nbsp;";
                            echo form_reset($cancel_button);
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
             <?php echo form_close(); ?>
        </div>
        <?php
    }
    else
    {
    ?>
        <div>
            <p align="center"><?php echo lang('please'); ?> <a href=<?php echo base_url('users/login'); ?>><?php echo lang('login'); ?> </a><?php echo lang('not_sign_in_message_reply'); ?></p>
        </div>
    <?php
    }
}
else
{
    echo lang('no_records_found');
}
    ?>
</div>
<!---------------------------------------------html(complete)----------------------------------------------------->

<!---------------------------------------------js & ajax area(start)----------------------------------------------------->
<script type="text/javascript">
    $("#add_forum_post").submit( function() {
        var messageLength = CKEDITOR.instances['topic_text'].getData().replace(/<[^>]*>/gi, '').length;
        if( !messageLength ) {
            var top_px=$('#cke_topic_text').offset().top;
            var final_px=parseInt(top_px,10)+100;
            $(".topic_textformError").css("top", final_px);
            $("#ck_validation").css("display", "block");
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        jQuery("#add_forum_post").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );

    });

    function attach_error_event() {
        $('div.formError').bind('click', function() {
            $(this).fadeOut(1000, removeError);
            jQuery("#ck_validation").css("display", "none");
        });
    }
    function removeError()
    {
        jQuery(this).remove();
    }

</script>
<!---------------------------------------------js & ajax area(complete)----------------------------------------------------->