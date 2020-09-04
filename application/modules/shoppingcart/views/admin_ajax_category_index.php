<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="right"><?php echo lang('search_by_title'); ?>:</td>
                        <td align="left">
                            <?php
                            $input_data = array(
                                'name' => 'search_term',
                                'id' => 'search_term',
                                'value' => set_value('search_term', urldecode($search_term))
                            );
                            echo form_input($input_data);
                            ?>
                        </td>
                        <td>
                            <?php
                            $search_button = array(
                                'content' => lang('ci_action_search'),
                                'title' => lang('ci_action_search'),
                                'class' => 'inputbutton',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button);
                            ?>
                        </td>
                        <td>
                            <?php
                            $reset_button = array(
                                'content' => lang('ci_action_reset'),
                                'title' => lang('ci_action_reset'),
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
                    <th><?php echo lang('sr_no') ?></th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 'scc.title' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('scc.title', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('title'); ?>
                            <?php
                            if ($sort_by == 'scc.title')
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
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 'scc.slug_url' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('scc.slug_url', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('slug_url'); ?>
                            <?php
                            if ($sort_by == 'scc.slug_url')
                            {
                                ?>
                                <div class="sorting">
                                <?php echo add_image(array($sort_image)); ?>
                                </div>
    <?php }
?>
                        </a>
                    </th>
                    <th><?php echo lang('products') ?></th>
                    <th><?php echo lang('sub_categories') ?></th>
                    <th><?php echo lang('status') ?></th>
                    <th><?php echo lang('actions') ?></th>
                </tr>
                <?php
                if (count($category_list) > 0)
                {
                    $i = 1;
                    foreach ($category_list as $category_page)
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
                        <tr class="<?php echo $class; ?>" >
                            <td><?php echo $i; ?></td>
                            <td>
                                <?php
                                if (isset($category_page['scc']['parent_id']) && $category_page['scc']['parent_id'] != 0)
                                {
                                    echo '&nbsp;&nbsp;&nbsp; - ';
                                }

                                echo $category_page['scc']['title'];
                                ?>
                            </td>
                            <td><?php echo $category_page['scc']['slug_url']; ?></td>
                            <td><?php echo $category_page['totalproduct']; ?></td>
                            <td><?php echo $category_page['subcategory']; ?></td>
                            <td>
                                <?php
                                if ($category_page['scc']['status'] == 1)
                                {
                                    echo add_image(array('active.png'));
                                }
                                else
                                {
                                    echo add_image(array('inactive.png'));
                                }
                                ?>
                            </td>
                            <td>
                                <div class="action">
                                    <div class="edit">
                                        <a href="<?php echo site_url() . $this->_data["section_name"]; ?>/shoppingcart/action_category/edit/<?php echo $category_page['l']['language_code'] . "/" . $category_page['scc']['category_id']; ?>" title="<?php echo lang('edit'); ?>"><?php echo add_image(array('edit.png')); ?></a>
                                    </div>
                                    <div class="delete">
                                        <a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_category('<?php echo $category_page['scc']['id']; ?>', '<?php echo $category_page['scc']['slug_url']; ?>')"><?php echo add_image(array('delete.png')); ?></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                else
                {
                    ?>
                    <tr>
                        <td colspan="7"><center><?php echo lang('ci_model_no_data') ?></center></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
        if (count($category_list) > 0)
        {
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . $this->_data["section_name"] . "/shoppingcart/ajax_category_index/" . $language_code,
                'params' => $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '',
                'element' => 'ajax_table'
            );

            widget('custom_pagination', $options);
        }
        ?>
    </div>
</div>
<script type="text/javascript">
                            function submit_search()
                            {
                                $('#error_msg').fadeOut(1000); //hide error message it shown up while search

                                if ($('#search_term').val() == '')
                                {
                                    $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg_search_req'); ?>', 'error');
                                    attach_error_event(); //for remove dynamically populate popup
                                    return false;
                                }

                                blockUI();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_category_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val())},
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_category_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order},
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/shoppingcart/ajax_category_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: ""},
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
</script>