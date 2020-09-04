<!---------------------------------------------html(start)----------------------------------------------------->
<div id="ajax_table">
    <div class="main-container">
        <div  class="content-center">
            <div style="float: right">
                <?php
                if (isset($logged_in)) {
                    echo anchor(site_url() . 'forum/action', lang('add-forum'), 'title="Add Forum" style="text-align:center;width:100%;"');
                }
                else
                {
                ?>
                    <p align="center">Please <a href=<?php echo base_url('users/login'); ?>>Login </a><?php echo lang('not_sign_in_message_add_forum'); ?></p>
                <?php
                }
                ?>
            </div>

            <div style="padding-bottom: 20px;">
            <?php if (!empty($forums)) { ?> <h2><?php echo lang("category"); ?>: <span style="color: #1D5283"><?php echo $category['categories']['title']; ?></span></h2> <?php } ?>
            </div>
            <div>

                <div class="search-box">
                    <table cellspacing="2" cellpadding="4" border="0">
                        <tbody>
                        <td align="right"><span class="star">*&nbsp;</span> <?php echo lang("search_forum"); ?>: </td>
                        <td align="left">
                            <?php
                            $input_data = array(
                                'name' => 'search_term',
                                'id' => 'search_term',
                                //'class' => 'validate[required]',
                                'value' => set_value('search_term', urldecode($search_term))
                            );
                            echo form_input($input_data);
                            ?>
                        </td>
                        <td>
                            <?php
                            $search_button = array(
                                'content' => "Search",
                                'title' => "Search",
                                'class' => 'inputbutton',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button);
                            ?>
                        </td>
                        <td>
                            <?php
                            $reset_button = array(
                                'content' => "Reset",
                                'title' => "Reset",
                                'class' => 'inputbutton',
                                'onclick' => "reset_data()",
                            );
                            echo form_button($reset_button);
                            ?>
                        </td>
                        <td style="">
                            <a href="<?php echo site_url() . 'forum/index/' ?>" style="padding: 20px;"><?php echo lang("back-to-category"); ?></a>

                        </td>
                        </tbody>
                    </table>
                </div>

                <?php
                if (!empty($forums)) {
                    ?>
                    <div class="grid-data grid-data-table">

                <?php echo form_open(); ?>
                        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%" style="text-align: left">
                            <tbody bgcolor="#fff">
                                <tr>
                                    <th>
                                       <?php echo lang('no'); ?>
                                    </th>
                                    <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = 'srt_down.png';
                                        if ($sort_by == 'forum_post_title' && $sort_order == 'asc') {
                                            $sort_image = 'srt_up.png';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                    <th>
                                         <a href="#" onclick="sort_data('forum_post_title', '<?php echo $field_sort_order; ?>');">
                                         <?php echo lang('forum_post_title'); ?>
                                        </a>
                                        <?php
                                        if ($sort_by == 'forum_post_title') {
                                            ?>
                                        <div class="sorting">
                                        <?php echo add_image(array($sort_image)); ?>
                                        </div>
                                        <?php }
                                        ?>
                                    </th>

                            <th>
                               <?php echo lang('rly_count'); ?>
                            </th>

                            <th>
                                <?php echo lang('last_update_on'); ?>
                            </th>

                            </tr>
                            <?php
                            if (isset($page_number) && $page_number > 1) {
                                $i = ($this->_ci->session->userdata[$section_name]['record_per_page'] * ($page_number - 1)) + 1;
                            } else {
                                $i = 1;
                            }
                            foreach ($forums as $forum) {
                                if ($i % 2 != 0)
                                {
                                    $color = "lightgray";
                                }
                                else
                                {
                                    $color = "white";
                                }
                                $slug = $forum['forum_post']['slug_url'];
                                //$forum['forum_post']['id']
                                ?>

                                <tr style="height: 50px; background-color: <?php echo $color;  ?>">
                                    <td><?php echo $i; ?> <?php if ($forum['forum_post']['is_private'] == 1) echo add_image(array('imp.png')); ?></td>
                                    <td><a href="<?php echo site_url(); ?>forum/forum_post/<?php echo $slug ?>"><?php echo $forum['forum_post']['forum_post_title']; ?></a></td>
                                    <td><?php echo $forum['forum_post']['rly_count']; ?></td>

                                    <td>
                                        <?php
                                        if ($forum['forum_post']['modified_on'] == "0000-00-00 00:00:00")
                                        {
                                            $forum['forum_post']['modified_on'] = "-";
                                        }
                                        echo $forum['forum_post']['modified_on'];
                                        $forum_id = $forum['forum_post']['id'];
                                        ?>
                                    </td>

                                </tr>
                                <?php
                                $i++;
                            }
                            echo form_hidden('search_text', (isset($search_text)) ? $search_text : '' );
                            echo form_hidden('page_number', "", "page_number");
                            echo form_hidden('per_page_result', "", "per_page_result");
                            ?>

                <?php
                $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
                ?>
                <tr>
                  <td colspan="4">
                  <?php
                  $options = array(
                      'total_records' => $total_records,
                      'page_number' => $page_number,
                      'isAjaxRequest' => 1,
                      //'base_url' => base_url() . "/forum/forum_listing/" . $category_id . "/" . $language_code,
                      'params' => $querystr,
                      'element' => 'ajax_table'
                  );
                  widget('custom_pagination', $options);
                  ?>
                  </td>
                </tr>
                <?php
            }
            else
            {
               echo lang('no_records_found');
            }
            ?>
            </tbody>
            </table>
                <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<!---------------------------------------------html(complete)----------------------------------------------------->   

<!---------------------------------------------js & ajax area(start)----------------------------------------------------->
<script type="text/javascript">

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
            //url: '<?php echo base_url(); ?>admin/forum/index/1',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: $('#search_term').val(), sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
    $("#search_term").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                submit_search();
            }
    });
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
            //url:'<?php echo base_url(); ?>admin/forum/index',
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
            //url:'<?php echo base_url(); ?>/forum/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: ""},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }

</script>
<!---------------------------------------------js & ajax area(complete)----------------------------------------------------->