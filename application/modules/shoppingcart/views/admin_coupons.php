<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="right"><?php echo lang('search_by_coupon_name') ?> :</td>
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
                    <th width="30px"><input type="checkbox" name="check_all" id="check_all" value="0"></th>
                    <th><?php echo lang('no') ?></th>
                    <th><?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'sccp.coupon_name' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sccp.coupon_name', '<?php echo $field_sort_order; ?>');" >
                            <?php
                            echo lang('coupon_name');

                            if ($sort_by == 'sccp.coupon_name')
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
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'sccp.coupon_code' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sccp.coupon_code', '<?php echo $field_sort_order; ?>');" >
                            <?php
                            echo lang('coupon_code');

                            if ($sort_by == 'sccp.coupon_code')
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
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'sccp.coupon_price' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sccp.coupon_price', '<?php echo $field_sort_order; ?>');" >
                            <?php
                            echo lang('price');

                            if ($sort_by == 'sccp.coupon_price')
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
                    <th><?php echo lang('coupon_maxuse_title'); ?></th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';

                        if ($sort_by == 'sccp.coupon_sdate' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sccp.coupon_sdate', '<?php echo $field_sort_order; ?>');" >
                            <?php
                            echo lang('start_date');

                            if ($sort_by == 'sccp.coupon_sdate')
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
                        if ($sort_by == 'sccp.coupon_edate' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('sccp.coupon_edate', '<?php echo $field_sort_order; ?>');" >
                            <?php
                            echo lang('end_date');

                            if ($sort_by == 'sccp.coupon_edate')
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
                    <th><?php echo lang('status'); ?></th>
                    <th><?php echo lang('actions'); ?></th>
                </tr>
                <?php
                $querystr = $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';

                if (!empty($allcoupons))
                {
                    if ($page_number > 1)
                    {
                        $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                    }
                    else
                    {
                        $i = 1;
                    }

                    foreach ($allcoupons as $allrecord)
                    {
                        if ($i % 2 != 0)
                        {
                            $class = "odd-row";
                        }
                        else
                        {
                            $class = "even-row";
                        }

                        if ($allrecord['sccp']['status'] == '1')
                        {
                            $status = add_image(array('active.png'));
                        }
                        else
                        {
                            $status = add_image(array('inactive.png'));
                        }


                        $rec_id = $allrecord['sccp']['id'];
                        $price_percent = '';
                        $currency_code = CURRENCY_CODE;

                        if ($allrecord['sccp']['coupon_percentage'] == 1)
                        {
                            $price_percent = '%';
                            $currency_code = '';
                        }
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td>
                                <input type="checkbox" id="<?php echo $allrecord['sccp']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $allrecord['sccp']['id']; ?>">
                            </td>
                            <td><?php echo $i; ?></td>
                            <td>
                                <a href="<?php echo site_url() . $this->_data['section_name']; ?>/shoppingcart/action_coupon/edit/<?php echo $rec_id; ?>" title="<?php echo lang('edit'); ?>"><?php echo $allrecord['sccp']['coupon_name']; ?></a>
                            </td>
                            <td><?php echo $allrecord['sccp']['coupon_code']; ?></td>
                            <td><?php echo $allrecord['sccp']['coupon_price'] . $price_percent . '&nbsp;' . $currency_code; ?></td>
                            <td><?php echo $allrecord['sccp']['coupon_maxuse']; ?></td>
                            <td><?php echo $allrecord['sccp']['coupon_sdate']; ?></td>
                            <td><?php echo $allrecord['sccp']['coupon_edate']; ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <div class="edit">
                                    <a href="<?php echo site_url() . $this->_data['section_name']; ?>/shoppingcart/view/coupon/<?php echo $allrecord['sccp']['id'] ?>" title="<?php echo lang('view') ?>"><?php echo add_image(array('viewIcon.png')); ?></a>
                                </div>
                                <div class="edit">
                                    <a href="<?php echo site_url() . $this->_data['section_name']; ?>/shoppingcart/action_coupon/edit/<?php echo $rec_id; ?>" title="<?php echo lang('edit'); ?>"><?php echo add_image(array('edit.png')); ?></a>
                                </div>
                                <div class="delete">
                                    <a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_coupon('<?php echo $allrecord['sccp']['id']; ?>')"><?php echo add_image(array('delete.png')); ?></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="10">
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
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td colspan="9" align="center"><?php echo lang('no_records') ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        if (!empty($allcoupons))
        {
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . $this->_data['section_name'] . "/shoppingcart/ajax_coupons",
                'params' => $querystr,
                'element' => 'ajax_table'
            );
            widget('custom_pagination', $options);
        }
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

    if ($('#search_term').val() == '')
    {
        $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg_search_req'); ?>', 'error');
        attach_error_event(); //for remove dynamically populate popup
        return false;
    }

    blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
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
        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
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
        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
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
        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val},
        success: function(data) {
            //for managing same state while record delete
            pageno = "&page_number=<?php echo $page_number; ?>";
            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
        url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
        success: function(data) {
            //for managing same state while record delete
            pageno = "&page_number=<?php echo $page_number; ?>";
            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
            success: function(data) {
                //for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
            success: function(data) {
                //for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
            success: function(data) {
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons', 'ajax_table', '<?php echo $querystr; ?>');
            }
        });
    }
    else
    {
        return false;
    }
}
</script>