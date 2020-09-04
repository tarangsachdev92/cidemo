<div id="ajax_table">
    <div class="main-container"> 
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="right"><?php echo lang('search_by_user') ?> :</td>                        
                        <?php
                        $input_data = array(
                            'name' => 'search_term',
                            'id' => 'search_term',
                            'value' => set_value('search_term', urldecode($search_term))
                        );
                        ?>
                        <td align="left" colspan="2">
                            <?php
                            echo form_input($input_data);
                            $search_button = array(
                                'content' => lang('btn_search'),
                                'title' => lang('btn-search'),
                                'class' => 'inputbutton',
                                'onclick' => "submit_search()",
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
                    <th><?php echo lang('no') ?></th>
                    <th><?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'u.firstname' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('u.firstname', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('user'); ?>
                            <?php
                            if ($sort_by == 'u.firstname')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php } ?>
                        </a>
                    </th>
                    <th><?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'sco.id' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sco.id', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('order_id'); ?>
                            <?php
                            if ($sort_by == 'sco.id')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php } ?>
                        </a>
                    </th>
                    <th><?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'sco.order_items' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sco.order_items', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('products'); ?>
                            <?php
                            if ($sort_by == 'sco.order_items')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php } ?>
                        </a>
                    </th>
                    <th><?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'sco.total_amount' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sco.total_amount', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('order_total'); ?>
                            <?php
                            if ($sort_by == 'sco.total_amount')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                                <?php
                            }
                            ?>
                        </a>
                    </th>
                    <th><?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 'sco.order_date' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sco.order_date', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('order_date'); ?>
                            <?php
                            if ($sort_by == 'sco.order_date')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php } ?>
                        </a>
                    </th>
                    <th><?php echo lang('status'); ?></th>
                    <th><?php echo lang('actions'); ?></th>
                </tr>
                <?php
                if (!empty($allorders))
                {
                    if ($page_number > 1)
                    {
                        $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                    }
                    else
                    {
                        $i = 1;
                    }
                    foreach ($allorders as $allrecord)
                    {
                        if ($i % 2 != 0)
                        {
                            $class = "odd-row";
                        }
                        else
                        {
                            $class = "even-row";
                        }

                        if ($allrecord['sco']['order_status'] == '0')
                        {
                            $status = lang('pending');
                        }

                        if ($allrecord['sco']['order_status'] == '1')
                        {
                            $status = lang('cancelled');
                        }

                        if ($allrecord['sco']['order_status'] == '2')
                        {
                            $status = lang('processing');
                        }
                        if ($allrecord['sco']['order_status'] == '3')
                        {
                            $status = lang('despatched');
                        }
                        if ($allrecord['sco']['order_status'] == '4')
                        {
                            $status = lang('completed');
                        }

                        $rec_id = $allrecord['sco']['id'];
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $allrecord['u']['firstname']; ?></td>
                            <td><?php echo $allrecord['sco']['id']; ?></td>
                            <td><?php echo $allrecord['sco']['order_items']; ?></td>
                            <td><?php echo $allrecord['sco']['total_amount'] . '&nbsp;' . $allrecord['sco']['currency_code']; ?></td>
                            <td><?php echo $allrecord['sco']['order_date']; ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <div class="edit"><a href="<?php echo site_url() . $this->_data['section_name']; ?>/shoppingcart/view/order/<?php echo $allrecord['sco']['id'] ?>" title="<?php echo lang('view') ?>"><?php echo add_image(array('viewIcon.png')); ?></a></div>
                                <div class="edit"><a href="<?php echo site_url() . $this->_data['section_name']; ?>/shoppingcart/action_order/edit/<?php echo $rec_id; ?>" title="<?php echo lang('edit'); ?>"><?php echo add_image(array('edit.png')); ?></a></div>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                else
                {
                    ?>         
                    <tr><td colspan="10"><?php echo lang('no-records') ?></td></tr>
                <?php } ?>              
            </tbody>
        </table>	
        <?php
        $options = array(
            'total_records' => $total_records,
            'page_number' => $page_number,
            'isAjaxRequest' => 1,
            'base_url' => base_url() . $this->_data['section_name'] . "/shoppingcart/ajax_orders",
            'params' => $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '',
            'element' => 'ajax_table'
        );
        widget('custom_pagination', $options);
        ?>
    </div>
</div>
<?php
$csrf_token = $this->ci()->security->get_csrf_token_name();
$csrf_hash = $this->ci()->security->get_csrf_hash();
?>

<script type="text/javascript">
                            function submit_search()
                            {
                                $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                if ($('#search_term').val() == '') {
                                    $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg_search_req'); ?>', 'error');
                                    attach_error_event(); //for remove dynamically populate popup
                                    return false;
                                }
                                blockUI();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_orders',
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
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_orders',
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
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_orders',
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