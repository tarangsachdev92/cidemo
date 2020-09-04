<!---------------------------------------------ckeditor data(start)----------------------------------------------------->
<?php
$ckeditor = array(
    //ID of the textarea that will be replaced
    'id' => 'forum_description',
    'path' => 'assets/ckeditor',
    //Optionnal values
    'config' => array(
        'toolbar' => "Full", //Using the Full toolbar
        'width' => "550px", //Setting a custom width
        'height' => '100px', //Setting a custom height
    ),
);
?>
<!---------------------------------------------ckeditor data(complete)----------------------------------------------------->

<!---------------------------------------------add js(start)----------------------------------------------------->   
<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jquery-1.9.1.min', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<!---------------------------------------------add js(complete)----------------------------------------------------->

<!---------------------------------------------html(start)----------------------------------------------------->
<div id="ajax_table">
    <div class="main-container">

                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                    <h2><?php echo lang('add_forum'); ?></h2>
                    </tr>
                     <?php if (!empty($categories)) { ?>
                    <tr>
                        <td class="add-user-form-box">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                
                                <tr>
                                    <td width="100%" valign="top">
                                        <?php
                                        $attributes = array('name' => 'add_forum_form', 'id' => 'add_forum_form');
                                        if ((isset($action)) && $action == 'edit') {
                                            echo form_open('/forum/add_forum/edit/' . $forum_category, $attributes);
                                        } else {
                                            echo form_open('', $attributes);
                                        }
                                        ?>
                                        <table width="100%" cellpadding="5" cellspacing="1" border="0">

                                            <?php
                                            $title_data = array(
                                                'name' => 'forum_title',
                                                'id' => 'forum_title',
                                                'value' => set_value('forum_title', ((isset($forum_name)) ? $forum_name : '')),
                                                'style' => 'width:198px;',
                                                'class' => "validate[required]"
                                            );
                                            ?>
                                            <tr>
                                                <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('forum_title'), 'Forum title'); ?>:</td>
                                                <td><?php echo form_input($title_data); ?><br/><span class="warning-msg"><?php echo form_error('forum title'); ?></span></td>
                                            </tr>

                                            <tr>
                                                <td align="right" valign="top"></span><?php echo lang('forum_description'); ?>:</td>
                                                <td>
                                                    <?php
                                                    $description_data = array(
                                                        'name' => 'forum_description',
                                                        'id' => 'forum_description',
                                                        'value' => set_value('forum_description', ((isset($forum_description)) ? html_entity_decode($forum_description) : '')),
                                                        'style' => 'width:198px;'
                                                    );
                                                    echo form_textarea($description_data);
                                                    echo display_ckeditor($ckeditor);
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $statuslist = array();
                                            $statuslist_value = array();
                                            foreach ($categories as $category)
                                            {
                                                $statuslist_cat[$category["categories"]["category_id"]] = $category["categories"]["title"];
                                                $statuslist_cat_value = $category["categories"]["category_id"];
                                            }
                                            if (!isset($forum_category))
                                            {
                                                $forum_category = "";
                                            }
                                            ?>
                                            <tr>
                                                <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('category'), 'Category'); ?>:</td>
                                                <td>
                                                    <?php
                                                    echo form_dropdown('forum_category', $statuslist_cat, $forum_category, set_value($statuslist_cat_value));
                                                    ?>
                                                    <span class="warning-msg"><?php echo form_error('category'); ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="right"><?php echo form_label(lang('is_private'), 'is_private'); ?>:</td>
                                                <td class="checkbox">
                                                    <?php
                                                    if (isset($is_private) && $is_private == 1) {
                                                        $yes = TRUE;
                                                        $no = "";
                                                    } else {
                                                        $no = TRUE;
                                                        $yes = "";
                                                    }
                                                    ?>
                                                    <p><?php echo form_radio('is_private', '1', $yes); ?> <label><?php echo "Yes"; ?></label></p>
                                                    <p><?php echo form_radio('is_private', '0', $no); ?> <label><?php echo "No"; ?></label></p>
                                                </td>
                                            </tr>

                                            <?php
                                            if (isset($id) && $id != "" && $id != 0) {
                                                $statuslist = array('2' => 'Inactive', '1' => 'Active');
                                                if (!isset($status)) {
                                                    $status = "";
                                                }
                                                ?>
                                                <tr>
                                                    <td align="right"><span class="star">*&nbsp;</span><?php echo form_label(lang('status'), 'Status'); ?>:</td>
                                                    <td>
                                                        <?php
                                                        echo form_dropdown('status', $statuslist, $status);
                                                        ?>
                                                        <span class="warning-msg"><?php echo form_error('status'); ?></span>
                                                    </td>
                                                </tr>
                                            <?php } ?>


                                            <tr>
                                                <td colspan="2" style="padding-left: 320px"> <?php
                                            $submit_button = array(
                                                'name' => 'mysubmit',
                                                'id' => 'mysubmit',
                                                'value' => lang('btn-save'),
                                                'title' => lang('btn-save'),
                                                'class' => 'inputbutton',
                                            );
                                            echo form_submit($submit_button);
                                            $cancel_button = array(
                                                'name' => 'cancel',
                                                'value' => lang('btn-cancel'),
                                                'title' => lang('btn-cancel'),
                                                'class' => 'inputbutton',
                                                'onclick' => "location.href='" . site_url('/forum') . "'",
                                            );
                                            echo "&nbsp;";
                                            echo form_reset($cancel_button);
                                            ?>
                                                </td>
                                            </tr>
                                            <?php
                                            echo form_hidden('id', (isset($id)) ? $id : '0' );
                                            ?>
                                        </table>
                                        <?php echo form_close(); ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php
            } else {
                echo lang('Sorry_msg');
            }
            ?>
        </div>
    </div>

<!---------------------------------------------html(complete)----------------------------------------------------->

<!---------------------------------------------js & ajax area(start)----------------------------------------------------->
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#add_forum_form").validationEngine(
                {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"}
        );

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
    function sort_data(sort_by, sort_order)
    {
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/forum/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: $('#search_term').val(), sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
    function submit_search()
    {
        if ($('#search_term').val().trim() == '') {
            $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/forum/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: $('#search_term').val()},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
    function reset_data()
    {
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/forum/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: ""},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }

</script>
<!---------------------------------------------js & ajax area(complete)----------------------------------------------------->