<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="right"><?php echo lang('search_by_prd_name') ?> :</td>
                        <?php
                        $input_data = array(
                            'name' => 'search_term',
                            'id' => 'search_term',
                            'value' => set_value('search_term', urldecode($search_term))
                        );

                        $options = array();
                        $options[0] ='all';
                        $value = (isset($search_category_id)) ? $search_category_id : 0;

                        if (!empty($category_data))
                        {
                            foreach ($category_data as $cat_ids)
                            {
                                $cat_data = explode("=>", $cat_ids);
                                if (isset($cat_data[0]) && isset($cat_data[1]))
                                {
                                    $temp_array = array();
                                    $temp_array = array($cat_data[0] => $cat_data[1]);
                                    $options = $options + $temp_array;
                                }
                            }
                        }
                        ?>
                        <td align="left" colspan="2">
                            <?php
                            echo form_input($input_data).' &nbsp;';
                            echo form_dropdown('search_category_id', $options, $value,'id="search_category_id"').' &nbsp;';
                            $search_button = array(
                                'content' => lang('btn_search'),
                                'title' => lang('btn_search'),
                                'class' => 'inputbutton',
                                'onclick' => "submit_search()"
                            );
                            echo form_button($search_button);
                            ?>
                        </td>
                        <td>
                            <?php
                            $reset_button = array(
                                'content' => lang('reset_button'),
                                'title' => lang('reset_button'),
                                'class' => 'inputbutton',
                                'onclick' => "reset_data()"
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
                    <th width="30px"  style="text-align:center !important;"><input type="checkbox" name="check_all" id="check_all" value="0"></th>
                    <th style="text-align:center !important;"><?php echo lang('no'); ?></th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 'scp.name' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('scp.name', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('name'); ?>
                            <?php
                            if ($sort_by == 'scp.name')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php }
                            ?>
                        </a>
                    </th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        if ($sort_by == 'scp.slug_url' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_uscscp.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('scp.slug_url', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('slug'); ?>
                            <?php if ($sort_by == 'scp.slug_url')
                            {
                                ?>
                                <div class="sorting">
                                <?php echo add_image(array($sort_image)); ?>
                                </div>
<?php } ?>
                        </a>
                    </th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        if ($sort_by == 'scp.price' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_down.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('scp.price', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('price'); ?>
                            <?php if ($sort_by == 'price')
                            {
                                ?>
                                <div class="sorting">
                                <?php echo add_image(array($sort_image)); ?>
                                </div>
<?php } ?>
                        </a>
                    </th>
                    <th><?php echo lang('product_category'); ?></th>
                    <th><?php echo lang('on-featured'); ?></th>
                    <th><?php echo lang('status'); ?></th>
                    <th><?php echo lang('stock'); ?></th>
                    <th><?php echo lang('last_modified'); ?></th>
                    <th><?php echo lang('product_gallery'); ?></th>
                    <th><?php echo lang('actions'); ?></th>
                </tr>
                <?php
                $querystr = $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';

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
                        {
                            $class = "odd-row";
                        }
                        else
                        {
                            $class = "even-row";
                        }
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td  align="center"><input type="checkbox" id="<?php echo $page['scp']['product_id']; ?>" name="check_box[]" class="check_box" value="<?php echo $page['scp']['product_id']; ?>"></td>
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $page['scp']['name']; ?></td>
                            <td><?php echo $page['scp']['slug_url']; ?></td>
                            <td><?php echo $page['scp']['price'] . '&nbsp;' . $page['scp']['currency_code']; ?></td>
                            <td><?php echo $page['scc']['title']; ?></td>
                            <td align="center"><?php echo (isset($page['scp']['featured']) && $page['scp']['featured'] == 1 ? 'Yes' : 'No'); ?></td>
                            <td align="center">
                                <?php
                                if ($page['scp']['status'] == '1')
                                {
                                    echo add_image(array('active.png'));
                                }
                                elseif ($page['scp']['status'] == '0')
                                {
                                    echo add_image(array('inactive.png'));
                                }
                                ?>
                            </td>
                            <td align="center"><?php echo $page['scp']['stock']; ?></td>
                            <td align="center"><?php echo $page['scp']['modified_on']; ?></td>
                            <td align="center">
                                <a href="<?php echo site_url() . $this->_data["section_name"]; ?>/shoppingcart/images/<?php echo $page['scp']['product_id'] ?>" title="<?php echo lang('view') ?>"><?php echo lang('add_product_gallery'); ?></a>
                            </td>
                            <td align="center">
                                <div class="action">
                                    <div class="edit"><a href="<?php echo site_url() . $this->_data["section_name"]; ?>/shoppingcart/view/product/<?php echo $page['scp']['product_id'] ?>/<?php echo $page['l']['language_code']; ?>" title="<?php echo lang('view') ?>"><?php echo add_image(array('viewIcon.png')); ?></a></div>
                                    <div class="edit"><a href="<?php echo site_url() . $this->_data["section_name"]; ?>/shoppingcart/action/edit/<?php echo $page['l']['language_code'] . "/" . $page['scp']['product_id']; ?>" title="<?php echo lang('edit'); ?>"><?php echo add_image(array('edit.png')); ?></a></div>
                                    <div class="delete"><a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_product('<?php echo $page['scp']['product_id']; ?>', '<?php echo $page['scp']['slug_url']; ?>')"><?php echo add_image(array('delete.png')); ?></a></div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="11">
                            <?php
                            $reset_button = array(
                                'content' => lang('delete'),
                                'title' => lang('delete'),
                                'class' => 'inputbutton',
                                'onclick' => "delete_records()",
                            );
                            echo form_button($reset_button);

                            $reset_button = array(
                                'content' => lang('active'),
                                'title' => lang('active'),
                                'class' => 'inputbutton',
                                'onclick' => "active_records()",
                            );
                            echo form_button($reset_button);

                            $reset_button = array(
                                'content' => lang('inactive'),
                                'title' => lang('inactive'),
                                'class' => 'inputbutton',
                                'onclick' => "inactive_records()",
                            );
                            echo form_button($reset_button);

                            $reset_button = array(
                                'content' => lang('active_all'),
                                'title' => lang('active_all'),
                                'class' => 'inputbutton',
                                'onclick' => "active_all_records()",
                            );
                            echo form_button($reset_button);

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
                </tbody>
            </table>
            <?php
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . $this->_data["section_name"] . "/shoppingcart/ajax_products_index/" . $language_code,
                'params' => $querystr,
                'element' => 'ajax_table'
            );
            widget('custom_pagination', $options);
        }
        else
        {
            ?>
            <table width="100%">
                <tr><td colspan="11" align="center"><?php echo lang('no_records'); ?></td></tr>
            </table>
            <?php
        }
        ?>
    </div>
</div>

<script type="text/javascript">
                            function submit_search()
                            {
                                $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                if ($('#search_term').val() == '' && $('#search_category_id').val()==0)
                                {
                                    $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg_search_req'); ?>', 'error');
                                    attach_error_event(); //for remove dynamically populate popup
                                    return false;
                                }
                                blockUI();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), search_category_id: encodeURIComponent($('#search_category_id').val())},
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order, search_category_id: encodeURIComponent($('#search_category_id').val())},
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: "", search_category_id: 0},
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

                            $(function()
                            {
                                $("#check_all").click(function() {
                                    if ($("#check_all").is(':checked'))
                                    {
                                        $(".check_box").prop("checked", true);
                                    }
                                    else
                                    {
                                        $(".check_box").prop("checked", false);
                                    }
                                });

                                $(".check_box").click(function() {
                                    if ($(".check_box").length == $(".check_box:checked").length)
                                    {
                                        $("#check_all").prop("checked", true);
                                        $(".check_box").attr("checked", "checked");
                                    }
                                    else
                                    {
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val},
                                    success: function(data) {
                                        //for managing same state while record delete
                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                        ajaxLink('<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
                                    success: function(data) {
                                        //for managing same state while record delete
                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                        ajaxLink('<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
                                        url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
                                        success: function(data) {
                                            //for managing same state while record delete
                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                            ajaxLink('<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                        }
                                    });
                                }
                                else
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
                                        url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
                                        success: function(data) {
                                            //for managing same state while record delete
                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                            ajaxLink('<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
                                        url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>',
                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                                        success: function(data) {
                                            ajaxLink('<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_products_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>');
                                        }
                                    });
                                }
                                else
                                {
                                    return false;
                                }
                            }
</script>