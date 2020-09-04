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
                        'value' => set_value('topic_title', ((isset($topic_title)) ? $topic_title : '')),
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
                        'value' => set_value('topic_text', ((isset($topic_text)) ? html_entity_decode($topic_text) : '')),
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


                    echo "<p style='margin-top: 10px' >";
                    if (isset($attach)) {
                        echo $attach;
                    } else {
                        echo "No file";
                    }
                    echo "</p>";
                    ?>


                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('status'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $statuslist = array('2' => 'Inactive', '1' => 'Active');
                    echo form_dropdown('status', $statuslist, $status, ' class = "form-control" ');
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
                        'content' => '<i class="fa fa-save"></i> &nbsp; Save',
                        'type' => 'submit'
                    );
                    echo form_button($submit_button);

                    $cancel_button = array(
                        'name' => 'cancel',
                        'value' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; ' . lang('btn-cancel'),
                        'onclick' => "location.href='" . site_url($this->_data["section_name"] . '/forum/forum_post/' . $language_code . '/' . $post_id) . "'",
                    );
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo form_button($cancel_button);

                    echo form_hidden('file_exist', (isset($attach)) ? $attach : '' );
                    ?>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
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
</script>

<?php
echo add_css(array('bootstrap-wysihtml5'));
echo add_js(array('wysihtml5-0.3.0.min', 'bootstrap-wysihtml5',));
?>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>