<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<tr class="content">
    <td>
        <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="content-left" valign="top" style="" id="ajax_table">
                    <div style="border: 1px solid #999999;">
                        <table width="100%" style="margin: 0px;padding: 0px;">
                            <tr style="margin-bottom: 15px;">
                                <td width="100%">
                                    <h2 style=" font-size: 24px;margin-bottom: 8px;">
                                        <a itemprop="url" title="<?php echo $title; ?>" href="#" style="color: #2A72C2;text-decoration: none"><?php echo $title; ?></a>
                                    </h2>
                                    <span class="blog-author">
                                        by
                                        <a itemprop="author" href="#"><?php echo lang('admin') ?></a>
                                    </span>
                                    <span class="blog-category">
                                        in
                                        <a href="#"><?php echo $category_name; ?></a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo base_url() . $blog_image; ?>" style="width:100%;height: 200px;padding:0 20 0 20px"/>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-size: 18px;">
                                        <?php echo lang('posted_on') ?><?php echo $created; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>

                                <td style="background-color: #FFFFFF;padding: 5px;font: 400 14px/1.55 'Open Sans','Lucida Grande',Arial,sans-serif;color: #777777">
                                    <p>
                                        <?php echo $blog_text; ?>
                                    </p>

                                </td>
                            </tr>
                        </table>
                    </div><br />
                </td>
            </tr>
            <tr>
                <td class="content-left">
                    <div>
                        <h3 style=" background: none repeat scroll 0 0 #333333;
                            border-radius: 2px 2px 2px 2px;
                            color: #CCCCCC;
                            font-family: Arial;
                            font-size: 15px;
                            font-weight: normal;
                            height: 33px;
                            line-height: 33px;
                            margin: 0 0 20px;
                            padding: 0 10px;
                            text-shadow: none;
                            text-transform: uppercase;">Comments</h3>
                        <table style="border-radius: 2px 2px 2px 2px;border:2px dashed;width:100%;padding: 5px;">
                            <?php
                            if (!empty($comments))
                            {
                                foreach ($comments as $comment)
                                {
                                    foreach ($comment as $_comment)
                                    {
                                        ?>
                                        <tr>
                                            <td><span style="color: #2A72C2;font-family: Arial;font-size: 17px;"><?php echo $_comment['name']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="font-size: 14px;color:#333333 ;font-family:Comic Sans MS"><?php echo $_comment['comment']; ?></span><hr/></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td><center><span style="font-size: 20px;color:#333333 ;font-family:Comic Sans MS">No Comments</span></center></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>

                    </div>
                </td>
            </tr>
            <tr>
                <td class="content-left">
                    <div>
                        <h3 style=" background: none repeat scroll 0 0 #333333;
                            border-radius: 2px 2px 2px 2px;
                            color: #CCCCCC;
                            font-family: Arial;
                            font-size: 15px;
                            font-weight: normal;
                            height: 33px;
                            line-height: 33px;
                            margin: 0 0 20px;
                            padding: 0 10px;
                            text-shadow: none;
                            text-transform: uppercase;">Leave your comments</h3>
                            <?php echo form_open_multipart('blog/save_comment', array('id' => 'saveform', 'name' => 'saveform')); ?>
                        <table style="width:100%;padding: 5px;">

                            <?php
                            $name_data = array(
                                'name' => 'name',
                                'id' => 'name',
                                'value' => set_value('name', ((isset($name)) ? $name : '')),
                                'style' => 'width:198px;',
                                'class' => 'validate[required]'
                            );
                            ?>
                            <tr>
                                <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('comment-name'), 'commentname'); ?>:</td>
                                <td><?php echo form_input($name_data); ?><br/><span class="warning-msg"><?php echo form_error('commentname'); ?></span></td>
                            </tr>
                            <?php
                            $email_data = array(
                                'name' => 'email',
                                'id' => 'email',
                                'value' => set_value('email', ((isset($email)) ? $email : '')),
                                'style' => 'width:198px;',
                                'class' => 'validate[required,custom[email]]'
                            );
                            ?>
                            <tr>
                                <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('comment-email'), 'commentemail'); ?>:</td>
                                <td><?php echo form_input($email_data); ?><br/><span class="warning-msg"><?php echo form_error('commentemail'); ?></span></td>
                            </tr>
                            <?php
                            $website_data = array(
                                'name' => 'website',
                                'id' => 'website',
                                'value' => set_value('website', ((isset($website)) ? $website : '')),
                                'style' => 'width:198px;',
                                'class' => 'validate[]'
                            );
                            ?>
                            <tr>
                                <td align="right"><span class="star"></span><?php echo form_label(lang('comment-website'), 'commentwebsite'); ?>:</td>
                                <td><?php echo form_input($website_data); ?><br/><span class="warning-msg"><?php echo form_error('commentwebsite'); ?></span></td>
                            </tr>
                            <?php
                            $comment_data = array(
                                'name' => 'comment_data',
                                'id' => 'comment_data',
                                'value' => set_value('comment_data', ((isset($comment_data)) ? $comment_data : '')),
                                'style' => 'width:350px;height:100px',
                                'class' => 'validate[required]'
                            );
                            ?>
                            <tr>
                                <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('comment'), 'comment'); ?>:</td>
                                <td><?php echo form_textarea($comment_data); ?><br/><span class="warning-msg"><?php echo form_error('comment'); ?></span></td>
                            </tr>
                            <?php
                            $submit_button = array(
                                'name' => 'mysubmit',
                                'id' => 'mysubmit',
                                'value' => lang('btn-save'),
                                'title' => lang('btn-save'),
                                'style' => 'background: none repeat scroll 0 0 #1E71C1 !important;color: #FFFFFF !important;cursor: pointer;',
                                'class' => 'inputbutton',
                            );
                            ?>
                            <tr>
                                <td align="right">&nbsp;</td>
                                <td><?php echo form_submit($submit_button); ?></td>
                            </tr>
                            <?php
                            echo form_hidden('blogpost_id', (isset($id)) ? $id : '0');
                            echo form_hidden('slug_url', (isset($slug_url)) ? $slug_url : '0' );
                            ?>	
                        </table>
                        <?php echo form_close(); ?>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
<script type="text/javascript">
    $(document).ready(function() {

        jQuery("#saveform").validationEngine(
        {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
    );

    });
</script>