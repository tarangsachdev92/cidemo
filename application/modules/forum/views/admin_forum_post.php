<div class="contentpanel">
    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">

                <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>


                <?php echo anchor(site_url() . $this->_data["section_name"] . '/forum/forum_listing/' . $forum_first_post['fp']['category_id'] . "/" . $language_code, lang('back-to-listing'), 'title="Back to listing" class="add-link" '); ?>
            </div>
            <div class="panel table-panel">
                <div class="panel-body">
                    <div class="table-responsive">          		
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>
                            <div class="ckbox ckbox-default">
                                <input type="checkbox" name="check_all" id="check_all" value="0">
                                <label for="check_all"></label>
                            </div>

                            </th>

                            <th><?php echo lang('author'); ?></th>
                            <th><?php echo lang('post_details'); ?></th>
                            <th><?php echo lang('comment'); ?></th>
                            <th><?php echo lang('action'); ?></th>

                            </tr>

                            </thead>
                            <tbody>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?php echo add_image(array('default_pic.jpg')); ?></td>
                                    <td>
                                        <ul>
                                            <li><?php echo lang('posted_by') . ': '; ?><?php echo $forum_first_post['u']['firstname'] . "&nbsp;" . $forum_first_post['u']['lastname']; ?></li>
                                            <li><?php echo lang('posted_on') . ': '; ?><?php echo $forum_first_post['fp']['created_on']; ?></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <b><?php echo $forum_first_post['fp']['forum_post_title']; ?></b>
                                        <br /><br />
                                        <?php echo $forum_first_post['fp']['forum_post_text']; ?>
                                    </td>

                                    <td>
                                        <ul>
                                            <li><?php echo lang('total_comment') . '&nbsp;&nbsp;' . $total_records; ?></li>
                                            <li><?php echo lang('total_view') . '&nbsp;&nbsp;' . $view_count['custom']['total']; ?>
                                                <?php
                                                if (isset($last_post['custom']['lastupdate']) && $last_post['custom']['lastupdate'] != "") {
                                                    echo "<li>" . lang('last_comment_on') . '&nbsp;&nbsp;' . $last_post['custom']['lastupdate'] . "</li>";
                                                }
                                                ?>
                                        </ul>
                                    </td>
                                </tr>

                                <?php
                                if ($page_number > 1) {
                                    $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                                } else {
                                    $i = 1;
                                }
                                if (isset($forum_post_comments) && $forum_post_comments != "") {
                                    foreach ($forum_post_comments as $forum_post_comment) {
                                        ?>
                                        <tr>
                                            <td valign="top">
                                                <div class="ckbox ckbox-default">
                                                    <input type="checkbox" value="<?php echo $forum_post_comment['ft']['id']; ?>" class="check_box" name="check_box[]" id="<?php echo $forum_post_comment['ft']['id']; ?>">
                                                    <label for="<?php echo $forum_post_comment['ft']['id']; ?>"></label>
                                                </div>
                                            </td>
                                            <td><?php echo add_image(array('default_pic.jpg')); ?></td>

                                            <td>
                                                <ul>
                                                    <li><?php echo lang('posted_by') . ': '; ?><?php echo $forum_post_comment['u']['firstname'] . "&nbsp;" . $forum_post_comment['u']['lastname']; ?></li>
                                                    <li><?php echo lang('posted_on') . ': '; ?><?php echo $forum_post_comment['ft']['created_on']; ?></li>
                                                </ul> 
                                            </td>


                                            <td>
                                                <b><?php echo $forum_post_comment['ft']['topic_title']; ?></b>
                                                <br /><br />
                                                <?php echo $forum_post_comment['ft']['topic_text']; ?>

                                                <?php
                                                if (isset($forum_post_comment['ft']['attachment']) && $forum_post_comment['ft']['attachment'] != "") {
                                                    echo lang('attachment');
                                                    ?>: 
                                                    <a  href="<?php echo site_url(); ?>assets/uploads/forum_files/<?php echo $forum_post_comment['ft']['attachment']; ?>" target="_blank"> <?php echo $forum_post_comment['ft']['attachment']; ?> </a>
                                                <?php } ?>
                                            </td>


                                            <td>
                                                (#<?php echo lang('reply') . '&nbsp;&nbsp;' . $i; ?>)
                                                <?php $topic_id = $forum_post_comment['ft']['id']; ?>

                                                &nbsp;&nbsp;&nbsp; 

                                                <!--Show Status-->
                                                <?php
                                                if ($forum_post_comment['ft']['status'] == 1) {
                                                    echo add_image(array('active.png'));
                                                } else {
                                                    echo add_image(array('inactive.png'));
                                                }
                                                ?>
                                                <!--Show Status-->

                                                &nbsp;&nbsp;&nbsp; 

                                                <a href="<?php echo site_url() . $this->_data["section_name"]; ?>/forum/topic_edit/<?php echo $topic_id . "/" . $id . "/" . $language_code ?>" class="mr5" title="<?php echo lang('edit') ?>"><i class="fa fa-pencil"></i></a>

                                                <?php
                                                $deletelink = "<a href='javascript:;' title='Delete' onclick='delete_topic($topic_id )'><i class='fa fa-trash-o'></i></a>";
                                                echo $deletelink
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    echo 'No Record(s) Found';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-panel mb15">
                        <button onclick="delete_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Delete</button>
                        <button onclick="active_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active</button>
                        <button onclick="inactive_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>In Active</button>
                        <button onclick="active_all_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active All</button>
                        <button onclick="inactive_all_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Inactive All</button>
                    </div>

                    <?php
                    $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash());
                    $options = array(
                        'total_records' => $total_records,
                        'page_number' => $page_number,
                        'isAjaxRequest' => 1,
                        'base_url' => base_url() . $this->_data['section_name'] . "/forum/forum_post/" . $language_code . "/" . $id,
                        'params' => $querystr,
                        'element' => 'ajax_table'
                    );
                    widget('custom_pagination', $options);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('reply_this_post'); ?></h4>
        </div>

        <?php
        $attributes = array('name' => 'add_forum_post', 'id' => 'add_forum_post', "class" => "form-horizontal form-bordered");
        echo form_open_multipart("", $attributes);
        ?>

        <div class="panel-body panel-body-nopadding" style="display: block;">
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('reply_title'); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $title_data = array(
                        'name' => 'topic_title',
                        'id' => 'topic_title',
                        'value' => set_value('forum_title', ((isset($forum_name)) ? $forum_name : '')),
                        'class' => 'form-control'
                    );
                    echo form_input($title_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('topic_title'); ?></span>


                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('topic_text'); ?> <span class="asterisk">*</span></label>
                <div class="col-sm-9">

                    <?php
                    $reply_data = array(
                        'name' => 'topic_text',
                        'id' => 'topic_text',
                        'value' => '',
                        'class' => 'form-control'
                    );
                    echo form_textarea($reply_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('topic_text'); ?></span>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('attachment'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $attachment = array(
                        'name' => 'attachment',
                        'id' => 'attachment',
                        'value' => lang('attachment'),
                        'title' => lang('attachment'),
                        'class' => 'form-control'
                    );
                    echo form_upload($attachment);
                    ?>

                </div>
            </div>

        </div>

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">

                    <?php
                    $submit_button = array(
                        'name' => 'mysubmit',
                        'id' => 'mysubmit',
                        'value' => lang('Reply'),
                        'title' => lang('Reply'),
                        'class' => 'btn btn-primary',
                        'content' => '<i class="fa fa-reply-all"></i> &nbsp;' . lang('Reply'),
                        'type' => 'submit'
                    );
                    echo form_button($submit_button);

                    $cancel_button = array(
                        'name' => 'cancel',
                        'value' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url($this->_data["section_name"] . '/forum/forum_post/' . $language_code . "/" . $id) . "'",
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp;' . lang('btn-cancel')
                    );
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo form_button($cancel_button);
                    ?>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>


<?php
echo add_css(array('bootstrap-wysihtml5'));
echo add_js(array('wysihtml5-0.3.0.min', 'bootstrap-wysihtml5',));
?>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>

<script type="text/javascript">

                            $(document).ready(function() {
                                jQuery('#topic_text').wysihtml5({color: true, html: true});

                                $('#add_forum_post').bootstrapValidator({
                                    fields: {
                                        topic_title: {
                                            validators: {
                                                notEmpty: {
                                                    message: 'The Topic Title field is required.'
                                                }
                                            }
                                        }
                                    }});

                            });

                            $(function() {
                                $("#check_all").click(function() {
                                    if ($("#check_all").is(':checked')) {
                                        $(".check_box").prop("checked", true);
                                    }
                                    else
                                    {
                                        $(".check_box").prop("checked", false);
                                    }
                                });
                                $(".check_box").click(function() {

                                    if ($(".check_box").length == $(".check_box:checked").length) {
                                        $("#check_all").prop("checked", true);
                                        $(".check_box").attr("checked", "checked");
                                    }
                                    else
                                    {
                                        $("#check_all").removeAttr("checked");
                                    }

                                });
                            });


                            function attach_error_event() {
                                $('div.formError').bind('click', function() {
                                    $(this).fadeOut(1000, removeError);
                                });
                            }
                            function removeError()
                            {
                                jQuery(this).remove();
                            }
</script>

<script type="text/javascript">
    function delete_topic(id) {
        res = confirm('<?php echo lang('delete-alert') ?>');
        if (res) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data["section_name"]; ?>/forum/delete_topic',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', id: id},
                success: function(data) {

                    //for managing same state while record delete
                    if ($('.rows') && $('.rows').length > 1) {
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    } else {
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                    }
                    ajaxLink('<?php echo base_url() . $this->_data["section_name"]; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                        //set responce message
                                        $("#messages").show();
                                        $("#messages").html(data);
                                    }
                                });

                            }
                            else
                            {
                                return false;
                            }
                        }
                        function delete_records()
                        {
                            var val = [];
                            $(':checkbox:checked').each(function(i) {
                                val[i] = $(this).val();
                            });
                            if (val == "")
                            {
                                alert('Please select atleast one record for delete');
                                return false;
                            }

                            res = confirm('<?php echo lang('delete-alert') ?>');
                            if (res) {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>',
                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                                                    success: function(data) {

                                                        //for managing same state while record delete
                                                        if ($('.rows') && $('.rows').length > 1) {
                                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                        } else {
                                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                        }
                                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                                                            $("#messages").show();
                                                                            $("#messages").html(data);
                                                                        }
                                                                    });
                                                                } else
                                                                {
                                                                    return false;
                                                                }
                                                            }

                                                            function active_records()
                                                            {
                                                                var val = [];
                                                                $(':checkbox:checked').each(function(i) {
                                                                    val[i] = $(this).val();
                                                                });
                                                                if (val == "")
                                                                {
                                                                    alert('Please select atleast one record for active');
                                                                    return false;
                                                                }
                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>',
                                                                                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active', ids: val},
                                                                                success: function(data) {

                                                                                    //for managing same state while record delete
                                                                                    if ($('.rows') && $('.rows').length > 1) {
                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                    } else {
                                                                                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                    }
                                                                                    ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                                                                                    $("#messages").show();
                                                                                                    $("#messages").html(data);
                                                                                                }
                                                                                            });
                                                                                        }

                                                                                        function inactive_records()
                                                                                        {
                                                                                            var val = [];
                                                                                            $(':checkbox:checked').each(function(i) {
                                                                                                val[i] = $(this).val();
                                                                                            });
                                                                                            if (val == "")
                                                                                            {
                                                                                                alert('Please select atleast one record for inactive');
                                                                                                return false;
                                                                                            }
                                                                                            $.ajax({
                                                                                                type: 'POST',
                                                                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>',
                                                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
                                                                                                            success: function(data) {
                                                                                                                //for managing same state while record delete
                                                                                                                if ($('.rows') && $('.rows').length > 1) {
                                                                                                                    pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                } else {
                                                                                                                    pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                }
                                                                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                $("#messages").show();
                                                                                                                                $("#messages").html(data);
                                                                                                                            }
                                                                                                                        });
                                                                                                                    }

                                                                                                                    function active_all_records()
                                                                                                                    {
                                                                                                                        $.ajax({
                                                                                                                            type: 'POST',
                                                                                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>',
                                                                                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
                                                                                                                                        success: function(data) {
                                                                                                                                            //for managing same state while record delete
                                                                                                                                            if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                            } else {
                                                                                                                                                pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                            }
                                                                                                                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                            $("#messages").show();
                                                                                                                                                            $("#messages").html(data);
                                                                                                                                                        }
                                                                                                                                                    });
                                                                                                                                                }

                                                                                                                                                function inactive_all_records()
                                                                                                                                                {
                                                                                                                                                    $.ajax({
                                                                                                                                                        type: 'POST',
                                                                                                                                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>',
                                                                                                                                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
                                                                                                                                                                    success: function(data) {
                                                                                                                                                                        //for managing same state while record delete
                                                                                                                                                                        if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                                        } else {
                                                                                                                                                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                                        }
                                                                                                                                                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_post/<?php echo $language_code; ?>/<?php echo $id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                                        $("#messages").show();
                                                                                                                                                                                        $("#messages").html(data);
                                                                                                                                                                                    }
                                                                                                                                                                                });
                                                                                                                                                                            }

</script>