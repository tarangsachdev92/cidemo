<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="right"><?php echo lang('search_by') ?> :</td>
                        <td align="left">
                            <?php
                            $search_options = array(
                                'status' => lang('status'),
                            );
                            echo form_dropdown('search', $search_options, urldecode($search), 'id=search onchange = change_search(this.value);');
                            ?>
                        </td>
                        <td id='search_options'>
                            <?php
                            $status = array(
                                '' => '---All Status---',
                                '1' => lang('active'),
                                '0' => lang('inactive')
                            );
                            ?>
                            <div id='status'> <?php echo lang('status') . " : " . form_dropdown('search_status', $status, urldecode($search_status), 'id=search_status class=search') . "  "; ?> </div>
                        </td>

                        <td>
                            <?php
                            $search_button = array(
                                'content' => lang('btn_search'),
                                'title' => lang('btn_search'),
                                'class' => 'inputbutton',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button) . " ";

                            $reset_button = array(
                                'content' => lang('reset_button'),
                                'title' => lang('reset_button'),
                                'class' => 'inputbutton',
                                'onclick' => "reset_data()",
                            );
                            echo form_button($reset_button);
                            ?>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
                <tr>
                    <th width="30px" style="text-align:center ;"><input type="checkbox" name="check_all" id="check_all" value="0"></th>
                    <th style="text-align:center ;"><?php echo lang('no'); ?></th>
                    <th style="text-align:center ;">
                        <?php echo lang('product_image') ?>
                    </th>
                    <th style="text-align:center ;">
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_up.png';
                        if ($sort_by == 'scpi.status' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_down.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('scpi.status', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('status'); ?>
                            <?php
                            if ($sort_by == 'scpi.status')
                            {
                                ?>
                                <div class="sorting">
                                <?php echo add_image(array($sort_image)); ?>
                                </div>
<?php } ?>
                        </a>
                    </th style="text-align:center ;">
                    <th style="text-align:center ;"><?php echo lang('last_modified'); ?></th>
                    <th><?php echo lang('actions'); ?></th>
                </tr>
                <?php
                $querystr = $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search=' . urlencode($search) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
                if (count($list) > 0)
                {
                    if ($page_number > 1)
                    {
                        $i = ($this->_ci->session->userdata[$this->_data["section_name"]]['record_per_page'] * ($page_number - 1)) + 1;
                    }
                    else
                    {
                        $i = 1;
                    }
                    foreach ($list as $page)
                    {
                        if ($i % 2 != 0)
                            $class = "odd-row";
                        else
                            $class = "even-row";
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td align="center"><input type="checkbox" id="<?php echo $page['scpi']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $page['scpi']['id']; ?>"></td>
                            <td align="center"><?php echo $i; ?></td>
                            <td align="center">
                                <img src="<?php echo base_url() . "assets/uploads/shoppingcart/gallery/thumbs/" . $page['scpi']['product_image'] ?>" />
                            </td>
                            <td align="center">
                                <?php
                                if ($page['scpi']['status'] == '1')
                                {
                                    ?>
                                    <?php echo add_image(array('active.png')); ?>
                                    <?php
                                }
                                elseif ($page['scpi']['status'] == '0')
                                {
                                    ?>
                                    <?php echo add_image(array('inactive.png')); ?>
        <?php } ?>
                            </td>
                            <td align="center"><?php echo $page['scpi']['modified_on']; ?></td>
                            <td>
                                <div class="action">
                                    <div class="edit"><a href="<?php echo site_url() . $this->_data['section_name']; ?>/shoppingcart/action_image/edit/<?php echo $product_id . "/" . $page['scpi']['id']; ?>" title="<?php echo lang('edit'); ?>"><?php echo add_image(array('edit.png')); ?></a></div>
                                    <div class="delete"><a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_product_image('<?php echo $page['scpi']['id']; ?>')"><?php echo add_image(array('delete.png')); ?></a></div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="9">
                            <?php
                            $reset_button = array(
                                'content' => lang('delete'),
                                'title' => lang('delete'),
                                'class' => 'inputbutton',
                                'onclick' => "delete_records()",
                            );
                            echo form_button($reset_button);
                            ?>
                            <?php
                            $reset_button = array(
                                'content' => lang('active'),
                                'title' => lang('active'),
                                'class' => 'inputbutton',
                                'onclick' => "active_records()",
                            );
                            echo form_button($reset_button);
                            ?>
                            <?php
                            $reset_button = array(
                                'content' => lang('inactive'),
                                'title' => lang('inactive'),
                                'class' => 'inputbutton',
                                'onclick' => "inactive_records()",
                            );
                            echo form_button($reset_button);
                            ?>
                            <?php
                            $reset_button = array(
                                'content' => lang('active_all'),
                                'title' => lang('active_all'),
                                'class' => 'inputbutton',
                                'onclick' => "active_all_records()",
                            );
                            echo form_button($reset_button);
                            ?>
                            <?php
                            $reset_button = array(
                                'content' => lang('inactive_all'),
                                'title' => lang('inactive_all'),
                                'class' => 'inputbutton',
                                'onclick' => "inactive_all_records()",
                            );
                            echo form_button($reset_button);
                            ?>
                        </td>
                    </tr>

                    <?php
                }
                else
                {
                    ?>

                    <tr>
                        <td colspan="6" align="center">
                            <?php echo lang('no_records'); ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        if (count($list) > 0)
        {
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . $this->_data['section_name'] . "/shoppingcart/ajax_images/" . $product_id,
                'params' => $querystr,
                'element' => 'ajax_table'
            );
            widget('custom_pagination', $options);
        }
        ?>

    </div>
</div>
<script>
                            function submit_search()
                            {
                                $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                if ($('#search').val() == '') {
                                    $('#search').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
                                    attach_error_event(); //for remove dynamically populate popup
                                    return false;
                                }
                                blockUI();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                    error: function() {
                                        alert("Server problem. Please try again.");
                                        return false;
                                    },
                                    complete: function() {
                                        unblockUI();
                                    },
                                    success: function(data) {
                                        $("#ajax_table").html(data);
                                    }
                                });
                            }

                            function sort_data(sort_by, sort_order)
                            {
                                blockUI();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val()), sort_by: sort_by, sort_order: sort_order},
                                    error: function() {
                                        alert("Server problem. Please try again.");
                                        return false;
                                    },
                                    complete: function() {
                                        unblockUI();
                                    },
                                    success: function(data) {
                                        $("#ajax_table").html(data);
                                    }
                                });
                            }
                            function reset_data()
                            {
                                $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                blockUI();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: "", search_status: ""},
                                    error: function() {
                                        alert("Server problem. Please try again.");
                                        return false;
                                    },
                                    complete: function() {
                                        unblockUI();
                                    },
                                    success: function(data) {
                                        $("#ajax_table").html(data);
                                    }
                                });
                            }

                            function change_search(id)
                            {
                                $("#search_options div").hide();
                                var value = $("#search_" + id).val();
                                $("#search_options .search").val("");
                                $("#search_" + id).val(value);
                                $("#" + id).show();
                            }
                            change_search($("#search").val());


                            $(function() {
                                $("#check_all").click(function() {
                                    if ($("#check_all").is(':checked')) {
                                        $(".check_box").prop("checked", true);
                                    } else {
                                        $(".check_box").prop("checked", false);
                                    }
                                });

                                $(".check_box").click(function() {

                                    if ($(".check_box").length == $(".check_box:checked").length) {
                                        $("#check_all").prop("checked", true);
                                        $(".check_box").attr("checked", "checked");
                                    } else {
                                        $("#check_all").removeAttr("checked");
                                    }

                                });
                            });

                            function active_records()
                            {
                                var val = [];
                                $(':checkbox:checked').each(function(i) {
                                    val[i] = $(this).val();
                                });
                                if (val == "")
                                {
                                    alert('<?php echo lang('alert_msg_active_record_select'); ?>');
                                    return false;
                                }
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val, search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                    success: function(data) {
                                        //for managing same state while record delete
                                        if ($('.rows') && $('.rows').length > 1) {
                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                        } else {
                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                        }
                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
                                    alert('<?php echo lang('alert_msg_inactive_record_select'); ?>');
                                    return false;
                                }
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val, search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                    success: function(data) {
                                        //for managing same state while record delete
                                        if ($('.rows') && $('.rows').length > 1) {
                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                        } else {
                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                        }
                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                    }
                                });
                            }

                            function active_all_records()
                            {
                                res = confirm('<?php echo lang('active_all_confirm') ?>');
                                if (res)
                                {
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all', search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                        success: function(data) {
                                            //for managing same state while record delete
                                            if ($('.rows') && $('.rows').length > 1) {
                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                            } else {
                                                pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                            }
                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                        }
                                    });
                                } else
                                {
                                    return false;
                                }
                            }

                            function inactive_all_records()
                            {
                                res = confirm('<?php echo lang('inactive_all_confirm') ?>');
                                if (res)
                                {
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all', search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                        success: function(data) {
                                            //for managing same state while record delete
                                            if ($('.rows') && $('.rows').length > 1) {
                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                            } else {
                                                pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                            }
                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
                                    alert('<?php echo lang('alert_msg_delete_record_select'); ?>');
                                    return false;
                                }

                                res = confirm('<?php echo lang('delete_confirm') ?>');
                                if (res)
                                {
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val, search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                        success: function(data) {

                                            //for managing same state while record delete
                                            if ($('.rows') && $('.rows').length > 1) {
                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                            } else {
                                                pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                            }
                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                        }
                                    });
                                } else
                                {
                                    return false;
                                }
                            }
</script>